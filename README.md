Pathfinder Character Manager
============================

Pathfinder Character Manager is a Web application aimed at helping Pathfinder RPG players to manage
their characters and interactions between them by automatically applying bonuses and maluses to their character sheet.

Some of the features include:
 * Creation of new player characters
 * Character leveling
 * Character equipment
 * Party logbook
 * Automatic management of bonuses
 * Casting spells or powers on other characters (effects are reflected on them)
 * Dungeon master view to monitor players' health
 * Counters to track spell or power durations

Requirements
------------

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

 
Unordered TODO List
-------------------

  * Add Scrolls and potions
  * Tie counters to specific spells or powers to remove their effects when the counter reaches its limit
  * Allow dungeon master to add effects to characters
  * Add planner to help users setup a meeting place and date for next games
  * Add missing classes
  * Filter spells/feats/... by rulebooks and only allow some of them in the configuration of a party
  * Characters should not be able to pick feats with prerequisities if they don't meet these requirements 
