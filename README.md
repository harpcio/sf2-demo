Symfony2 Demo with DoctrineMigrations, KnpMenu, FOSUserBundle
=======================

INSTALL:

1) run "git clone https://github.com/harpcio/sf2-demo.git"

2) run "composer install"

3) run "php app/console doctrine:migrations:migrate"

4) run "php app/console fos:user:create" and create "admin"

5) run "php app/console fos:user:promote" and add to "admin" role "ROLE_ADMIN"

6) run "php app/console assets:install"

Nice fun!
