# Sequence project

**Sequence project** is a web and console application to Calculation of the maximum value in a sequence powered by Symfony. The project is a recruitment task for the position of PHP Developer.

Installation
------------

[Install Composer](https://getcomposer.org/download/), which is used to install PHP packages.

```
git clone https://github.com/bluegreen/sequence.git project_name
cd project_name
composer install
``` 

Configuring a Web Server
------------
Configure virtual host so that document root directs to your project directory. This directory is /var/www/project/public/.
For more information, please visit the [Configuring a Web Server](https://symfony.com/doc/4.4/setup/web_server_configuration.html) page.

User interface
------------
User interface is using [Bootstrap 4.4.1](https://getbootstrap.com/)
To run the application, go to the application's home page in your browser.

Command Line Interface
------------
To run the application in the console, start the terminal and run the following command:
```
cd project_name
php bin/console app:calculate-sequence
``` 