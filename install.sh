#!/bin/bash
set -e

echo What is your theme name?
read APP_NAME
echo Your theme name is: $APP_NAME

echo What is your WordPress theme path? exemple user/wordpress/wp-content/theme
read APP_PATH
echo Your theme path is: $APP_PATH
cp -r `dirname "$0"`/juststart  $APP_PATH
cd $APP_PATH

mv juststart $APP_NAME
cd $APP_PATH/$APP_NAME
grep -rli "_juststart" * | xargs -I@ sed -i "" "s/_juststart/$APP_NAME/g" @
echo Your theme was install
