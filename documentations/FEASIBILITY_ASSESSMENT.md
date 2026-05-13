# Feasibility Assessment Report

## Purpose

This report checks whether Spring Wisdom is realistic for a student project. It reviews technical, operational, economic, schedule, security, and resource feasibility.

## Technical Feasibility

Spring Wisdom is technically feasible.

The project uses common and understandable tools:

| Area | Tool |
| --- | --- |
| Backend | PHP |
| Frontend | Bootstrap, CSS, JavaScript |
| Database | Supabase Postgres |
| File storage | Supabase Storage |
| Hosting | Render Docker Web Service |

The system already includes login, roles, content publishing, reports, messages, and admin tools. These features are suitable for a student final project.

## Operational Feasibility

The system is operationally feasible because the workflows are clear.

| Role | Main Work |
| --- | --- |
| User | Browse, read, report, message, request author access |
| Author | Create, edit, and delete own content |
| Admin | Manage users, authors, reports, messages, requests, and updates |

Admins have enough tools to keep the platform organized during a demo.

## Economic Feasibility

The selected cost scenario is a free-tier demo.

Estimated cost:

| Period | Cost |
| --- | ---: |
| Monthly | USD 0 |
| Yearly | USD 0 |

This is feasible for student submission. The project can be demonstrated without paid hosting if usage stays within free-tier limits.

The free-tier cost estimate should be checked against official Render and Supabase pricing pages before final submission because cloud pricing can change.

## Schedule Feasibility

The project is schedule feasible because the stack is simple. It does not require a complex frontend build system or a large framework.

The main work is already organized into PHP pages and shared includes. This makes it easier to understand, test, and present.

## Security Feasibility

The project is security feasible for a student demo if these rules are followed:

- Do not commit `.env` files.
- Do not expose Supabase service-role keys in browser code.
- Use `APP_ENV=production` for deployed production mode.
- Change the default admin password after first login.
- Keep the Supabase Storage bucket private.
- Validate file uploads.

The current upload code allows only PDF, TXT, and DOCX source files and limits each file to 5 MB.

## Resource Feasibility

The project can be maintained by a small student team.

Required resources:

- A laptop for development.
- GitHub for source control.
- Supabase account for database and storage.
- Render account for demo hosting.
- Browser for testing.

No paid software is required for the demo setup.

## Risks and Mitigation

| Risk | Impact | Mitigation |
| --- | --- | --- |
| Free hosting sleeps after inactivity | First request may be slow | Mention this in presentation |
| Free-tier storage limit | Uploads may stop if storage is full | Limit source files and clean old demo files |
| Secrets exposed by mistake | Security issue | Keep `.env` ignored and use environment variables |
| Database not seeded | Admin cannot log in | Run schema and admin seed before demo |
| Uploads saved locally in local mode | Files may not persist in hosted container | Use Supabase Storage in production |

## Feasibility Conclusion

Spring Wisdom is feasible for student project submission. It has a clear scope, working user roles, realistic hosting options, and a low-cost demo plan.
