# Testing and Acceptance

## Purpose

This document gives manual test cases for the Spring Wisdom student project.

## Acceptance Summary

The project is acceptable when the main user, author, and admin workflows work without errors.

## Manual Test Cases

| ID | Test Case | Steps | Expected Result |
| --- | --- | --- | --- |
| T01 | Open access portal | Open the app URL | Login/register page loads |
| T02 | Register user | Fill registration form | New normal user account is created |
| T03 | Login user | Use valid email and password | User reaches signed-in area |
| T04 | Browse content | Open Browse page | Published content is shown |
| T05 | Read content | Open one article | Article title, summary, and body are shown |
| T06 | Report content | Submit report category and reason | Report is saved |
| T07 | Request author access | Submit author request | Request becomes pending |
| T08 | Admin login | Log in as admin | Admin dashboard opens |
| T09 | Approve author request | Admin approves request | User becomes author |
| T10 | Author creates content | Create article with title, category, summary, body | Article is saved |
| T11 | Author edits content | Change own article | Updated content is saved |
| T12 | Author deletes content | Delete own article | Article is removed |
| T13 | Upload source file | Upload PDF/TXT/DOCX under 5 MB | File path is saved |
| T14 | Reject large file | Upload file over 5 MB | Upload is rejected |
| T15 | Admin reviews report | Open reports and act on report | Report status changes |
| T16 | Admin sends message | Send or reply to message | Message status updates |
| T17 | Admin feed | Create platform update | Update appears on feed page |
| T18 | Role protection | Open admin page as normal user | Access is blocked |

## Deployment Tests

| Test | Expected Result |
| --- | --- |
| Render URL opens | App loads in browser |
| Supabase database works | Login and content queries work |
| Supabase Storage works | Source file upload succeeds |
| Static assets load | CSS, JS, icons, and images display |
| Secrets are hidden | `.env` and keys are not public |

## Acceptance Criteria

The project passes if:

- Main pages load correctly.
- User roles behave correctly.
- Data is saved and shown correctly.
- Reports and author requests work.
- Optional file upload follows file type and size rules.
- No private secrets are exposed.

