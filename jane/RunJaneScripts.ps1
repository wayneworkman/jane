#This file should be stored locally on the server that will execute the import scripts,
#and scheduled to run however often is needed. 
#Paths and filenames need adjusted apropriately.
#
#Redirecting the output to a log file is optional but can help with diagnosing issues.

#Log location:
$log = "z:\Jane.log"

#File 1 location:
$file1 = "Z:\Created-" + $(Get-Date -Format yyyy-MM-dd) + "---abc.ps1"

#File 2 location:
$file2 = "Z:\Created-" + $(Get-Date -Format yyyy-MM-dd) + "---def.ps1"

#Check if file exists. If so, run it and redirect output to log, then delete file and file.signed
$currentFile = $file1
$FileExists = Test-Path $currentFile
If ($FileExists -eq $True) {
    powershell.exe -executionpolicy bypass -windowstyle hidden -noninteractive -nologo -file $currentFile 2>&1 | Out-File $log -Append
    Remove-Item $currentFile
    $currentFile = $currentFile + ".signed"
    $FileExists = Test-Path $currentFile
    If ($FileExists -eq $True) {
        Remove-Item $currentFile
    }
}



$currentFile = $file2
$FileExists = Test-Path $currentFile
If ($FileExists -eq $True) {
    powershell.exe -executionpolicy bypass -windowstyle hidden -noninteractive -nologo -file $currentFile 2>&1 | Out-File $log -Append
    Remove-Item $currentFile
    $currentFile = $currentFile + ".signed"
    $FileExists = Test-Path $currentFile
    If ($FileExists -eq $True) {
        Remove-Item $currentFile
    }
}



