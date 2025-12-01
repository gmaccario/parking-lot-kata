# Episode 02: Unit Testing, Refactoring & Quality Tools

🇮🇹 [Versione italiana](README.md)

## 📺 Watch the Video

[Link to YouTube video](https://youtu.be/oPCxWAiHyxg)

---

## 🎯 What You'll Learn

- Writing tests with PHPUnit
- Test-driven refactoring
- Configuring and using PHP CS Fixer
- Static analysis with PHPStan

---

## 🔑 Key Concepts

### Test-Driven Refactoring

1. **Write tests** — Verify current behavior
2. **Run tests** — All must be green
3. **Refactor** — Improve the code
4. **Re-run tests** — Must stay green

Tests give you confidence to improve code without breaking existing functionality.

---

## 🧪 PHPUnit Setup

### Configuration phpunit.xml

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

### Test Structure

Mirror the `src/` structure inside `tests/Unit/`:

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

## 📝 Test Examples

### Basic Test: Interface and Value

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

### Complex Tests: State and Behavior

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
    // ...continue until full
    
    $this->assertFalse($floor->hasSpace(new Car()));
}
```

---

## 🔧 PHP CS Fixer

### Installation

```bash
composer require --dev friendsofphp/php-cs-fixer
```

### Configuration .php-cs-fixer.php

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

### Commands

```bash
# Preview changes (dry run)
./vendor/bin/php-cs-fixer fix --dry-run

# Apply fixes
./vendor/bin/php-cs-fixer fix
```

---

## 📊 PHPStan

### Installation

```bash
composer require --dev phpstan/phpstan
```

### Commands

```bash
# Base level (0)
./vendor/bin/phpstan analyse src --level=0

# Maximum level (10)
./vendor/bin/phpstan analyse src --level=10
```

### Levels

PHPStan has 11 levels (0-10). Each level adds stricter rules:

- **0-3**: Basic errors, missing types
- **4-6**: Stricter type checks
- **7-9**: Advanced rules
- **10**: Maximum strictness

### Fix Example

```php
// ❌ PHPStan level 6 error: missing array type
public function __construct(array $floors) {}

// ✅ Fixed
/** @param ParkingFloor[] $floors */
public function __construct(array $floors) {}
```

---

## 📂 File Structure

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

## 🚀 Useful Commands

```bash
# Run all tests
./vendor/bin/phpunit

# Fix code style
./vendor/bin/php-cs-fixer fix

# Static analysis
./vendor/bin/phpstan analyse src tests --level=6
```

---

## ➡️ Navigation

- [← Episode 01: Introduction & Clean Code](../01-basic-implementation/)
- [↑ Back to main README](../../README.md)
- [→ Episode 03: Symfony Console](../03-symfony-console-component-integration/)