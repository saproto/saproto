<h1 align="center">
    <a href="https://proto.utwente.nl">
        <img alt="Proto logo" src="public/images/logo/banner-regular.png" width="100%">
    </a>
    <br>
    S.A. Proto
</h1>

<p align="center"> 
    <b>The website of S.A. Proto</b>.<br> 
    The study association of BSc. Creative Technology and MSc. Interaction Technology.<br>
    <a href="https://github.com/saproto/saproto/issues">
        <img alt="issues badge" src="https://img.shields.io/github/issues/saproto/saproto?color=%2503b71a">
    </a>
    <a href="https://github.com/saproto/saproto/graphs/contributors">
        <img alt="contributors badge" src="https://img.shields.io/github/contributors/saproto/saproto?color=%2503b71a">
    </a>
    <img alt="open source badge" src="https://badges.frapsoft.com/os/v2/open-source.svg?v=103">
</p>

## Contributors

[Here](https://github.com/saproto/saproto/graphs/contributors) you can find the people that have contributed to the code to this project. But, let's not forget the other members of the [HYTTIOAOAc](https://www.proto.utwente.nl/committee/haveyoutriedturningitoffandonagain)!

## Prerequisites

This README is tailored to install on a Debian system. You may need to change commands to match your operating system.

Before following the installation instructions, you need to have a working installation of `php`, `git`, `npm`, `composer`. Depending on your operating system and plans for your development environment, you need to either set up a webserver and database or install docker using the [instructions below](#running-with-docker). JetBrains [PhpStorm IDE](https://www.jetbrains.com/help/phpstorm/installation-guide.html) is strongly recommended for development on this project, especially with the laravel plugin for proper code completion and reverences.

## Installation instructions

Installing the website on your own system should be quite simple. First you'll have to clone the repository somewhere on your system:

```
git clone git@github.com:saproto/saproto.git
```

If you want to run a development environment in Docker **(you most likely do)** you can now move on to the [Running with Docker](#running-with-docker) section below. If you want to install without Docker you can find the instructions in the section [Running without Docker](#running-without-docker).

## Running with Docker

This repository can be run through Docker by using `docker compose`. This is still a work in progress, but for now the website can be run locally using the instructions below. Be aware that as a Windows user you need to have either Windows Educational or Pro installed, because Docker uses Hyper-V.

For more information on installing and using Docker check out their documentation at [docs.docker.com](https://docs.docker.com).

After cloning the repository and installing Docker the following instructions can be run in the terminal in the source folder of the project.

### Setup

##### Configuration
Copy and rename `.env.docker.example` to `.env`.

```
cp .env.docker.example .env
```

After that open the new `.env` file and set the `PERSONAL_PROTO_KEY` to your personal Proto key, which can be found/generated on the bottom of [your dashboard](https://www.proto.utwente.nl/user/dashboard) on the *live* Proto website.

##### Client-side dependencies
First you'll need to run `npm install` to install all client-side dependencies.

To compile the project assets (JS/CSS) run `npm run dev` to compile once or `npm run watch` to keep checking for changes to scripts or stylesheets.

When adding a new library or client-side dependency through npm don't forget to require the scripts in `application.js` and the stylesheet in `vendor.scss`.

##### Initial application setup
```
docker compose up -d
docker compose exec app /bin/bash
composer install
php artisan key:generate
php artisan migrate --seed
```

When you have finished the setup and Docker the following port will be exposed on localhost:

- `8080` = Website
- `8081` = PhpMyAdmin
- `8082` = [Mailhog](https://github.com/mailhog/MailHog)

You can sign in with the same Proto username you use on the *live* website and the password given to you during the database seeding. This user will have full admin rights on the local website.

### Handy commands

##### Running
```
docker compose up -d
```

##### Stopping
```
docker compose stop
```

##### Access to PHP container
```
docker compose exec app /bin/bash
```

## Running without Docker

In the repository you'll find a file called `.env.example`. Make a copy of this file called `.env`:

```
cp .env.example .env
```

This is the environment configuration. In this file you will establish your own database connection, e-mail credentials and whatnot. You will at least need to set the following options for your instance of the website to work:

* `APP_URL` is the URL (including https://, but without trailing slash) of your own website instance.
* `PRIMARY_DOMAIN` and `FALLBACK_COOKIE_DOMAIN` is only the [FQDN](https://en.wikipedia.org/wiki/Fully_qualified_domain_name) domain part of `APP_URL`.
* `DEBUG` should be set to `true` so you can see in detail what goes wrong if an error occurs.
* All the `DB_*` settings should be set to reflect your database set-up.
* `DEV_ALLOWED` is a comma separated list of IP addresses (IPv4 or IPv6) that may access your application. As long as `APP_ENV` is `local`, only whitelisted IPs are allowed to connect.
* `PERSONAL_PROTO_KEY` should be set to your personal Proto key, which can be found/generated on the bottom of your dashboard on the *live* Proto site.

You can skip all the other stuff (mailing API, Google API) until you need to work on the specific part of the website that uses them.

Now we can initialize the project.

```
chmod +x update.sh
composer install
npm install
npm run dev
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

Now you have set up your website correctly. The only thing that remains is pointing your web directory to the `public` directory of the website. This is where the front-facing controllers reside. The rest of the project is then shielded from public access. You could do this using symlinks. An example command on a webserver running DirectAdmin could look like this:
```
ln -s /home/user/domains/example.saproto.nl/saproto/public /home/user/domains/example.saproto.nl/public_html
```

That's it, everything should be up and running!