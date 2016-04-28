<?php

$ldaphost = 'ldap.corp.redhat.com';
$ldapport = 636;

$ds = ldap_connect($ldaphost, $ldapport)
or die("Could not connect to $ldaphost");
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
//ldap_set_option($ds, LDAP_OPT_DEBUG_LEVEL, 7);
if ($ds) 
{
    $username = "uid=pcarey,ou=users,dc=redhat,dc=com";
    $upasswd = 'device$defy4Fury';

    $ldapbind = ldap_bind($ds, $username, $upasswd);


    if ($ldapbind) 
        {print "Congratulations! $username is authenticated.";}
    else 
        {print "Access Denied!";}


}
?>
