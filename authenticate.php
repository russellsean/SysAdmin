<!--  This code will execute when form method is set to POST  -->
<?php
if(isset($_POST['user']) && isset($_POST['pass'])) {
	// $domain = "Lancastersd\\";
	$user = $_POST['user'];
	$pass = $_POST['pass'];

	$ldapconfig['host'] = 'webmail.lancastersd.k12.wi.us';
	$ldapconfig['port'] = 9000;
	$ldapconfig['basedn'] = 'dc=lancastersd,dc=k12,dc=wi,dc=us';

	$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
	// ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
	// ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
	echo "connect result is " . $ds . "<br />";
	if ($ds) { 
	    echo "Binding ..."; 
	    $r=ldap_bind($ds, $user, $pass);     // this is an "anonymous" bind, typically
	                           // read-only access
	    echo "Bind result is " . $r . "<br />";

	    echo "Searching for (sn=S*) ...";
	    // Search surname entry
	    $sr=ldap_search($ds, "o=My Company, c=US", "sn=S*");  
	    echo "Search result is " . $sr . "<br />";

	    echo "Number of entries returned is " . ldap_count_entries($ds, $sr) . "<br />";

	    echo "Getting entries ...<p>";
	    $info = ldap_get_entries($ds, $sr);
	    echo "Data for " . $info["count"] . " items returned:<p>";

	    for ($i=0; $i<$info["count"]; $i++) {
	        echo "dn is: " . $info[$i]["dn"] . "<br />";
	        echo "first cn entry is: " . $info[$i]["cn"][0] . "<br />";
	        echo "first email entry is: " . $info[$i]["mail"][0] . "<br /><hr />";
	    }

	    echo "Closing connection";
	    ldap_close($ds);

	} else {
	    echo "<h4>Unable to connect to LDAP server</h4>";
	}


	// $dn="ou=Tech Accounts,".$ldapconfig['basedn'] or die("Could not connect to LDAP server.");

	// $bind=ldap_bind($ds, 'Lancastersd\\'.$user, $pass);

	// $isITuser = ldap_search($bind,$dn,'(&(objectClass=User)(sAMAccountName=' . $user. '))');
	// if ($isITuser) {
	//     echo("Login correct");
	// } else {
	//     echo("Login incorrect");
	// }
}
?>
