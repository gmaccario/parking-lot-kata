# Episode 01: Introduction & Basic Implementation

🇮🇹 [Versione italiana](README.md)

## 📺 Watch the Video

[Link to YouTube video](https://youtu.be/2vNkzn3NmtQ)

---

## 🎯 What You'll Learn

- Analyzing requirements and translating them to code
- DDD Lite approach: start from the domain, not the command
- Using interfaces instead of inheritance for flexibility
- PHP 8: types, return types, and Enums
- Clean Code: clear naming, no magic numbers

---

## 📋 The Requirements

A multi-floor parking garage that:
- Accepts vehicles: Car, Van, Motorcycle
- Different sizes: Motorcycle = 0.5, Car = 1.0, Van = 1.5
- Three floors with different capacities
- Van can only park on ground floor
- Welcome or error message

---

## 🔑 Key Concepts

### DDD Lite

Start from the domain, not the command. Entities are the building blocks:

```
Domain/
├── Entity/
│   ├── Car.php
│   ├── Van.php
│   ├── Motorcycle.php
│   ├── ParkingFloor.php
│   └── ParkingGarage.php
├── Contract/
│   └── SizeableInterface.php
├── Enum/
│   └── FloorLevelEnum.php
└── Exception/
    ├── NoSpaceInGarageException.php
    └── NoSpaceForVanException.php
```

### Interface vs Inheritance

```php
// ❌ Rigid - What if tomorrow we want to park containers?
class Car extends Vehicle {}
class Van extends Vehicle {}
class Container extends Vehicle {}  // A container is not a vehicle!

// ✅ Flexible - Anything with a size
interface SizeableInterface {
    public function getSize(): float;
}

class Car implements SizeableInterface {}
class Container implements SizeableInterface {}  // Works!
```

---

## 📝 Domain Entities

### Vehicles

```php
interface SizeableInterface
{
    public function getSize(): float;
}

class Car implements SizeableInterface
{
    public function getSize(): float
    {
        return 1.0;
    }
}

class Motorcycle implements SizeableInterface
{
    public function getSize(): float
    {
        return 0.5;  // Two motorcycles = one car
    }
}

class Van implements SizeableInterface
{
    public function getSize(): float
    {
        return 1.5;
    }
}
```

### ParkingFloor

```php
class ParkingFloor
{
    public function __construct(
        private float $capacity,
        private float $currentLoad = 0.0,
    ) {}

    public function hasSpace(SizeableInterface $item): bool
    {
        return $item->getSize() <= ($this->capacity - $this->currentLoad);
    }

    public function park(SizeableInterface $item): bool
    {
        if (!$this->hasSpace($item)) {
            return false;
        }
        $this->currentLoad += $item->getSize();
        return true;
    }
}
```

### ParkingGarage

```php
class ParkingGarage
{
    public function __construct(
        private array $floors = [],
    ) {}

    public function park(SizeableInterface $item): ParkingFloor
    {
        // Van only on ground floor
        if ($item instanceof Van) {
            $groundFloor = $this->floors[FloorLevelEnum::GROUND->value];
            if ($groundFloor->hasSpace($item)) {
                $groundFloor->park($item);
                return $groundFloor;
            }
            throw new NoSpaceForVanException();
        }

        // Other vehicles: first available floor
        foreach ($this->floors as $floor) {
            if ($floor->hasSpace($item)) {
                $floor->park($item);
                return $floor;
            }
        }

        throw new NoSpaceInGarageException();
    }
}
```

---

## 🎨 PHP 8: Enum for Floor Levels

```php
// ❌ Magic numbers
$groundFloor = $this->floors[0];

// ✅ Clear and readable Enum
enum FloorLevelEnum: int
{
    case GROUND = 0;
    case FIRST = 1;
    case SECOND = 2;
}

$groundFloor = $this->floors[FloorLevelEnum::GROUND->value];
```

---

## 🚀 Run the Command

```php
// console.php
$floors = [
    FloorLevelEnum::GROUND->value => new ParkingFloor(2.0),
    FloorLevelEnum::FIRST->value => new ParkingFloor(6.0),
    FloorLevelEnum::SECOND->value => new ParkingFloor(10.0),
];

$garage = new ParkingGarage($floors);

try {
    $floor = $garage->park(new Car());
    echo "Welcome! Parked on floor.";
} catch (NoSpaceInGarageException $e) {
    echo $e->getMessage();
}
```

```bash
php console.php
```

---

## 📂 File Structure

```
├── composer.json
├── console.php
│
└── src/
    └── Domain/
        ├── Contract/
        │   └── SizeableInterface.php
        ├── Entity/
        │   ├── Car.php
        │   ├── Van.php
        │   ├── Motorcycle.php
        │   ├── ParkingFloor.php
        │   └── ParkingGarage.php
        ├── Enum/
        │   └── FloorLevelEnum.php
        └── Exception/
            ├── NoSpaceInGarageException.php
            └── NoSpaceForVanException.php
```

---

## 💡 Trade-offs (DDD Lite)

| Choice | Reason |
|--------|--------|
| No Value Objects | Simplicity, use primitive types |
| No Repository | No database required |
| No Service Class | Enrich domain entities instead |
| Interface vs Inheritance | Flexibility for future items (container, storage box) |

---

## ➡️ Navigation

- [↑ Back to main README](../../README.md)
- [→ Episode 02: Unit Testing & Quality Tools](../02-tests-refactoring-quality-tools/)