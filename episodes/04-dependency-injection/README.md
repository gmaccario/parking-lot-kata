# Episodio 04: Dependency Injection in PHP Puro

🇬🇧 [English version](README-en.md)

## 📺 Guarda il Video

[Link al video YouTube](https://youtu.be/ZNI3K5WfNPo)

---

## 🎯 Cosa Imparerai

- Cos'è la Dependency Injection e perché è importante
- Come estrarre la logica da un comando per renderla testabile
- Due approcci: Service Class vs. Domain Entity
- Quando arricchire l'entità di dominio invece di creare servizi

---

## 🔑 Concetti Chiave

### Dependency Injection

Iniettare oggetti dall'esterno invece di crearli internamente. 

Vantaggi:

- **Testabilità** — Puoi passare mock od oggetti configurati nei test
- **Sostituibilità** — Facile scambiare implementazioni
- **Single Responsibility** — Ogni classe fa una cosa sola

---

## 🐛 Il Problema

Il comando `ParkingStatusCommand` aveva dipendenze interne:

```php
// ❌ SBAGLIATO - Dipendenza interna, non testabile
class ParkingStatusCommand extends Command
{
    protected function execute(...): int
    {
        $currentHour = (int) date('G');  // Creato internamente!
        
        if ($currentHour >= 9 && $currentHour < 23) {
            // Parking aperto
        }
    }
}
```

Problemi:
- Non puoi testare gli orari notturni
- Orari hardcoded
- Viola Single Responsibility (logica + presentazione)

---

## ✅ La Soluzione

### Approccio 1: Service Class

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

### Approccio 2: Arricchire il Domain Entity (preferito in DDD)

```php
// ParkingGarage.php
class ParkingGarage
{
    public function __construct(
        // ... altri parametri
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

Il comando diventa semplice:

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

## 🧪 Testabilità

Ora puoi testare qualsiasi orario:

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

## 📂 Struttura File

```
src/
├── Domain/
│   └── Entity/
│       └── ParkingGarage.php    ← Arricchito con isOpen()
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

## 💡 Service Class vs. Domain Entity

| Service Class | Domain Entity |
|---------------|---------------|
| Logica complessa che coinvolge più entità | Logica che appartiene naturalmente all'entità |
| Orchestrazione di operazioni | Comportamento intrinseco dell'oggetto |
| Utile come primo step di refactoring | Preferito in DDD |

In questo caso, chiedere "il parking è aperto?" è una domanda naturale da fare al garage stesso.

---

## ➡️ Navigazione

- [← Episodio 03: Symfony Console](../03-symfony-console-component-integration/)
- [↑ Torna al README principale](../../README.md)
- [→ Episodio 05: Strategy Pattern](../05-strategy-pattern/)