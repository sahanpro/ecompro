# Installation Guide
1. Install PHP 8.3+ and MySQL.
2. Create Laravel 13 project and copy repository files.
3. Install dependencies: `composer require laravel/sanctum stripe/stripe-php srmklive/paypal`.
4. Configure `.env`.
5. Run migrations and seeders: `php artisan migrate --seed`.
6. Start queue worker: `php artisan queue:work`.
