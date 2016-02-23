#!/bin/bash

INPUT=/root/testdata.csv
OLDIFS=$IFS
IFS=,
[ ! -f $INPUT ] && { echo "$INPUT file not found"; exit 99; }
while read Category StudentID StudentFirstName StudentMiddleName StudentLastName BIRTHDATE SchoolName
do

                echo "-------------------------------------------------"
                echo "Category : $Category"
                echo "StudentID : $StudentID"
                echo "StudentFirstName : $StudentFirstName"
                echo "StudentMiddleName : $StudentMiddleName"
                echo "StudentLastName : $StudentLastName"
                echo "BIRTHDATE : $BIRTHDATE"
                echo "SchoolName : $SchoolName"
                echo "Username : ${StudentFirstName:0:1}${StudentMiddleName:0:1}${StudentLastName:0:1}${StudentID:5:4}" | tr '[:upper:]' '[:lower:]'
                echo "Password : ${BIRTHDATE///}"
                echo "Fullname : ${StudentFirstName} ${StudentMiddleName} ${StudentLastName}"

done < $INPUT
IFS=$OLDIFS


