
# Get first argument as entity name

# Get first argument as entity name
if [ $# -eq 0 ]; then
  echo "Please provide entity Id"
  exit 1
fi

# Check if second argument is provided
if [ $# -eq 1 ]; then
  echo "Please provide api url"
  exit 1
fi

# Check if second argument is provided
if [ $# -eq 1 ]; then
  echo "Please provide app path"
  exit 1
fi

entityId=$1
apiUrl=$2
appPath=$3


currentFilePath=$(realpath $0)
currentFileDir=$(dirname $currentFilePath)
logFilePath="$currentFileDir/z-build.log"
touch $logFilePath

# Si la libreria no esta instalada en el proyecto, se debe correr el siguiente comando
# mklink /D "./node_modules/entities-builder" "C:\Users\josea\AppData\Roaming\npm\node_modules\entities-builder


echo -e "\n--------cd $appPath/app && ng g entities-builder:entity-crud --entity $entityId --api $apiUrl --------" >> $logFilePath 2>&1
cd $appPath/app && ng g entities-builder:entity-crud --entity $entityId --api $apiUrl --delete >> $logFilePath 2>&1
