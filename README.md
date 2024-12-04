# Laravel 11 Sanctum API

A simple API built with Laravel 11 and Sanctum for user authentication and authorization.

## Features

-   User Registration: Allows users to register via username, email and password.
-   User Login: Users can log in and receive a Sanctum token for authenticated requests.
-   User Profile: Authenticated users can view their profile information.
-   User Logout: Authenticated users can log out by invalidating their Sanctum token.

### Technologies Used

-   Laravel 11: PHP framework for building the API.
-   Sanctum: For token-based authentication.
-   MySQL: Used for storing user data.

### Setup

Follow the steps below to set up the Laravel 11 Sanctum API on your local machine.

1. Clone the Repository
   Clone the repository to your local machine:
   `git clone https://github.com/yourusername/laravel-sanctum-api.git`
   cd laravel-sanctum-api

2. Install Dependencies
   Install the project dependencies using Composer:
   `composer install`

3. Environment Configuration

    - Create a .env file by copying the .env.example file:
      `cp .env.example .env`
    - Generate the application key:
      `php artisan key:generate`
    - Set up your database connection in the .env file. For example:
      env
      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=your_database_name
      DB_USERNAME=your_database_user
      DB_PASSWORD=your_database_password

4. Run Migrations

-   Run the database migrations to create the necessary tables:
    `php artisan migrate`

5.  Install Sanctum
    Sanctum is already included in the dependencies, but you need to set it up. Run the following command to publish the Sanctum configuration:
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
    Then, run the Sanctum migration:
    `php artisan migrate`

6.  Set Up Sanctum Middleware

        - In the app/Http/Kernel.php file, make sure the Sanctum middleware is added to the api middleware group:
          `'api' => [

    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],`

7.  Testing the API

    - Once everything is set up, you can start the Laravel development server:
      `php artisan serve`

8.  Endpoints
    - Below are the available API endpoints for the project.

User Registration - Endpoint: POST /api/register - Description: Register a new user by providing name, email, and password. - Request Body:
json
Copy code
{
"name": "John Doe",
"email": "john@example.com",
"password": "password"
}
User Login

    - Endpoint: POST /api/login
    - Description: Log in an existing user and receive a Sanctum token.
    - Request Body:
      json
      Copy code
      {
      "email": "john@example.com",
      "password": "password"
      }

User Profile

    - Endpoint: GET /api/user
    - Description: Fetch the authenticated user's profile. This endpoint is protected by Sanctum authentication.
    - Headers: Authorization: Bearer {token}

User Logout - Endpoint: GET /api/logout - Description: Log out the authenticated user by invalidating the Sanctum token. - Headers: Authorization: Bearer {token}
