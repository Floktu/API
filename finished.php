<?php

// Create OAuth2Client object
require_once('./OAuth2Client/OAuth2Exception.php');
require_once('./OAuth2Client/OAuth2Client.php');
require_once('./OAuth2Client/FL_OAuth2Client.php');
$client = new FL_OAuth2Client();

// This example uses the session to store the authcode and token, but in production you could store to your database
session_start();

if (isset($_REQUEST['code']))
{
	// Store the authcode
	$_SESSION['code'] = $_REQUEST['code'];
	
	// Exchange authcode for access token
	$client->setVariable('code', $_SESSION['code']);
	$oauthSession = $client->getSession();
	
	if (isset($oauthSession['access_token']))
	{
		// Store the access token
		$_SESSION['access_token'] = $oauthSession['access_token'];
	}
}

// Render the page
include('./includes/htmltop.php');
if (isset($_SESSION['access_token']))
{
?>

	<h2>Connected</h2>
	<p>
		You are now connected to your Floktu account.
		<br/><a href="./events.php">View Events</a>
	</p>

<?php
}
else
{
?>
	
	<h2>Not Connected</h2>
	<p>
		Could not connect to your Floktu account.
		<br/><a href="./">Try Again</a>
	</p>
	
<?php
}

include('./includes/htmlbottom.php');
?>