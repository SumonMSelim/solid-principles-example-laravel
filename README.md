## Refactor your legacy code using SOLID principles
[![Tests](https://github.com/SumonMSelim/solid-principles-example-laravel/actions/workflows/tests.yml/badge.svg)](https://github.com/SumonMSelim/solid-principles-example-laravel/actions/workflows/tests.yml)
[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)](https://laravel.com/)
[![License](https://img.shields.io/github/license/SumonMSelim/solid-principles-example-laravel)](https://github.com/SumonMSelim/solid-principles-example-laravel/blob/main/composer.json)


This is a Laravel application used for demo purposes — a pseudo application that illustrates how SOLID principles can be applied in a PHP/Laravel codebase.

### Prerequisites

**Recommended (Docker):**

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

No local PHP or Composer installation is required when using Docker.

**Application stack:**

| Component | Version |
|-----------|---------|
| PHP | 8.4 |
| Laravel | 13.x |
| MySQL | 8.4 |

**PHP extensions** (included in the Docker image; required if running without Docker):

- `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `gd`, `zip`

### Installation

1. Clone the repository:

   ```bash
   git clone git@github.com:SumonMSelim/solid-principles-example-laravel.git
   cd solid-principles-example-laravel
   ```

2. Create your environment file:

   ```bash
   cp .env.example .env
   ```

3. Configure Docker database settings in `.env` (defaults match `docker-compose.yml`):

   ```dotenv
   APP_URL=http://localhost:8081

   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=solid
   DB_USERNAME=solid
   DB_PASSWORD=secret
   ```

4. Build and start the containers:

   ```bash
   docker compose up --build -d
   ```

5. Run database migrations:

   ```bash
   docker compose exec app php artisan migrate
   ```

6. (Optional) Verify the installation:

   ```bash
   docker compose exec app php artisan test
   ```

### Running the application

Start all services:

```bash
docker compose up -d
```

Stop services:

```bash
docker compose down
```

View logs:

```bash
docker compose logs -f app
```

Open the app at [http://localhost:8081](http://localhost:8081).

Health check: [http://localhost:8081/up](http://localhost:8081/up)


### Testing

Run the full test suite locally:

```bash
docker compose exec app php artisan test
```

Continuous integration runs on every pull request and push to `main` via [GitHub Actions](.github/workflows/tests.yml).

### Docker services

| Service | URL / Port |
|---------|------------|
| App (nginx) | http://localhost:8081 |
| MySQL | localhost:3307 |

Default database credentials (override in `.env`):

- Database: `solid`
- Username: `solid`
- Password: `secret`

### Example requests

Register a user via the API:

```bash
curl -X POST http://localhost:8081/api/users/create \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"first_name":"Jane","last_name":"Doe","email":"jane@example.com","password":"secret123"}'
```

Check payment status:

```bash
curl http://localhost:8081/status
```

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
