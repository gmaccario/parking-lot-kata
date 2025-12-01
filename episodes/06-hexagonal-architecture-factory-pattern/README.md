# Episodio 06: Hexagonal Architecture e Factory Pattern

🇬🇧 [English version](README-en.md)

## 📺 Guarda il Video

[Link al video YouTube](https://youtu.be/uhfUYHX0iN8)

---

## 🎯 Cosa Imparerai

- Hexagonal Architecture (Ports & Adapters) in pratica
- La regola della direzione delle dipendenze
- Factory Pattern: un pattern creazionale
- Come correggere violazioni architetturali
- Testing della factory

---

## 🔑 Concetti Chiave

### Hexagonal Architecture

```
┌─────────────────────────────────────┐
│           Infrastructure            │  ← Adapters (implementazioni concrete)
│  ┌───────────────────────────────┐  │
│  │         Application           │  │  ← Ports (interfacce) + Use Cases
│  │  ┌─────────────────────────┐  │  │
│  │  │        Domain           │  │  │  ← Entities, Value Objects
│  │  └─────────────────────────┘  │  │
│  └───────────────────────────────┘  │
└─────────────────────────────────────┘

Direzione dipendenze: Infrastructure → Application → Domain
Mai il contrario!
```

### Factory Pattern

Il Factory Pattern risolve il problema di *istanziare* oggetti senza specificare le classi concrete. Vantaggi:

- Il client conosce solo la factory, non le implementazioni specifiche
- Aggiungere nuovi tipi richiede modifiche solo alla factory
- Rispetta il principio Open-Closed

---

## 🐛 Il Problema

Nel video precedente, il comando (livello Application) dipendeva direttamente dai parser concreti (livello Infrastructure):

```php
// ❌ SBAGLIATO - Application dipende da Infrastructure
use App\Infrastructure\Parser\CsvParserStrategy;
use App\Infrastructure\Parser\JsonParserStrategy;
```

Questo viola la regola delle dipendenze dell'architettura esagonale.

## ✅ La Soluzione

1. **Creare una Port** — `ParserFactoryInterface` nel livello Application
2. **Creare un Adapter** — `ParserFactory` nel livello Infrastructure
3. **Iniettare l'interfaccia** — Il comando dipende solo dalla port

```php
// ✅ CORRETTO - Application dipende solo da interfacce
use App\Application\Parser\ParserFactoryInterface;
```

---

## 📂 File Modificati

```
src/
├── Application/
│   └── Parser/
│       └── ParserFactoryInterface.php   ← Port (nuova interfaccia)
│
└── Infrastructure/
    └── Parser/
        └── ParserFactory.php            ← Adapter (implementazione)

tests/
└── Unit/
    └── Infra/
        └── Parser/
            └── ParserFactoryTest.php    ← Test della factory
```

---

## 🧪 Eseguire i Test

```bash
./vendor/bin/phpunit tests/Unit/Infra/Parser/ParserFactoryTest.php
```

---

## 💡 Estendibilità

Aggiungere un nuovo formato (es. TXT) richiede solo:

1. Creare `TxtParserStrategy` in Infrastructure
2. Aggiungere il case nella `ParserFactory`

Nessuna modifica al Domain o Application — principio Open-Closed rispettato.

---

## ➡️ Navigazione

- [← Episodio 05: Strategy Pattern](../05-strategy-pattern/)
- [↑ Torna al README principale](../../README.md)
- [→ Soluzione Completa](../../complete-solution/)