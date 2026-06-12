# APES AI Coding Rules

Use this file as the project instruction source for AI coding tools.

Recommended target paths in the Laravel project:

- `.cursor/rules/apes.mdc` for Cursor
- `.github/copilot-instructions.md` for GitHub Copilot
- `AGENTS.md` for agent-based tools
- `GEMINI.md` for Gemini-oriented workflows

## Project Identity

APES is a Laravel web application for AKHLAK Performance Evaluation System.

The app supports 360-degree employee evaluation based on BUMN Core Values AKHLAK:

- Amanah
- Kompeten
- Harmonis
- Loyal
- Adaptif
- Kolaboratif

Use the VINPROJECT Figma design reference provided by the user as the main UI direction.

## Required Tech Stack

- Laravel
- Blade templates
- MySQL
- Bootstrap or Tabler-style Bootstrap UI
- Chart.js for charts
- Standard Laravel migrations, seeders, controllers, models, and policies/middleware

Do not use React, Vue, Inertia, Livewire, Tailwind, or API-first architecture unless explicitly requested by the user.

## Visual Direction

Follow the APES mockup style:

- Clean internal HR dashboard UI.
- White page background with light gray application surface.
- Yellow is the primary brand color for navbar surfaces and main CTAs.
- Keep the topbar white and clean by default; reserve yellow for sidebar, CTAs, and accent surfaces.
- Dark blue is now reserved for text, borders, and structural accents only.
- Yellow active navigation state or yellow highlight on active navigation.
- On yellow navigation surfaces, use soft cream hover states and navy text for readable contrast.
- White cards with subtle border and soft shadow.
- Compact dashboard cards.
- Data tables with clear spacing and action icons.
- Rounded form inputs and buttons.
- Professional BUMN-style corporate look.
- Use Inter as the default font family for all pages, components, and UI states.
- Use yellow as the hero/accent color, keep most text black or near-black, and use dark blue only for structural accents and labels.
- Primary buttons should use yellow/amber gradients with dark text; hover states may darken to warm amber but should stay readable.
- Logout and destructive-like actions should use a strong contrasting navy/amber treatment rather than muted gray.
- Use green for success, red for danger, and orange for warning.
- Avoid decorative landing-page sections.
- Avoid dark mode unless requested.

Suggested color tokens:

```css
:root {
    --apes-navy: #053b78;
    --apes-yellow: #f6c445;
    --apes-yellow-dark: #d99a00;
    --apes-yellow-soft: #fff7d6;
    --apes-blue: #0b63ce;
    --apes-blue-soft: #eaf2ff;
    --apes-bg: #f5f7fb;
    --apes-border: #e2e8f0;
    --apes-text: #1f2937;
    --apes-muted: #64748b;
    --apes-success: #16a34a;
    --apes-danger: #dc2626;
    --apes-warning: #f59e0b;
}
```

## Layout Rules

Use one main authenticated layout:

- Left sidebar with APES logo/title.
- Sidebar menu changes by role.
- Topbar contains page title, period selector, and user profile.
- Main content uses cards, tables, charts, and forms.
- Keep content dense but readable.
- Prefer reusable Blade partials/components.

Recommended Blade structure:

```text
resources/views/layouts/app.blade.php
resources/views/layouts/auth.blade.php
resources/views/partials/sidebar.blade.php
resources/views/partials/topbar.blade.php
resources/views/components/stat-card.blade.php
resources/views/components/table-actions.blade.php
resources/views/components/grade-badge.blade.php
```

## Roles

The app has three roles:

- `hr`
- `direktur`
- `karyawan`

HR can manage system data.

Direktur can view dashboard, recap, details, and print reports.

Karyawan can edit biodata, perform assigned assessments, and view personal results.

## Required Pages From Design Reference

Implement these pages according to the Figma/screenshot flow:

1. Login for all roles.
2. Dashboard Direktur.
3. Rekap Penilaian for Direktur.
4. Cetak Hasil Penilaian for Direktur.
5. Dashboard HR Department.
6. Kelola Data Karyawan for HR.
7. Kelola Variabel AKHLAK for HR.
8. Kelola Indikator Penilaian for HR.
9. Kelola Penilaian for HR.
10. Edit Biodata for Karyawan.
11. Dashboard Karyawan.
12. Melakukan Penilaian for Karyawan.
13. Hasil Penilaian Pribadi for Karyawan.

