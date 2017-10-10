# S.A. Proto 2.0

## Prerequisites

This README is taylored to install on a Debian system. You may need to change commands to match your operating system.

Before following the intallation instructions, you need to have a working installation of `php`, `git`, `npm`, `composer`. Depending on your operating system and plans for your development environment, you also need to set-up a web-server and database server.

## Installation instructions

Installing the website on your own server should be quite simple. First you'll have to clone the repository somewhere in the vicinity of your public web folder using git:

```
git clone git@github.com:saproto/saproto.git
```

In the repository you'll find a file called `.env.example`. Make a copy of this file called `.env`:

```
cp .env.example .env
```

This is the environment configuration. In this file you will establish your own database connection, e-mail credentials and whatnot. You will at least need a database configured for the website to work. You can skip all the other stuff (mailing API, Google API) since only a few specific services use them.

Now we need to initialize the project:

```
chmod +x update.sh
composer install
npm install
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

The database seeder copies some non-sensitive data from the live website (*be sure to add your personal key to your `.env` file, you can find your personal key on your dashboard at the bottom*), add your user account and display the randomly generated password in the console and finally adds more dummy users, orders and the likes. If you need more dummy data, feel free to improve the database seeder.

Now you have set-up your website correctly. The only thing that remains is pointing your web directory to the `public` directory of the website. This is where the front-facing controllers reside. The rest of the project is then shielded from public access. You could do this using symlinks. An example command on a webserver running DirectAdmin could like like this:

```
ln -s /home/user/domains/example.saproto.nl/saproto/public /home/user/domains/example.saproto.nl/public_html
```

That's it, everything should be up and running!
