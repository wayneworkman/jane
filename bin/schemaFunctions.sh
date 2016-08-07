schema3() {

    local options="-sN"
    if [[ $mysqlHost != "" ]]; then
        local options="$options -h$mysqlHost"
    fi
    if [[ $mysqlUser != "" ]]; then
        local options="$options -u$mysqlUser"
    fi
    if [[ $mysqlpass != "" ]]; then
        local options="$options -p$mysqlPass"
    fi
    local options="$options -D jane -e"

    local step1="ALTER TABLE usernameTracking ADD userGroup VARCHAR(255);"
    local step2="UPDATE globalSettings SET settingValue = '4' WHERE settingKey = 'schemaVersion'"

    dots "Going from DB Schema 3 to 4"

    mysql $options "$step1" > /dev/null 2>&1
    if [[ "$?" -ne 0 ]]; then
        echo "Failed"
        echo "   Failure attempting:"
        echo "   $step1"
        echo
        exit
    fi

    mysql $options "$step2" > /dev/null 2>&1
    if [[ "$?" -ne 0 ]]; then
        echo "Failed"
        echo "   Failure attempting:"
        echo "   $step2"
        echo
        exit
    fi

    echo "Done"

}

schema2() {
    local options="-sN"
    if [[ $mysqlHost != "" ]]; then
        local options="$options -h$mysqlHost"
    fi
    if [[ $mysqlUser != "" ]]; then
        local options="$options -u$mysqlUser"
    fi
    if [[ $mysqlpass != "" ]]; then
        local options="$options -p$mysqlPass"
    fi
    local options="$options -D jane -e"

    local step1="ALTER TABLE usernameTracking ADD UNIQUE (trackingImportedID)"
    local step2="ALTER TABLE usernameTracking ADD UNIQUE (trackingUserName)"
    local step3="UPDATE globalSettings SET settingValue = '3' WHERE settingKey = 'schemaVersion'"

    dots "Going from DB Schema 2 to 3"

    mysql $options "$step1" > /dev/null 2>&1
    if [[ "$?" -ne 0 ]]; then
        echo "Failed"
        echo "   Failure attempting:"
        echo "   $step1"
        echo
        exit
    fi

    mysql $options "$step2" > /dev/null 2>&1
    if [[ "$?" -ne 0 ]]; then
        echo "Failed"
        echo "   Failure attempting:"
        echo "   $step2"
        echo
        exit
    fi

    mysql $options "$step3" > /dev/null 2>&1
    if [[ "$?" -ne 0 ]]; then
        echo "Failed"
        echo "   Failure attempting:"
        echo "   $step3"
        echo
        exit
    fi
    echo "Done"
}


schema1() {
    local options="-sN"
    if [[ $mysqlHost != "" ]]; then
        local options="$options -h$mysqlHost"
    fi
    if [[ $mysqlUser != "" ]]; then
        local options="$options -u$mysqlUser"
    fi
    if [[ $mysqlpass != "" ]]; then
        local options="$options -p$mysqlPass"
    fi
    local options="$options -D jane -e"



    local step1="CREATE TABLE usernameTracking(trackingID int NOT NULL AUTO_INCREMENT,trackingImportedID VARCHAR(255),trackingUserName VARCHAR(255),trackingIsAbnormal VARCHAR(1),PRIMARY KEY (trackingID))"
    local step2="GRANT ALL ON jane.usernameTracking TO 'janeWeb'@'localhost'"
    local step3="GRANT ALL ON jane.usernameTracking TO 'janeSystem'@'localhost'"
    local step4="UPDATE globalSettings SET settingValue = '2' WHERE settingKey = 'schemaVersion'"

    dots "Going from DB Schema 1 to 2"

    mysql $options "$step1" > /dev/null 2>&1
    if [[ "$?" -ne 0 ]]; then
        echo "Failed"
        echo "   Failure attempting:"
        echo "   $step1"
        echo
        exit
    fi
    
    mysql $options "$step2" > /dev/null 2>&1
    if [[ "$?" -ne 0 ]]; then
        echo "Failed"
        echo "   Failure attempting:"
        echo "   $step2"
        echo
        exit
    fi

    mysql $options "$step3" > /dev/null 2>&1
    if [[ "$?" -ne 0 ]]; then
        echo "Failed"
        echo "   Failure attempting:"
        echo "   $step3"
        echo
        exit
    fi

    mysql $options "$step4" > /dev/null 2>&1
    if [[ "$?" -ne 0 ]]; then
        echo "Failed"
        echo "   Failure attempting:"
        echo "   $step4"
        echo
        exit
    fi

    echo "Done"
}


