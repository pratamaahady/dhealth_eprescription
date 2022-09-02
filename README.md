# E-Prescription

Aplikasi sederhana yg memungkinkan user untuk dapat melakukan pencatatan pemberian resep secara digital.

## Requirements
- PHP >= 7.4
- MySQL
- Composer

## Cara Install


1. Clone repository ini.

    ````
    git clone https://github.com/pratamaahady/dhealth_eprescription
    ````

2. Masuk ke folder <b>dhealth_eprescription</b>
    ````
    cd dhealth_eprescription
    ````

3. install menggunakan <b>Composer</b>
    ````
    composer install
    ````

4. Salin file <b>.env.example</b> dengan nama <b>.env</b>
    ````
    cp .env.example .env
    ````

5. Generate key untuk aplikasi
    ````
    php artisan key:generate
    ````

6. Konfigurasi koneksi database
    ````
    nano .env
    ````

    ````
    DB_DATABASE=NAMA_DATABASE
    DB_USERNAME=USER_DATABASE
    DB_PASSWORD=PASSWORD_DATABASE
    ````

7. Import database
    ````
    php artisan migrate:fresh --seed
    ````

8. Jalankan aplikasi
    ````
    php artisan artisan serve
    ````

## Login Account
````
Username: admin
Password: password
````

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
