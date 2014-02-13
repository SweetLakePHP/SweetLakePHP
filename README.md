[![SensioLabsInsight](https://insight.sensiolabs.com/projects/6e9c7314-18a3-409f-a88c-6c73a4f75f3d/big.png)](https://insight.sensiolabs.com/projects/6e9c7314-18a3-409f-a88c-6c73a4f75f3d)

SweetLakePHP
============

Our website at sweetlakephp.nl


Want to get involved with this project? See our [issues (bug/feature) page](https://github.com/verschoof/SweetLakePHP/issues?state=open).



# Getting started

## Requirements

* A local running webserver like WAMP, XAMPP
* A virtual host
* You must have Meetup account (API key)


## Installation

### Step 1: Get the files from GIT

Go to your project folder and type:

    git clone https://github.com/verschoof/SweetLakePHP.git sweetlakephp


### Step 2: Get your API key from Meetup

* Go to url [Meetup api key](http://www.meetup.com/meetup_api/key/)

Copy your API key



### Step 3: Create your config files

In the project 'app' folders you find a folder named 'config'. We must add there two files
* parameters_dev.yml
* parameters_prod.yml

 Simply copy the file 'parameters.yml.dist' to parameters_dev.yml and parameters_prod.yml.
 Edit both files and make the following change:
* Line 20: meetup_api_key, replace 'key' with your API key

Extra change for file parameters_dev.yml:
* Line 27: uncomment #delivery_address, and add there an e-mailaddress 

The file parameters_prod.yml is only required if you use app.php ( We encourage developers to use only app_dev.php.).

### Step 4: Run composer

    php composer.phar install

Be patient, this process takes some time, if you dont see any errors, then composer ran succesfully.

### Step 5: Almost done (last step)

At this time you can browse to your vhost (http://yourhostname)

The loading will take some time, but if you will see a very basic page that mean composer could not run the last steps.

We have to add the assets to the web folder. That is done with one command.

    php app/console assets:install web -symlink
    php app/console assetic:dump

Revisit your browser and see if the website is fully loaded.

Congratulations!

Go ahead and make some changes!
