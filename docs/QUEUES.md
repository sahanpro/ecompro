# Queue Setup
1. Set `QUEUE_CONNECTION=database`.
2. Run `php artisan queue:table && php artisan migrate`.
3. Start worker: `php artisan queue:work --tries=3`.
4. Use queues for order emails, stock movement jobs, payment reconciliation.
