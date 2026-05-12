# Render Deployment Guide

This package deploys Spring Wisdom as a Docker-based Render Web Service.

## Recommended Target

- Service type: Web Service
- Runtime: Docker
- Region: Singapore
- Plan: Free for student demo
- Database: existing Supabase Postgres project
- File uploads: existing Supabase Storage bucket `content-files`

Render's free web services can sleep after idle time, so the first request after inactivity may be slower. Uploaded files should remain in Supabase Storage, not on the Render container filesystem.

## Files Added For Render

- `../Dockerfile` builds PHP 8.3 with Apache, OPcache, curl, PostgreSQL PDO, and pgsql.
- `../render.yaml` defines the Render Blueprint.
- `../docker/start-apache.sh` binds Apache to Render's `PORT`.
- `../docker/apache-security.conf` disables directory listing and blocks dotfiles, Markdown, SQL, and env-style files from direct web access.
- `../docker/opcache.ini` enables production PHP bytecode caching.
- `../docker/uploads.ini` sets practical upload limits for source files.
- `../.dockerignore` keeps `.env`, logs, Git data, and design artifacts out of the image.

## Supabase Preparation

1. In Supabase SQL editor, run `schema.sql`.
2. Create a private Storage bucket named `content-files`.
3. Seed the first admin account from `README.md`.
4. Use the Supabase pooler connection values for the database env vars.

## Render Blueprint Setup

1. Push this repo to GitHub.
2. In Render, choose **New > Blueprint**.
3. Select the repo containing `render.yaml`.
4. Confirm the service region is Singapore.
5. Provide the secret values when Render prompts for `sync: false` env vars.

Required env vars:

```text
APP_ENV=production
SUPABASE_DB_DSN=pgsql:host=YOUR_POOLER_HOST;port=5432;dbname=postgres;sslmode=require
SUPABASE_DB_USER=postgres.YOUR_PROJECT_REF
SUPABASE_DB_PASSWORD=YOUR_DATABASE_PASSWORD
SUPABASE_URL=https://YOUR_PROJECT_REF.supabase.co
SUPABASE_SERVICE_ROLE_KEY=YOUR_SERVICE_ROLE_KEY
SUPABASE_STORAGE_BUCKET=content-files
```

Do not set `DEV_AI_SEED_KEY` for the final public deployment unless you intentionally need the hidden seeding tool.

## Manual Web Service Setup

If you do not use the Blueprint:

1. Create a new Render Web Service from the repo.
2. Choose Docker runtime.
3. Set Dockerfile path to `./Dockerfile`.
4. Set region to Singapore.
5. Set plan to Free.
6. Add the env vars above in the Render dashboard.
7. Deploy.

## Post-Deploy Checks

- Open the Render URL and confirm the access portal loads.
- Log in with the seeded admin.
- Change the seeded admin password.
- Register a normal user.
- Approve an author request.
- Create author content.
- Upload a source file and confirm it lands in Supabase Storage.
- Submit and review a report.
- Send and resolve a message.

## Notes

- Render terminates HTTPS before forwarding traffic to the container over HTTP.
- The container filesystem is temporary. Keep user uploads in Supabase Storage.
- The Docker image excludes local `.env` files. Production secrets must be entered in Render.
