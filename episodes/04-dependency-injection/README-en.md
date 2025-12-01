# Episode 04: Dependency Injection in Pure PHP

🇮🇹 [Versione italiana](README.md)

## 📺 Watch the Video

[Link to YouTube video](https://youtu.be/ZNI3K5WfNPo)

---

## 🎯 What You'll Learn

- What Dependency Injection is and why it matters
- How to extract logic from a command to make it testable
- Two approaches: Service Class vs. Domain Entity
- When to enrich a domain entity instead of creating services

---

## 🔑 Key Concepts

### Dependency Injection

Inject objects from outside instead of creating them internally. 

Benefits:

- **Testability** — You can pass mocks or configured objects in tests
- **Replaceability** — Easy to swap implementations
- **Single Responsibility** — Each class does one thing

---

## 🐛 The Problem

The `ParkingStatusCommand` had internal dependencies:

```php
// ❌ WRONG - Internal dependency, not testable
class ParkingStatusCommand extends Command
{
    protected function execute(...): int
    {
        $currentHour = (int) date('G');  // Created internally!
        
        if ($currentHour >= 9 && $currentHour < 23) {
            // Parking open
        }
    }
}
```

Problems:
- Can't test night hours
- Hardcoded times
- Violates Single Responsibility (logic + presentation)

---

## ✅ The Solution

### Approach 1: Service Class

```php
// ParkingStatusService.php
class ParkingStatusService
{
    public function __construct(
        protected int $openingHour = 9,
        protected int $closingHour = 23,
    ) {}

    public function isOpen(?DateTimeInterface $dateTime = null): bool
    {
        $dateTime ??= new DateTime();
        $hour = (int) $dateTime->format('G');
        
        return $hour >= $this->openingHour 
            && $hour < $this->closingHour;
    }
}
```

### Approach 2: Enrich Domain Entity (preferred in DDD)

```php
// ParkingGarage.php
class ParkingGarage
{
    public function __construct(
        // ... other parameters
        protected int $openingHour = 9,
        protected int $closingHour = 23,
    ) {}

    public function isOpen(?DateTimeInterface $dateTime = null): bool
    {
        $dateTime ??= new DateTime();
        $hour = (int) $dateTime->format('G');
        
        return $hour >= $this->openingHour 
            && $hour < $this->closingHour;
    }
}
```

The command becomes simple:

```php
public function __construct(
    private readonly ParkingGarage $parkingGarage,
) {
    parent::__construct();
}

protected function execute(...): int
{
    if ($this->parkingGarage->isOpen()) {
        // ...
    }
}
```

---

## 🧪 Testability

Now you can test any time:

```php
public function testParkingIsOpenAt10AM(): void
{
    $dateTime = new DateTime('10:00');
    $this->assertTrue($this->garage->isOpen($dateTime));
}

public function testParkingIsClosedAtMidnight(): void
{
    $dateTime = new DateTime('00:00');
    $this->assertFalse($this->garage->isOpen($dateTime));
}

public function testParkingIsClosedAt2259(): void
{
    $dateTime = new DateTime('22:59:59');
    $this->assertTrue($this->garage->isOpen($dateTime));
}
```

---

## 📂 File Structure

```
src/
├── Domain/
│   └── Entity/
│       └── ParkingGarage.php    ← Enriched with isOpen()
│
└── Application/
    └── Command/
        └── ParkingStatusCommand.php

tests/
└── Unit/
    └── Domain/
        └── Entity/
            └── ParkingGarageTest.php
```

---

## 💡 Service Class vs Domain Entity

| Service Class | Domain Entity |
|---------------|---------------|
| Complex logic involving multiple entities | Logic that naturally belongs to the entity |
| Orchestration of operations | Intrinsic object behavior |
| Useful as a first refactoring step | Preferred in DDD |

In this case, asking "is the parking open?" is a natural question to ask the garage itself.

---

## ➡️ Navigation

- [← Episode 03: Symfony Console](../03-symfony-console-component-integration/)
- [↑ Back to main README](../../README.md)
- [→ Episode 05: Strategy Pattern](../05-strategy-pattern/)