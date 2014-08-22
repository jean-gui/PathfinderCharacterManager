#!/bin/sh

URL="http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG."
EXT=".ashx"
CLASS=("Barbare" "Barde" "Druide" "Ensorceleur" "Guerrier" "Magicien" "Moine" "Paladin" "Pr%C3%AAtre" "R%C3%B4deur" "Roublard")


for i in ${CLASS[@]}; do
    u="${URL}${i}${EXT}"
    lynx.exe -dump -width 20000 "${u}"                                               | \
        # remove ref to links
        sed 's/\[[^]]*\]//g'                                                         | \

        # remove anything except block between these markers
        sed '/Descriptif de la classe/,/Le contenu officiel de/!d'                   | \

        # remove first lines (first marker)
        sed '1,4d'                                                                   | \

        # remove last line (last marker)
        sed '$d'                                                                     | \

        # remove empty lines
        sed '/^[ ]*$/d'                                                              | \

        # add marker before power title
        sed 's/^[^ ]/@&/'                                                            | \

        # remove indentation
        sed 's/^[ ]*//'                                                              | \

        # protect "
        sed 's/"/""/g' > "${i}".csv
        
        # here we need vim because it provides a better sed
        # - we replace all \n by markers to keep only one line
        # - we use the title's marker to create CSV fields
        # - we clean the last eol marker of the file
        # - we use eol marker + title marker to separate lines in CSV
        # - we replace eol markers by \n to get back \n in CSV text fields
        # - we clean the first title's marker of the file
        vim -c '%s/\n/€/g | %s/\(@[^¶]*\)¶€[ ]*\([^@]*\)/"\1";"\2"/g | %s/€"\%$/"/ | %s/€""@/""/g | %s/€//g | %s/"@/"/ | wq!' "${i}".csv
        
done
