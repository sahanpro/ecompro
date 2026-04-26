# Payment Setup
## Stripe
Set `STRIPE_KEY`, `STRIPE_SECRET`, `STRIPE_WEBHOOK_SECRET` in `.env`.
Use `/api/payments/stripe/webhook` endpoint for async confirmation.

## PayPal
Set `PAYPAL_MODE`, `PAYPAL_CLIENT_ID`, `PAYPAL_CLIENT_SECRET`, `PAYPAL_WEBHOOK_ID`.
Use `/api/payments/paypal/success` and `/api/payments/paypal/cancel` callbacks.

## COD
Use `payment_method=cod` during checkout.
