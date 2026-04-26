# SMTP Setup
Configure SMTP keys in `.env`:
- `MAIL_MAILER=smtp`
- `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION`

Queue mail by running `php artisan queue:work`.
