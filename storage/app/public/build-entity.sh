
# Get first argument as entity name

if [ $# -eq 0 ]

then

echo "Please provide entity name"

exit 1

fi

# create variable with name

name=$1


nameLower=${name,,}

nameLowerPlural=${nameLower}s

# Current absolute path
currentPath=$(pwd)

# Si la libreria no esta instalada en el proyecto, se debe correr el siguiente comando
# mklink /D "./node_modules/entities-builder" "C:\Users\josea\AppData\Roaming\npm\node_modules\entities-builder

# Copy schemas/$name.json and copy into ../app/src/app/entities-schemas/$name.json
rm ../app/src/app/entities-schemas/$nameLower.json
cp ./schemas/$nameLower.json ../app/src/app/entities-schemas/$nameLower.json
cd ../app && ng g entities-builder:entity-crud --name $name

# Search and go to the folder where entity was created
found_folder=$(find . -type d -name "$nameLowerPlural" | head -1)
cd "$found_folder"

sh ./$name.sh
# delete the .sh file
rm ./$name.sh
# Go back to base folder

cd "$currentPath"



# Copy schemas/$name.json and copy into ../api/storage/app/public/entities-schemas/$name.json

rm ../api/storage/app/public/entities-schemas/$nameLower.json
cp ./schemas/$nameLower.json ../api/storage/app/public/entities-schemas/$nameLower.json
cd ../api && php artisan make:entity $name $label


