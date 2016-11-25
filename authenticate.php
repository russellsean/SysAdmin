<!--  This code will execute when form method is set to POST  -->
<?php
if(isset($_POST['user']) && isset($_POST['pass'])) {
	$domain = "Lancastersd\\";
	$user = $_POST['user'];
	$pass = $_POST['pass'];

	$ldapconfig['host'] = 'webmail.lancastersd.k12.wi.us';
	$ldapconfig['port'] = 9000;
	$ldapconfig['basedn'] = 'dc=lancastersd,dc=k12,dc=wi,dc=us';

	$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

	$dn="ou=Tech Accounts,".$ldapconfig['basedn'];
	$bind=ldap_bind($ds, $domain.$user, $pass);
	$isITuser = ldap_search($bind,$dn,'(&(objectClass=User)(sAMAccountName=' . $user. '))');
	if ($isITuser) {
	    echo("Login correct");
	} else {
	    echo("Login incorrect");
	}
}
?>
