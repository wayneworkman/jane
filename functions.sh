#!/bin/bash

importFromCSV() {
INPUT=/root/AddsDrops.csv
OLDIFS=$IFS
sql=""
IFS=,
[ ! -f $INPUT ] && { echo "$INPUT file not found"; exit 99; }
while read Category StudentID StudentFirstName StudentMiddleName StudentLastName BIRTHDATE SchoolName
do

if [[ $Category != "Category" ]]; then

	sql=$sql"INSERT INTO Users (Category,StudentID,StudentFirstName,StudentMiddleName,StudentLastName,BIRTHDATE,SchoolName) VALUES ('$Category', '$StudentID', '$StudentFirstName', '$StudentMiddleName', '$StudentLastName', '$BIRTHDATE', '$SchoolName');"

fi

done < $INPUT
IFS=$OLDIFS


echo $sql | mysql -h$servername -u$username -p$password $database;

}
readJaneSettings() {
janeSettings=$currentDir/.janesettings
servername="$(grep 'servername=' $janeSettings | cut -d \' -f2 )"
username="$(grep 'username=' $janeSettings | cut -d \' -f2 )"
password="$(grep 'password=' $janeSettings | cut -d \' -f2 )"
database="$(grep 'database=' $janeSettings | cut -d \' -f2 )"
}


