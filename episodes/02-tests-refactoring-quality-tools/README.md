# Episodio 02: Unit Testing, Refactoring & Quality Tools

🇬🇧 [English version](README-en.md)

## 📺 Guarda il Video

[Link al video YouTube](https://youtu.be/oPCxWAiHyxg)

---

## 🎯 Cosa Imparerai

- Scrivere test con PHPUnit
- Refactoring guidato dai test
- Configurare e usare PHP CS Fixer
- Analisi statica con PHPStan

---

## 🔑 Concetti Chiave

### Test-Driven Refactoring

1. **Scrivi i test** — Verifica il comportamento attuale
2. **Esegui i test** — Devono essere tutti verdi
3. **Refactoring** — Migliora il codice
4. **Riesegui i test** — Devono restare verdi

I test ti danno la sicurezza di migliorare il codice senza rompere funzionalità esistenti.

---

## 🧪 PHPUnit Setup

### Configurazione phpunit.xml

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit>
    <testsuites>
        <testsuite name="unit">
            <directory suffix="Test.php">tests/Unit</directory>
        </testsuite>
    </testsuites>
    <source>
        <include>
            <directory suffix=".php">src</directory>
        </include>
    </source>
</phpunit>
```

### Struttura Test

Replica la struttura di `src/` dentro `tests/Unit/`:

```
src/
└── Domain/
    └── Entity/
        ├── Car.php
        └── ParkingFloor.php

tests/
└── Unit/
    └── Domain/
        └── Entity/
            ├── CarTest.php
            └── ParkingFloorTest.php
```

---

## 📝 Esempi di Test

### Test Base: Interfaccia e Valore

```php
class CarTest extends TestCase
{
    private Car $car;

    protected function setUp(): void
    {
        $this->car = new Car();
    }

    public function testCarImplementsSizeableInterface(): void
    {
        $this->assertInstanceOf(Sizeable::class, $this->car);
    }

    public function testGetSizeReturnsExpectedValue(): void
    {
        $this->assertEquals(1.0, $this->car->getSize());
    }
}
```

### Test Complessi: Stato e Comportamento

```php
public function testHasSpaceReturnsTrueWhenItemFits(): void
{
    $floor = new ParkingFloor(1.0);
    $car = new Car();
    
    $this->assertTrue($floor->hasSpace($car));
}

public function testHasSpaceReturnsFalseWhenFull(): void
{
    $floor = new ParkingFloor(0.5);
    $car = new Car();
    
    $this->assertFalse($floor->hasSpace($car));
}

public function testFloorFillsUpProgressively(): void
{
    $floor = new ParkingFloor(5.0);
    
    $this->assertTrue($floor->hasSpace(new Car()));
    $floor->park(new Car());  // 1.0
    
    $floor->park(new Motorcycle());  // 1.5
    $floor->park(new Motorcycle());  // 2.0
    // ...continua fino a riempire
    
    $this->assertFalse($floor->hasSpace(new Car()));
}
```

---

## 🔧 PHP CS Fixer

### Installazione

```bash
composer require --dev friendsofphp/php-cs-fixer
```

### Configurazione .php-cs-fixer.php

```php
<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests');

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder);
```

### Comandi

```bash
# Anteprima modifiche (dry run)
./vendor/bin/php-cs-fixer fix --dry-run

# Applica le correzioni
./vendor/bin/php-cs-fixer fix
```

---

## 📊 PHPStan

### Installazione

```bash
composer require --dev phpstan/phpstan
```

### Comandi

```bash
# Livello base (0)
./vendor/bin/phpstan analyse src --level=0

# Livello massimo (10)
./vendor/bin/phpstan analyse src --level=10
```

### Livelli

PHPStan ha 11 livelli (0-10). Ogni livello aggiunge regole più strette:

- **0-3**: Errori base, tipi mancanti
- **4-6**: Controlli sui tipi più rigorosi
- **7-9**: Regole avanzate
- **10**: Massima severità

### Esempio di Fix

```php
// ❌ PHPStan level 6 error: missing array type
public function __construct(array $floors) {}

// ✅ Corretto
/** @param ParkingFloor[] $floors */
public function __construct(array $floors) {}
```

---

## 📂 Struttura File

```
├── .php-cs-fixer.php
├── phpunit.xml
├── src/
│   └── Domain/
│       └── Entity/
│           ├── Car.php
│           ├── Van.php
│           ├── Motorcycle.php
│           └── ParkingFloor.php
│
└── tests/
    └── Unit/
        └── Domain/
            └── Entity/
                ├── CarTest.php
                ├── VanTest.php
                ├── MotorcycleTest.php
                └── ParkingFloorTest.php
```

---

## 🚀 Comandi Utili

```bash
# Esegui tutti i test
./vendor/bin/phpunit

# Correggi lo stile del codice
./vendor/bin/php-cs-fixer fix

# Analisi statica
./vendor/bin/phpstan analyse src tests --level=6
```

---

## ➡️ Navigazione

- [← Episodio 01: Introduzione & Clean Code](../01-basic-implementation/)
- [↑ Torna al README principale](../../README.md)
- [→ Episodio 03: Symfony Console](../03-symfony-console-component-integration/)