If numbering differs from the mockup, prioritize page function over exact number.

## Backend Rules

Use standard Laravel structure:

- Controllers in `app/Http/Controllers`
- Models in `app/Models`
- Migrations in `database/migrations`
- Seeders in `database/seeders`
- Blade views in `resources/views`
- Routes in `routes/web.php`

Use Laravel validation for form requests or controller validation.

Use Eloquent relationships instead of raw SQL where practical.

Use middleware to protect role-specific routes.

Do not hardcode database credentials.

Do not commit `.env`.

## Data Model

Core tables should include:

- users
- employees
- variables
- indicators
- periods
- assessor_assignments
- assessments
- assessment_details
- assessment_summaries

Suggested mapping:

- `employees` stores employee profile data.
- `variables` stores AKHLAK variables.
- `indicators` belongs to `variables`.
- `periods` stores assessment period data.
- `assessor_assignments` stores who assesses whom and the assessor type.
- `assessments` stores submitted assessment header data.
- `assessment_details` stores score per indicator.
- `assessment_summaries` stores final weighted results.

Assessment weights:

- Atasan Langsung: 40%
- Rekan Sejawat: 20%
- Bawahan: 30%
- Self Assessment: 10%

## UI Page Details

### Login

Use a two-column layout:

- Left side: company logo, APES title, subtitle, and illustration area.
- Right side: login card with username, password, error message, yellow login button, and forgot password text.

### Dashboard Direktur

Show:

- Total karyawan.
- Rata-rata nilai AKHLAK.
- Penilaian selesai.
- Penilaian belum selesai.
- Grade distribution donut chart.
- AKHLAK variable bar chart.
- Top 5 employees table.
- Department ranking table.

### Rekap Penilaian

Show:

- Filter period and department.
- Summary cards.
- Table with employee name, department, weighted assessment components, final score, grade, and view action.
- Pagination UI.

### Cetak Hasil Penilaian

Make a print-friendly report:

- Company logo.
- Report title.
- Employee data.
- Final score and grade.
- Variable scores.
- 360 feedback component scores.
- Print and export button.

### Dashboard HR

Show:

- Total karyawan.
- Total variabel.
- Total indikator.
- Penilaian selesai.
- Progress penilaian chart.
- Grade distribution chart.
- AKHLAK performance chart.
- Quick action buttons with yellow primary action styling.

### Kelola Data Karyawan

Show:

- Search input.
- Add employee button.
- Employee table.
- Edit and delete actions.

### Kelola Variabel

Show AKHLAK variable cards with icons, indicator count, edit action, and delete action.

### Kelola Indikator

Show:

- Variable filter.
- Indicator table.
- Status badge.
- Edit and delete actions.

### Kelola Penilaian

Show:

- Period management form.
- Weight configuration card.
- Assessment assignment tab/table.

### Dashboard Karyawan

Show:

- Latest score.
- Latest grade.
- Assessment status.
- Role as evaluator.
- AKHLAK radar chart.
- Score trend chart.

### Edit Biodata

Show:

- Profile photo placeholder.
- Employee profile form.
- Save button.
- Success alert.

### Melakukan Penilaian

Use a stepper:

- Pilih Periode.
- Pilih Karyawan.
- Penilaian.
- Review & Simpan.

Show indicator scoring rows with numeric score choices.

### Hasil Penilaian Pribadi

Show:

- Final score and grade.
- 360 composition bars.
- AKHLAK radar chart.
- Score cards per variable.
- Grade category legend.

## Git Rules

Commit after each meaningful feature:

- Initial Laravel setup.
- Add auth and roles.
- Add APES layout.
- Add employee management.
- Add AKHLAK variable and indicator management.
- Add assessment period and assignment management.
- Add assessment form.
- Add recap and scoring.
- Add dashboard charts.
- Add printable reports.

Before committing:

- Run `php artisan test` when tests exist.
- Run `php artisan route:list` if routes changed.
- Check `git status`.
- Ensure `.env` is not staged.

## Response Style For AI Tools

When modifying code:

- Explain the changed files briefly.
- Mention commands that should be run.
- Mention any migration or seeder changes.
- Keep implementation aligned with the Figma reference.
