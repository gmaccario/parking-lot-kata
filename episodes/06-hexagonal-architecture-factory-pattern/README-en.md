# Episode 06: Hexagonal Architecture & Factory Pattern

🇮🇹 [Versione italiana](README.md)

## 📺 Watch the Video

[Link to YouTube video](https://youtu.be/uhfUYHX0iN8)

---

## 🎯 What You'll Learn

- Hexagonal Architecture (Ports & Adapters) in practice
- The dependency direction rule
- Factory Pattern: a creational pattern
- How to fix architectural violations
- Testing the factory

---

## 🔑 Key Concepts

### Hexagonal Architecture

```
┌─────────────────────────────────────┐
│           Infrastructure            │  ← Adapters (concrete implementations)
│  ┌───────────────────────────────┐  │
│  │         Application           │  │  ← Ports (interfaces) + Use Cases
│  │  ┌─────────────────────────┐  │  │
│  │  │        Domain           │  │  │  ← Entities, Value Objects
│  │  └─────────────────────────┘  │  │
│  └───────────────────────────────┘  │
└─────────────────────────────────────┘

Dependency direction: Infrastructure → Application → Domain
Never the opposite!
```

### Factory Pattern

The Factory Pattern solves the problem of instantiating objects without specifying concrete classes. Benefits:

- Client only knows the factory, not specific implementations
- Adding new types requires changes only to the factory
- Respects the Open-Closed principle

---

## 🐛 The Problem

In the previous video, the command (Application layer) depended directly on concrete parsers (Infrastructure layer):

```php
// ❌ WRONG - Application depends on Infrastructure
use App\Infrastructure\Parser\CsvParserStrategy;
use App\Infrastructure\Parser\JsonParserStrategy;
```

This violates the hexagonal architecture dependency rule.

## ✅ The Solution

1. **Create a Port** — `ParserFactoryInterface` in Application layer
2. **Create an Adapter** — `ParserFactory` in Infrastructure layer
3. **Inject the interface** — Command depends only on the port

```php
// ✅ CORRECT - Application depends only on interfaces
use App\Application\Parser\ParserFactoryInterface;
```

---

## 📂 Modified Files

```
src/
├── Application/
│   └── Parser/
│       └── ParserFactoryInterface.php   ← Port (new interface)
│
└── Infrastructure/
    └── Parser/
        └── ParserFactory.php            ← Adapter (implementation)

tests/
└── Unit/
    └── Infra/
        └── Parser/
            └── ParserFactoryTest.php    ← Factory test
```

---

## 🧪 Run Tests

```bash
./vendor/bin/phpunit tests/Unit/Infra/Parser/ParserFactoryTest.php
```

---

## 💡 Extensibility

Adding a new format (e.g., TXT) requires only:

1. Create `TxtParserStrategy` in Infrastructure
2. Add the case in `ParserFactory`

No changes to Domain or Application — Open-Closed principle respected.

---

## ➡️ Navigation

- [← Episode 05: Strategy Pattern](../05-strategy-pattern/)
- [↑ Back to main README](../../README.md)
- [→ Complete Solution](../../complete-solution/)