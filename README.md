<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Aplikasi SIMRS - Sistem Informasi Klinik (Powered by Yii2)</h1>
    <br>
</p>

Aplikasi ini adalah sistem manajemen klinik yang dirancang untuk membantu klinik dalam mengelola data pasien, rekam medis, resep obat, serta layanan yang diberikan kepada pasien. Sistem ini bertujuan untuk mempermudah administrasi klinik dan meningkatkan efisiensi layanan kepada pasien.

## FITUR UTAMA

1. Manajemen Pasien: Mengelola data pasien yang terdaftar, termasuk informasi pribadi dan riwayat medis.
2. Rekam Medis: Mencatat dan mengelola rekam medis pasien secara detail, termasuk layanan medis dan harga yang diterima.
3. Resep Obat: Menyimpan dan mengelola resep obat yang diberikan kepada pasien untuk proses penebusan.
4. Laporan Keuangan: Menyediakan laporan tentang biaya layanan dan resep obat yang diterima pasien.
5. Pengelolaan Staf: Menambahkan dan mengelola data staf medis dan non-medis yang bekerja di klinik.

## Teknologi yang Digunakan

- Backend: Yii2 (PHP)
- Frontend: Yii2 (PHP), JavaScript (untuk interaksi dinamis)
- Database: MySQL (atau database yang sesuai)
  Libraries & Tools: - jQuery (untuk interaksi dengan frontend) - Chart.js (untuk visualisasi data) - Bootstrap (untuk desain responsif)

## DIRECTORY STRUCTURE

      assets/             contains assets definition
      config/             contains application configurations
      console/            contains console commands (controllers)
      controllers/        contains Web controller classes
      environments/       contains environment-based overrides
      helpers/            contains useful helper classes
      mail/               contains view files for e-mails
      migrations/         contains all migration files
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      themes/             contains application view layout template
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources

## REQUIREMENTS

The minimum requirement by this project that your Web server supports PHP 8.1.

## INSTALLATION

Install neccesary package :

```
composer install
```

Open console/terminal

Initiate project state, choose project state you want to use, `0` for development, and `1` for production :

```
php init
```

Open file `config/components.php`, and change `dbname`, `username` and `password`, for example:

```php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'schemaMap' => [
                'mysql' => SamIT\Yii2\MariaDb\Schema::class
            ],
            'dsn' => 'mysql:host=localhost;dbname=simrs_test',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ]
];
```

Run migration for RBAC :

```
php yii migrate --migrationPath=@yii/rbac/migrations
```

Run migration for Admin :

```
php yii migrate --migrationPath=@mdm/admin/migrations
```

Run migration for the rest of application :

```
php yii migrate
```

Run this to add admin user, change `username` and `password` with you like :

```
php yii config/tambah-admin username password
```

You can then access the application through the following URL :

```
http://localhost/simrs
```

You can inject data with :

tambah data provinsi :

```
php yii insert/tambah-provinsi wilayah_provinsi
```

tambah data kabupaten_kota :

```
php yii insert/tambah-kabupaten-kota wilayah_kabupaten_kota
```

tambah data kecamatan:

```
php yii insert/tambah-kecamatan wilayah_kecamatan
```

tambah data kelurahan:

```
php yii insert/tambah-kelurahan wilayah_kelurahan
```

tambah data data satuan:

```
php yii insert/tambah-satuan data_satuan
```

tambah data obat :

```
php yii insert/obat obat


tambah data layanan medis :

```

php yii insert/layanan layanan_medis

## Lisensi

Aplikasi ini dilisensikan di bawah lisensi Apache License 2.0. Lihat file LICENSE untuk informasi lebih lanjut.

```

```
