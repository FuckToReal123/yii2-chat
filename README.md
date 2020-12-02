### Развертывание проекта.

1. docker-compose up -d
2. docker-compose exec php-fpm php yii migrate --migrationPath=@yii/rbac/migrations
3. docker-compose exec php-fpm php yii migrate

Теперь проект доступен по адресу http://localhost:8092/
