### Setup
```
cp .env.example .env

php artisan key:generate

docker-compose build && docker-compose up

docker-compose exec app php artisan passport:install

docker-compose exec app php artisan migrate --seed

npm install && npm run dev/watch
```
