Pathfinder Character Manager
============================

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

    ./app/console doctrine:fixtures:load
    
Run
---

    ./app/console server:run 0.0.0.0:8000 --verbose