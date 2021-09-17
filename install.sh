#!/bin/bash
set -e

echo What is your theme name?
read APP_NAME
echo Your theme name is: $APP_NAME

#  String replace
grep -rli "_juststart" * | xargs -I@ sed -i "" "s/_juststart/$APP_NAME/g" @

#  Remove composer
if [[ -f composer.json ]] && [[ -f composer.lock ]]
then
    rm composer.lock
    rm composer.json
fi

#  Remove composer vedor
rmdir vendor

if [[ -f install.sh ]]
then
    rm install.sh
fi

#  Change translate
cd languages/
mv _jdlang.pot $APP_NAME.pot

echo Your theme was install
