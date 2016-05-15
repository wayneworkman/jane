#This file should be stored locally on the server that will execute the import scripts,
#and scheduled to run however often is needed. 
#Paths and filenames need adjusted apropriately.
#
#Redirecting the output to a log file is optional but can help with diagnosing issues.
#Due to how Windows verifies the signature of powershell files, execution policy must be set to unrestricted.
#In case you need, this is the command:   Set-ExecutionPolicy unrestricted
#In order for this script to run, it must have a .ps1 extension.

powershell.exe -executionpolicy bypass -file Z:\abc.ps1 | Out-File z:\Jane.log -Append
powershell.exe -executionpolicy bypass -file Z:\def.ps1 | Out-File z:\Jane.log -Append
Remove-Item Z:\abc.ps1
Remove-Item Z:\def.ps1
