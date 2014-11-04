[![SensioLabsInsight](https://insight.sensiolabs.com/projects/6e9c7314-18a3-409f-a88c-6c73a4f75f3d/big.png)](https://insight.sensiolabs.com/projects/6e9c7314-18a3-409f-a88c-6c73a4f75f3d)

SweetLakePHP
============

Our website at [sweetlakephp.nl](http://sweetlakephp.nl/)!

Want to get involved with this project? See our [issues (bug/feature) page](https://github.com/verschoof/SweetLakePHP/issues?state=open).

# Getting started

## Requirements

* [Virtualbox](https://www.virtualbox.org/)
* [Vagrant](https://www.vagrantup.com/)
* [Ansible](http://docs.ansible.com/intro_installation.html) (minimal version 1.5)
* A [fork](https://help.github.com/articles/fork-a-repo) of our [Github repository](https://github.com/verschoof/SweetLakePHP)
* A [clone](http://stackoverflow.com/questions/1872113/how-do-i-clone-a-github-project-to-run-locally) of your repository on your local machine

## Also: gather the following information

* A Meetup API key (you'll need an account at [meetup.com])
* OPTIONAL: a Twitter API key (for loading some tweets in the footer)

## Installation

This is the Vagrant manual. We highly recommend using a virtual environment for development, but if you have a 
local webserver (or, you are subjected to cruel and unusual punishment and **have** to use Windows), you can find 
a more detailed description of the installation process:

[Local webserver setup method](docs/local-webserver-setup-method.md).

### Step 1: Create your config file

In the project 'app' folders you will find a folder named 'config'. You must add a file called:

* `parameters_dev.yml`

Simply copy the file `parameters.yml.dist` to `parameters_dev.yml`.
Edit the file and make and following changes:

* Line 14: uncomment `#mailer_delivery_address`, and replace 'YOUR_EMAIL_ADDRESS_HERE' with your e-mail address.
* Line 22: meetup_api_key, replace 'ADD_YOUR_MEETUP_API_KEY_HERE' with your API key.
* Line 24-27: _OPTIONAL_ add your twitter API key settings

### Step 2: Install dependencies with composer

    php composer.phar install

Be patient, this process takes some time, if you dont see any errors, then composer ran successfully.


### Step 3: Vagrant up

This repository contains a Vagrantfile. This means that is uses [Vagrant](http://www.vagrantup.com) to automatically create a virtual machine on your system.
_Unfortunately, Ansible does not work that well with Vagrant on Windows, so don't even try unless you know what you're doing. Installing a local webserver is a lot less painful_

**Ansible Galaxy:**
In the root of the project, enter the command:
   
    ansible-galaxy install -r ansible/ansible-galaxy.txt --force

**Vagrant:**
In the root of the project, enter the command:

    vagrant up

After the machine is created, [Ansible](http://docs.ansible.com) is used to "provision" it. That just means all the
necessary software is installed. It also takes care of the proper config files for the webserver.

The webserver is configured to listen to the hostname _sweetlakephp.loc_, so the url should be
[http://sweetlakephp.loc]. You will need to add this line in your local hosts file
(/etc/hosts on Linux and OS X, %SystemRoot%\system32\drivers\etc\hosts on Windows).

    192.168.30.48  sweetlakephp.loc

### Step 3: Vagrant up
Run doctrine migrations in the vagrantbox

    vagrant ssh
    cd /vagrant/
    app/console doctrine:migrations:migrate

### Go ahead and make some changes!
At this time you should be able to browse to [http://sweetlakephp.loc]. Congratulations!


### Troubleshooting

**Q: I see a very blank page with some content, but no styles.**

A: Something went wrong with the final steps of the `composer install` command.
We have to add the assets to the web folder. That can be done with the following commands:

    php app/console assets:install web --symlink
    php app/console assetic:dump

Revisit your browser and see if the website is fully loaded.

**Q: I get an error during the Vagrant up command, but the Vagrant is now running.**

A: You can try to run the provisioning part separately, with:

    vagrant provision

