
# Check if second argument is provided
if [ $# -eq 0 ]; then
  echo "Please provide app path"
  exit 1
fi

# Check if third argument is provided
if [ $# -eq 1 ]; then
  echo "Please provide entityObject"
  exit 1
fi

currentFilePath=$(realpath $0)
currentFileDir=$(dirname $currentFilePath)
logFilePath="$currentFileDir/z-build.log"
touch $logFilePath


appPath=$1
entityObject=$2

echo -e "\n--------cd $appPath/api && php artisan make:entity --entity=$entityObject --------" >> $logFilePath 2>&1
cd $appPath/api && php artisan make:entity --entity="$entityObject" >> $logFilePath 2>&1
