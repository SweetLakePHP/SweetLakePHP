[![SensioLabsInsight](https://insight.sensiolabs.com/projects/6e9c7314-18a3-409f-a88c-6c73a4f75f3d/big.png)](https://insight.sensiolabs.com/projects/6e9c7314-18a3-409f-a88c-6c73a4f75f3d)

SweetLakePHP
============

Our website at [sweetlakephp.nl](http://sweetlakephp.nl/)!

Want to get involved with this project? See our [issues (bug/feature) page](https://github.com/verschoof/SweetLakePHP/issues?state=open).


# Getting started

## Requirements

* A Meetup account (you'll need an API key)
* If you don't use Vagrant, you'll need A local running webserver. Projects that include a local webserver are for example WAMP or XAMPP.
* If you do use Vagrant, you'll also need Ansible (minimal version 1.5)


## Installation

### Step 1: Fork the project

Go to our [Github repository](https://github.com/verschoof/SweetLakePHP) and click "Fork".


### Step 2: Get the files from GIT

In a terminal, go to the folder you want to create the project in, and clone your fork:

    git clone git@github.com:<username>/SweetLakePHP.git sweetlakephp

Or if your prefer HTTPS in stead of SSH:

    git clone https://github.com/<username>/SweetLakePHP.git sweetlakephp

Replace `<username>` with your Github username.


### Step 3: Get your API key from Meetup

* Get your [Meetup API key](http://www.meetup.com/meetup_api/key/) (you'll need an account).


### Step 4: Create your config file

In the project 'app' folders you find a folder named 'config'. We must add a file called:

* `parameters_dev.yml`

Simply copy the file `parameters.yml.dist` to `parameters_dev.yml`.
Edit the file and make and following changes:

* Line 5-8: db_credentials, enter the database credentials for your local db server.
* Line 20: meetup_api_key, replace 'key' with your API key.
* Line 14: uncomment `#mailer_delivery_address`, and add your e-mail address.

If you use Vagrant, the database credentials are:

    database_socket:   /var/run/mysqld/mysqld.sock
    database_name:     sweetlakephp
    database_user:     sweetlakephp
    database_password: secret

### Step 5: Install dependencies with composer

    php composer.phar install

Be patient, this process takes some time, if you dont see any errors, then composer ran successfully.


### Step 6: Make `app/cache` and `app/logs` writable for the webserver

Please read section _Setting up Permissions_ under [Configuration and Setup](http://symfony.com/doc/current/book/installation.html#configuration-and-setup) in [The Book](http://symfony.com/doc/current/book/index.html).


### Step 7A (Vagrant users only): Vagrant up

This repository contains a Vagrantfile. This means that is uses [Vagrant](http://www.vagrantup.com) to automatically create a virtual machine on your system.
_Unfortunately, Ansible does not work that well with Vagrant on Windows, so don't even try unless you know what you're doing. Installing a local webserver is a lot less painful_

**Ansible Galaxy:**
In the root of the project, enter the command:
   
    ansible-galaxy install -r ansible/ansible-galaxy.txt -p ansible --force

**Vagrant:**
In the root of the project, enter the command:

    vagrant up

After the machine is created, [Ansible](http://docs.ansible.com) is used to "provision" it. That just means all the necessary software is installed. It also takes care of the proper config files for the webserver.

The webserver is configured to listen to the hostname *sweetlakephp.loc*, so the url should be [http://sweetlakephp.loc](http://sweetlakephp.loc).
You will need to add this line in your local hosts file (/etc/hosts on Linux and OS X, %SystemRoot%\system32\drivers\etc\hosts on Windows).

    192.168.30.48  sweetlakephp.loc

### Step 7B (local webserver only): Configure your webserver

How the webserver should be configured depends on which webserver you use.

Basic examples for Apache2 and Nginx can be found in Symfony 2's cookbook: [Configuring a web server](http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html).


### Step 8: Almost done (last step)

At this time you should be able to browse to your locally running project (`http://localhost/` or whatever you configured in step 7).

The loading will take some time, but if you will see a very basic page (without styles) that means composer could not run the last steps.

We have to add the assets to the web folder. That is done with one command.

    php app/console assets:install web --symlink
    php app/console assetic:dump

Revisit your browser and see if the website is fully loaded.

Congratulations!

Go ahead and make some changes!
