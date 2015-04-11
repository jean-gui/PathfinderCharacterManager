Pathfinder Character Manager
============================

Requirements:
 * [PHP][1] with an appropriate database mod (mod_sqlite, mod_mysql, ...)
 * [Composer][2]
 * [Less][3]
 * For production, a Web server able to run PHP scripts 

Install
-------

    git clone https://github.com/jean-gui/PathfinderCharacterManager.git
    cd PathfinderCharacterManager
    composer install
    ./app/console --env=prod assets:install --symlink
    ./app/console --env=prod assetic:dump
    ./app/console --env=prod doctrine:schema:create

Load initial data
-----------------

    ./app/console doctrine:fixtures:load --fixtures src/Troulite/PathfinderBundle/DataFixtures/ORM/Base

Or if you want to additionally load test users/characters/groups/parties:
    ./app/console doctrine:fixtures:load
    
Run
---

### Development

    ./app/console server:run 0.0.0.0:8000 --verbose

Or to test the production environment:

    ./app/console --env=prod server:run 0.0.0.0:8000 --verbose
    
### Production

For production, it is recommended to use a Web server such as Apache or Nginx.
See [Symfony doc][4] to setup such a server
    
[1]: http://www.php.net/
[2]: https://getcomposer.org/
[3]: http://lesscss.org/
[4]: http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html