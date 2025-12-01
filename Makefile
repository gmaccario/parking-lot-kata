.PHONY: help up down shell clean

# Default target
help:
	@echo "Parking Lot Kata - Comandi disponibili / Available commands:"
	@echo ""
	@echo "  make up          Avvia il container / Start container"
	@echo "  make down        Ferma il container / Stop container"
	@echo "  make shell       Entra nel container / Enter container shell"
	@echo "  make clean       Rimuovi container e volumi / Remove container and volumes"
	@echo ""
	@echo "Primo utilizzo / First time:"
	@echo ""
	@echo "  make up"
	@echo "  make shell"
	@echo "  cd episodes/01-basic-implementation"
	@echo "  composer install"
	@echo "  ./vendor/bin/phpunit"
	@echo ""

up:
	docker-compose up -d --build
	@echo ""
	@echo "✅ Container pronto! / Container ready!"
	@echo ""
	@echo "Prossimi passi / Next steps:"
	@echo "  make shell"
	@echo "  cd episodes/01-basic-implementation"
	@echo "  composer install"
	@echo "  ./vendor/bin/phpunit"

down:
	docker-compose down

shell:
	docker exec -it parking-lot-php bash

clean:
	docker-compose down -v
