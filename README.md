

## Features
- Admin authentication & dashboard
- Candidate management (CRUD)
- Election creation & management
- Voter authentication and participation
- Real-time vote counting and result display
- Database seeding for demo data

---

## Requirements

Before running this project, ensure you have installed:

- [PHP](https://www.php.net/) >= 8.1  
- [Composer](https://getcomposer.org/)  
- [Laravel](https://laravel.com/) >= 10  
- [MySQL](https://www.mysql.com/) or any supported database  
- [Node.js](https://nodejs.org/) & [NPM](https://www.npmjs.com/) (for frontend assets)  

##Installation

Clone the repository:

git clone https://github.com/Adewale17/voting_system.git
cd voting-system
````

Install PHP dependencies:

```bash
composer install
```

Install JavaScript dependencies:

```bash
npm install && npm run dev
```

---

## 🛠️ Configuration

1. Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```

2. Generate application key:

```bash
php artisan key:generate
```

3. Update database credentials inside `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=voting_db
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🗄️ Database Setup

Run migrations:

```bash
php artisan migrate
```

(Optional) Seed database with sample data:

```bash
php artisan db:seed
```

Or migrate and seed together:

```bash
php artisan migrate --seed
```

---

## ▶️ Running the App

Start the local development server:

```bash
php artisan serve
```

Visit:

```
http://127.0.0.1:8000 for student login


## Default Admin Credentials

If seeded, you can log in with:
http://127.0.0.1:8000/login  for admin login

* **Email:** [admin@voting.com]
* **Password:** [password1234]






