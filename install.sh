#!/bin/bash
set -e

echo Your theme name is: ${PWD##*/}

#  String replace
grep -rli "_juststart" * | xargs -I@ sed -i "" "s/_juststart/${PWD##*/}/g" @

#  Remove composer
if [[ -f composer.json ]] && [[ -f composer.lock ]]
then
    rm composer.lock
    rm composer.json
fi

#  Remove composer vedor
rm -rf vendor/

if [[ -f install.sh ]]
then
    rm install.sh
fi

#  Change translate
cd languages/
mv _jdlang.pot ${PWD##*/}.pot

echo Your theme was install
