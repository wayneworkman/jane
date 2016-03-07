#!/bin/bash

#----- MySQL Credentials -----#
snmysqluser="janeSystem"
snmysqlpass="janesystempassword"
snmysqlhost=""
snmysqldatabase="jane" #Database name is required.


options=""
if [[ $snmysqlhost != "" ]]; then
	options="$options-h$snmysqlhost "
fi
if [[ $snmysqluser != "" ]]; then
        options="$options-u$snmysqluser "
fi
if [[ $snmysqlpass != "" ]]; then
        options="$options-p$snmysqlpass "
fi
options="$options-D $snmysqldatabase -e"





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
		

		sql="INSERT INTO userDataToImport (userAction,userFirstName,userMiddleName,userLastName,userGroup,userUserName,userPassword) VALUES ('$userAction','$userFirstName','$userMiddleName','$userLastName','$userGroup','$userUserName','$userPassword')"

		if [[ $userAction != "Category" ]]; then
			mysql -ujane -pjanepassword -D jane -e "$sql"
		fi

done < $INPUT
IFS=$OLDIFS


