#!/bin/bash

XSL="../src/Troulite/PathfinderBundle/Resources/data/dump-classpowers.xsl"

URL="http://paizo.com/pathfinderRPG/prd/classes/"
EXT=".html"
CLASS=("barbarian" "bard" "cleric" "druid" "fighter" "monk" "paladin" "ranger" "rogue" "sorcerer" "wizard")

for i in ${CLASS[@]}; do
    u="${URL}${i}${EXT}"
    name="${i}"

    lynx -source "${u}"                         | \
    tidy -n -q --show-warnings no -asxml -i     | \
    xsltproc "${XSL}" -                         | \
    sed 's/"/""/g'                              | \
    sed 's/|,|/";"/'                            | \
    sed 's/|/"/g'                               | \
    sed "s/^\"/\"$name\";\"/"                   | \
    cat > "${name}".csv
done
