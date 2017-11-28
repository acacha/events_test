# Events test


# Estructura

2 projectes Github:
- Paquet
- Aplicació test Laravel

Exemple projecte events:

- events: carpeta amb l'aplicació Laravel.
  - events: carpeta amb el projecte. Ha d'estar dins de la carpeta test

Notes:
- Cada carpeta té el seu propi projecte Github
- Utilitzeu fitxer .gitignore per no afegir el projecte paquet al repositori del projecte de test

Per treballar amb el PHPStorm es poden obrir dos projectes PHPStorm o treballar al projecte test

# TODO

Projecte: tinkeringJsonApi
- Integrar dins del projecte: Dos formes interactuar amb els model/base de dades:
  - Laravel
  - API JSON
  - 2 Controladors diferents
  - 2 Tests suites diferents
  
# Plantilles

- Vue component: https://gist.github.com/acacha/891bae9e5497346cf6f4a48b9d522e5b
- Vue component test:  https://gist.github.com/acacha/9fea3c99326b61671d983d34d5c5c2fa
- Laravel Blade view: https://gist.github.com/acacha/93d676daf953a589a704ed1827138083

# Tasques

- Utilitzeu el menu de la sidebar per apuntar a les diferents URLS de la vostra aplicació
- Instal·lar i configurar Laravel passport seguint docs: 
 - https://laravel.com/docs/5.5/passport
 - Recordeu Middleware FreshApitoken: https://laravel.com/docs/5.5/passport#consuming-your-api-with-javascript

## Instal·lació testos Javascript:
  
```bash
npm install --save-dev vue-test-utils mocha mocha-webpack jsdom jsdom-global expect
npm run dev
```

Crear Carpeta Tests/Javascript a paquet (no a test) i posa fitxer setup.js:

```
require('jsdom-global')()
```

Afegir npm run script a package.json amb el nom test:

Objectiu: executar els testos amb npm run test

```
test: "mocha-webpack --webpack-config=node_modules/laravel-mix/setup/webpack.config.js --require events/tests/Javascript/setup.js events/tests/Javascript/**.*.spec.js"
```

## Configuració Path resolve NPM

Cal informar a webpack que a part de la carpeta node_modules hi ha més carpetes on pot trobar mòduls en local

Cal fer modificacions al fitxer webpack-mix.js

Just despres de **.sourceMaps()** afegir:

```
.webpackConfig({
    resolve: {
      modules: [
        path.resolve(__dirname, './events/resources/assets/js'),
        path.resolve(__dirname, 'node_modules')
      ]
    }
  })
```

I cal convertir la carpeta /events/resources/assets/js en un paquet npm amb:

```
npm init -y
```

 Canvieu el nom del paquet pel nom del projecte amb vendor davant. Exemple:
 
```
acacha-events
```
    
Canvieu també el main:

```
main:'events-bootstrap.js'
```

I creeu el fitxer events-bootstrap.js:

Mireu tota la estructura al codi del professor amb exemple de com ha de ser el fitxer.

Finalment cal que feu un require del paquet al projecte de test. Al fitxer resources/assets/js/app.js 
després de carregar vue:

```
window.Vue = require('vue')
```

Poseu un require

```
require('events-bootstrap');
```

Comproveu compila ok npm run dev.

## Laravel permission

Instal·leu el suport seguinet les passes de (feu la instal·lació AL PAQUET!!!):

https://github.com/spatie/laravel-permission#installation

En resum:

 $ cd events
 $ composer require spatie/laravel-permission
  
Al projecte de tests 

 $ cd ..
 $ composer update 
 
Veureu que instal·la Laravel Permission. 

Ara a test executeu:

```php
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"
```

I ja podeu instal·lar les taules de roles i permisssos. Ara cal que els usuaris suportin rols i permisos
afegint el Trait HasRoles al model app/User:

 https://github.com/spatie/laravel-permission#usage
  
## Laravel Dusk

Instal·leu seguint els passos de:

https://laravel.com/docs/5.5/dusk#installation

Recordeu de desactivar el autodiscover per tal de no tenir problemes amb Laravel Dusk al instal·lar en explotació
(dona un error sinó ja que és molt important no executar Laravel Dusk a explotació per que permet impersonar usuaris)

```
"extra": {
        "laravel": {
            "dont-discover": [
                "laravel/dusk"
            ]
        }
    },
```

# Helpers de projecte

Crear fitxer:

```
events/src/helpers.php
```

Afegir a autoload de events/composer.json:

```
"autoload": {
        ...
        "files" : [
            "src/helpers.php"
        ]
    },
```

Run:
 
```
composer dumpautoload
```

I al projecte test pq agafi els canvis execute:

```
composer update acacha/events
```

Proveu amb tinker:

```
php artisan tinker;  
Psy Shell v0.8.15 (PHP 7.0.22-0ubuntu0.16.04.1 — cli) by Justin Hileman
>>> initialize_events_permissions()
```

Mètodes cal crear:
- initialize_events_permissions: Crear tots els rols i permisos necessàries a l'aplicació
- create_admin_user: crea usuari admin
- first_user_as_events_manager

Editar el fitxer events/composer.json

# User admin i rol seeders

Executar els helpers:
- initialize_events_permissions
- create_admin_user
- first_user_as_events_manager

Al seed de la base de dades

# (HTTP)Request Objects

Crear tots els objectes per a totes les tipus de peticions per a User i Event. Exemple Users (ídem Events)

- ListUsers
- StoreUser
- EditUser
- ShowUser
- DestroyUser

Implementar normes de validació Laravel (retornin 422 si error) i crear test per comprovar:
- Comprovar email a usuaris: ha de ser únic i ha de ser un email

Afegir autoritzacions amb Laravel Permission:

- Crear helpers per omplir la base de dades:
  - Vegeu apartat helpers
- Adaptar els testos. Al setup assegurar-se que els permissos estan afegir a la base de dades: initialize_events_permissions  
- Crear un permis per a cada operació
- Crear un rol manager per users (users-manager) i per a events (events-manager) amb permisos per fer totes les operacions 

Events:
- Un usuari pot crear, veure, editar i eliminar events creats per ell mateix
- Un usuari no pot veure, editar ni eliminar esdeveniment d'altres usuaris sinó té rol de manager

Usuaris:
- Un usuari no pot editar ni eliminar altres usuaris sinó és users managers 
