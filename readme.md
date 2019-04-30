## Setup
- Clone the repository: <code>git clone https://github.com/judith-angeli/yaraku</code>
- Run <code>composer install</code>
- Create <code>.env</code> file in the root directory and update database credentials
- Generate a key <code>php artisan key:generate</code>
- Run <code>php artisan migrate</code>
- Optional: Run <code>php artisan db:seed --class=BooksTableSeeder</code> to pre-populate the database tables
- Visit '/' or '/books'
