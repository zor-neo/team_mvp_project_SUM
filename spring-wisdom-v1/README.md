# Spring Wisdom V1

Plain PHP + Bootstrap learning / reading hub based on the concept UI.

For production setup, see `DEPLOYMENT.md`. For Render deployment, see `RENDER_DEPLOYMENT.md`. For environment variable names, see `.env.example`. For local filling instructions, see `ENV_GUIDE.md`. For performance tradeoffs and student-project limitations, see `TECHNICAL_LIMITATIONS.md`.

Local `.env` values are loaded automatically by the app. Real server environment variables are not overwritten.

## Run Locally

```powershell
cd "C:\Users\kaung\Desktop\Spring Wisdom\spring-wisdom-v1"
php -S localhost:8080 router.php
```

Open `http://localhost:8080`.

Demo accounts when Supabase is not configured:

- User: `user@spring.test` / `password`
- Author: `author@spring.test` / `password`
- Admin: `admin@spring.test` / `password`

The Access Portal also has demo role buttons.

## Supabase Setup

1. Create a Supabase project.
2. Run `schema.sql` in the SQL editor.
3. Create a private Storage bucket named `content-files`.
4. Set environment variables before starting PHP:

```powershell
$env:APP_ENV="production"
$env:SUPABASE_DB_DSN="pgsql:host=YOUR_HOST;port=5432;dbname=postgres;sslmode=require"
$env:SUPABASE_DB_USER="postgres"
$env:SUPABASE_DB_PASSWORD="YOUR_DATABASE_PASSWORD"
$env:SUPABASE_URL="https://YOUR_PROJECT.supabase.co"
$env:SUPABASE_SERVICE_ROLE_KEY="YOUR_SERVICE_ROLE_KEY"
$env:SUPABASE_STORAGE_BUCKET="content-files"
php -S localhost:8080 router.php
```

For local demo mode, leave `APP_ENV` unset or set it to `local`. In production mode, Spring Wisdom requires Supabase DB configuration and will not silently fall back to session demo data.

Seed an admin manually after creating the schema:

```sql
insert into users (name, email, password_hash, role)
values (
  'Admin Scholar',
  'admin@spring.test',
  '$2y$12$3GVSfzhRK6HL8.3tKpnsguwBxr2cUSl5VBUcnBWkyKhAgIyG8ucEi',
  'admin'
);
```

The seeded admin password is `password`.

## Temporary Gemini Archive Seeder

The hidden Gemini seeding tool is for local/admin content creation only. It is not linked in the app navigation.

```powershell
$env:DEV_AI_SEED_KEY="choose-a-local-secret"
$env:GEMINI_API_KEY="YOUR_GEMINI_API_KEY"
$env:GEMINI_MODEL="gemini-2.5-flash"
```

Sign in as admin, then open:

```text
http://localhost:8080/dev-ai-seed.php
```

Generated items are published directly into the archive under the selected author account.

## Deployment Checklist

- Use a PHP-capable host with HTTPS enabled.
- Set `APP_ENV=production`.
- Set all Supabase database environment variables.
- Set `SUPABASE_URL`, `SUPABASE_SERVICE_ROLE_KEY`, and `SUPABASE_STORAGE_BUCKET`.
- Run `schema.sql` in Supabase before opening the deployed app.
- Seed at least one admin account.
- Confirm the `content-files` storage bucket exists.
- Do not expose `SUPABASE_SERVICE_ROLE_KEY`, `GEMINI_API_KEY`, or `DEV_AI_SEED_KEY` in browser JavaScript.

## V1 Notes

- Public registration creates normal users only.
- Admins can promote/demote users and approve author requests.
- Authors can create, edit, and delete content.
- Readers can report content only with both a category and a typed reason.
- Uploaded source files are stored for admin review and are not exposed in reader pages.
- Every signed-in page shows the account avatar dropdown.
- If a user has no profile photo, the navbar uses `assets/images/default-avatar.svg`.
- Account Information lets users update display name, optional profile fields, and profile photo.
- Change Password requires the current password, confirmation, and a stronger new password.
- Normal users can reach Author Request from both the navbar and account dropdown.
- Admin accounts have a Role Switch dropdown for audit mode.
- Role Switch is session-only: it lets admin view Author/User pages without changing the database role.
- When admin audits as Author/User, an Admin tab remains visible to return to admin mode.
- Author navigation uses My Space for uploads/collections and Analytics for contribution charts.
- Admin dashboard includes whole-web content analytics with category and posting-frequency charts.
