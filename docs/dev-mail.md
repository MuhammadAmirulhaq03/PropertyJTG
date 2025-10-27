Development email setup options

Option A — Mailtrap (recommended)

1) Create a Mailtrap inbox (free plan is fine) and copy your SMTP credentials.
2) Copy .env.mailtrap.example to .env (or merge the mail lines into your existing .env) and fill in MAIL_USERNAME/MAIL_PASSWORD with your Mailtrap values.
3) Clear config cache: `php artisan optimize:clear`
4) Trigger a password reset and open the message in your Mailtrap inbox.

Option B — Log driver (zero-setup)

1) In .env set:
   - MAIL_MAILER=log
   - QUEUE_CONNECTION=sync
2) `php artisan optimize:clear`
3) Trigger a password reset. Open `storage/logs/laravel.log` and click the reset link that was logged.

Notes
- Keep `QUEUE_CONNECTION=sync` during dev so you don't need a queue worker.
- Ensure `APP_URL` matches your local URL so links open correctly.
- Revert anytime by switching `MAIL_MAILER` back to `log` and clearing cache.

