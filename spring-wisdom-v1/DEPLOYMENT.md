# Spring Wisdom V1 Deployment Guide

Spring Wisdom V1 is a plain PHP + Bootstrap app. The recommended deployment target is a PHP-capable host with HTTPS enabled. Supabase provides Postgres and Storage.

For zero-budget Render deployment, use `RENDER_DEPLOYMENT.md` and the Docker files in the repository root.

## 1. Prepare Supabase

1. Create a Supabase project.
2. Open the Supabase SQL editor.
3. Run the full contents of `schema.sql`.
4. Create a Storage bucket named `content-files`.
5. Keep the bucket private for source content files.

For an existing database created before Resource Management, also run `resource-management-migration.sql` once after deployment.

## 2. Seed Admin Account

Run this after `schema.sql`:

```sql
insert into users (name, email, password_hash, role)
values (
  'Admin Scholar',
  'admin@spring.test',
  '$2y$12$3GVSfzhRK6HL8.3tKpnsguwBxr2cUSl5VBUcnBWkyKhAgIyG8ucEi',
  'admin'
);
```

Default seeded password: `password`.

Change this password immediately after first login.

Optional demo data:

Run `seed.sql` after the admin seed if you want sample accounts and archive content for testing. It creates 3 authors, 3 normal users, and 15 published reading contents. The sample account password is also `password`.

## 3. Configure Environment Variables

Use `.env.example` as the reference. In production, set:

- `APP_ENV=production`
- `SUPABASE_DB_DSN`
- `SUPABASE_DB_USER`
- `SUPABASE_DB_PASSWORD`
- `SUPABASE_URL`
- `SUPABASE_SERVICE_ROLE_KEY`
- `SUPABASE_STORAGE_BUCKET=content-files`

Optional Gemini seeding tool:

- `DEV_AI_SEED_KEY`
- `GEMINI_API_KEY`
- `GEMINI_MODEL`

Never expose service-role or Gemini keys in browser JavaScript.

## 4. Upload App Files

Upload the contents of `spring-wisdom-v1` to the PHP host web root or configured app folder.

The public entry page is:

```text
index.php
```

For local testing:

```powershell
cd "C:\Users\kaung\Desktop\Spring Wisdom\spring-wisdom-v1"
php -S localhost:8080 router.php
```

The router is required for local PHP testing because the built-in server does not read `.htaccess`; it blocks direct requests for dotfiles, SQL files, Markdown files, logs, and other repository/config artifacts.

## 5. Production Checks

Before final submission, verify:

- Login works with the seeded admin.
- Public registration creates normal user accounts only.
- User can browse, open content, report content, and request author access.
- Admin can approve/reject author requests.
- Admin can promote/demote users.
- Author can create, edit, and delete only own content.
- Admin can review reports, message authors, hide articles, dismiss reports, and resolve messages.
- Supabase Storage accepts content source file uploads.
- Normal users cannot see source file links in reader pages.
- `APP_ENV=production` is set on the host.

## 6. Hidden Gemini Seeder

The seeder is not linked in app navigation.
The `dev-ai-seed.php` route is intended for local/admin seeding workflow and is intentionally untracked in Git for deployment safety.

After signing in as admin, open:

```text
/dev-ai-seed.php
```

Use it only for temporary archive seeding. Remove `DEV_AI_SEED_KEY` from production when it is no longer needed.

## 7. Troubleshooting

- If the app shows a configuration error, confirm required Supabase DB env vars are present.
- If uploads fail, confirm `SUPABASE_URL`, `SUPABASE_SERVICE_ROLE_KEY`, and bucket name.
- If local demo data is needed, leave `APP_ENV` unset or set it to `local`.
- If production still shows demo accounts, check that `APP_ENV=production` is active.
