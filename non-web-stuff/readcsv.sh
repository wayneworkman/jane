#!/bin/bash

#----- MySQL Credentials -----#
mysqluser="janeSystem"
mysqlpass="janesystempassword"
mysqlhost=""
mysqldatabase="jane" #Database name is required.




options="-sN"
if [[ $mysqlhost != "" ]]; then
	options="$options -h$mysqlhost"
fi
if [[ $mysqluser != "" ]]; then
        options="$options -u$mysqluser"
fi
if [[ $mysqlpass != "" ]]; then
        options="$options -p$mysqlpass"
fi
options="$options -D $mysqldatabase -e"






INPUT=/root/testdata.csv
OLDIFS=$IFS
IFS=,
[ ! -f $INPUT ] && { echo "$INPUT file not found"; exit 99; }
while read Category StudentID StudentFirstName StudentMiddleName StudentLastName BIRTHDATE SchoolName
do

                
		userAction=$Category
		userFirstName=$StudentFirstName
		userMiddleName=$StudentMiddleName
		userLastName=$StudentLastName
		userGroup=$SchoolName
		userPassword=${BIRTHDATE///}
		userUserName=$(echo "${StudentFirstName:0:1}${StudentMiddleName:0:1}${StudentLastName:0:1}${StudentID:5:4}" | tr '[:upper:]' '[:lower:]')
		userImportedID=$StudentID
		

		sql="INSERT INTO userDataToImport (userAction,userFirstName,userMiddleName,userLastName,userGroup,userUserName,userPassword,userImportedID) VALUES ('$userAction','$userFirstName','$userMiddleName','$userLastName','$userGroup','$userUserName','$userPassword','$userImportedID')"

		if [[ $userAction != "Category" ]]; then
			echo $options "$sql"	
			mysql $options "$sql"
			#mysql -u$mysqluser -p$mysqlpass -D $mysqldatabase -e "$sql"
		fi

done < $INPUT
IFS=$OLDIFS




#There needs to be one of these written for each settings type (for now).
sql="SELECT SettingsTypeID FROM janeSettingsTypes WHERE SettingsTypeName = 'Active Directory'"
SettingsTypeID=$(mysql $options "$sql")

sql="SELECT JaneSettingsID, JaneSettingsWHERE FROM janeSettings WHERE janeSettingsTypeID = '$SettingsTypeID'"
Settings=$(mysql $options "$sql")


previousIFS=$IFS
IFS=' '
for p in $SettingsTypeIDs; do





done
