## myfaq-php-isa
phpMyFAQ code goes here and maintained by the ISA team

## What to do to collaborate?

If you want to have a local copy running for testing purposes, please, use the following steps as a guideline:

* Install a server with RHEL7 (or other compatible LAMP server)
* Git clone the source to your DocumentRoot folder
* Create a copy of the phpMyFAQ database
* Configure the system with Red Hat specifics
* Make your changes, test them, send us your Pull request


## Install a server with RHEL7 (or other compatible LAMP server)

* Install a RHEL7 Server choosing the "Basic Web Server" environment
* Follow the instructions from the upstram project http://www.phpmyfaq.de/docs/2.8#2.1


## Git clone the source to your DocumentRoot folder

Note: Web Server specific configuration outside of the scope for this document.

```
cd $DOCUMENTROOT
git clone https://github.com/npatel2012/myfaq-php-isa.git myphpfaq.dev
```

Note: You can use other destination directory. Change it if needed.


## Create a copy of the phpMyFAQ database

Note: Use the provided sample available on $DOCUMENTROOT/myphpfaq/dbsample/faq.sql

### Prepare the server:
```
yum install mysql-server
service mysqld on
mysql_secure_installation
```

### Create the dev database:

```
mysql> CREATE DATABASE devfaqdb;
mysql> GRANT USAGE ON *.* TO 'devfaquser'@'localhost' IDENTIFIED BY 'change-this-dev-password';
mysql> GRANT ALL PRIVILEGES ON `devfaqdb`.* TO 'devfaquser'@'localhost';
mysql> FLUSH PRIVILEGES;
mysql> \q

(Optional) mysql devfaqdb < $DOCUMENTROOT/myphpfaq/dbsample/faq.sql
```

## Configure the system with Red Hat specifics

### Optional: 
Edit .htaccess and change:
RewriteBase /


### Database configuration: Edit config/database.php to set the DB access:

```
<?php
$DB['server'] = 'localhost';
$DB['user'] = 'devfaquser';
$DB['password'] = 'my-new-dev-password';
$DB['db'] = 'devfaqdb';
$DB['prefix'] = '';
$DB['type'] = 'mysqli';
?>
```

### LDAP config integration: Edit config/ldap.php to look like:

```
<?php
// Main LDAP server
$PMF_LDAP['ldap_server'] = 'ldaps://ldap.corp.redhat.com';
$PMF_LDAP['ldap_port'] = '636';
$PMF_LDAP['ldap_user'] = '';
$PMF_LDAP['ldap_password'] = '';
$PMF_LDAP['ldap_base'] = 'ou=users,dc=redhat,dc=com';
?>
```


### Edit config/constants_ldap.php and do the following changes:
```
// Datamapping - in this example for an ADS
$PMF_LDAP['ldap_mapping'] = array (
'name'     => 'cn',
'username' => 'uid',
'mail'     => 'mail'
);

// Option to use anonymous LDAP connection (without username and password)
// Default: false
$PMF_LDAP['ldap_use_anonymous_login'] = true;
```
