# System Architecture

## Overview

Spring Wisdom uses a simple server-rendered web architecture. The browser requests a PHP page. PHP checks the session and role, reads or writes data, then returns HTML.

## Main Parts

| Part | Responsibility |
| --- | --- |
| Browser | Shows pages and sends form requests |
| PHP pages | Render HTML and handle user actions |
| Shared includes | Provide auth, config, layout, storage, and data functions |
| Supabase Postgres | Stores main application data |
| Supabase Storage | Stores optional source file attachments |
| Render | Hosts the deployed PHP application |

## Request Flow

1. User opens a page in the browser.
2. Browser sends a request to the PHP app.
3. PHP loads shared config and checks the session.
4. PHP checks the user's role when needed.
5. PHP reads or writes data in Supabase Postgres.
6. PHP renders an HTML page.
7. Browser displays the page with Bootstrap, custom CSS, and JavaScript.

## Role Flow

| Role | Access Level |
| --- | --- |
| Public visitor | Access portal and public information pages |
| User | Reader pages, reports, messages, author request |
| Author | User features plus author dashboard and analytics |
| Admin | Full management pages and role switch audit mode |

## Frontend

The frontend uses:

- Bootstrap layout and components.
- Bootstrap Icons.
- Custom `assets/css/style.css`.
- Small `assets/js/main.js`.
- Normal page links and forms.

The frontend is not a single-page application. Each page is rendered by PHP.

## Backend

The backend uses plain PHP. Important responsibilities include:

- Login and registration.
- Session management.
- Role checks.
- Content CRUD.
- Report management.
- Message handling.
- Author request approval.
- Admin feed creation.
- Optional file upload.

## Database

Supabase Postgres stores structured project data:

- Users.
- Contents.
- Content categories.
- Reports.
- Author requests.
- Admin feeds.
- Messages.

## File Storage

Supabase Storage stores optional source files uploaded with author content.

The main article text stays in the database. The storage bucket is only for optional attachments.

## Deployment Shape

The project can be deployed as a Docker Web Service on Render. Render hosts the PHP app. Supabase provides database and storage services.

Production secrets are entered as environment variables in Render. They are not stored in the repository.

