Ngày 2

![image](https://github.com/Training-Exercises-Dtsmart/1_daominhhung/assets/100175597/9fbefc6e-ff65-46b3-a574-f47a9d55df8c)


Ngày 09/09/2024
Refactor in modules (Product, User)
![image](https://github.com/Training-Exercises-Dtsmart/1_daominhhung/assets/100175597/a994ccbb-5e67-480e-9631-e662baf3cc46)

Ngày 10/07.2024: Kết quả bài test
Employee

Register 
![image](https://github.com/Training-Exercises-Dtsmart/1_daominhhung/assets/100175597/a46205be-0fb2-48d0-a29f-203791c1365b)
Login 
![image](https://github.com/Training-Exercises-Dtsmart/1_daominhhung/assets/100175597/0c811beb-be96-45e2-8ac2-2203f8ca426f)

Request 

View request from Staff:
![image](https://github.com/Training-Exercises-Dtsmart/1_daominhhung/assets/100175597/d38d0cf7-e504-420e-b067-7a3223e0aaf7)
View request from Hr:
![image](https://github.com/Training-Exercises-Dtsmart/1_daominhhung/assets/100175597/eea6322e-557a-49b8-bbaf-cfa9837ede48)

Create Request 
![image](https://github.com/Training-Exercises-Dtsmart/1_daominhhung/assets/100175597/4af5f535-5677-4d9d-a25b-2a8aa4cb9df2)
Update Request 
fromm Staff 
![image](https://github.com/Training-Exercises-Dtsmart/1_daominhhung/assets/100175597/16f8db79-58e5-41f1-aef1-112d41f95535)
from HR
![image](https://github.com/Training-Exercises-Dtsmart/1_daominhhung/assets/100175597/147d8955-cdb6-46a0-9d8a-b1452b2f3f0a)


Ngày  11/07/2024
SendMail and config.php
![image](https://github.com/Training-Exercises-Dtsmart/1_daominhhung/assets/100175597/2a19d612-48ab-45b2-8306-42ceb65f88dc)
![image](https://github.com/Training-Exercises-Dtsmart/1_daominhhung/assets/100175597/7ec608a5-8f5a-4c2f-ac77-ca9e1368b492)

Queue SendMail 
![image](https://github.com/Training-Exercises-Dtsmart/1_daominhhung/assets/100175597/557ba055-b715-4822-8d60-ade2ff8f13f9)
![image](https://github.com/Training-Exercises-Dtsmart/1_daominhhung/assets/100175597/99861418-8ef2-4d97-bf9a-577425f4b896)

Result 
![image](https://github.com/Training-Exercises-Dtsmart/1_daominhhung/assets/100175597/e859052a-efbb-410f-a304-81b00bdd7096)


RBAC date: 12/07/2024
RBAC for Product: create , delete , update by admin 
![image](https://github.com/user-attachments/assets/11a65ab9-8ee8-47f6-9af3-37d75a99331c)

Result 
Update by author 
![image](https://github.com/user-attachments/assets/d58002d5-5291-4e8d-9c85-b917c1dc0113)
Update by admin 
![image](https://github.com/user-attachments/assets/6f55aac5-2b41-4e16-8571-766bf4eee10f)

Upload File 
![image](https://github.com/user-attachments/assets/3dd7b91f-1d8d-47b2-a555-65d932f746cf)
![image](https://github.com/user-attachments/assets/dc79bfe9-d570-4565-a529-43265e8241c6)

<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
    <br>
</p>

Yii 2 Basic Project Template is a skeleton [Yii 2](https://www.yiiframework.com/) application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![build](https://github.com/yiisoft/yii2-app-basic/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-basic/actions?query=workflow%3Abuild)

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.4.


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](https://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](https://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

~~~
composer create-project --prefer-dist yiisoft/yii2-app-basic basic
~~~

Now you should be able to access the application through the following URL, assuming `basic` is the directory
directly under the Web root.

~~~
http://localhost/basic/web/
~~~

### Install from an Archive File

Extract the archive file downloaded from [yiiframework.com](https://www.yiiframework.com/download/) to
a directory named `basic` that is directly under the Web root.

Set cookie validation key in `config/web.php` file to some random secret string:

```php
'request' => [
    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
    'cookieValidationKey' => '<secret random string goes here>',
],
```

You can then access the application through the following URL:

~~~
http://localhost/basic/web/
~~~


### Install with Docker

Update your vendor packages

    docker-compose run --rm php composer update --prefer-dist
    
Run the installation triggers (creating cookie validation code)

    docker-compose run --rm php composer install    
    
Start the container

    docker-compose up -d
    
You can then access the application through the following URL:

    http://127.0.0.1:8000

**NOTES:** 
- Minimum required Docker engine version `17.04` for development (see [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `.docker-composer` for composer caches


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.
- Refer to the README in the `tests` directory for information specific to basic application tests.


TESTING
-------

Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework](https://codeception.com/).
By default, there are 3 test suites:

- `unit`
- `functional`
- `acceptance`

Tests can be executed by running

```
vendor/bin/codecept run
```

The command above will execute unit and functional tests. Unit tests are testing the system components, while functional
tests are for testing user interaction. Acceptance tests are disabled by default as they require additional setup since
they perform testing in real browser. 


### Running  acceptance tests

To execute acceptance tests do the following:  

1. Rename `tests/acceptance.suite.yml.example` to `tests/acceptance.suite.yml` to enable suite configuration

2. Replace `codeception/base` package in `composer.json` with `codeception/codeception` to install full-featured
   version of Codeception

3. Update dependencies with Composer 

    ```
    composer update  
    ```

4. Download [Selenium Server](https://www.seleniumhq.org/download/) and launch it:

    ```
    java -jar ~/selenium-server-standalone-x.xx.x.jar
    ```

    In case of using Selenium Server 3.0 with Firefox browser since v48 or Google Chrome since v53 you must download [GeckoDriver](https://github.com/mozilla/geckodriver/releases) or [ChromeDriver](https://sites.google.com/a/chromium.org/chromedriver/downloads) and launch Selenium with it:

    ```
    # for Firefox
    java -jar -Dwebdriver.gecko.driver=~/geckodriver ~/selenium-server-standalone-3.xx.x.jar
    
    # for Google Chrome
    java -jar -Dwebdriver.chrome.driver=~/chromedriver ~/selenium-server-standalone-3.xx.x.jar
    ``` 
    
    As an alternative way you can use already configured Docker container with older versions of Selenium and Firefox:
    
    ```
    docker run --net=host selenium/standalone-firefox:2.53.0
    ```

5. (Optional) Create `yii2basic_test` database and update it by applying migrations if you have them.

   ```
   tests/bin/yii migrate
   ```

   The database configuration can be found at `config/test_db.php`.


6. Start web server:

    ```
    tests/bin/yii serve
    ```

7. Now you can run all available tests

   ```
   # run all available tests
   vendor/bin/codecept run

   # run acceptance tests
   vendor/bin/codecept run acceptance

   # run only unit and functional tests
   vendor/bin/codecept run unit,functional
   ```

### Code coverage support

By default, code coverage is disabled in `codeception.yml` configuration file, you should uncomment needed rows to be able
to collect code coverage. You can run your tests and collect coverage with the following command:

```
#collect coverage for all tests
vendor/bin/codecept run --coverage --coverage-html --coverage-xml

#collect coverage only for unit tests
vendor/bin/codecept run unit --coverage --coverage-html --coverage-xml

#collect coverage for unit and functional tests
vendor/bin/codecept run functional,unit --coverage --coverage-html --coverage-xml
```

You can see code coverage output under the `tests/_output` directory.
