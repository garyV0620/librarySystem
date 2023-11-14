# Library System 
This App is a Library System that you can login and register account (User can borrow and return books while admin can enable and disable users and maintenance books while both users can update their profile). 
This App also uses email verification to verify registered account.
You can use the default User Name: 'username' and Password: 'password' to log in admin.

## About
This project uses laravel framework with blade template.
It uses sweet alert, Jquery, DataTable, JavaScript, TailWind CSS, CSS.
It also uses Laravel Breeze.

## Getting Started
You can clone the repository or download it 

### Prerequisites
-PHP 8.0 and Up, SQL, Or you can use local server such as WAMP or XAMP or LAMP, COMPOSER, NODE JS, GIT

## Installation

Follow these steps to install and set up the project:

1. **Clone the Repository:**
   ```bash
   $ $ git clone 'repository'
   $ cd librarySystem
   
2. Install Composer Dependencies:
    Run the following command on your command prompt or terminal:
    ```bash
   $ composer install

3. Install Node.js Dependencies:
    Run the following command on your terminal:
     ```bash
   $ npm install
     
4. Copy .env.example file to .env on the root folder.
   For Email verification you can use this settings to .env or use your own settings
	```dotenv
    MAIL_MAILER=smtp
	MAIL_HOST=smtp.gmail.com
	MAIL_PORT=587
	MAIL_USERNAME=vgary0620@gmail.com
	MAIL_PASSWORD=vxqdnigbkpzikxtz
	MAIL_ENCRYPTION=null
	MAIL_FROM_ADDRESS="librarySystem@gmail.com"
	MAIL_FROM_NAME="${APP_NAME}"
	```  
	
5. Database Configuration:
    Edit the .env file and update the database settings according to your setup. For MariaDB, use the following configuration:
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3307
    DB_DATABASE=library_system
    DB_USERNAME=root
    DB_PASSWORD=
    ```  
    Alternatively, for SQLite, comment out the MySQL settings and use:
     ```dotenv
    DB_CONNECTION=sqlite
    ```
   

6. Generate an Encryption Key:
   Run the following command to generate an application encryption key:
    ```bash
    $ php artisan key:generate
    
7. Run Database Migrations:
   Execute the following command to run database migrations and Seeder:
    ```bash
    $ php artisan migrate:fresh
	$ php artisan db:seed
    ```
     type 'yes' if prompt to create.
8. Run the Application: To run the application, follow these steps:

    8.1. Run the development build  
    ```bash
    $ npm run dev
    ```
    If you want to use a custom host and port:
    ```bash
    $ npm run dev -- --host=yourhostORIp --port=yourPort
    ```
    
    8.2. Open another terminal.
    
    8.3. Start the PHP development server:
    ```bash
    $ php artisan serve
    ```
    If you want to use a custom host and port:
    ```bash
    $ php artisan serve --host=yourhostORIp --port=yourPort
    ```
    
    **Note:** Do not use the same port as the one used for `npm run dev`.
    
    8.4. Check the INFO message: Server running on [http://127.0.0.1:8001].
    
    8.4. Open [http://127.0.0.1:8001] in your web browser.

9. Enjoy using the APP (you can register by clicking Register Account)