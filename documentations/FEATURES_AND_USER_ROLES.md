# Features and User Roles

## Public Visitor

Public visitors can:

- Open the access portal.
- View public pages.
- Register a normal user account.
- Log in.

Public visitors cannot publish content or access dashboards.

## Normal User

Normal users can:

- Browse learning content.
- Read published articles.
- Report content with a reason.
- Send messages.
- Request author access.
- Update account information.
- Change password.

Normal users cannot create articles unless an admin approves author access.

## Author

Authors can:

- Use normal user features.
- Open the author dashboard.
- Create new content.
- Edit own content.
- Delete own content.
- Upload an optional source file.
- View author analytics.

Authors should only manage their own content.

## Admin

Admins can:

- View the admin dashboard.
- Manage user accounts.
- Promote or demote user roles.
- Manage author accounts.
- Approve or reject author requests.
- Review reports.
- Hide reported content.
- Dismiss reports.
- Send and resolve messages.
- Create admin feed updates.
- Manage content categories/resources.
- Use role switch for audit mode.

## Main Feature List

| Feature | User | Author | Admin |
| --- | :---: | :---: | :---: |
| Browse content | Yes | Yes | Yes |
| Read content | Yes | Yes | Yes |
| Report content | Yes | Yes | Yes |
| Request author access | Yes | No | No |
| Create content | No | Yes | Yes |
| Edit own content | No | Yes | Yes |
| Manage all users | No | No | Yes |
| Review reports | No | No | Yes |
| Approve author requests | No | No | Yes |
| Create platform updates | No | No | Yes |

## Important User Flows

### User Becomes Author

1. User logs in.
2. User opens Author Request.
3. User submits a reason.
4. Admin reviews the request.
5. Admin approves the request.
6. User role becomes author.

### Author Publishes Content

1. Author logs in.
2. Author opens My Space.
3. Author fills title, category, summary, and body.
4. Author optionally uploads a source file.
5. System saves the content.
6. Published content appears in the archive.

### User Reports Content

1. User opens a content page.
2. User selects report category.
3. User writes a reason.
4. Admin reviews the report.
5. Admin decides to hide or keep the content.

