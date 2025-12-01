# Episodio 05: Strategy Pattern - Dal Caos degli If-Else al Design Pattern

🇬🇧 [English version](README-en.md)

## 📺 Guarda il Video

[Link al video YouTube](https://youtu.be/msoG82vf_1k)

---

## 🎯 Cosa Imparerai

- Cos'è un Design Pattern e le tre famiglie (behavioral, creational, structural)
- Strategy Pattern: un pattern comportamentale
- Come eliminare le catene di if-else
- Principio Open-Closed in pratica
- Struttura base dell'architettura esagonale

---

## 🔑 Concetti Chiave

### Strategy Pattern

Il pattern Strategy permette di organizzare una famiglia di algoritmi in classi separate e renderli intercambiabili. 

Tre elementi principali:

1. **Interface** — Il contratto che ogni strategia deve rispettare
2. **Concrete Strategies** — Le implementazioni specifiche
3. **Context** — Usa le strategie senza conoscere i dettagli implementativi

---

## 🐛 Il Problema

Parsing di file in formati diversi (CSV, JSON, XML) con if-else:

```php
// ❌ SBAGLIATO - Catena di if-else
if ($extension === 'csv') {
    // 50 righe di logica CSV...
} elseif ($extension === 'json') {
    // 50 righe di logica JSON...
} elseif ($extension === 'xml') {
    // 50 righe di logica XML...
}
// Nuovo formato? Riapri questo file e aggiungi altro codice.
```

Problemi: viola Open-Closed, difficile da testare, alto carico cognitivo.

## ✅ La Soluzione

```php
// ✅ CORRETTO - Strategy Pattern
interface ParserInterface {
    public function parse(string $path): array;
}

class CsvParserStrategy implements ParserInterface { /* ... */ }
class JsonParserStrategy implements ParserInterface { /* ... */ }
class XmlParserStrategy implements ParserInterface { /* ... */ }
```

Nuovo formato? Aggiungi una nuova classe. Nessuna modifica al codice esistente.

---

## 📂 Struttura File

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
        ├── CsvParserStrategy.php            ← Strategia concreta
        ├── JsonParserStrategy.php           ← Strategia concreta
        └── XmlParserStrategy.php            ← Strategia concreta

data/
├── parking-reservation.csv
├── parking-reservation.json
└── parking-reservation.xml
```

---

## 🧪 Testare il Comando

```bash
# CSV
./bin/console app:parking-import-reservations data/parking-reservation.csv

# JSON
./bin/console app:parking-import-reservations data/parking-reservation.json

# XML
./bin/console app:parking-import-reservations data/parking-reservation.xml
```

---

## 💡 Vantaggi

- **Open-Closed** — Estendi senza modificare
- **Single Responsibility** — Ogni strategia ha una sola responsabilità
- **Testabilità** — Ogni classe può essere testata in isolamento
- **Manutenibilità** — Meno codice da tenere a mente

---

## ➡️ Navigazione

- [← Episodio 04: Dependency Injection](../04-dependency-injection/)
- [↑ Torna al README principale](../../README.md)
- [→ Episodio 06: Hexagonal Architecture & Factory Pattern](../06-hexagonal-architecture-factory-pattern/)