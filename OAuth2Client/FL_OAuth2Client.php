<?php

class FL_OAuth2Client extends OAuth2Client 
{

	public $access_token = null;
	public $refresh_token = null;
	public $instance_url = null;

	public function __construct() 
	{
		// START - CLIENT SETS THESE VARIABLES
		$host = 'http://localhost/oauth2client/'; // Your redirect host
		$client_id = '';   // Your client id
		$client_secret = ''; // Your client secret
		// END - CLIENT SETS THESE VARIABLES
		
		if (!$client_id || !$client_secret)
		{
			die('Error: You must enter a client id and client secret in FL_Oauth2Client.php');
		}
		
		$config = array('client_id' => $client_id, 'client_secret' => $client_secret,
						'authorize_uri' => 'https://floktu.com/api/v1/authorize',
						'access_token_uri' => 'https://floktu.com/api/v1/token',
						'redirect_uri' => $host . 'finished.php',
						'cookie_support' => false,
						'file_upload' => false,
						'token_as_header' => false,
						'base_uri' => 'https://floktu.com/api/v1/'
						);
		
		parent::__construct($config);
	}
	
	// Get a Login URL for use with redirects. A full page redirect is currently
	public function getLoginUri($params = array()) {
		$def_params = array(
						'response_type' => 'code',
						'client_id' => $this->getVariable('client_id'),
						'redirect_uri' => $this->getVariable('redirect_uri'),
					);
		$params = array_merge($params, $def_params);
		return $this->getUri( $this->getVariable('authorize_uri'), $params);
	}
}
