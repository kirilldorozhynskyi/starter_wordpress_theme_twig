#!/bin/bash
set -e

echo What name your theme?
read APP_NAME
echo Your theme name is: $APP_NAME

echo What path your theme?
read APP_PATH
echo Your theme path is: $APP_PATH
cp -r `dirname "$0"`/juststart  $APP_PATH
cd $APP_PATH


mv juststart $APP_NAME
cd $APP_PATH/$APP_NAME
grep -rli "_juststart" * | xargs -I@ sed -i "" "s/_juststart/$APP_NAME/g" @
echo Your theme was install
