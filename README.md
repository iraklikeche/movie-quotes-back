# Movie Quotes - Back-End

This is the back-end for the Movie Quotes application, built with Laravel. It provides the necessary APIs for user authentication, movie and quote management, and real-time notifications.

## Features

-   User Authentication (Sign up, Sign in, Forgot Password, Reset Password) using Laravel Sanctum
-   CRUD operations for movies and quotes
-   Real-time notifications using Pusher and Laravel Broadcasting
-   Localization support with Spatie Translatable
-   Media management with Spatie Media Library
-   Advanced query capabilities with Spatie Query Builder

## Technologies Used

-   **Laravel**
-   **MySQL**
-   **Spatie Translatable**
-   **Spatie Media Library**
-   **Spatie Query Builder**
-   **Laravel Sanctum**
-   **Pusher**
-   **Laravel Broadcasting**

## Installation Instructions

### Prerequisites

Ensure you have the following installed:

-   [PHP](https://www.php.net/) (v7.4 or higher)
-   [Composer](https://getcomposer.org/)
-   [MySQL](https://www.mysql.com/)
-   [Node.js](https://nodejs.org/) and [npm](https://www.npmjs.com/)

### Step-by-Step Guide

1. **Clone the repository**:

    ```bash
    git clone git@github.com:RedberryInternship/-back-movie-quotes-irakli-ketchekmadze.git
    cd movie-quotes-backend
    ```

2. **Install dependencies**:

    ```bash
    composer install
    npm install
    ```

3. **Configure environment variables**:

    - Copy the `.env.example` file to `.env`:
        ```bash
        cp .env.example .env
        ```
    - Update the `.env` file with your database and other service credentials.

4. **Generate application key**:

    ```bash
    php artisan key:generate
    ```

5. **Run database migrations**:

    ```bash
    php artisan migrate
    ```

6. **Seed the database** (if you have seeders):

    ```bash
    php artisan db:seed
    ```

7. **Run the development server**:
    ```bash
    php artisan serve
    ```

## Usage

To start using the application, run the development server as described above. You can then access the API at `http://localhost:8000`.

## Configuration

The application requires several environment variables for configuration. Add these variables to your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=movie_quotes
DB_USERNAME=your-database-username
DB_PASSWORD=your-database-password

PUSHER_APP_ID=your-pusher-app-id
PUSHER_APP_KEY=your-pusher-app-key
PUSHER_APP_SECRET=your-pusher-app-secret
PUSHER_APP_CLUSTER=your-pusher-app-cluster

BROADCAST_DRIVER=pusher


## Endpoints

### Authentication

- **Register**: `POST /api/register`
- **Login**: `POST /api/login`
- **Forgot Password**: `POST /api/password/forgot`
- **Reset Password**: `POST /api/password/reset`

### Movies

- **Create Movie**: `POST /api/movies`
- **Get Movies**: `GET /api/movies`
- **Get Movie**: `GET /api/movies/{id}`
- **Update Movie**: `PUT /api/movies/{id}`
- **Delete Movie**: `DELETE /api/movies/{id}`

### Quotes

- **Create Quote**: `POST /api/quotes`
- **Get Quotes**: `GET /api/quotes`
- **Get Quote**: `GET /api/quotes/{id}`
- **Update Quote**: `PUT /api/quotes/{id}`
- **Delete Quote**: `DELETE /api/quotes/{id}`

### Users

- **Get User Profile**: `GET /api/user`
- **Update User Profile**: `PUT /api/user`
```

## File Structure

movie-quotes-backend/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
├── README.md
└── webpack.mix.js

## Database

<a href='https://drawsql.app/teams/irakli/diagrams/movie-quotes'>Link to drawsql</a>

<img src="{{ env('DRAWSQL_IMAGE') }}" alt="drawSQL" />
