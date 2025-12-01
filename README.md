# 🏗️ PHP 8 Parking Lot Kata - Serie Completa

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](#)
![PHP](https://img.shields.io/badge/PHP-8.4%2B-777bb3.svg)

🇬🇧 [English version](README-en.md)

> **Impara Clean Architecture, Design Patterns e le best practices di PHP 8**  
> attraverso una kata di programmazione reale con video tutorial completi.

---

## 📺 Serie di Video Tutorial

Questo repository accompagna la mia serie completa di tutorial su YouTube:

| Episodio | Argomento                                                        | Video |
|----------|------------------------------------------------------------------|-------|
| 01 | Introduzione & Clean Code Basics                                 | [Guarda](https://youtu.be/2vNkzn3NmtQ) |
| 02 | Unit Test, Refactoring, Quality Tools                            | [Guarda](https://youtu.be/oPCxWAiHyxg) |
| 03 | Integrazione Symfony Console                                     | [Guarda](https://youtu.be/uqCo_pUl9Dg) |
| 04 | Dependency Injection in PHP Puro                                 | [Guarda](https://youtu.be/ZNI3K5WfNPo) |
| 05 | Strategy Pattern: Refactoring da If-Else a Design Pattern Clean  | [Guarda](https://youtu.be/msoG82vf_1k) |
| 06 | Hexagonal Architecture e Factory Pattern                         | [Guarda](https://youtu.be/uhfUYHX0iN8) |

🔔 **[Iscriviti al mio canale YouTube](https://www.youtube.com/@GiuseppeMaccario)** per altri tutorial su PHP 8 e altro ancora!

---

## 🎯 Cosa Imparerai

- ✅ Hexagonal Architecture nella pratica
- ✅ Design Patterns come lo Strategy e il Factory Pattern
- ✅ Dependency Injection senza framework
- ✅ Principi SOLID applicati a codice reale
- ✅ Clean Code & Domain-Driven Design
- ✅ Test-Driven Development con PHPUnit

---

## 🚀 Quick Start

**Requisiti:** Solo Docker. Non serve PHP installato localmente.

```bash
# Clona il repository
git clone https://github.com/gmaccario/parking-lot-kata
cd parking-lot-kata

# Avvia il container
make up

# Entra nel container
make shell

# Scegli un episodio
cd episodes/04-dependency-injection

# Installa le dipendenze
composer install

# Leggi il file README dell'episodio specifico 
# Esegui specifici comandi

# Esegui i test
./vendor/bin/phpunit
```

**Comandi disponibili:**

| Comando | Descrizione |
|---------|-------------|
| `make up` | Avvia il container |
| `make down` | Ferma il container |
| `make shell` | Entra nel container |
| `make clean` | Rimuovi container e volumi |

---

## 📂 Struttura del Repository

```
parking-lot-kata/
│
├── README.md
├── README-en.md
│
├── episodes/
│   ├── 01-basic-implementation/
│   │   ├── README.md
│   │   ├── src/
│   │   ├── tests/
│   │   └── composer.json
│   │
│   ├── 02-tests-refactoring-quality-tools/
│   │   ├── README.md
│   │   ├── src/
│   │   ├── tests/
│   │   └── composer.json
│   │
│   ├── 03-symfony-console-component-integration/
│   ├── 04-dependency-injection/
│   ├── 05-strategy-pattern/
│   └── 06-hexagonal-architecture-factory-pattern/
│
├── docker-compose.yml
├── Makefile
└── LICENSE
```

Ogni episodio è autonomo e contiene:

- Codice funzionante completo
- Test esaustivi
- README con spiegazione dei concetti
- Link al video corrispondente

**Sei nuovo?** Inizia da `/episodes/01-basic-implementation` oppure [guarda l'espisodio su YouTube](https://youtu.be/2vNkzn3NmtQ).

---

## 💡 Perché Questa Kata?

Dopo 15 anni di sviluppo di sistemi PHP ad alto traffico (inclusi London2012.com e FIFA.com), ho visto cosa distingue uno sviluppatore junior da uno senior: **il pensiero architetturale, non la conoscenza della sintassi.**

Questa kata ti insegna a pensare in modo architetturale attraverso la pratica diretta.

---

## 🤝 Contribuire

Hai trovato un bug? Hai un suggerimento? Apri una issue!  
Vuoi aggiungere un miglioramento? Le PR sono benvenute.

---

## 📬 Contatti

- **YouTube:** [Giuseppe Maccario](https://www.youtube.com/@GiuseppeMaccario)
- **Website:** [giuseppemaccario.com](https://www.giuseppemaccario.com)
- **LinkedIn:** [Connettiti con me](https://www.linkedin.com/in/giuseppemaccario/)

---

## 📝 Licenza

MIT - Usa questo codice per imparare, insegnare e costruire ottimo software.

---

**⭐ Se questo repo ti ha aiutato a migliorare le tue skill PHP, lascia una stella!**  
Aiuta altri sviluppatori a scoprire questi tutorial.