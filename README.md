# mute84

The web application `mute84.com` is a personal project to learn about Laravel and create a fun way to share audio projects.

## Getting Started

1. Install composer dependencies with `composer install`.
2. Customize the `.env` file after `cp .env.example .env`.
   - Set the absolute path to the local database sqlite file in the `.env`.
   - Set the App Key with `php artisan key:generate`.
3. Run the migrations with `php artisan migrate`
4. Link the storage to public directory with `php artisan storage:link`
5. Serve the Application with [Herd](https://herd.laravel.com) or `php artisan serve`.
