docker-compose up -d
docker-compose exec php php artisan migrate
echo "Start website: localhost:80"