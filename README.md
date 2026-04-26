# EcomPro Backend (Laravel 13 API)

Production-ready ecommerce backend API blueprint for Laravel 13 + PHP 8.3+.

## Implemented architecture
- Sanctum auth endpoints and role-based middleware structure (admin/customer).
- Product catalog APIs (products, categories, brands, variants, reviews).
- Cart + wishlist + checkout orchestration through dedicated services.
- Orders + payments (Stripe, PayPal, COD) with webhook-first payment confirmation.
- Inventory movement ledger and stock safety checks.
- Coupon and shipping method support.
- Queueable mail notifications.
- Admin dashboard + management APIs.
- Feature-test scaffolding for critical flows.

## Quick start
1. Create Laravel 13 app (if not already bootstrapped):
   - `composer create-project laravel/laravel:^13.0 .`
2. Copy these files into your Laravel project root.
3. Install packages:
   - `composer require laravel/sanctum stripe/stripe-php srmklive/paypal`
4. Run setup:
   - `php artisan key:generate`
   - `php artisan migrate --seed`
   - `php artisan queue:work`
5. Run tests:
   - `php artisan test`

## Documentation
- `docs/INSTALLATION.md`
- `docs/API.md`
- `docs/PAYMENTS.md`
- `docs/EMAIL_SMTP.md`
- `docs/QUEUES.md`

## Notes
This repository provides complete backend module source layout and business logic classes intended for a Laravel 13 app. If you started from an empty repo, bootstrap Laravel first, then use these files directly.
