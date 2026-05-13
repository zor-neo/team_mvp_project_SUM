# Presentation Guide

## Goal

This guide helps prepare a clear student project presentation for Spring Wisdom.

## Suggested Slide Outline

| Slide | Topic |
| --- | --- |
| 1 | Project title and team |
| 2 | Problem statement |
| 3 | Project objectives |
| 4 | Target users and roles |
| 5 | Main features |
| 6 | System architecture |
| 7 | Database and storage |
| 8 | Feasibility and cost |
| 9 | Live demo |
| 10 | Limitations and future work |
| 11 | Conclusion |

## Short Project Explanation

Spring Wisdom is a learning portal. Users can read articles, authors can publish content, and admins can manage reports, users, messages, and author requests.

The project uses PHP, Bootstrap, Supabase Postgres, Supabase Storage, and Render hosting.

## Demo Script

1. Open the access portal.
2. Log in as a normal user.
3. Browse and open an article.
4. Submit a report or author request.
5. Log in as admin.
6. Approve an author request.
7. Review reports and messages.
8. Switch to author role or log in as author.
9. Create a content item.
10. Show that the content appears in the archive.

## Key Talking Points

- The project has three main roles: user, author, and admin.
- Article text is stored in Supabase Postgres.
- Optional source files are stored in Supabase Storage.
- The demo can run with free-tier services.
- The system is simple enough for student maintenance.
- The project has clear future improvement paths.

## Possible Questions and Answers

| Question | Answer |
| --- | --- |
| Why use PHP? | PHP is simple, common, and easy to deploy for a student project. |
| Why use Supabase? | It provides hosted Postgres and Storage without building our own server infrastructure. |
| Where are articles stored? | Article text is stored in the `contents` table in Postgres. |
| Where are files stored? | Optional PDF/TXT/DOCX source files are stored in Supabase Storage. |
| What is the demo cost? | The estimated free-tier demo cost is USD 0 per month. |
| Is it production ready? | It is good for student demo. Real production would need stronger uptime, backups, monitoring, and paid services. |

## Presentation Tips

- Keep explanations short.
- Show the live system early.
- Explain roles clearly.
- Do not show private keys or `.env` files.
- Mention limitations honestly.
- End with future improvements.

