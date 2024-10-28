# Login Page

Single Page login applications

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)

## Installation

1. **Clone the repository:**
    ```bash
    git clone git@github.com:kaziharun/login-page.git
    ```

2. **Install dependencies:**
    ```bash
    composer install
    npm install
    npm run dev
    ```

3. **Set up environment variables:**
    - Copy .env.dist to .env.local.
    - Modify the .env.local file to configure the database connection.
    - Generate a new secret key:
    ```bash
    php bin/console secrets:generate-keys
    ```


4. **Database Setup:**
    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```
   
5. **Load Seed Data:**
    ```bash
    php bin/console doctrine:fixtures:load
    ```
   
6. **Run the Symfony Server:**
    ```bash
    symfony server:start
    ```

7. **Access the application:**
   Open a web browser and go to `http://localhost:8000`

   

## Usage

Provide instructions on how to use the application or any relevant usage information.
1. **User Access:**
   - User: `tom@email.com`
   - Password: `user123`
   
Feel free to explore and test the login functionality.
