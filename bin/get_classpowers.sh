#!/bin/bash

usage() {
    echo "Usage: $0 [en|fr]"
    exit 1
}


if [ $# -ne 1 ]; then
    usage 
else
    if [ $1 != "fr" -a $1 != "en" ]; then
        usage
    else
        SRC="$1"
    fi
fi


if [ $SRC = "en" ]; then
    URL="http://www.d20pfsrd.com/classes/core-classes/"
    #CLASS=("barbarian" "bard" "druid" "sorcerer" "fighter" "wizard" "monk" "paladin" "cleric" "ranger" "rogue")
    CLASS=("druid")
else
    URL="http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG."
    EXT=".ashx"
    CLASS=("Barbare" "Barde" "Druide" "Ensorceleur" "Guerrier" "Magicien" "Moine" "Paladin" "Pr%C3%AAtre" "R%C3%B4deur" "Roublard")
fi

for i in ${CLASS[@]}; do
    if [ $SRC = "en" ]; then
        u="${URL}${i}"
        name="${i}"
    else
        u="${URL}${i}${EXT}"
        name=$(printf $(echo "${i}" | sed 's/%/\\x/g'))
    fi

    lynx -dump -width 20000 "${u}"                                  | \
        # remove ref to links
        sed 's/\[[^]]*\]//g'                                        | \

        # remove anything except block between these markers
        if [ $SRC = "en" ]; then
            sed '/^[ ]*Weapon and Armor Proficiency/,/Favored Class/!d'
        else
            sed '/^[ ]*Armes et armures/,/Le contenu officiel de/!d'
        fi                                                          | \

        # remove last line (last marker)
        sed '$d'                                                    | \

        # remove empty lines
        sed '/^[ ]*$/d'                                             | \

        if [ $SRC = "en" ]; then
            # add @ and ¶ markers around power title
            sed 's/^[^ ].*/@&¶/'
        else
            # add @ marker before power title
            sed 's/^[ ]*\([^ ].*¶\)/@\1/'
        fi                                                          | \

        # remove indentation
        #sed 's/^[ ]*//'                                             | \

        # protect "
        #sed 's/"/""/g'                                              | \

        # here we need vim because it provides a better sed
        # - we replace all \n by markers to keep only one line
        # - we use the title's marker to create CSV fields
        # - we clean the last eol marker of the file
        # - we use eol marker + title marker to separate lines in CSV
        # - we replace eol markers by \n to get back \n in CSV text fields
        # - we clean the first title's marker of the file
        #vim -es -c '%s/\n/€/g | %s/\(@[^¶]*\)¶€[ ]*\([^@]*\)/"\1";"\2"/g | %s/€"\%$/"/ | %s/€""@/""/g | %s/€//g | %s/"@/"/ | x! /dev/stdout' /dev/stdin | \

        ## add class as a prefix
        #sed "s/^\"/\"$name\";\"/"                                       | \

        # write file
        cat > "${name}".csv
done
