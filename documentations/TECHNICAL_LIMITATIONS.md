# Technical Limitations

## Purpose

This document explains the current limits of Spring Wisdom. These limits are acceptable for a student project, but they should be known during presentation.

## Full Page Reloads

Spring Wisdom uses PHP server-rendered pages. Each navigation loads a new page.

This is simple and easy to explain, but it is not as smooth as a modern single-page application.

## Free Hosting Limitations

The free Render service can sleep after inactivity. The first request after idle time may be slow.

This is acceptable for a classroom demo but not ideal for real production users.

## Free Database and Storage Limits

Supabase free-tier limits are enough for a small demo. They are not designed for heavy production traffic or large file storage.

If the project grows, a paid plan may be needed.

## File Upload Limits

The current project allows optional source files only as:

- PDF.
- TXT.
- DOCX.

Each file is limited to 5 MB.

This protects storage space and reduces risk, but it may be too small for some real learning materials.

## Profile Photo Storage

In the current code, profile photos use local upload storage. For strong production durability, profile photos should be moved to Supabase Storage.

## Limited Automation Testing

The project mainly uses manual testing. This is acceptable for student submission, but a larger system should add automated tests.

## Basic Search and Analytics

The project includes useful browsing and dashboard features, but search and analytics are still simple.

Future versions could add:

- Better search filters.
- More dashboard charts.
- Export reports.
- Activity logs.

## Future Improvement Ideas

- Move all uploads to Supabase Storage.
- Add automated tests.
- Add password reset by email.
- Add email verification.
- Add stronger admin audit logs.
- Add content drafts before publishing.
- Add pagination to more views if data grows.

## Conclusion

The current technical choices are suitable for a student final project. They keep the system understandable, presentable, and realistic for a small team.

