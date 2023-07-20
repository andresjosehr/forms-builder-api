#!/bin/bash

# Dasherize app name. Expample: 
#   "My App" => "my-app"
appName=$1

logFilePath="C:/laragon/www/apps-management/app/src/assets/log"

# Create log file
touch $logFilePath

# Erease content of log file

echo -e "\n-------- gh repo create $appName-api --private --------" >> $logFilePath 2>&1
gh repo create $appName-api --private

# Create new folder at C:\laragon\www\{appName}
echo -e "\n--------mkdir C:/laragon/www/$appName --------" >> $logFilePath 2>&1
mkdir C:/laragon/www/$appName

echo -e "\n--------cd C:/laragon/www/$appName --------" >> $logFilePath 2>&1
cd C:/laragon/www/$appName

echo -e "\n-------- git clone https://github.com/andresjosehr/laravel-starter.git api --------" >> $logFilePath 2>&1
git clone https://andresjosehr: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@github.com/andresjosehr/laravel-starter.git api >> $logFilePath 2>&1

echo -e "\n--------cd api --------" >> $logFilePath 2>&1
cd api

echo -e "\n--------composer install --------" >> $logFilePath 2>&1
composer install >> $logFilePath 2>&1

echo -e "\n--------cp .env.example .env --------" >> $logFilePath 2>&1
cp .env.example .env

Replace "DB_DATABASE=laravel" by "DB_DATABASE={appName}"

echo -e "\n--------sed -i 's/DB_DATABASE=laravel/DB_DATABASE=$appName/g' .env --------" >> $logFilePath 2>&1
sed -i 's/DB_DATABASE=laravel/DB_DATABASE=$appName/g' .env >> $logFilePath 2>&1

echo -e "\n--------php artisan key:generate --------" >> $logFilePath 2>&1
php artisan key:generate >> $logFilePath 2>&1

echo -e "\n-------php artisan jwt:secret --------" >> $logFilePath 2>&1
php artisan jwt:secret >> $logFilePath 2>&1


echo -e "\n--------gh repo create $appName-api --private --------" >> $logFilePath 2>&1
gh repo create $appName-api --private >> $logFilePath 2>&1

echo -e "\n--------rm -rf .git --------" >> $logFilePath 2>&1
rm -rf .git >> $logFilePath 2>&1

echo -e "\n--------git init --------" >> $logFilePath 2>&1
git init >> $logFilePath 2>&1

echo -e "\n--------git add . --------" >> $logFilePath 2>&1
git add . >> $logFilePath 2>&1

echo -e "\n--------git commit -m 'Initial commit' --------" >> $logFilePath 2>&1
git commit -m "Initial commit" >> $logFilePath 2>&1

echo -e "\n--------git remote add origin https://github.com/andresjosehr/$appName-api.git --------" >> $logFilePath 2>&1
git remote add origin https://github.com/andresjosehr/$appName-api.git >> $logFilePath 2>&1

echo -e "\n--------git push -u origin master --------" >> $logFilePath 2>&1
git push -u origin master >> $logFilePath 2>&1

echo -e "\n--------cd .. --------" >> $logFilePath 2>&1
mysql --user=root -e "CREATE DATABASE $appName"

echo -e "\n--------cd .. --------" >> $logFilePath 2>&1
cd ..

echo -e "\n--------git clone -b andresjosehr-starter --------" >> $logFilePath 2>&1
git clone -b andresjosehr-starter https://andresjosehr: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@github.com/andresjosehr/fuse-angular.git app >> $logFilePath 2>&1

echo -e "\n--------cd app --------" >> $logFilePath 2>&1
cd app

echo -e "\n--------npm install --------" >> $logFilePath 2>&1
npm install >> $logFilePath 2>&1

echo -e "\n--------npm run build --------" >> $logFilePath 2>&1
gh repo create $appName-app --private >> $logFilePath 2>&1

echo -e "\n--------rm -rf .git --------" >> $logFilePath 2>&1
rm -rf .git >> $logFilePath 2>&1

echo -e "\n--------git init --------" >> $logFilePath 2>&1
git init >> $logFilePath 2>&1


echo -e "\n--------git add . --------" >> $logFilePath 2>&1
git add . >> $logFilePath 2>&1

echo -e "\n--------git commit -m 'Initial commit' --------" >> $logFilePath 2>&1
git commit -m "Initial commit" >> $logFilePath 2>&1

echo -e "\n--------git remote add origin mklink /D "./node_modules/entities-builder" "C:\Users\josea\AppData\Roaming\npm\node_modules\entities-builder" --------" >> $logFilePath 2>&1

echo -e "\n--------git remote add origin --------" >> $logFilePath 2>&1
git remote add origin https://github.com/andresjosehr/$appName-app.git >> $logFilePath 2>&1

echo -e "\n--------git push -u origin master --------" >> $logFilePath 2>&1
git push -u origin master >> $logFilePath 2>&1

echo -e "\n--------App successfully created! --------" >> $logFilePath 2>&1

# Sleet 5 seconds
sleep 5

# delete log file
rm $logFilePath
