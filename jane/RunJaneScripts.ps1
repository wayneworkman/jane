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

#Check if file1 exists. If so, run it and redirect output to log, then delete file1 and file1.signed
$FileExists = Test-Path $file1
If ($FileExists -eq $True) {
    powershell.exe -executionpolicy bypass -windowstyle hidden -noninteractive -nologo -file $file1 2>&1 | Out-File $log -Append
    Remove-Item $file1
    $file1 = $file1 + ".signed"
    $FileExists = Test-Path $file1
    If ($FileExists -eq $True) {
        Remove-Item $file1
    }
}

#Check if file2 exists. If so, run it and redirect output to log, then delete file2 and file2.signed
$FileExists = Test-Path $file2
If ($FileExists -eq $True) {
    powershell.exe -executionpolicy bypass -windowstyle hidden -noninteractive -nologo -file $file2 2>&1 | Out-File $log -Append
    Remove-Item $file2
    $file2 = $file2 + ".signed"
    $FileExists = Test-Path $file2
    If ($FileExists -eq $True) {
        Remove-Item $file2
    }
}
