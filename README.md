### Запуск проекта

```php
cp .env.test .env
docker-compose up --build -d
cp app/.env.test app/.env
```
Остановить и удалить все контейнеры:
```php
docker-compose down
```

Чтобы войти в любой из контейнеров, делаем следующее:
```php
docker exec -it <container_name> bash
```

Запустить интерпретатор php
```php
docker exec -it wim-proj-php php -v
```

Посмотреть запущенные контейнеры:
```php
docker ps
```

Логи контейнера:
```php
docker logs <container_name>
```