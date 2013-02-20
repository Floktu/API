<?php

class FL_OAuth2Client extends OAuth2Client 
{

    public $access_token = null;
    public $refresh_token = null;
    public $instance_url = null;

    public function __construct() 
    {
        $base =  'localhost';
        $path = '/oauth2client/finished.php';
        
        $client_id = '2112';   //enter your client id
        $client_secret = '4531595effd076ec94fcf0ea913c07b5'; //enter your client secret
        
        $config = array('client_id'=>$client_id, 'client_secret'=>$client_secret,
                        'authorize_uri'=>'https://floktu.com/api/v1/authorize',
                        'access_token_uri'=>'https://floktu.com/api/v1/token',
                        'redirect_uri'=>'http://'.$base.$path,
                        'cookie_support'=>false, 'file_upload'=>false,
                        'token_as_header'=>false,
                        'base_uri'=>'https://floktu.com/api/oauth2/'
                        );
   
        parent::__construct($config);
    }
    
    /**
    * Get a Login URL for use with redirects. A full page redirect is currently
    * required.
    *
    * @param $params
    *   Provide custom parameters.
    *
    * @return
    *   The URL for the login flow.
    */
    public function getLoginUri($params = array()) {
        $def_params = array(
                        'response_type' => 'code',
                        'client_id' => $this->getVariable('client_id'),
                        'redirect_uri' => $this->getVariable('redirect_uri'),
                    );
        $params = array_merge($params, $def_params);
        return $this->getUri( $this->getVariable('authorize_uri'), $params);
    }

    public function api($path, $method = 'GET', $params = array()) {
        try {
            return parent::api($path, $method, $params);
        } catch (OAuth2Exception $e){
            //once and only once, try to get use the refresh token to get a fresh token
            if ($e->getMessage()=='INVALID_SESSION_ID'){
                $this->refreshToken();
                return parent::api($path, $method, $params);
            } else {
                throw $e;
            }
        }

    }
}
