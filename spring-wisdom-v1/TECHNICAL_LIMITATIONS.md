# Technical Limitations and Performance Notes

Spring Wisdom V1 intentionally uses a simple PHP + Bootstrap + Supabase Postgres architecture. This is suitable for a student project because it keeps the system understandable, easy to deploy on common PHP hosting, and simple to demonstrate. The tradeoff is that the application does not have the same level of client-side caching, background data loading, or route-level smoothness as a modern single-page application.

## Current Architecture

- PHP renders each page on the server.
- Supabase Postgres stores users, contents, reports, author requests, messages, and admin feeds.
- Supabase Storage is used for uploaded source files.
- Bootstrap and small custom CSS/JavaScript provide the frontend interface.
- Local demo mode can fall back to session-based data when Supabase is not configured.

This architecture is clear and appropriate for learning database-backed web application development. It also makes authentication, roles, CRUD operations, and moderation workflows easier to explain during review.

## Main Performance Limitations

### 1. Full Page Reloads

Each navigation loads a new PHP page. The browser requests the page, PHP checks the session, queries data, renders HTML, and sends the full response back.

This is simpler than a React/Vite single-page application, but it can feel less smooth because route changes are not handled instantly in the browser.

### 2. Server-Side Database Waiting

Most pages wait for database queries before any page content is returned. If the Supabase database or network connection is slow, the whole page response is delayed.

The project already uses the Supabase connection pooler, which helps connection handling, but each PHP request still depends on database response time.

### 3. Limited Application-Level Caching

Spring Wisdom currently prioritizes fresh database reads. This keeps behavior easy to understand, but it means repeated visits to pages such as the dashboard, home feed, reports, and archive list may repeat similar queries.

A production system would usually cache low-changing data, such as dashboard counts or recent feed items, for a short period.

### 4. Some Queries Load More Data Than Needed

Several pages use helper functions that return full lists and then filter or count rows in PHP. This is acceptable for small student-demo datasets, but it becomes inefficient as the data grows.

Examples of better long-term patterns:

- Use `select count(*)` for dashboard totals instead of loading all rows.
- Query one content item by `id` instead of loading all content and searching in PHP.
- Query an author's contents directly with `where author_id = :id`.
- Use `limit` and `offset` for paginated lists.

### 5. Basic Asset Strategy

The app uses Bootstrap, Bootstrap Icons, Google Fonts, local CSS, and local JavaScript. This is simple and reliable for development, but external CDN/font requests can add delay depending on network conditions.

For stronger production performance, common assets could be bundled locally and served with long browser cache headers.

## Why This Is Acceptable For V1

The goal of Spring Wisdom V1 is to demonstrate a complete learning portal with:

- User registration and login.
- Role-based access for users, authors, and admins.
- Content publishing and archive browsing.
- Report and moderation workflows.
- Author request approval.
- Admin dashboard and messaging.
- Supabase database and storage integration.

For this scope, simple PHP server-rendering is easier to maintain and explain than a larger frontend framework. The current design favors clarity, correctness, and demonstration value over advanced performance engineering.

## Planned Student-Level Optimizations

These improvements keep the current PHP stack while making the system more scalable:

1. Replace PHP-side counts with SQL count queries.
2. Add direct database queries for single-record lookups.
3. Add pagination to archive, users, reports, and messages pages.
4. Add SQL `limit` clauses for dashboard previews and home feed previews.
5. Cache dashboard counts and recent feeds for 30-60 seconds.
6. Keep using Supabase indexes for frequently filtered columns.
7. Serve frontend assets locally where possible.

These are realistic optimizations for a student project because they improve performance without requiring a full rewrite.

## Possible Future Upgrade Path

If the project later needs a smoother, app-like user experience, Spring Wisdom could be migrated to:

- React or Vue for the frontend.
- Supabase JavaScript client for browser-side data loading.
- TanStack Query or a similar library for caching.
- Supabase views or RPC functions for optimized read workflows.

That approach would improve perceived latency and navigation smoothness, but it would also increase project complexity. For V1, the PHP approach remains the better balance for a student submission.

## Summary

Spring Wisdom V1 has known performance limits because it uses traditional server-rendered PHP pages and fresh database reads. These limits are acceptable for a student-level project and small to moderate demo datasets. The recommended direction is to keep the PHP stack, improve query efficiency, add pagination, and introduce small caching where it provides clear benefit.
