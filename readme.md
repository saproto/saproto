# S.A. Proto 2.0

Fancy readme.md will follow soon.


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

Now we need to initialize the program. This is done using our own update utility:

```
chmod +x update.sh
./update.sh
```

This update utility will initialize the website for you. It can also be used to update to a newer version of our code.

If you are developing for the site, but are not a part of the Have You Tried Turning It Off And On Again committee, you'll need to create your own copy of `update.sh` to use. In this copy, change this line:

```
php artisan app:migrate --no-confirmation
```

to look like this:

```
# php artisan app:migrate --no-confirmation
```

This is because this piece of code migrates data from the old site to you're installation. But since this includes a lot of personal data of members it is not availble to those outside the committee.

Now you have set-up your website correctly. The only thing that remains is pointing your web directory to the `public` directory of the website. This is where the front-facing controllers reside. The rest of the project is then shielded from public access. You could do this using symlinks. An example command on a webserver running DirectAdmin could like like this:

```
ln -s /home/user/domains/example.saproto.nl/saproto/public /home/user/domains/example.saproto.nl/public_html
```

If you wish to edit the stylesheet as well, you'll need to use Gulp for that. Gulp compiles our SASS files and publishes them to the public directory for you. You can install all needed components using `npm`:

```
npm install
```

Then you only need to start Gulp by running the following once:

```
gulp
```

That's it, everything should be up and running!
