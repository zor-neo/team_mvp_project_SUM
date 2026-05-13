# Project Overview

## Project Name

Spring Wisdom

## Project Summary

Spring Wisdom is a learning and reading portal. It helps users browse educational articles, authors publish learning content, and admins manage users, reports, messages, and author requests.

The project is built with PHP, Bootstrap, custom CSS, small JavaScript, Supabase Postgres, and Supabase Storage.

This overview explains the full project at a high level. For deeper detail, read the specific documents in this folder.

## Problem Statement

Students and readers need a simple place to find organized learning content. Authors need a way to share articles. Admins need tools to check content, manage users, and respond to reports.

Spring Wisdom solves this with a role-based web portal.

## Objectives

- Provide a clean learning archive for readers.
- Allow authors to create, edit, and delete articles.
- Allow users to request author access.
- Allow users to report content with a reason.
- Allow admins to manage users, authors, reports, messages, and updates.
- Use a real database and storage service for deployment.
- Keep the project simple enough to explain in a student presentation.

## Target Users

| User Type | Purpose |
| --- | --- |
| Public visitor | View public pages and access the login/register portal |
| Normal user | Browse articles, report content, send messages, and request author access |
| Author | Publish and manage own articles |
| Admin | Manage the whole platform |

## Main Features

- Login and registration.
- Role-based navigation.
- Browse and read learning content.
- Author dashboard for content management.
- Admin dashboard with platform statistics.
- User management and author management.
- Author request approval flow.
- Report and moderation flow.
- Messaging between users/authors/admins.
- Admin feed for platform updates.
- Optional source file upload for articles.

## System Overview

Spring Wisdom uses a traditional server-rendered web architecture.

| Layer | Technology |
| --- | --- |
| Frontend | Bootstrap, custom CSS, small JavaScript |
| Backend | Plain PHP |
| Database | Supabase Postgres |
| File storage | Supabase Storage |
| Deployment target | Render Docker Web Service |

The PHP backend renders pages, checks sessions, validates roles, queries the database, and returns HTML to the browser.

## Database and Storage Summary

Article text is saved in Supabase Postgres. This includes title, category, summary, body, status, and author information.

Only optional uploaded source files use Supabase Storage. These files can be PDF, TXT, or DOCX. Each optional file is limited to 5 MB by the current code.

Do not confuse total storage with maximum upload size. The current Supabase free-plan reference lists 1 GB total file storage and 50 MB as the maximum size for one uploaded file. Spring Wisdom keeps a smaller 5 MB app limit.

More detail is in `DATABASE_AND_STORAGE.md`.

## Feasibility Summary

The project is feasible as a student final project because it uses a simple stack, common tools, and a clear feature scope.

The free-tier demo setup is economically feasible because the estimated demo cost is:

| Period | Estimated Cost |
| --- | ---: |
| Monthly | USD 0 |
| Yearly | USD 0 |

More detail is in `FEASIBILITY_ASSESSMENT.md` and `COST_CALCULATION.md`.

The cost report uses official Render and Supabase pricing references and should be rechecked before final submission.

## Testing Summary

The project should be tested through manual user flows:

- Register and login.
- Browse content.
- Submit an author request.
- Approve author request as admin.
- Create content as author.
- Report content as user.
- Review reports as admin.
- Upload an optional source file.

More detail is in `TESTING_AND_ACCEPTANCE.md`.

## Deployment Summary

The project can run locally with PHP's built-in server. It can also deploy to Render using Docker and connect to Supabase for database and storage.

Production deployment should use environment variables and must not commit secrets.

More detail is in `INSTALLATION_AND_DEPLOYMENT.md`.

## Limitations

- Navigation uses full page reloads.
- Free hosting can be slower after idle time.
- Free-tier database and storage limits are not for heavy production use.
- Profile photos are local in the current code and should be moved to cloud storage for strong production durability.
- The project is optimized for student demonstration, not high-scale production.

More detail is in `TECHNICAL_LIMITATIONS.md`.

## Future Improvements

- Move profile photos to Supabase Storage.
- Add stronger file management for old attachments.
- Add automated tests.
- Add email verification and password reset.
- Add more analytics and search filters.
- Add a modern frontend framework only if the project scope grows.
