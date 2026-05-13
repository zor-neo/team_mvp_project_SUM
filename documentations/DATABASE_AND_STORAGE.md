# Database and Storage

## Overview

Spring Wisdom uses Supabase Postgres for main data and Supabase Storage for optional source file attachments.

Article text is stored in the database. Optional uploaded files are stored in the storage bucket.

## Main Database Tables

| Table | Purpose |
| --- | --- |
| `users` | Stores users, roles, profile fields, and settings |
| `contents` | Stores article title, category, summary, body, status, and file path |
| `content_categories` | Stores active article categories |
| `reports` | Stores user reports for content |
| `author_requests` | Stores requests to become an author |
| `admin_feeds` | Stores admin platform updates |
| `messages` | Stores messages and admin replies |

## Important Relationships

- Each content item belongs to one author.
- Each report belongs to one content item and one user.
- Each author request belongs to one user.
- Each admin feed belongs to one admin.
- Messages can optionally connect to reports or content.

## Content Storage

Article fields are saved in the `contents` table.

| Field | Meaning |
| --- | --- |
| `title` | Article title |
| `category` | Article category |
| `summary` | Short description |
| `body` | Main article text |
| `file_path` | Optional source file path |
| `status` | `published` or `hidden` |

## Supabase Storage

Supabase Storage is used for optional source files only.

Important storage distinction:

| Limit Type | Meaning |
| --- | --- |
| Total file storage | Total space available in the storage bucket or plan |
| Maximum file upload size | Largest size allowed for one uploaded file |

The current Supabase free-plan reference lists 1 GB total file storage and 50 MB maximum size for one uploaded file. Spring Wisdom uses a stricter app rule: each optional source file must be 5 MB or smaller.

Allowed upload types:

- PDF.
- TXT.
- DOCX.

Current Spring Wisdom upload size limit:

```text
5 MB per file
```

Storage path format:

```text
contents/{content_id}/{filename}
```

Example:

```text
contents/16/AWS-Certified-Cloud-Practitioner.pdf
```

## Environment Variables

The production app needs these environment variables:

| Variable | Purpose |
| --- | --- |
| `APP_ENV` | Uses `production` for deployed mode |
| `SUPABASE_DB_DSN` | Supabase Postgres connection string |
| `SUPABASE_DB_USER` | Database user |
| `SUPABASE_DB_PASSWORD` | Database password |
| `SUPABASE_URL` | Supabase project URL |
| `SUPABASE_SERVICE_ROLE_KEY` | Server-side storage/database service key |
| `SUPABASE_STORAGE_BUCKET` | Storage bucket name |

Do not place real values in documentation or browser JavaScript.

## Local Mode and Production Mode

In local mode, the app can use demo session data when Supabase is not configured.

In production mode, Supabase database configuration is required. Supabase Storage is also required for uploaded source files.

## Storage Notes

- The storage bucket should be private.
- Normal readers should not directly browse source files.
- Source file access should be controlled by the PHP app.
- Old demo uploads should be cleaned if storage space is limited.
