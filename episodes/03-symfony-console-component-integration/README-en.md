# Episode 03: Symfony Console Integration in Pure PHP

🇮🇹 [Versione italiana](README.md)

## 📺 Watch the Video

[Link to YouTube video](https://youtu.be/uqCo_pUl9Dg)

---

## 🎯 What You'll Learn

- Why use Symfony Console instead of simple scripts
- How to integrate a Symfony component in a pure PHP project
- Creating commands with classes and attributes
- Using SymfonyStyle for formatted output
- Testing commands with PHPUnit

---

## 🔑 Key Concepts

### Why Symfony Console?

| Simple Script | Symfony Console |
|---------------|-----------------|
| Scattered files | Commands organized in classes |
| Manual argument parsing | Automatic argument/option handling |
| Manual output | SymfonyStyle for consistent output |
| Hard to test | Easily testable |
| Not reusable | Extendable commands |

Symfony Console is the PHP community standard, used by Composer, Laravel Artisan, and many other CLIs.

---

## 🚀 Setup

### Installation

```bash
composer require symfony/console
```

### Entry Point: bin/console

```php
#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\Command\ParkingStatusCommand;
use App\Command\SmartParkingSystemCommand;

$application = new Application('Parking Lot CLI', '0.1.0');

$application->add(new ParkingStatusCommand());
$application->add(new SmartParkingSystemCommand());

$application->run();
```

```bash
chmod +x bin/console
```

---

## 📝 Anatomy of a Command

```php
<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:parking-status',
    description: 'Check if the parking lot is open or closed'
)]
class ParkingStatusCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        // Logic...
        
        $io->info('Parking is open');
        
        return Command::SUCCESS;
    }
}
```

---

## 🎨 SymfonyStyle Output

```php
$io = new SymfonyStyle($input, $output);

$io->title('Welcome to Smart Parking System');
$io->text('Press CTRL+C to exit');
$io->info('Vehicle parked successfully');
$io->error('Invalid vehicle type');
$io->writeln(str_repeat('-', 40));
```

---

## ❓ Interactive Input

```php
$helper = $this->getHelper('question');

$question = new Question('What vehicle is entering? ');
$question->setAutocompleterValues(['car', 'van', 'motorcycle']);

$answer = $helper->ask($input, $output, $question);
```

---

## 📂 File Structure

```
bin/
└── console                      ← Entry point (executable)

src/
└── Command/
    ├── ParkingStatusCommand.php
    └── SmartParkingSystemCommand.php

tests/
└── Unit/
    └── Command/
        └── ParkingStatusCommandTest.php
```

---

## 🧪 Testing Commands

```php
public function testParkingStatusCommand(): void
{
    $application = new Application();
    $application->add(new ParkingStatusCommand());

    $command = $application->find('app:parking-status');
    $commandTester = new CommandTester($command);
    
    $commandTester->execute([]);

    $this->assertEquals(0, $commandTester->getStatusCode());
    $this->assertMatchesRegularExpression(
        '/Parking is (open|closed)/',
        $commandTester->getDisplay()
    );
}
```

---

## 💡 Free Features

Running `bin/console` automatically gives you:

- `list` — List of all available commands
- `--help` — Help for any command
- `--version` — Application version
- Command autocompletion

---

## ➡️ Navigation

- [← Episode 02: Unit Testing & Quality Tools](../02-tests-refactoring-quality-tools/)
- [↑ Back to main README](../../README.md)
- [→ Episode 04: Dependency Injection](../04-dependency-injection/)