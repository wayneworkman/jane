#This file should be stored locally on the server that will execute the import scripts,
#and scheduled to run however often is needed. 
#Paths and filenames need adjusted apropriately for your setup.
#Adjust the below variables as needed, don't bother below the line unless you have strong scripting knowedge.

#Drive letter for mapped drive to use, J for Jane, but you may use whatever letter available.
$driveLetter="J"

#Your Jane username:
$janeUsername="wayne"

#Your Jane SMB password:
$janeSMBPassword="MyAwesomePassword"

#Jane settings group name. 
#This is the group name that the settings sets belong to, and that you belong to.
#Groups are managed in the web interface. You must be a member of the setting's group
#in order to access it's scripts.
$janeGroupName="testGroup"

#Jane server hostname or IP address:
$janeHostname="10.0.0.12"

#Jane settings Nicknames. This is a list of all NickNames for Jane Settings-sets you want
#to run using this particular script, on this particular server.
#Entries are double-quoted, and comma seperated as shown below in the sample. 
#The below uses Jane Setting nick names abc and def.
#These nicnames are defined within the web interface, and are case sensitive.
#This list can be as long as it needs to be.
$nickNames= @("abc","def")

#Log location, this is where you want the log to be, and what it should be named.

#Storing on the mapped drive:
#$log = $driveLetter + ":\Jane.log"
#Storing on the C:\ drive:
$log = "C:\Jane.log"


########################################################################################################
# Do not modify below here unless you know what you're doing - or aren't worried about breaking things.#
########################################################################################################

#Here, check if the drive letter is already in use. If so, delete it.
if (Get-PSDrive $driveLetter) {
    Get-PSDrive $driveLetter | Remove-PSDrive
}

#Map the Jane share using the defined settings above.
$pass=$janeSMBPassword|ConvertTo-SecureString -AsPlainText -Force
$Cred = New-Object System.Management.Automation.PsCredential("$janeUsername",$pass)
New-PSDrive -name $driveLetter -Root "\\$janeHostname\$janeGroupName" -Credential $cred -PSProvider filesystem

#Begin loop for jane settings nick names. This loops through each one.
for ($i=0; $i -lt $nickNames.length; $i++) {

    #Build the filename.
    $file = $driveLetter + ":\Created-" + $(Get-Date -Format yyyy-MM-dd) + "---" + $nickNames[$i] + ".ps1"

    #Check if file exists. If so, run it and redirect output to log, then delete file and file.signed
    $FileExists = Test-Path $file
    If ($FileExists -eq $True) {
        powershell.exe -executionpolicy bypass -windowstyle hidden -noninteractive -nologo -file $file 2>&1 | Out-File $log -Append
        Remove-Item $file
        $currentFile = $file + ".signed"
        $FileExists = Test-Path $file
        If ($FileExists -eq $True) {
            Remove-Item $file
        }
    }
#end loop
}

#Cleanup the share.
if (Get-PSDrive $driveLetter) {
    Get-PSDrive $driveLetter | Remove-PSDrive
}


