composer i

creer .env

php artisan key:generate

npm install && npm run build

composer run dev

php artisan migrate --seed
# or

php artisan migrate:fresh --seed

php artisan route:list

php artisan optimize

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Installez Laravel Passport
php artisan install:api --passport

# Configurez le modèle User pour utiliser Passpor
HasApiTokens

# Configurez api dans config/auth.php

  'guards' => [
    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
   ],

# Deploying Passport
php artisan passport:keys
php artisan passport:keys --force

# Loading Keys From the Environment
php artisan vendor:publish --tag=passport-config

# Vérifier la configuration de Passport dans config/passport.php
'private_key' => env('PASSPORT_PRIVATE_KEY', storage_path('oauth-private.key')),
'public_key' => env('PASSPORT_PUBLIC_KEY', storage_path('oauth-public.key')),

# refresh 
php artisan passport:client --personal


# Installez Socialite pour la connexion OAuth2
composer require laravel/socialite

# Ajoutez Microsoft dans Socialite : Modifiez config/services.php
'microsoft' => [
    'client_id' => env('OAUTH_MICROSOFT_CLIENT_ID'),
    'client_secret' => env('OAUTH_MICROSOFT_CLIENT_SECRET'),
    'redirect' => env('OAUTH_MICROSOFT_REDIRECT_URI'),
],

# . env
OUTLOOK_CLIENT_ID=
OUTLOOK_TENANT_ID=
OUTLOOK_CLIENT_SECRET=
OUTLOOK_REDIRECT_URI=

## Système de Rôles et Permissions
composer require spatie/laravel-permission

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

php artisan make:seeder RolesAndPermissionsSeeder



php artisan make:controller AuthController

php artisan migrate

# Configurer une bibliothèque pour accéder à Microsoft Graph
composer require microsoft/microsoft-graph

# Créer une route et un contrôleur
php artisan make:controller OutlookEmailController

Route::get('/authorize', [OutlookEmailController::class, 'authorizeUser']);
Route::get('/callback', [OutlookEmailController::class, 'handleCallback']);
Route::get('/emails', [OutlookEmailController::class, 'fetchEmails']);


GET  http://127.0.0.1:8000/api/authorize

http://127.0.0.1:8000/api/callback

POST https://login.microsoftonline.com/{TENANT_ID}/oauth2/v2.0/token

Key	Value
client_id	Votre Client ID
client_secret	Votre Client Secret
grant_type	authorization_code
code	(Collez ici le code d'autorisation récupéré)
redirect_uri	URL de redirection (exemple : http://127.0.0.1:8000/api/callback)


http://127.0.0.1:8000/api/emails



php artisan make:model Classification -rm

php artisan make:mail VerifyEmail

