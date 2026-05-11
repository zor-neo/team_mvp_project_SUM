---
name: Spring Wisdom Bootstrap Design Guide
project_type: Student Final Project
frontend_stack:
  - HTML
  - Bootstrap
  - CSS
  - Light JavaScript
colors:
  background: '#f9f9fe'
  surface: '#ffffff'
  surface-soft: '#f2f3fb'
  surface-muted: '#ecedf6'
  border: '#dfe2ed'
  text-main: '#2f323b'
  text-muted: '#5b5f68'
  primary: '#465f8a'
  primary-hover: '#3a537d'
  primary-soft: '#b1cafb'
  secondary: '#565f71'
  tertiary: '#665881'
  danger: '#a83836'
typography:
  fontFamily: Inter
  h1: 40px
  h2: 32px
  h3: 24px
  body: 16px
  small: 14px
  label: 12px
rounded:
  small: 4px
  default: 8px
  large: 12px
  pill: 9999px
---

# Spring Wisdom Design Guide

## Design Goal

Spring Wisdom is a learning portal for preserving, browsing, and managing educational knowledge. The interface should feel calm, academic, organized, and trustworthy.

This design guide is intended for a student final project using **HTML, Bootstrap, custom CSS, and small JavaScript interactions**. The goal is not to build an advanced production frontend. The goal is to create a clean, understandable, presentable web application prototype with consistent pages and working basic UI behavior.

## Frontend Direction

Use **Bootstrap as the main layout and component system**. Avoid advanced frameworks such as React, Vue, Angular, Tailwind-heavy architecture, or complex build tools unless the project requirement changes.

Recommended implementation:

- HTML files for each page.
- Bootstrap CDN or local Bootstrap files.
- One shared custom CSS file, for example `assets/css/style.css`.
- One small JavaScript file, for example `assets/js/main.js`.
- Bootstrap Icons or Material Symbols for simple icons.
- Simple page-to-page navigation using normal links.

The code should be easy to read and explain during a final project presentation.

## Brand Style

The Spring Wisdom style is based on quiet professionalism. It should look like a modern educational archive, not a marketing landing page or entertainment app.

Use:

- Soft off-white backgrounds.
- Slate-blue primary buttons and links.
- Clean card layouts.
- Clear headings.
- Moderate spacing.
- Simple icons.
- Subtle borders instead of heavy shadows.

Avoid:

- Overly decorative gradients.
- Too many different colors.
- Complicated animations.
- Large blocks of generated utility classes.
- Layouts that are difficult to explain.

## Color System

Primary colors:

- **Primary:** `#465f8a`
- **Primary Hover:** `#3a537d`
- **Primary Soft:** `#b1cafb`
- **Background:** `#f9f9fe`
- **Surface:** `#ffffff`
- **Surface Soft:** `#f2f3fb`
- **Text Main:** `#2f323b`
- **Text Muted:** `#5b5f68`
- **Border:** `#dfe2ed`
- **Danger:** `#a83836`

Bootstrap mapping:

- Use primary buttons for main actions such as login, search, upload, approve, and save.
- Use outline buttons for secondary actions such as cancel, view details, or learn more.
- Use danger styling for delete, reject, or logout actions.
- Use light backgrounds for cards and dashboard sections.

Example CSS variables:

```css
:root {
  --sw-bg: #f9f9fe;
  --sw-surface: #ffffff;
  --sw-surface-soft: #f2f3fb;
  --sw-border: #dfe2ed;
  --sw-text: #2f323b;
  --sw-muted: #5b5f68;
  --sw-primary: #465f8a;
  --sw-primary-hover: #3a537d;
  --sw-danger: #a83836;
}
```

## Typography

Use **Inter** for all text.

Recommended hierarchy:

- Page title: 36-40px, bold.
- Section title: 24-32px, semibold or bold.
- Card title: 18-22px, semibold.
- Body text: 16px.
- Helper text and metadata: 14px.
- Labels and badges: 12px, uppercase only when useful.

Keep typography simple. Do not mix many fonts. For consistency, avoid using Lora or other decorative fonts unless it becomes a deliberate design decision later.

## Layout

Use Bootstrap grid and spacing utilities.

Recommended structure:

- `.container` or `.container-lg` for page width.
- `.row` and `.col-*` for responsive grids.
- `.card` for repeated content blocks.
- `.navbar` for top navigation.
- `.dropdown` for account menus.
- `.modal` for confirmations such as delete or reject.
- `.form-control`, `.form-select`, and `.form-label` for forms.

Spacing should follow Bootstrap defaults:

- `py-4` or `py-5` for page sections.
- `mb-3`, `mb-4`, and `mb-5` for vertical spacing.
- `g-3` or `g-4` for grid gaps.

