### Развертывание проекта.

1. cp .env.dist .env
2. docker-compose up -d
3. docker-compose exec php-fpm php yii migrate --migrationPath=@yii/rbac/migrations
4. docker-compose exec php-fpm php yii migrate

Теперь проект доступен по адресу http://localhost:8092/
