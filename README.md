# Admin24™ - Modified Files & Changes Summary

## Overview
This document tracks all files modified and changes made to customize the Admin24™ accounting platform, including bug fixes, branding updates, and feature enhancements.

---

## Modified Files by Category

### 1. Expense Account Tracking & Item Update Fix
**File:** `modules/Inventory/Jobs/Items/UpdateItem.php`
- **Change:** Added handling for DoubleEntry account fields (`de_income_account_id` and `de_expense_account_id`) using `updateOrCreate()` logic
- **Impact:** Ensures item accounts are properly persisted when editing items

### 2. Payroll Duplication & Currency Fix
**File:** `modules/Payroll/Jobs/RunPayroll/CreateRunPayrollEmployees.php`
- **Change:** Refactored to use `updateOrCreate()` instead of `create()` to prevent duplicate payroll employee entries
- **Change:** Added currency conversion logic to store employee totals in the run_payroll currency before database insertion
- **Impact:** Eliminates duplicate payroll entries and ensures correct multi-currency handling

**File:** `database/migrations/2025_11_14_000000_add_unique_constraint_run_payroll_employees.php` (NEW)
- **Change:** Created migration to add unique constraint on `(run_payroll_id, employee_id)`
- **Impact:** Prevents duplicate entries at the database level

### 3. CSS Branding Override
**File:** `public/css/admin24-overrides.css` (NEW)
- **Change:** Created comprehensive CSS override file with breaker-bay palette (50-950 shades)
- **Change:** Replaced Tailwind green utilities (#008a00 → #3b4f69) without requiring asset rebuild
- **Impact:** Enables faster branding changes without full frontend asset compilation

### 4. Layout Head Templates - CSS Override Injection (10 files)
- `resources/views/layouts/admin/head.blade.php`
- `resources/views/layouts/auth/head.blade.php`
- `resources/views/layouts/signed/head.blade.php`
- `resources/views/layouts/wizard/head.blade.php`
- `resources/views/layouts/maintenance/head.blade.php`
- `resources/views/layouts/modules/head.blade.php`
- `resources/views/layouts/portal/head.blade.php`
- `resources/views/layouts/error/head.blade.php`
- `resources/views/layouts/preview/head.blade.php`
- `resources/views/layouts/install/head.blade.php`

**Change:** Injected `<link rel="stylesheet" href="{{ asset('public/css/admin24-overrides.css?v=' . version('short')) }}">` after app.css link
**Impact:** CSS overrides applied globally across all layouts

### 5. Footer Language Files - Branding Update (58 files)
All files in `resources/lang/*/footer.php`:
- **Change:** `'powered'` key: Replaced all variations of "Powered by Akaunting" → "Powered by Admin24™"
- **Change:** `'link'` key: Updated all URLs from `https://akaunting.com` → `https://admin24.ke`
- **Change:** `'tag_line'` key: Replaced "Akaunting" → "Admin24™" in all locales

**Affected locales:** en-GB, en-US, en-AU, fr-FR, es-ES, es-AR, es-CO, it-IT, pl-PL, de-DE, pt-BR, pt-PT, zh-CN, zh-TW, id-ID, and 42+ others

### 6. Logo References in Blade Views (12 files)
- `resources/views/components/email/footer.blade.php`
- `resources/views/components/layouts/admin/menu.blade.php` (2 instances)
- `resources/views/components/layouts/install.blade.php` (2 instances)
- `resources/views/components/layouts/portal/menu.blade.php` (2 instances)
- `resources/views/components/modules/banners.blade.php`
- `resources/views/auth/login/create.blade.php`
- `resources/views/auth/register/create.blade.php`
- `resources/views/auth/reset/create.blade.php`
- `resources/views/auth/forgot/create.blade.php`

**Changes:**
- Renamed logo files from `akaunting-logo-*` → `admin-24-logo-emblem.svg`
- Updated alt text from "Akaunting" → "Admin24™"

### 7. Loader GIF Update (2 files)
- `resources/views/components/loading/absolute.blade.php`
- `resources/views/components/loading/content.blade.php`

**Change:** Updated loader image from `akaunting-loading.gif` → `admin24-loading.gif`
**Impact:** Loading animations display Admin24™ branding

---

## Summary Statistics

| Category | Files Modified | Primary Changes |
|----------|---|---|
| **Bug Fixes** | 2 | Item account persistence; Payroll duplication & currency |
| **Database** | 1 | Added unique constraint migration |
| **CSS Branding** | 11 | Created override file; injected in all layout heads |
| **Footer Localization** | 58 | Branding text & URLs (Admin24™, admin24.ke) |
| **Logo References** | 12 | File paths (emblem) & alt text |
| **Loader Assets** | 2 | GIF file reference update |
| **TOTAL** | **86 files** | **Complete app rebranding + bug fixes** |

---

## Key Improvements

✅ **Bug Fixes:**
- Item expense/income accounts now update correctly when editing items
- Payroll amounts calculate correctly without duplication
- Multi-currency payroll conversion works properly

✅ **Branding:**
- Complete rebranding from Akaunting to Admin24™
- Updated URLs from akaunting.com to admin24.ke
- Logo assets updated to emblem style
- Loading animation displays Admin24™ branding
- Primary color changed to breaker-bay (#3b4f69)

✅ **Performance:**
- CSS override system enables faster changes without asset rebuild
- Unique database constraints prevent data duplication at source

---

## Requirements

* PHP 8.1 or higher
* Database (e.g.: MariaDB, MySQL, PostgreSQL, SQLite)
* Web Server (eg: Apache, Nginx, IIS)

## Framework

Admin24™ is built on [Laravel](http://laravel.com), modern technologies including VueJS, Tailwind CSS, and RESTful API.

## License

Admin24™ is released under the [BSL license](LICENSE.txt).
