## Installation

1. Clone the repository
2. Install the dependencies
3. Run the application

```bash
git clone git@github.com:karakhanyans/calctek.git
cd calctek

composer install
cp .env.example .env

php artisan key:generate
php artisan migrate

npm install
npm run dev # or npm run build

php artisan serve
```

