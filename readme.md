# S.A. Proto 2.0

## Prerequisites

This README is taylored to install on a Debian system. You may need to change commands to match your operating system.

Before following the intallation instructions, you need to have a working installation of `php`, `git`, `npm`, `composer`. Depending on your operating system and plans for your development environment, you need to either set-up a web-server and database or install docker [instructions below](#running-with-docker). JetBrains PhpStorm IDE is strongly recommended for development on this project, especially with the laravel plugin for proper code completion and reverences.

## Installation instructions

Installing the website on your own server should be quite simple. First you'll have to clone the repository somewhere in the vicinity of your public web folder using git:

```
git clone git@github.com:saproto/saproto.git
```

In the repository you'll find a file called `.env.example`. Make a copy of this file called `.env`:

```
cp .env.example .env
```

This is the environment configuration. In this file you will establish your own database connection, e-mail credentials and whatnot. You will at least need to set the following options for your instance of the website to work:

* `APP_URL` is the URL (including https://, but without trailing slash) of your own website instance.
* `PRIMARY_DOMAIN` and `FALLBACK_COOKIE_DOMAIN` is only the FQDN domain part of `APP_URL`.
* `DEBUG` should be set to `true` so you can see in detail what goes wrong if an error occurs.
* All the `DB_*` settings should be set to reflect your database set-up.
* `DEV_ALLOWED` is a comma separated list of IP addresses (IPv4 or IPv6) that may access your application. As long as `APP_ENV` is `local`, only whitelisted IP's are allowed to connect.
* `PERSONAL_PROTO_KEY` should be set to your personal Proto key, which can be found/generated on the bottom of your dashboard on the 'live' Proto site.

You can skip all the other stuff (mailing API, Google API) until you need to work on the specific part of the website that uses them.

To run grunt you need to first install `grunt-cli` globaly with the following command.

```
npm install -g grunt-cli
```

Now we can initialize the project.

```
chmod +x update.sh
composer install
npm install
grunt
php artisan key:generate
```

After this is done we can install, and later update, our project using our own update utility:

```
./update.sh
```

This update utility will initialize the website for you. It can also be used to update to a newer version of our code.

Next on the list is to initialize the database. The following command rebuilds the database from scratch (**warning**: this will completely empty the database, only use when you are sure!) and fills it with some dummy data:

```
php artisan migrate:refresh --seed
```

The database seeder copies some non-sensitive data from the live website, add your user account and display the randomly generated password in the console and finally adds more dummy users, orders and the likes. If you need more dummy data, feel free to improve the database seeder.

Now you have set-up your website correctly. The only thing that remains is pointing your web directory to the `public` directory of the website. This is where the front-facing controllers reside. The rest of the project is then shielded from public access. You could do this using symlinks. An example command on a webserver running DirectAdmin could like like this:

```
ln -s /home/user/domains/example.saproto.nl/saproto/public /home/user/domains/example.saproto.nl/public_html
```

That's it, everything should be up and running!


## Running with Docker

This repository can be run through Docker by using `docker-compose`. This is still a work in progress, but for now the website can be run localy using the instructions below. Be aware that as a Windows user you need to have either Windows Educational or Pro installed, because Docker uses Hyper-V.

For more information on installing and using Docker check out their documentation at https://docs.docker.com

After cloning the repository and installing Docker the following instructions can be run in the terminal in the source folder of the project.

### Setup

##### Configuration
Copy and rename `.env.docker.example` to `.env`.

```
cp .env.docker.example .env
```

After that open the new `.env` file and set the `PERSONAL_PROTO_KEY` to your personal Proto key, which can be found/generated on the bottom of your dashboard on the 'real' Proto site.

##### Client-side dependencies
To run grunt you need to first install `grunt-cli` globaly with the following command.

```
npm install -g grunt-cli
```

After that you can setup the client-side dependencies

```
npm install
grunt
```

##### Initial application setup
```
docker-compose up -d
docker-compose exec app /bin/bash
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

When you have finished the setup and Docker is running the website will be exposed at port `8080`, PhpMyAdmin will be exposed at port `8081` and Mailhog will be exposed at port `8082`.

You can sign in with the same Proto username you use on the 'real' site and the password given to you during the database seeding. This user will have full rights on the website.

### Handy commands

##### Running
```
docker-compose up -d
```

##### Stopping
```
docker-compose stop
```

##### Access to PHP container
```
docker-compose exec app /bin/bash
```
