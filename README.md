
# To-Do List App with Laravel 12 & VueJS 3

This is a simple To-Do List application built with Laravel 12, VueJS 3, and MySQL/PostgreSQL as the database. The app allows users to create tasks, mark them as completed, and perform basic CRUD operations (Create, Read, Update, Delete). It also supports basic user authentication using Laravel Sanctum.

## Features

- **Add tasks**: Users can create new tasks with a title and description.
- **Apply basic validation**: Tasks must have a title, and a description is optional.
- **Edit/Delete tasks**: Users can edit task titles and delete tasks.
- **Mark tasks as completed**: Users can mark tasks as completed.
- **Authentication with Laravel Sanctum**: Users can log in and perform actions on tasks after authentication.
- **Basic CRUD operations**: Tasks can be created, read, updated, and deleted.
- **Automated testing**: Tests are written to ensure application functionality.
- **Deploy to production**: Instructions to deploy the app to a production server.

---

## Requirements

- PHP >= 8.1
- Laravel 12
- MySQL or PostgreSQL
- Node.js & npm (for frontend development)
- Composer
- VueJS 3

---

## Installation

### Clone the Repository

```bash
git clone https://github.com/RaihanBhuiyan/to-do-list.git
cd todo-list-app
```

### Set Up Your Environment

1. **Install Composer Dependencies**

```bash
composer install
```

2. **Set Up the .env File**

Copy the `.env.example` file and rename it to `.env`. Then, update the database and app configurations:

```bash
cp .env.example .env
```

Open the `.env` file and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

3. **Generate Application Key**

```bash
php artisan key:generate
```

4. **Run Migrations**

To create the necessary database tables:

```bash
php artisan migrate
```

5. **Install NPM Dependencies**

```bash
npm install
```

6. **Run Vite (Frontend)**

```bash
npm run dev
```

---

## Authentication Setup with Laravel Sanctum

Laravel Sanctum is used for simple authentication. To set it up:

1. **Install Sanctum**

```bash
composer require laravel/sanctum
```

2. **Publish Sanctum Config**

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

3. **Run Sanctum Migrations**

```bash
php artisan migrate
```

4. **Add Sanctum Middleware**

//

5. **Enable API Authentication**

In the `app/Models/User.php`, make sure to include the `HasApiTokens` trait:

```php
use Laravel\Sanctum\HasApiTokens;
```

### User Authentication API Endpoints

- **POST `/api/login`**: Log in and get the authentication token.
- **POST `/api/register`**: Register a new user.
- **GET `/api/user`**: Fetch authenticated user details (requires authentication).

---

## CRUD Operations for Tasks

1. **Create Task (POST /api/tasks)**:  
   - Users can add tasks with a title and description.
   - The task must have a title (description is optional).

2. **Read Tasks (GET /api/tasks)**:  
   - Fetch all tasks for the authenticated user.

3. **Update Task (PUT /api/tasks/{id})**:  
   - Update a task's title or mark it as completed.

4. **Delete Task (DELETE /api/tasks/{id})**:  
   - Delete a task by its ID.

### Task API Endpoints

- **POST `/api/tasks`**: Create a new task.
- **GET `/api/tasks`**: List all tasks for the authenticated user.
- **PUT `/api/tasks/{id}`**: Update a task (mark as completed).
- **DELETE `/api/tasks/{id}`**: Delete a task.

---

## Frontend with VueJS 3

1. **Fetch Tasks**:  
   The frontend fetches tasks using the API `/api/tasks` and displays them in two categories: Pending and Completed.

2. **Add New Task**:  
   Users can add new tasks using a form with input fields for the task's title and description.

3. **Mark Task as Completed**:  
   Tasks can be marked as completed, which updates their status.

4. **Delete Task**:  
   Tasks can be deleted from the list.

---

## Testing

Automated testing is implemented using PHPUnit. You can run the tests with the following command:

```bash
php artisan test
or 
php artisan test --filter TaskApiTest
```

Tests include:
- Validating task creation, update, and deletion.
- Ensuring authenticated users can access their tasks.
- Verifying authentication and registration functionalities.

---

## Deployment

To deploy the app to production, follow these steps:

1. **Set Up Production Server**

Make sure your production server meets the following requirements:
- PHP >= 8.1
- Composer
- Node.js
- MySQL/PostgreSQL

2. **Clone the Repository**

Clone the project to your server:

```bash
git clone https://github.com/RaihanBhuiyan/to-do-list.git
cd todo-list-app
```

3. **Set Up Environment**

Copy the `.env.example` to `.env` and configure the database and other settings as required.

4. **Install Dependencies**

Install the PHP and frontend dependencies:

```bash
composer install --optimize-autoloader --no-dev
npm install
```

5. **Run Migrations**

```bash
php artisan migrate --force
```

6. **Build Frontend Assets**

Build the frontend assets for production:

```bash
npm run build
```

7. **Set Up Web Server**

Configure your web server (e.g., Nginx or Apache) to serve the Laravel application, pointing to the `public` folder.

8. **Configure Permissions**

Ensure proper permissions for storage and cache directories:

```bash
chmod -R 775 storage bootstrap/cache
```

9. **Start the Application**

Start the application by running:

```bash
php artisan serve --host=0.0.0.0 --port=80
```

You can now access the app in the browser.

---
10. Docker Setup

To run the application using Docker, follow these steps:


Run the following command to build and start the Docker containers:

```bash
docker-compose up -d
```

To run Artisan commands inside the Docker container, use:
```bash
docker-compose exec app php artisan <command>
docker-compose exec app php artisan migrate
```
Rebuild the Containers
```bash
docker-compose down --rmi all
docker-compose up -d
```
## Conclusion

This app allows users to manage tasks easily with features like adding, editing, deleting, and marking tasks as completed. It uses Laravel Sanctum for secure authentication, VueJS for a dynamic frontend, and MySQL/PostgreSQL for the database. Automated tests ensure that the core functionality is working as expected.

For deployment, the app can be set up on any server with PHP and Node.js, following the outlined steps.

---

## License

This project is open-source and available under the [MIT License](LICENSE).
