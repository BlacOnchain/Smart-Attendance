# Smart Attendance

Smart Attendance is a Laravel application for Computer Science departments. Students register their level and semester, select courses, view their timetable, and check in with a lecturer's time-limited QR code. Lecturers open sessions, monitor check-ins, and manage assigned courses.

## Local setup with XAMPP

Run these commands from the project folder:

```text
composer install
copy .env.example .env
php artisan key:generate
npm install
php artisan migrate
php artisan db:seed
npm run build
php artisan serve
```

Set the local database values in `.env` before migrating:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smart_attendance2
DB_USERNAME=root
DB_PASSWORD=
```

The database must already exist in MariaDB/phpMyAdmin. If MariaDB reports that `localhost` is not allowed, repair the MySQL `root` account host permissions or use the host and credentials created by XAMPP.

## Railway deployment

The production application is deployed at [smart-attendance-production-996c.up.railway.app](https://smart-attendance-production-996c.up.railway.app/). Railway should provide PostgreSQL connection values through its database service. Confirm these variables in the Railway service:

```env
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=pgsql
DATABASE_URL=<Railway PostgreSQL connection URL>
```

After deploying a migration change, run the migration as part of the Railway start/deploy process:

```text
php artisan migrate --force
php artisan db:seed --force
```

Do not run `migrate:fresh` on Railway because it deletes production data.

## Free deployment alternative: Render + external Postgres

This repository now includes a `Dockerfile` and `render.yaml`. Render can host
the Laravel web service on its free web plan, but its free web service sleeps
after inactivity and its free Postgres database expires after 30 days. Do not
use Render's free Postgres for important attendance records.

For a longer-lived free test setup, create a free Postgres database with
Supabase, copy its connection URL into Render as `DATABASE_URL`, and deploy
this repository as a Blueprint. Supabase's free database is 500 MB and pauses
after one week of inactivity, so this is still a demo/early-pilot setup rather
than a production backup strategy.

Set these values in Render before the first deploy:

```text
APP_KEY=<output of php artisan key:generate --show>
APP_URL=https://your-render-service.onrender.com
DATABASE_URL=<Supabase pooled PostgreSQL URL>
MAIL_MAILER=log
MAIL_FROM_ADDRESS=your-real-school-email@example.com
```

The container runs `php artisan migrate --force` on startup and never runs
`migrate:fresh`. Replace `MAIL_MAILER=log` with an HTTPS-based transactional
mail provider before using password reset or login alerts with real users.

## Accounts and roles

Public registration creates student accounts only. Lecturer accounts should be created by an administrator or inserted securely with `role=lecturer`. HOD course assignment requires `is_hod=1`.

## Verification

```text
php artisan test
php artisan view:cache
npm run build
```

The feature tests cover registration, lecturer/student role separation, and preventing attendance by students who are not enrolled in the course.

## Application structure

- `app/Http/Controllers`: authentication, student, lecturer, and attendance workflows.
- `database/migrations`: the canonical database structure for new and existing installations.
- `database/seeders`: course catalog and timetable data.
- `resources/views/auth`: student and lecturer login pages.
- `resources/views/student`: student portal pages.
- `resources/views/lecturer`: lecturer portal pages.

---


<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
