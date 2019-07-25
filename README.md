<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Translations</h1>
    <br>
</p>

The test application for emulation process of the postponed money transfers.

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      database_backups/   dump database file
      mail/               contains view files for e-mails
      migration/          contains migration files
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      web/                contains the entry script and Web resources
      views/themes/public contains view files for the Web application      
      test_task.pdf       the description of a test task on which the project is created



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.1.0.


INSTALLATION
------------

### Install via Composer and git

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

~~~
git clone https://github.com/xenoidon/translations.git
~~~

~~~
composer update
~~~

Now you should be able to access the application through the following URL, assuming `basic` is the directory
directly under the Web root.

~~~
http://localhost/
~~~


CONFIGURATION
-------------

### Database
In the database it is necessary to create base with utf8_general_ci encoding.

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=test',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

Team of migration from the console we create tables

```
php yii migrate
```

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.
- Refer to the README in the `tests` directory for information specific to basic application tests.

OPERATION
-------------

### Start of process of the translations

It is made by start from console team 
```
php yii translation
```
Start with a key of true hides a conclusion of text data to the screen. 
He can be used for start of process of the scheduler of tasks (for example cron)
```
php yii translation true
```