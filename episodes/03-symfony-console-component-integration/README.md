# Episodio 03: Integrazione Symfony Console in PHP Puro

🇬🇧 [English version](README-en.md)

## 📺 Guarda il Video

[Link al video YouTube](https://youtu.be/uqCo_pUl9Dg)

---

## 🎯 Cosa Imparerai

- Perché usare Symfony Console invece di script semplici
- Come integrare un componente Symfony in un progetto PHP puro
- Creare comandi con classi e attributi
- Usare SymfonyStyle per output formattati
- Testare i comandi con PHPUnit

---

## 🔑 Concetti Chiave

### Perché Symfony Console?

| Script Semplice | Symfony Console |
|-----------------|-----------------|
| File sparsi | Comandi organizzati in classi |
| Parsing manuale argomenti | Gestione automatica argomenti/opzioni |
| Output manuale | SymfonyStyle per output consistente |
| Difficile da testare | Facilmente testabile |
| Non riutilizzabile | Comandi estendibili |

Symfony Console è lo standard della community PHP, usato da Composer, Laravel Artisan, e molti altri CLI.

---

## 🚀 Setup

### Installazione

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

## 📝 Anatomia di un Comando

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
        
        // Logica...
        
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

## ❓ Input Interattivo

```php
$helper = $this->getHelper('question');

$question = new Question('What vehicle is entering? ');
$question->setAutocompleterValues(['car', 'van', 'motorcycle']);

$answer = $helper->ask($input, $output, $question);
```

---

## 📂 Struttura File

```
bin/
└── console                      ← Entry point (eseguibile)

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

## 🧪 Testare i Comandi

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

## 💡 Funzionalità Gratuite

Eseguendo `bin/console` ottieni automaticamente:

- `list` — Elenco di tutti i comandi disponibili
- `--help` — Aiuto per ogni comando
- `--version` — Versione dell'applicazione
- Autocompletamento dei comandi

---

## ➡️ Navigazione

- [← Episodio 02: Unit Testing & Quality Tools](../02-tests-refactoring-quality-tools/)
- [↑ Torna al README principale](../../README.md)
- [→ Episodio 04: Dependency Injection](../04-dependency-injection/)