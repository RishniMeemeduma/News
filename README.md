# php laravel framework version 8
# php version  7.4.33
# node version 14.16.1
# mysql version 8.0.31
# run migrations
php artisan migrate
# Create env file and add additional parameter
JSON_FILE_NAME="2020-01-02.json"
# commands to run
composer i
cp .env.example .env #change the database name
php artisan key:generate
php artisan serve

# To run unit test
php artisan test --filter NewsTest
