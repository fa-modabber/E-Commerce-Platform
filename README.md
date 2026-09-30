# E-Commerce Platform

A Laravel-based e-commerce platform for managing products, customers, shopping carts, discounts, and store content. The project includes a customer-facing storefront and an administration panel for managing the store.

## 🟠 Tech Stack

* **Backend:** PHP, Laravel
* **Database:** MySQL
* **Frontend:** Laravel Blade, Bootstrap, Alpine.js
* **Development Environment:** Docker & Docker Compose
---

## 🟠 Requirements

Make sure the following are installed on your system:

- Docker
- Docker Compose

---
## 🟠 Installation

### 1. Clone the repository

```bash
git clone https://github.com/fa-modabber/Onlineshop-merchify.git
```

### 2. Navigate to the project directory

```bash
cd E-Commerce Platform
```

### 3. Create the environment file

```bash
cp .env.example .env
```
Update some configuration in `.env`:

```env
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=platform
DB_USERNAME=platform
DB_PASSWORD=platform
```

### 4. Build and start the containers

```bash
docker compose up -d --build
```

### 5. Generate the application key
```bash
docker compose exec app php artisan key:generate
```

### 6. Run database migrations and seeders

```bash
docker compose exec app php artisan migrate --seed
```

### 7. Run queue worker

```bash
docker compose exec app php artisan queue:work
```

### 8. Access the application

The following diagram provides a visual overview of the application services and their corresponding access URLs.
```text
Browser
   │
   ├── :8000 → Laravel Container
   │
   └── :8080 → phpMyAdmin Container
                    │
                    ▼
               MySQL Container
```

The API will be available at:

```text
http://localhost:8000
```

phpMyAdmin will be available at:

```text
http://localhost:8080
```

### 6. Stop the containers

```bash
docker compose down
```

To remove the database volume as well:

```bash
docker compose down -v
```

---

## 🟠 Testing (coming soon)

---

## 🟠 Postman Collection (coming soon)

The Postman collection is available in:

```text
/docs/postman/ecommerce-platform.json
```

---

## 🟠 Features

### Storefront

* Home and About Us pages
* Product catalog with search, filtering, sorting, and pagination
* Product details and recommendations
* Sale pricing with configurable date ranges
* Product image management
* Mobile OTP authentication with resend and logout
* SMS integration with test mode
* Shopping cart and discount codes
* User profile, addresses, and wishlist
* Contact Us form and message management

### Admin Panel

* Dashboard
* Product, category, slider, attribute, and discount management
* User management
* About Us and footer content management
* Contact message management

---

## 🟠 Database

---

## 🟠 Security (comin soon)

---

## 🟠 Future Improvements

* Order management and order lifecycle
* Payment gateway integration
* Transaction management
* Purchase and payment status tracking
* Sales statistics and reporting
* Advanced admin dashboard analytics
* Improved product listing and search experience
* Automated testing and expanded test coverage
* Production-ready SMS integration
* Additional security hardening and performance optimization
