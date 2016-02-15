#Get present working directory.
currentDir="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

#Source the functions script.
. "$currentDir/functions.sh"

readJaneSettings

importFromCSV




