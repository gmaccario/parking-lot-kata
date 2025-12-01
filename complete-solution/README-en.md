# 🏁 Complete Solution

🇮🇹 [Versione italiana](README.md)

This is the final implementation of the Parking Lot Kata with all patterns and architectural principles applied.

---

## ⚠️ Important Note

If you're learning, **don't start here**.

This complete solution only makes sense after understanding the journey that brought us here. Every architectural decision has a reason explained in the individual episodes.

👉 **Start from:** [`/episodes/01-basic-implementation`](../episodes/01-basic-implementation/)

---

## 📺 Complete Video Series

| Episodio | Argomento                                                          | Video                                  |
|----------|--------------------------------------------------------------------|----------------------------------------|
| 01 | Introduction & Clean Code Basics                                   | [Watch](https://youtu.be/2vNkzn3NmtQ)  |
| 02 | Unit Test, Refactoring, Quality Tools                              | [Watch](https://youtu.be/oPCxWAiHyxg) |
| 03 | Symfony Console Integration                                        | [Watch](https://youtu.be/uqCo_pUl9Dg) |
| 04 | Dependency Injection in pure PHP                                   | [Watch](https://youtu.be/ZNI3K5WfNPo) |
| 05 | Strategy Pattern: Refactoring from If-Else to Design Pattern Clean | [Watch](https://youtu.be/msoG82vf_1k) |
| 06 | Hexagonal Architecture and Factory Pattern                         | [Watch](https://youtu.be/uhfUYHX0iN8) |

---

## 🎯 What This Solution Includes

- **Domain-Driven Design and Hexagonal Architecture** — Clear separation between domain, application, and infrastructure
- **Strategy Pattern** — Flexible pricing without if-else chains
- **Factory Pattern** — Decoupled object creation
- **Dependency Injection** — No hardcoded dependencies
- **Comprehensive tests** — Unit and integration tests with PHPUnit
- **Symfony Console** — Ready-to-use CLI interface

---

## 🚀 Quick Start

```bash
# Install dependencies
composer install

# Run tests
./vendor/bin/phpunit

# Run the application
php bin/console app:parking-status
php bin/console app:smart-parking-system 
php bin/console app:parking-import-reservations ./data/parking-reservations.csv
php bin/console app:parking-import-reservations ./data/parking-reservations.txt
php bin/console app:parking-import-reservations ./data/parking-reservations.json
php bin/console app:parking-import-reservations ./data/parking-reservations.xml
```

---

## 📂 Structure

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

## 📬 Connect

- **YouTube:** [Giuseppe Maccario](https://www.youtube.com/@GiuseppeMaccario)
- **Website:** [giuseppemaccario.com](https://www.giuseppemaccario.com)
- **LinkedIn:** [Connect with me](https://www.linkedin.com/in/giuseppemaccario/)