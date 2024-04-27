<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once APPPATH . 'vendor/autoload.php';

use Google\Client as Google_Client;
use Google\Service\Oauth2;
class Google_api {

    public $client;

    public function __construct() {
        $this->client = new Google_Client();
        // Your Google API credentials and settings
        $this->client->setClientId('CNF_LOGINGG_ID');
        $this->client->setClientSecret('CNF_LOGINGG_SECRET');
        $this->client->setRedirectUri('YOUR_REDIRECT_URI');
        $this->client->setScopes(['email', 'profile']);
    }

    public function getClient() {
        return $this->client;
    }

    public function getOauth2Service() {
        return $this->oauth2;
    }

}
