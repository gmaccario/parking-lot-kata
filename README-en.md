# 🏗️ PHP 8 Parking Lot Kata - Complete Series

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](#)
![PHP](https://img.shields.io/badge/PHP-8.4%2B-777bb3.svg)

🇮🇹 [Versione italiana](README.md)

> **Learn Clean Architecture, Design Patterns, and PHP 8 best practices**  
> through a real-world coding kata with full video tutorials.

---

## 📺 Video Tutorial Series

This repository accompanies my complete YouTube tutorial series:

| Episodio | Argomento                                                          | Video                                  |
|----|--------------------------------------------------------------------|----------------------------------------|
| 01 | Introduction & Clean Code Basics                                   | [Watch](https://youtu.be/2vNkzn3NmtQ)  |
| 02 | Unit Test, Refactoring, Quality Tools                              | [Watch](https://youtu.be/oPCxWAiHyxg) |
| 03 | Symfony Console Integration                                        | [Watch](https://youtu.be/uqCo_pUl9Dg) |
| 04 | Dependency Injection in pure PHP                                   | [Watch](https://youtu.be/ZNI3K5WfNPo) |
| 05 | Strategy Pattern: Refactoring from If-Else to Design Pattern Clean | [Watch](https://youtu.be/msoG82vf_1k) |
| 06 | Hexagonal Architecture and Factory Pattern                         | [Watch](https://youtu.be/uhfUYHX0iN8) |
| 07 | Eliminating Primitive Obsession with Value Objects and Aggregates  | [Watch](https://www.youtube.com/watch?v=ox4obH0x2YU) |

🔔 **[Subscribe to my YouTube channel](https://www.youtube.com/@GiuseppeMaccario)** for more PHP architecture tutorials

---

## 🎯 What You'll Learn

- ✅ Hexagonal Architecture in practice
- ✅ Design Patterns such as the Strategy and the Factory Pattern
- ✅ Dependency Injection without frameworks
- ✅ SOLID principles applied to real code
- ✅ Clean Code & Domain-Driven Design
- ✅ Test-Driven Development with PHPUnit

---

## 🚀 Quick Start

**Requirements**: PHP 8.4+ and Composer. Alternatively, you can use Docker.

### Option 1: Local PHP (as shown in the videos)

```bash
# Clone the repository
git clone https://github.com/gmaccario/parking-lot-kata
cd parking-lot-kata

# Choose an episode
cd episodes/04-dependency-injection

# Install dependencies
composer install

# Run tests
./vendor/bin/phpunit

# Read the specific episode's README file
# Run the specific commands
```

### Option 2: Docker
```bash
# Clone the repository
git clone https://github.com/gmaccario/parking-lot-kata
cd parking-lot-kata

# Start the container
make up

# Enter the container
make shell

# Choose an episode
cd episodes/04-dependency-injection

# Install dependencies
composer install

# Run tests
./vendor/bin/phpunit

# Read the specific episode's README file
# Run the specific commands
```

**Available commands:**

| Command | Description |
|---------|-------------|
| `make up` | Start container |
| `make down` | Stop container |
| `make shell` | Enter container shell |
| `make clean` | Remove container and volumes |

---

## 📂 Repository Structure

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

Each episode is self-contained with:

- Complete working code
- Comprehensive tests
- A README explaining the concepts
- Link to corresponding video

**New here?** Start with `/episodes/01-basic-implementation` or [watch the episode on YouTube](https://youtu.be/2vNkzn3NmtQ).

---

## 💡 Why This Kata?

After 15 years building high-traffic PHP systems (including London2012.com and FIFA.com), I've seen what separates junior developers from senior ones: **architectural thinking, not syntax knowledge.**

This kata teaches you to think architecturally through hands-on practice.

---

## 🤝 Contributing

Found a bug? Have a suggestion? Open an issue!  
Want to add an improvement? PRs welcome.

---

## 📬 Connect

- **YouTube:** [Giuseppe Maccario](https://www.youtube.com/@GiuseppeMaccario)
- **Website:** [giuseppemaccario.com](https://www.giuseppemaccario.com)
- **LinkedIn:** [Connect with me](https://www.linkedin.com/in/giuseppemaccario/)

---

## 📝 License

MIT - Use this code to learn, teach, and build great software.

---

**⭐ If this helped you level up your PHP skills, star the repo!**  
It helps others discover these tutorials.