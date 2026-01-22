# Episodio 07: Value Objects, Aggregates e Fix del Layer

🇬🇧 [English version](README-en.md)

## 📺 Guarda il Video

[Link al video YouTube](https://youtu.be/ox4obH0x2YU)

---

## 🎯 Cosa Imparerai

- Cos'è la Primitive Obsession e perché è un code smell
- Value Objects: oggetti immutabili con validazione incorporata
- Differenza tra Entity e Value Object
- Aggregates e Aggregate Root nel DDD
- Correzione architetturale: Commands da Application a Infrastructure

---

## 🔑 Concetti Chiave

### Primitive Obsession

Il code smell che risolviamo in questo episodio: usare tipi primitivi (`int`, `string`, `float`) per rappresentare concetti di dominio.

**❌ Prima (primitivi separati):**
```php
class ParkingGarage
{
    public function __construct(
        private int $openingHour,  // Che senso ha senza closingHour?
        private int $closingHour,
    ) {}
}
```

**✅ Dopo (Value Object):**
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

Caratteristiche principali:

| Proprietà | Descrizione |
|-----------|-------------|
| **No Identity** | Non hanno ID, conta solo il valore |
| **Immutabili** | Una volta creati, non cambiano |
| **Self-validating** | Validazione nel costruttore |
| **Encapsulation** | Raggruppano dati correlati |

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
| Ha un ID univoco | Nessun ID |
| Mutabile | Immutabile |
| Identità conta | Valore conta |
| Es: `Car #1`, `Car #2` | Es: `OperatingHours(9, 18)` |

---

### Aggregates

Il `ParkingGarage` è un **Aggregate Root** perché:

1. È il punto d'ingresso per le operazioni (`park()`)
2. Conosce le regole di business (es: van solo al piano terra)
3. Gestisce la consistenza tra le sue entità interne (floors)

```php
// ✅ Corretto: chiedi al Garage
$garage->park($vehicle);

// ❌ Sbagliato: bypassare l'Aggregate Root
$floor->park($vehicle);
```

---

### Fix Architetturale

I **Symfony Console Commands** appartengono a **Infrastructure**, non Application:

```
Domain/          → Nessuna dipendenza esterna
Application/     → Solo interfacce (Ports) e Use Cases
Infrastructure/  → Commands, Controllers, DB adapters
```

I Commands hanno dipendenze verso `symfony/console` → Infrastructure layer.

---

## 📂 Struttura File

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

## 💡 Value Objects Creati

| Value Object | Sostituisce | Validazione |
|--------------|-------------|-------------|
| `OperatingHours` | `openingHour` + `closingHour` | Ore 0-23, opening < closing |
| `Capacity` | `float $capacity` | Deve essere > 0 |
| `OccupiedSpace` | `float $occupiedSpace` | Deve essere ≥ 0 |

---

## ➡️ Navigazione

- [← Episodio 06: Hexagonal Architecture & Factory Pattern](../06-hexagonal-architecture/)
- [↑ Torna al README principale](../../README.md)
- [→ Episodio 08: Coming soon...]
