  Módulo de Movilizaciones

    Tabla: movilizacions con todos los campos

    Modelo: Movilizacion con relaciones y métodos

    Controlador: CRUD completo + Autorizar + Rechazar + Finalizar

    Vistas: Index, Create, Show, Edit

    Flujo: Pendiente → Aprobado/Rechazado → Finalizado

    Integrantes: Listado dinámico de personal en la comisión

    Cálculos: KM recorridos automáticos

📋 Campos incluidos
Sección	Campos
Datos principales	Fecha salida, Hora salida, Motivo, Lugar origen, Destino
Conductor	Nombres, Cédula, Cargo
Vehículo	Marca, Placa, KM salida, KM retorno
Comisión	Lista de integrantes (nombre, cédula, cargo)
Control	Estado, Observaciones, Usuario creador, editor, autorizador
🔄 Flujo de trabajo

    Crear → estado: pendiente

    Autorizar → estado: aprobado

    Finalizar → estado: finalizado (con fecha de retorno y km de retorno)

    Rechazar → estado: rechazado

📊 Módulos completos del sistema

    ✅ Novedades de Estación (CRUD + PDF + Excel + Dashboard)

    ✅ Movilizaciones de Unidades (CRUD + Autorización + Finalización)

    ✅ Inspecciones (CRUD + PDF)

    ✅ Usuarios (Edición + Roles)

    ✅ Notificaciones (Campanita + Base de datos)

System for the Control and Registration of Incidents to which a Firefighters Institution attends

Fully responsive system, that is, it works on mobiles, tablets and computers

## Features
-php            ^7.2

-Icons FontAwesome

-Activity Log 	spatie/laravel-activitylog    ^3.16

-Geocoder		javascript

-laravel/framework  ^8.0,

-Translate		laravel-lang/lang    ~7.0

-Send Mail		smtp

-PDF export		barryvdh/laravel-dompdf    ^0.8.6

-PDF import		barryvdh/laravel-dompdf    ^0.8.6

-Excel export	maatwebsite/excel          ^3.1

-Excel import	maatwebsite/excel          ^3.1

-Bootstrap		Fully responsive system, that is, it works on mobiles, tablets and computers
### Images

### Installation

1. Clone the repo
`git clone https://github.com/jcoronel3107/incidentes2.git`

2. Configure .env file
`mv .env.example .env`

3. Install composer
`composer install`

4.  Migrate database
`php artisan migrate`

5.  App key
`php artisan key:generate`

6. Seed database
`php artisan db:seed`

## Authors
Juan Fernando Coronel - jcoronel3107

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
