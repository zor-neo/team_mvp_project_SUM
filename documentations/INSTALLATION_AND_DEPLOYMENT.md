# Installation and Deployment

## Local Setup

Requirements:

- PHP installed locally.
- A browser.
- Project files from the repository.

Run locally:

```powershell
cd "spring-wisdom-v1"
php -S localhost:8080 router.php
```

Open:

```text
http://localhost:8080
```

## Local Demo Accounts

When Supabase is not configured and the app is in local demo mode, these demo accounts can be used:

| Role | Email | Password |
| --- | --- | --- |
| User | `user@spring.test` | `password` |
| Author | `author@spring.test` | `password` |
| Admin | `admin@spring.test` | `password` |

These are demo credentials only. Change real production passwords.

## Supabase Setup

1. Create a Supabase project.
2. Run `spring-wisdom-v1/schema.sql` in Supabase SQL editor.
3. Create a private Storage bucket.
4. Set the storage bucket name in `SUPABASE_STORAGE_BUCKET`.
5. Seed the first admin account.
6. Add environment variables in the hosting platform.

## Render Deployment

The project can deploy to Render as a Docker Web Service.

Basic steps:

1. Push the repository to GitHub.
2. Create a Render Web Service or Blueprint.
3. Use the Dockerfile in the repository root.
4. Set environment variables in Render.
5. Deploy.
6. Test the deployed URL.

## Required Production Environment Variables

```text
APP_ENV=production
SUPABASE_DB_DSN=...
SUPABASE_DB_USER=...
SUPABASE_DB_PASSWORD=...
SUPABASE_URL=...
SUPABASE_SERVICE_ROLE_KEY=...
SUPABASE_STORAGE_BUCKET=...
```

Never commit real values.

## Post-Deployment Checklist

- Access portal loads.
- Admin can log in.
- Admin password is changed.
- User registration works.
- Author request works.
- Admin can approve author request.
- Author can create content.
- Optional source file uploads to Supabase Storage.
- User can report content.
- Admin can review reports.
- Messages can be sent and resolved.

## Troubleshooting

| Problem | Check |
| --- | --- |
| App shows config error | Confirm required environment variables |
| Upload fails | Confirm Supabase URL, service key, and bucket |
| Demo data appears in production | Confirm `APP_ENV=production` |
| First request is slow | Free Render service may be waking up |
| Admin cannot log in | Confirm admin seed was run |

