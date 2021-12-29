LARADULES
=======
A simple library to split your codes into modules. Make your codes become flexible, easy to maintenance and coding faster.

Installation
------------

Use composer to manage your dependencies and install with command:

```bash
composer require omaicode/laradules
```
Commands
-------

To create a module, enter command:

```bash
php artisan laradules:create:module {MODULE NAME}
```

This command will create your module inside folder {PROJECT}/modules. Example:

- app
    - Http
    - Models
    - Providers
    - ...
- modules
    - ModuleA
    - ModuleB

To show module list, enter command:

```bash
php artisan laradules:list:module
```
LICENSE
-------

MIT

CREDIT
------

This is my first public library for Laravel, if it have any bugs just create your issue. I'll update as soon as possible!
Thanks you for use my libraby.