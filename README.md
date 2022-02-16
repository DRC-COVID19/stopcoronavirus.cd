<p align="center"><img src="https://www.kinshasadigital.com/img/images/logo_kinshasa_digital.png?w=100"></p>

## About
Stop Coronavirus COVID-19 RDC - Situation Épidémiologique en RDC [http://www.stopcoronavirusrdc.info/](http://www.stopcoronavirusrdc.info/)
## Installation

Use the package manager composer to install laravel and yarn or npm to install node module.

```bash
    composer install
```

```bash
    npm install or yarn install
```

## Initialization

- Rename file .env.example to .env
- Update databse information

JWT token

```bash
    php artisan jwt:secret
```

Migration

```bash
    php artisan migrate
```

Install Laravel Admin

```bash
    php artisan admin:install
```

Storage link

```bash
    php artisan storage:link
```


Initialize seeds

```bash
    php artisan db:seed
```

Compile assets

```bash
    yarn or npm watch
```

Live reload
```bash
    yarn hot
```

Compile assets for Production 
```bash
    yarn prod or npm run prod
```

Note to update `dashboard.blade` and use `mix` method instead of `asset`

Start server

```bash
    php artisan serve
```
## Api Documentation

- e.g : [localhost:8000/docs](http://localhost:8000/docs)

## Contributing
- [Kinshasa Digital](https://www.kinshasadigital.com)
## License

[MIT license](https://opensource.org/licenses/MIT).
