docker-compose up -d
sleep 5
docker-compose exec php php artisan migrate
sleep 5
echo "Start website: localhost:80"
