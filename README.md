
Installation
Clone repository

clone repository to your local machine

<code>git clone https://github.com/mucahittopal/laravel-vue-integration.git</code>

Change Directory

Navigate into the project directory

<code>cd laravel-vue-integration</code>

Copy .env file

copy content of the environment file

<code>cp .env.example .env</code>

Edit .env file

Update .env file with DB information

<pre>
  DB_CONNECTION=mysql
  DB_HOST=localhost
  DB_PORT=3306
  DB_DATABASE=laravel
  DB_USERNAME=root
  DB_PASSWORD=
</pre>

Install laravel packages

Remove composer.lock file and install packages

<code>rm composer.lock</code>

<code>composer install</code>

Generate Key

Generate application key from your terminal

<code>php artisan key:generate</code>

Install npm packages

Remove package-lock.json file and install npm packages

<code>rm package-lock.json</code>

<code>npm i</code>

Run Migrations

Run database migrations and seed the post tables

<code>php artisan migrate:fresh --seed</code>

Set password underconstruction

<code>php artisan code:set 123456</code>


Start Application

<code>php artisan serve</code>

Start Vue

<code>npm run watch</code>

Go to localhost:8000 and register, start blogging tada






