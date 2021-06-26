# PHP
```sudo apt install software-properties-common```
```sudo add-apt-repository ppa:ondrej/php```

Installing PHP as an Apache module is a straightforward task:
```sudo apt update```
```sudo apt install php8.0 libapache2-mod-php8.0```

# Composer
First, update the package manager cache by running:
```sudo apt update```

Next, run the following command to install the required packages:
```sudo apt install php-cli unzip```

Make sure you’re in your home directory, then retrieve the installer using curl:
```cd ~```
```curl -sS https://getcomposer.org/installer -o composer-setup.php```


Next, we’ll verify that the downloaded installer matches the SHA-384 hash for the latest installer found
```HASH=`curl -sS https://composer.github.io/installer.sig`
php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"```

You’ll see the following output:
```Installer verified```


To install composer globally, use the following command which will download and install Composer as a system-wide command named composer, under /usr/local/bin:
```sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer```


To test your installation, run:
```composer```

# Installing mysql

```sudo apt-get update```

```sudo apt-get install mysql```

To create new user in mysql run:
```sudo mysql -u root -p```

Now add this line to create new user:
```CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';```

now you can use this user in the laravel application.


# Laravel
``` git clone https://github.com/Hoteru-Project/hoteru-backend-laravel.git```

```cd hoteru-backend-laravel```

```composer install```

rename .env.example to .env
Run``` php artisan key:generate```
Run ```php artisan migrate```

#### Configure database and add the following lines to it
##### For requesting google maps apis
##### GOOGLE_KEY=
#### Nodejs key to fetch hotels data (providers)
#### API_TOKEN=
#### Nodejs Applocation base url
#### API_URL=http://localhost:8080
#### Frontend application URI to send emails to redirect to.
#### APP_FRONTEND_URL=http://localhost:3000


#### IP Info Provider to get IP data
#### IPINFO_PROVIDER_TOKEN=

#### Currency Converter API Key to convert Currency
#### CURRCONV_API_KEY=

Now Generate secret key for JWT:
```php artisan jwt:secret```

You are all ready now in laravel

To create admin user type:
```php artisan voyager:admin your@email.com --create```


Now you need to migrate voyager seeds
```php artisan db:seed --class=DataTypesTableSeeder```
```php artisan db:seed --class=DataRowsTableSeeder```
```php artisan db:seed --class=MenusTableSeeder```
```php artisan db:seed --class=MenuItemsTableSeeder```
```php artisan db:seed --class=RolesTableSeeder```
```php artisan db:seed --class=PermissionsTableSeeder```
```php artisan db:seed --class=PermissionRoleTableSeeder```

Run ```php artisan serve```

