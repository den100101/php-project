# CampusFlow — New School Management Project

A separate PHP/MySQL project with a completely new navy-and-violet interface. It connects to your existing school database and does not create, rename, or modify any tables.

## Existing tables used
`tbl_account`, `tbl_course`, `tbl_instructors`, `tbl_schoolyear`, `tbl_section`, `tbl_students`, `tbl_term`, `tbl_yearlevel`.

The CRUD pages inspect each table with `SHOW COLUMNS`, so they can adapt to the column names in your current database.

## Local setup
1. Extract this folder into XAMPP `htdocs`.
2. Set DB values in `includes/database.php` or your PHP environment.
3. Default local database name is `db_website`.
4. Visit `http://localhost/campusflow_school_management/login.php`.

## Render
Use Docker runtime and set `DB_HOST`, `DB_PORT`, `DB_USER`, `DB_PASSWORD`, and `DB_NAME` in Render environment variables. Configure Aiven TLS as required by your service before production use.

## Notes
- Login uses `password_verify()` against `tbl_account.PASSWORD`.
- New account passwords are stored using `password_hash()`.
- Roles supported: Admin, Registrar, Dean, Instructor, Student.
- Role access is configured in `index.php`.
- Generic CRUD may need table-specific dropdowns or validation if your database has foreign keys or special required fields.
