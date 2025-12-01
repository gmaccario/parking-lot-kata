# Episodio 01: Introduzione & Implementazione Base

🇬🇧 [English version](README-en.md)

## 📺 Guarda il Video

[Link al video YouTube](https://youtu.be/2vNkzn3NmtQ)

---

## 🎯 Cosa Imparerai

- Analizzare requisiti e tradurli in codice
- Approccio DDD Lite: partire dal dominio, non dal comando
- Usare interfacce invece dell'ereditarietà per flessibilità
- PHP 8: tipi, return type e Enum
- Clean Code: nomi chiari, niente magic numbers

---

## 📋 I Requisiti

Un parcheggio multi piano che:
- Accetta veicoli: Car, Van, Motorcycle
- Dimensioni diverse: Motorcycle = 0.5, Car = 1.0, Van = 1.5
- Tre piani con capacità diverse
- Van può parcheggiare solo al piano terra
- Messaggio di benvenuto o errore

---

## 🔑 Concetti Chiave

### DDD Lite

Parti dal dominio, non dal comando. Le entità sono i mattoncini base:

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

### Interfaccia vs Ereditarietà

```php
// ❌ Rigido - Se domani vogliamo parcheggiare container?
class Car extends Vehicle {}
class Van extends Vehicle {}
class Container extends Vehicle {}  // Un container non è un veicolo!

// ✅ Flessibile - Qualsiasi cosa con una dimensione
interface SizeableInterface {
    public function getSize(): float;
}

class Car implements SizeableInterface {}
class Container implements SizeableInterface {}  // Funziona!
```

---

## 📝 Entità del Dominio

### Veicoli

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
        return 0.5;  // Due moto = una macchina
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
        // Van solo al piano terra
        if ($item instanceof Van) {
            $groundFloor = $this->floors[FloorLevelEnum::GROUND->value];
            if ($groundFloor->hasSpace($item)) {
                $groundFloor->park($item);
                return $groundFloor;
            }
            throw new NoSpaceForVanException();
        }

        // Altri veicoli: primo piano disponibile
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

## 🎨 PHP 8: Enum per i Piani

```php
// ❌ Magic numbers
$groundFloor = $this->floors[0];

// ✅ Enum chiaro e leggibile
enum FloorLevelEnum: int
{
    case GROUND = 0;
    case FIRST = 1;
    case SECOND = 2;
}

$groundFloor = $this->floors[FloorLevelEnum::GROUND->value];
```

---

## 🚀 Eseguire il Comando

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

## 📂 Struttura File

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

| Scelta | Motivazione |
|--------|-------------|
| No Value Objects | Semplicità, usiamo tipi primitivi |
| No Repository | Nessun database richiesto |
| No Service Class | Arricchiamo le entità di dominio |
| Interfaccia vs Ereditarietà | Flessibilità per elementi futuri (container, storage box) |

---

## ➡️ Navigazione

- [↑ Torna al README principale](../../README.md)
- [→ Episodio 02: Unit Testing & Quality Tools](../02-tests-refactoring-quality-tools/)