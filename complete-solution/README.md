# 🏁 Soluzione Completa

🇬🇧 [English version](README-en.md)

Questa è l'implementazione finale della Parking Lot Kata con tutti i pattern e i principi architetturali applicati.

---

## ⚠️ Nota Importante

Se stai imparando, **non partire da qui**.

Questa soluzione completa ha senso solo dopo aver compreso il percorso che ci ha portato qui. Ogni scelta architetturale ha una motivazione che viene spiegata nei singoli episodi.

👉 **Inizia da:** [`/episodes/01-basic-implementation`](../episodes/01-basic-implementation/)

---

## 📺 Serie Video Completa

| Episodio | Argomento                                                        | Video |
|----------|------------------------------------------------------------------|-------|
| 01 | Introduzione & Clean Code Basics                                 | [Guarda](https://youtu.be/2vNkzn3NmtQ) |
| 02 | Unit Test, Refactoring, Quality Tools                            | [Guarda](https://youtu.be/oPCxWAiHyxg) |
| 03 | Integrazione Symfony Console                                     | [Guarda](https://youtu.be/uqCo_pUl9Dg) |
| 04 | Dependency Injection in PHP Puro                                 | [Guarda](https://youtu.be/ZNI3K5WfNPo) |
| 05 | Strategy Pattern: Refactoring da If-Else a Design Pattern Clean  | [Guarda](https://youtu.be/msoG82vf_1k) |
| 06 | Hexagonal Architecture e Factory Pattern                         | [Guarda](https://youtu.be/uhfUYHX0iN8) |

---

## 🎯 Cosa Include Questa Soluzione

- **Domain-Driven Design e Hexagonal Architecture** — Separazione netta tra dominio, applicazione e infrastruttura
- **Strategy Pattern** — Parsing flessibile senza catene di if-else
- **Factory Pattern** — Creazione di oggetti disaccoppiata
- **Dependency Injection** — Nessuna dipendenza hardcoded
- **Test completi** — Unit test e integration test con PHPUnit
- **Symfony Console** — Interfaccia CLI pronta all'uso

---

## 🚀 Quick Start

```bash
# Installa le dipendenze
composer install

# Esegui i test
./vendor/bin/phpunit

# Esegui l'applicazione
php bin/console app:parking-status
php bin/console app:smart-parking-system 
php bin/console app:parking-import-reservations ./data/parking-reservations.csv
php bin/console app:parking-import-reservations ./data/parking-reservations.txt
php bin/console app:parking-import-reservations ./data/parking-reservations.json
php bin/console app:parking-import-reservations ./data/parking-reservations.xml
```

---

## 📂 Struttura

```
complete-solution/
│
├── src/
│   ├── Domain/
│   │   ├── Entity/
│   │   ├── Enum/
│   │   ├── Exception/
│   │   └── Interfaces/
│   │
│   ├── Application/
│   │   ├── Command/
│   │   ├── Parser/
│   │   └── UseCase/
│   │
│   └── Infrastructure/
│       └── Parser/
│
├── tests/
│   └── Unit/
│
├── bin/
│   └── console
│
├── data/
│   └── csv/json/txt/xml
│
├── doc/
│   └── IT-Requirements.pdf
│
├── README.md
└── composer.json
```

---

## 📬 Contatti

- **YouTube:** [Giuseppe Maccario](https://www.youtube.com/@GiuseppeMaccario)
- **Website:** [giuseppemaccario.com](https://www.giuseppemaccario.com)
- **LinkedIn:** [Connettiti con me](https://www.linkedin.com/in/giuseppemaccario/)