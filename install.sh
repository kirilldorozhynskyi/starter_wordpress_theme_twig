#!/bin/bash
set -e

echo What is your theme name?
read APP_NAME
echo Your theme name is: $APP_NAME

grep -rli "_juststart" * | xargs -I@ sed -i "" "s/_juststart/$APP_NAME/g" @
echo Your theme was install
