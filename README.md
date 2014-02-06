SweetLakePHP
============

Our website at [sweetlakephp.nl](http://sweetlakephp.nl/)!

Want to get involved with this project? See our [issues (bug/feature) page](https://github.com/verschoof/SweetLakePHP/issues?state=open).


# Getting started

## Requirements

* A local running webserver like WAMP, XAMPP
* A Meetup account (you'll need an API key)


## Installation

### Step 1: Fork the project

Go to our [Github repository](https://github.com/verschoof/SweetLakePHP) and click "Fork".


### Step 2: Get the files from GIT

In a terminal, go to the folder you want to create the project in, and clone your fork:

    git clone <repo> sweetlakephp

You can find the `<repo>` at Github, which should look something like `git@github.com:<username>/SweetLakePHP.git` (SSH) or `https://github.com/<username>/SweetLakePHP.git` (HTTPS).


### Step 3: Get your API key from Meetup

* Get your [Meetup API key](http://www.meetup.com/meetup_api/key/) (you'll need an account).


### Step 4: Create your config files

In the project 'app' folders you find a folder named 'config'. We must add two files:

* `parameters_dev.yml`
* `parameters_prod.yml`

Simply copy the file `parameters.yml.dist` to `parameters_dev.yml` and `parameters_prod.yml`.
Edit both files and make and following changes:

* Line 20: meetup_api_key, replace 'key' with your API key.

Extra change for file parameters_dev.yml:

* Line 14: uncomment `#mailer_delivery_address`, and add your e-mail address.

The file `parameters_prod.yml` is only required if you use `app.php` (we encourage developers to use `app_dev.php` only).


### Step 5: Make `app/cache` and `app/logs` writable for the webserver

Please read section _Setting up Permissions_ under [Configuration and Setup](http://symfony.com/doc/current/book/installation.html#configuration-and-setup) in [The Book](http://symfony.com/doc/current/book/index.html).


### Step 6: Install dependencies with composer

    php composer.phar install

Be patient, this process takes some time, if you dont see any errors, then composer ran successfully.


### Step 7: Configure your webserver

How the webserver should be configured depends on which webserver you use.

Basic examples for Apache2 and Nginx can be found in Symfony 2's cookbook: [Configuring a web server](http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html).


### Step 8: Almost done (last step)

At this time you should be able to browse to your locally running project (`http://localhost/` or whatever you configured in step 6).

The loading will take some time, but if you will see a very basic page that mean composer could not run the last steps.

We have to add the assets to the web folder. That is done with one command.

    php app/console assets:install web --symlink
    php app/console assetic:dump

Revisit your browser and see if the website is fully loaded.

Congratulations!

Go ahead and make some changes!
