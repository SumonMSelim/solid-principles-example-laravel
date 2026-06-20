## Refactor your legacy code using SOLID principles

This is a Laravel application used for demo purposes — a pseudo application that illustrates how SOLID principles can be applied in a PHP/Laravel codebase.

### Prerequisites

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

No local PHP or Composer installation is required.

### Quick start

```bash
git clone git@github.com:SumonMSelim/solid-principles-example-laravel.git
cd solid-principles-example-laravel
cp .env.example .env
# Ensure Docker database settings in .env:
# DB_HOST=mysql DB_DATABASE=solid DB_USERNAME=solid DB_PASSWORD=secret
docker compose up --build
```

In another terminal:

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan test
```

Open [http://localhost:8081](http://localhost:8081).

### Stack

| Component | Version |
|-----------|---------|
| PHP | 8.4 |
| Laravel | 13.x |
| MySQL | 8.4 |

### Docker services

| Service | URL / Port |
|---------|------------|
| App (nginx) | http://localhost:8081 |
| MySQL | localhost:3307 |

Default database credentials (override in `.env`):

- Database: `solid`
- Username: `solid`
- Password: `secret`

### Routes

| Method | Path | Description |
|--------|------|-------------|
| GET | `/` | Welcome page |
| POST | `/register` | Register a user (web) |
| POST | `/users/create` | Create a user (admin) |
| GET | `/users/index` | List users from yesterday (admin) |
| POST | `/pay` | Process a payment (user) |
| GET | `/status` | Payment status (user) |
| POST | `/api/register` | Register a user (API) |
| POST | `/api/users/create` | Create a user (API) |

### SOLID map

| Principle | Examples in this codebase |
|-----------|---------------------------|
| **SRP** | `PaymentOrchestrator`, `NotificationService`, `CreateUserRequest` |
| **OCP** | Payment gateways registered in `config/payments.php`; resolved via `PaymentGatewayResolver` |
| **LSP** | All payment classes implement `PayableInterface`; status services implement `PaymentStatusInterface` |
| **ISP** | Focused contracts: `PayableInterface`, `NotifiableInterface`, `PaymentStatusInterface` |
| **DIP** | Controllers depend on interfaces; bindings in `AppServiceProvider` |

### Resources

- Video: https://www.youtube.com/watch?v=TWY9Bin9TY0
- Slides: https://docs.google.com/presentation/d/1uBOPaLyZ1SSN-u8usc8HiOFVWikL7YO3b27I0WdD8V8/
