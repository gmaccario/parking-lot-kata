# Episode 07: Value Objects, Aggregates & Layer Fix

🇮🇹 [Versione italiana](README.md)

## 📺 Watch the Video

[YouTube Video Link](https://youtu.be/ox4obH0x2YU)

---

## 🎯 What You'll Learn

- What Primitive Obsession is and why it's a code smell
- Value Objects: immutable objects with built-in validation
- Difference between Entity and Value Object
- Aggregates and Aggregate Root in DDD
- Architectural fix: Commands from Application to Infrastructure

---

## 🔑 Key Concepts

### Primitive Obsession

The code smell we solve in this episode: using primitive types (`int`, `string`, `float`) to represent domain concepts.

**❌ Before (separate primitives):**
```php
class ParkingGarage
{
    public function __construct(
        private int $openingHour,  // Meaningless without closingHour
        private int $closingHour,
    ) {}
}
```

**✅ After (Value Object):**
```php
class ParkingGarage
{
    public function __construct(
        private OperatingHours $operatingHours,
    ) {}
}
```

---

### Value Objects

Key characteristics:

| Property | Description |
|----------|-------------|
| **No Identity** | No ID needed, only the value matters |
| **Immutable** | Once created, they don't change |
| **Self-validating** | Validation in constructor |
| **Encapsulation** | Group related data together |

```php
final readonly class OperatingHours
{
    public function __construct(
        public int $openingHour,
        public int $closingHour,
    ) {
        if ($openingHour < 0 || $openingHour > 23) {
            throw new InvalidHourException();
        }
        if ($closingHour < 0 || $closingHour > 23) {
            throw new InvalidHourException();
        }
        if ($openingHour >= $closingHour) {
            throw new InvalidOperatingHoursException();
        }
    }

    public function isOpen(DateTimeInterface $dateTime): bool
    {
        $hour = (int) $dateTime->format('G');
        return $hour >= $this->openingHour && $hour < $this->closingHour;
    }
}
```

---

### Entity vs Value Object

| Entity | Value Object |
|--------|--------------|
| Has unique ID | No ID |
| Mutable | Immutable |
| Identity matters | Value matters |
| E.g.: `Car #1`, `Car #2` | E.g.: `OperatingHours(9, 18)` |

---

### Aggregates

`ParkingGarage` is an **Aggregate Root** because:

1. It's the entry point for operations (`park()`)
2. It knows the business rules (e.g., vans only on ground floor)
3. It manages consistency among its internal entities (floors)

```php
// ✅ Correct: ask the Garage
$garage->park($vehicle);

// ❌ Wrong: bypass the Aggregate Root
$floor->park($vehicle);
```

---

### Architectural Fix

**Symfony Console Commands** belong in **Infrastructure**, not Application:

```
Domain/          → No external dependencies
Application/     → Only interfaces (Ports) and Use Cases
Infrastructure/  → Commands, Controllers, DB adapters
```

Commands have dependencies on `symfony/console` → Infrastructure layer.

---

## 📂 File Structure

```
src/
├── Domain/
│   ├── Aggregate/
│   │   └── ParkingGarage.php       ← Aggregate Root
│   ├── Entity/
│   │   ├── Car.php
│   │   ├── Van.php
│   │   ├── Motorcycle.php
│   │   └── ParkingFloor.php
│   ├── VO/
│   │   ├── OperatingHours.php      ← NEW
│   │   ├── Capacity.php            ← NEW
│   │   └── OccupiedSpace.php       ← NEW
│   ├── Enum/
│   └── Exception/
│       ├── InvalidHourException.php
│       └── InvalidOperatingHoursException.php
│
├── Application/
│   └── UseCase/
│
└── Infrastructure/
    └── Command/                     ← MOVED from Application
        ├── ParkingStatusCommand.php
        └── SmartParkingSystemCommand.php
```

---

## 💡 Value Objects Created

| Value Object | Replaces | Validation |
|--------------|----------|------------|
| `OperatingHours` | `openingHour` + `closingHour` | Hours 0-23, opening < closing |
| `Capacity` | `float $capacity` | Must be > 0 |
| `OccupiedSpace` | `float $occupiedSpace` | Must be ≥ 0 |

---

## ➡️ Navigation

- [← Episode 06: Hexagonal Architecture & Factory Pattern](../06-hexagonal-architecture/)
- [↑ Back to main README](../../README.md)
- [→ Episode 08: Coming soon...]
