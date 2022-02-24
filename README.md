### Запуск проекта

```php
cp .env.test .env
docker-compose up --build -d
cp app/.env.test app/.env
```
Остановить контейнер:
```php
docker-compose down
```

Чтобы войти в любой из контейнеров, делаем следующее:
```php
docker exec -it <container_name> bash
```

Посмотреть запущенные контейнеры:
```php
docker ps
```

Логи контейнера:
```php
docker logs <container_name>
```