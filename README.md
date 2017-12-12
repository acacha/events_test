# Events test

# Social Login

- Utilitza OAuth: http://acacha.org/mediawiki/OAuth
- Delegació de permisos: valet key dels cotxes

Dos formes utilitzar:
- Com a clients: les nostres aplicacions utilitzen servidors OAuth de tercers com Github o Facebook
- Com a servidors: les nostres aplicacions ofereixen el servei a tercers (que poden ser aplicacions nostres propies)


## Client Social Login

Amb Laravel fàcil d'implementar gràcies a:
- Laravel Socialite: https://github.com/laravel/socialite | https://laravel.com/docs/5.5/socialite

Personalment he creat un paquet per automatitzar/facilitar la instal·lació a Adminlte:

- https://github.com/acacha/laravel-social

A Tasques i CS només cal que feu:

```
adminlte-laravel social 
php artisan acacha:social
```

I seguiu les passes de l'assistent.

Modifiqueu/sobrescriviu la vista parcial Laravel:

vendor/adminlte/auth/partials/social_login

I deixeu només les opcions de Google, Facebook, Github i Twitter. Github és prioritari.

## Servidor Social Login

- Laravel passport afegeix servidor Oauth a les aplicacions
- Acabem doncs tenint una aplicació fent dos Rols de OAuth o fins i tots els tres
  - http://acacha.org/mediawiki/OAuth#OAuth_roles
  - Authorization server: Laravel Passport
  - CLIENT PHP (ja sigui pur PUR o amb Javascript Vue però a Laravel): La nostra app és també la app client i el resource server
  - BACKEND PHP: Api json
  - CLIENT Javascript: per exemple aplicació vue-cli passà a ser l'aplicació client
  
Dos opcions:
- Client PHP: només alumnes no dual: creeu una nova opció/boto a CS que permeti logar-se utilitzant Tasques
- Client Javascript: l'aplicació de tasques Javascript ha de tenir un Login que utilitzi el Laravel Passport de tasques   

# Widgets

- Camps descripció: rich text editor
- Camps booleans: Toogle button
- Camps de dates
- Modals: similar als alerts però en una "finestra" nova

# Modals

Com funcionaven amb Jquery/Bootstrap:

- El codi Javascript el proporciona el propi Bootstrap. No cal escriure codi propi
- https://getbootstrap.com/docs/3.3/javascript/#modals
- El modal sempre és un div que ja es troba al document HTML però que inicialment està ocult
- Important: tenir en compte si cal tenir múltiples modals al mateix document HTML. Si són el mateix no repetir
  - ES poden tenir múltiples modals però pq siguin diferents
  - Vigileu no repetir el mateix dins un bucle (per exemple pq tenim una llista o taula)
- Per no tenir que utilitzar Javascript s'utilitzen atributs HTML a mida data-

 data-toggle="modal" data-target="#myModal"
 
- Això indica que si fem click a un buton per exemple amb aquest atributs es mostrarà el modal amb id myModal

Com ho fem amb Vue:
- https://vuejs.org/v2/examples/modal.html
- Utilitzem condicional rendering i activem un booleà que mostri el modal   
- Podem utilitzar els modal de adminlte:
  - https://adminlte.io/themes/AdminLTE/pages/UI/modals.html
  - No cal però utilitzar el codi Javascript sinó que mostrem el modal utilitzant vue
- També es pot fer un wrapper per executar la funcionalitat de Javascript:
  - https://vuejs.org/v2/examples/select2.html Exemple wrapper select2
  - En aquest cas però trobo molt més complicat

## Rich Text Editors:
- Quill.js
- Medium editor 
- https://github.com/sorrycc/awesome-javascript#editors

## Text overflow

- https://css-tricks.com/almanac/properties/t/text-overflow/
- https://css-tricks.com/examples/OverflowExample/
- Els 3 punts es diuen ellipsis
- https://www.npmjs.com/package/text-ellipsis
- Possible solució per mostrar text expandit al fer click:
  - http://jsfiddle.net/4h75G/13/
  - Es desplaça tota la taula és lleig
  
CLIP TEXT:

To clip text with an ellipsis when it overflows a table cell, you will need to set the max-width CSS property on each td class for the overflow to work. No extra layout div's are required

td {
    max-width: 100px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

Solució millorada:
- Utilitzar un modal:
- Mostrar sempre el contingut de la descripció adaptat a la mida de la cela
- Si es passa mostrar una elipsis (...)
- Si fem click mostrar un modal per podeu veure text complet
- Al modal podriem activar edició: utilitzar per exemple medium editor

# Toogle button



# Dates

Opcions:
- Input Date Mask: Molt millor per dates molt lluny de la data actual. Per exemple data de naixement. 
- Calendari 

Llibreries:
- PHP: Carbon
- Javascript: moment.js | https://date-fns.org/
- Configuració de la data al backend Laravel: timezone
- Humanitzar dates (1 day ago o similar)
- Localitzar dates (escriure en format correcte de la zona no en anglès)


# Millores a l'API

Nous endpoints:
- Poder marcar un esdeveniment com prioritari/assistiré si/no o el que es vulgui (Booleà)
  - Que no sigui utilitzar edit de tota la tasca
- Ídem que l'anterior però només per canviar la descripció

Concretament tip 4 de Cruddy By Design de Adam Wathan:
- https://github.com/adamwathan/laracon2017/pull/4

Proposta:

Exemple booleà assistiré:

- La idea és que l'usuari a la que està associat l'esdeveniment pugui marcat si hi assistirà o no
- Ho podem veure com un canvi d'estat de l'esdeveniment
- Estats: published

Suposem tenim originalment

- EventsController@attend -> Mètode per marcar que s'assistirà a un esdeveniment
- EventsController@unattend-> Mètode per desmarcar que s'assistirà a un esdeveniment

Un alternativa per separar controladors és crear un nou controlador:

- AttendedEventsController

I els mètodes passen a ser:

- EventsController@attend   -> AttendedEventsController@store
- EventsController@unattend -> AttendedEventsController@destroy

Exemple booleà prioritari:

- EventsController@priorize   -> PriorizedEventsController@store
- EventsController@unpriorize -> PriorizedEventsController@destroy

Article recomanat:
- https://github.com/adamwathan/laracon2017
- Vídeo: https://www.youtube.com/watch?v=MF0jFKvS4SI


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
