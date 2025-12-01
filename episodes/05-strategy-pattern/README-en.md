# Episode 05: Strategy Pattern - From If-Else Chaos to Clean Design Pattern

🇮🇹 [Versione italiana](README.md)

## 📺 Watch the Video

[Link to YouTube video](https://youtu.be/msoG82vf_1k)

---

## 🎯 What You'll Learn

- What Design Patterns are and the three families (behavioral, creational, structural)
- Strategy Pattern: a behavioral pattern
- How to eliminate if-else chains
- Open-Closed principle in practice
- Basic hexagonal architecture structure

---

## 🔑 Key Concepts

### Strategy Pattern

The Strategy Pattern allows organizing a family of algorithms into separate classes and making them interchangeable. 

Three main elements:

1. **Interface** — The contract every strategy must respect
2. **Concrete Strategies** — The specific implementations
3. **Context** — Uses strategies without knowing implementation details

---

## 🐛 The Problem

Parsing files in different formats (CSV, JSON, XML) with if-else:

```php
// ❌ WRONG - If-else chain
if ($extension === 'csv') {
    // 50 lines of CSV logic...
} elseif ($extension === 'json') {
    // 50 lines of JSON logic...
} elseif ($extension === 'xml') {
    // 50 lines of XML logic...
}
// New format? Reopen this file and add more code.
```

Problems: violates Open-Closed, hard to test, high cognitive load.

## ✅ The Solution

```php
// ✅ CORRECT - Strategy Pattern
interface ParserInterface {
    public function parse(string $path): array;
}

class CsvParserStrategy implements ParserInterface { /* ... */ }
class JsonParserStrategy implements ParserInterface { /* ... */ }
class XmlParserStrategy implements ParserInterface { /* ... */ }
```

New format? Add a new class. No changes to existing code.

---

## 📂 File Structure

```
src/
├── Application/
│   ├── Command/
│   │   └── ParkingImportReservationsCommand.php
│   ├── Parser/
│   │   └── ParserInterface.php              ← Interface
│   └── UseCase/
│       └── ImportReservationsUseCase.php    ← Context
│
└── Infrastructure/
    └── Parser/
        ├── CsvParserStrategy.php            ← Concrete strategy
        ├── JsonParserStrategy.php           ← Concrete strategy
        └── XmlParserStrategy.php            ← Concrete strategy

data/
├── parking-reservation.csv
├── parking-reservation.json
└── parking-reservation.xml
```

---

## 🧪 Test the Command

```bash
# CSV
./bin/console app:parking-import-reservations data/parking-reservation.csv

# JSON
./bin/console app:parking-import-reservations data/parking-reservation.json

# XML
./bin/console app:parking-import-reservations data/parking-reservation.xml
```

---

## 💡 Benefits

- **Open-Closed** — Extend without modifying
- **Single Responsibility** — Each strategy has one job
- **Testability** — Each class can be tested in isolation
- **Maintainability** — Less code to keep in mind

---

## ➡️ Navigation

- [← Episode 04: Dependency Injection](../04-dependency-injection/)
- [↑ Back to main README](../../README.md)
- [→ Episode 06: Hexagonal Architecture & Factory Pattern](../06-hexagonal-architecture-factory-pattern/)