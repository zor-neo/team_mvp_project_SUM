# Environment Setup Guide

Use `.env` for your local secrets and `.env.example` as the safe template.

The app loads `.env` automatically during local PHP startup. Real server environment variables take priority over `.env` values.

## Local Demo Mode

For demo data without Supabase, keep:

```text
APP_ENV=local
```

Then run:

```powershell
cd "C:\Users\kaung\Desktop\Spring Wisdom\spring-wisdom-v1"
php -S localhost:8080
```

Demo accounts:

- `user@spring.test` / `password`
- `author@spring.test` / `password`
- `admin@spring.test` / `password`

## Supabase Mode

Fill these in `.env`:

```text
APP_ENV=production
SUPABASE_DB_DSN=pgsql:host=YOUR_SUPABASE_DB_HOST;port=5432;dbname=postgres;sslmode=require
SUPABASE_DB_USER=postgres
SUPABASE_DB_PASSWORD=YOUR_DATABASE_PASSWORD
SUPABASE_URL=https://YOUR_PROJECT.supabase.co
SUPABASE_SERVICE_ROLE_KEY=YOUR_SERVICE_ROLE_KEY
SUPABASE_STORAGE_BUCKET=content-files
```

Where to find values:

- `SUPABASE_URL`: Supabase project settings, API section.
- `SUPABASE_SERVICE_ROLE_KEY`: Supabase project settings, API section. Keep secret.
- `SUPABASE_DB_DSN`, `SUPABASE_DB_USER`, `SUPABASE_DB_PASSWORD`: Supabase database connection settings.
- `SUPABASE_STORAGE_BUCKET`: use `content-files` after creating that bucket.

Run `schema.sql` in Supabase SQL editor before using production mode.

Your local PHP must have the PostgreSQL PDO driver enabled. Check with:

```powershell
php -m | Select-String -Pattern "pdo|pgsql"
```

You should see both `PDO` and `pdo_pgsql` / `pgsql`. If only `PDO` appears, install or enable the PostgreSQL extension for your PHP version before testing Supabase locally.

## Gemini Seeder

The hidden AI seeder needs:

```text
DEV_AI_SEED_KEY=choose-your-local-secret
GEMINI_API_KEY=your-gemini-api-key
GEMINI_MODEL=gemini-2.5-flash
```

After signing in as admin:

```text
http://localhost:8080/dev-ai-seed.php?key=choose-your-local-secret
```

Remove `DEV_AI_SEED_KEY` from hosted production when the seeder is no longer needed.

## Important

- Never share real `.env` values.
- Commit `.env.example`, not `.env`.
- `.env` is ignored by git in this project.
