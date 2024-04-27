<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Google\Client ;
use Google\Service\Oauth2 ;

class Google_api_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->library('google_api','googleClient');
        $this->googleClient = new Google_Client();
        // Your Google API credentials and settings
        $this->googleClient->setClientId(CNF_LOGINGG_ID);
        $this->googleClient->setClientSecret(CNF_LOGINGG_SECRET);
        $this->googleClient->setRedirectUri(base_url().'auth/google/callback');
       // $this->googleClient->addScope("email");
       $this->googleClient->setScopes(['email', 'profile']);
       $this->googleClient->setPrompt('select_account');
        //$this->googleClient->setScopes(['email', 'profile']);
    }

    // In your controller method
   /* public function index() {
        // Get the OAuth2 service from the Google_api library
        $oauth2Service = $this->google_api->getOauth2Service();
        
        // Example: Retrieve user info
        $userInfo = $oauth2Service->userinfo->get();
        // Do something with $userInfo
    }*/

    public function login_with_google()
    {
        $login_url = $this->googleClient->createAuthUrl();
        redirect($login_url);
        
    }
    
    public function google_callback()
    {
        //echo json_encode($_GET['code']);exit();
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->input->get('code'));
        if (!isset($token['error'])) {
            $this->googleClient->setAccessToken($token['access_token']);

            // Get profile info from Google
            $google_oauth = new Google_Service_Oauth2($this->googleClient);
            $google_account_info = $google_oauth->userinfo->get();
            $email = $google_account_info->email;
            $name = $google_account_info->name;
           // $session = session();
            echo json_encode( $google_account_info);
            // Set session data
            /*$session = session();

            $userData = [
                'isLoggedIn' => true,
                'userName' => $name, // Google name
                'userEmail' => $email, // Google email
            ];
            
            $session->set($userData);

            return redirect()->route('dashboard');*/
            // Handle user login or registration here
            // Your logic for handling login or registration
        } else {
            // Handle error case
            //return redirect()->route('login')->with('error', 'Failed to login with Google');
            redirect("error");
        }
    }
    public function logout() {
        $this->session->unset_userdata('google_access_token');
        // Redirect to the login page or any other appropriate page
        redirect('login');
    }

    public function login()
    {
        echo "done";
    }
}
