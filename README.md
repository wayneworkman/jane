# Jane

Jane is a LAMP plus Samba based and open source account provisioning solution designed to use personell information from one or many sources to create & maintain accounts for those personnel automatically.

Jane is designed with scale and flexibility in mind. It is well-suited for small or large school districts, universities, and companies. Jane is designed to work along-side an established SIS (student information system) or EIS (employee information system).

  - Simple web-based interface
  - Provisions & maintains personnel/student/staff Active Directory accounts
  - Granular user controls for higher & lower tier support staff for managing Jane
  - Supports an unlimited number of Active Directory domains
  - Supports an unlimited number of setting-sets per domain
  - Ensures unique usernames for all users even across seperate domains
  - Granular settings for each domain or user-type.
  - Innovative SQL-based selection for personell sorting
  - Intense security concepts
  - After setup, is completely automated.
 
### Requirements

 - Dedicated server (recommended to use a virtual machine)
 - CentOS 7 installation media (minimim will work but won't have a GUI after setup)
 - 2 CPU cores
 - 512MB RAM (1GB recommended)
 - 15GB disk (20GB recommended)
 - Internet connection **during installation** required
 
### Installation

 - Install CentOS 7
 - During installation, **Do not** create an account called `jane`
 - Recommended during installation to create a `/jane` partition of at least 5GB
 - After OS installation completes, install git: `yum install git -y`
 - Clone the Jane repository: `git clone https://github.com/wayneworkman/jane.git /root/jane`
 - Install Jane: `cd /root/jane/bin;./setup.sh`

### Configuration

 - Visit the web interface via a web browser using the server IP address
 - Default credentials are `administrator` and `changeme`
 - Create a settings-set, configure it as desired
 - Configure your data source to place a CSV onto the Jane server
 - Configure the powershell template for the settings-set you made
 - Place the prepared script on the desired domain controller
 - Configure the script to run as often as you need via Task Scheduler on Windows Server
 - Enjoy Jane, the open, free, and automated account provisioning solution.
 
### Feature Requests, Improvements, Bugs, and other things

 - Please create issues on Github for bug reports, provide as much detail as possible without compromising your own security.
 - For feature requests or other things, please email wayne.workman2012@gmail.com

### Help Wanted

- Need OSX test environment to develop for Apple Open Directory account provisioning
- Need GAFE or Google Enterprise domain to develop account provisioning on those platforms
- Need sponsors for web hosting; for forums and wiki.
