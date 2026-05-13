# Cost Calculation Report

## Purpose

This report estimates the cost of running Spring Wisdom for a student project demo.

The selected scenario is **Free tier demo**.

## Cost Summary

Pricing references were checked on 2026-05-13. Free-tier limits can change, so the official pricing pages should be checked again before final submission.

| Item | Estimated Monthly Cost | Estimated Yearly Cost |
| --- | ---: | ---: |
| Render hosting | USD 0 | USD 0 |
| Supabase Postgres | USD 0 | USD 0 |
| Supabase Storage | USD 0 | USD 0 |
| Platform SSL | USD 0 | USD 0 |
| Platform subdomain | USD 0 | USD 0 |
| GitHub repository | USD 0 | USD 0 |
| Local development tools | USD 0 | USD 0 |
| Total | USD 0 | USD 0 |

## Hosting Cost

Render can be used for a free student demo web service. The free service may sleep after inactivity, so the first request after idle time may be slower.

For a classroom demo, this is acceptable.

Official references:

- Render free tier: https://render.com/free
- Render pricing: https://render.com/pricing

## Database Cost

Supabase Postgres can be used on the free plan while the project stays within free-tier limits.

Spring Wisdom stores article data, users, reports, messages, author requests, and admin feed records in Postgres.

Current Supabase free plan reference includes a 500 MB database size per project.

Official reference:

- Supabase pricing: https://supabase.com/pricing

## Storage Cost

Supabase Storage is used only for optional source file attachments.

Article text is not stored in the storage bucket. Article text is saved in the database.

Current Supabase free plan reference lists 1 GB total file storage and a 50 MB maximum size for one uploaded file. These are different limits.

Spring Wisdom is stricter than Supabase's single-file limit because the app code limits each optional source file to 5 MB.

Optional attachment rules in the current project:

| Rule | Value |
| --- | --- |
| Allowed files | PDF, TXT, DOCX |
| Maximum file size | 5 MB |
| Storage path | `contents/{content_id}/{filename}` |

For conservative classroom planning, this report also shows a 50 MB usable storage budget. This is not the same as the official free-plan total storage reference; it is a safe project planning number.

| File Size | Approximate Number of Files |
| ---: | ---: |
| 5 MB | 10 files |
| 2.5 MB | 20 files |
| 1 MB | 50 files |

Official references:

- Supabase pricing: https://supabase.com/pricing
- Supabase Storage pricing: https://supabase.com/docs/guides/storage/pricing

## Optional Paid Costs Not Included

These items are not required for the student demo:

| Optional Item | Reason Not Included |
| --- | --- |
| Custom domain | Platform URL is enough for demo |
| Paid hosting plan | Free tier is enough for small demo |
| Paid Supabase plan | Free tier is enough for small demo |
| Email delivery service | Not required in current scope |
| Paid monitoring | Manual testing is enough for submission |
| Developer labor | Student project work is not priced |

## Cost Conclusion

The estimated cost for the Spring Wisdom student demo is USD 0 per month and USD 0 per year.

If the project becomes a real production system, a paid hosting plan, paid database plan, backups, monitoring, and a custom domain may be needed.