## Page List

The project should include these main pages:

1. **Landing / Login Page**
   - Brand name.
   - Short project description.
   - Login form.
   - Register tab or register link.
   - Simple show/hide password JavaScript.

2. **Home Page**
   - About Spring Wisdom.
   - Mission or purpose section.
   - Announcement cards.
   - Navigation to user space.

3. **User Page**
   - Search bar.
   - Featured article.
   - Article/category cards.
   - Bookmark buttons as visual interactions.

4. **Author Dashboard**
   - Upload content form.
   - My uploaded content cards.
   - Edit and delete buttons.
   - Basic validation for title, category, and content.

5. **Admin Dashboard**
   - Reported articles section.
   - Author request section.
   - User messages section.
   - Simple approve, reject, hide, and message buttons.

6. **Admin Feed / Updates Page**
   - List of platform updates.
   - Featured update.
   - Standard update cards or article list.

## Navigation

Use one consistent Bootstrap navbar across public/user-facing pages.

Suggested links:

- Home
- Browse
- Track
- My Space
- Updates

For logged-in pages, include:

- Notification icon.
- Account dropdown.
- Logout link.

Admin pages may use either:

- A top navbar plus dashboard cards, or
- A simple sidebar on desktop with a collapsed navbar on mobile.

For a student project, a top navbar is easier to implement and explain.

## Components

### Buttons

Use Bootstrap button classes with custom color overrides.

- Main action: `.btn .btn-primary`
- Secondary action: `.btn .btn-outline-secondary`
- Danger action: `.btn .btn-outline-danger` or `.btn .btn-danger`

Button text should be clear:

- Login
- Register
- Search
- Upload Content
- Save Changes
- Approve
- Reject
- Delete

### Cards

Use cards for:

- Articles.
- Announcements.
- Dashboard metrics.
- Author requests.
- Reported content.

Cards should have:

- Light surface background.
- 1px border.
- 8-12px radius.
- Minimal shadow or no shadow.

### Forms

Use Bootstrap forms.

Forms should include:

- Visible labels.
- Placeholder text only as extra help, not as the only label.
- Basic required fields.
- Simple validation feedback using Bootstrap classes.

Important forms:

- Login form.
- Register form.
- Content upload form.
- Search form.

### Tables and Lists

Use tables only where comparison is useful, such as admin user lists or report lists.

For simpler content, use cards or list groups.

### Modals

Use Bootstrap modals for:

- Confirm delete.
- Review author request.
- View reported article details.

Only add modals where they make the project feel complete without adding too much complexity.

## JavaScript Scope

Use small JavaScript only.

Recommended JS features:

- Toggle login/register view.
- Show or hide password.
- Validate forms before submit.
- Filter article cards by search text.
- Confirm delete with Bootstrap modal.
- Change bookmark icon state.

Avoid:

- Complex state management.
- API calls unless required by the backend later.
- Advanced animation libraries.
- Large custom JavaScript files.

## Responsiveness

The project should work on desktop and mobile.

Use Bootstrap responsive classes:

- `.navbar-expand-lg`
- `.col-md-6`
- `.col-lg-4`
- `.d-none`
- `.d-md-block`
- `.flex-column`
- `.flex-md-row`

Important responsive behavior:

- Navbar collapses on small screens.
- Cards stack vertically on mobile.
- Forms stay readable on mobile.
- Dashboard sections stack on mobile.

## Accessibility Basics

Include basic accessibility practices:

- Use real buttons for actions.
- Use links for navigation.
- Add `alt` text to meaningful images.
- Add labels for all form inputs.
- Use readable color contrast.
- Do not rely only on hover for dropdowns or important actions.

Bootstrap components already help with many accessibility needs when used correctly.

## Image Direction

Use images that support the learning and archive theme:

- Libraries.
- Books.
- Documents.
- Reading spaces.
- Abstract knowledge or data visuals for dashboards.

For final submission, prefer local image files stored in an `assets/images/` folder instead of long external generated image URLs.

## File Organization

Recommended folder structure:

```text
spring-wisdom/
  index.html
  home.html
  user.html
  author-dashboard.html
  admin-dashboard.html
  admin-feed.html
  assets/
    css/
      style.css
    js/
      main.js
    images/
      hero-library.jpg
      article-book.jpg
      avatar.png
```

## Design Summary

Spring Wisdom should feel like a polished but realistic student-built educational portal. The design should be professional, calm, and consistent, while the code should remain simple enough to understand, modify, and present.

The current prototype can be used as visual inspiration, but the revised implementation should be Bootstrap-first with clear HTML structure and only light JavaScript.
