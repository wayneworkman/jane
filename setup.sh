# This is not a full blown installer yet, more of a guide at this point.
# The below instructions are good for CentOS 7 and Fedora 21+. Fedora 22 and up will give messages about yum being depcreciated but for now that's just fine.

#Right now, this is just a dumping ground for what is needed to make Jane work.



#Update server
yum update -y

#install packages

# FEDORA 23
dnf -y install mariadb mariadb-server php httpd php-mysqlnd php-gd php-mhash php-mcrypt samba samba-client



#CentOS 7

#  rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
#  rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
#  yum install -y libtool-ltdl-2.4.2-20.el7.x86_64.rpm php55w-gd-5.5.31-1.w7.x86_64.rpm php55w-cli-5.5.31-1.w7.x86_64.rpm php55w-common-5.5.31-1.w7.x86_64.rpm php55w-mcrypt-5.5.31-1.w7.x86_64.rpm php55w-mysqlnd-5.5.31-1.w7.x86_64.rpm php55w-pdo-5.5.31-1.w7.x86_64.rpm php55w-5.5.31-1.w7.x86_64.rpm mariadb mariadb-server samba samba-client


#apache setup.
systemctl start httpd
systemctl enable httpd

#Firewalld setup.
for service in http samba; do firewall-cmd --permanent --zone=public --add-service=$service; done
systemctl enable firewalld.service
systemctl restart firewalld.service

#create user Jane
useradd jane
local password=janepassword
echo -e "$password\n$password\n" | sudo passwd jane


mysql < dbcreatecode.sql


#Additionally, make sure the jane php files is put into /var/www/html/jane
#set permissions on that with:  

#   chown -R apache:apache /var/www/html/jane
#   chmod -R 555 /var/www/html/jane
