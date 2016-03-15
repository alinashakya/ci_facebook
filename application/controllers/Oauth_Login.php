<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Oauth_Login
 *
 * @author Alina Shakya <a.shakya@andmine.com>
 */
class Oauth_Login extends CI_Controller {

    public $user = "";

    public function __construct() {
        parent::__construct();
        // Load facebook library and pass associative array which contains appId and secret key
        $this->load->library('facebook', array('appId' => '1700284973592773', 'secret' => '2bfb05554e3eebee07b463248495ba48'));

        // Get user's login information
        $this->user = $this->facebook->getUser();
    }

    // Store user information and send to profile page
    public function index() {
        if ($this->user) {
            $data['user_profile'] = $this->facebook->api('/me/');

            // Get logout url of facebook
            $data['logout_url'] = $this->facebook->getLogoutUrl(array('next' => 'http://localhost/ci_fb/index.php/oauth_login/logout'));
            // Send data to profile page
            $this->load->view('profile', $data);
        } else {
            // Store users facebook login url
            $data['login_url'] = $this->facebook->getLoginUrl();
            $this->load->view('login', $data);
        }
    }

    // Logout from facebook
    public function logout() {
        // Destroy session
        session_destroy();

        $data['login_url'] = $this->facebook->getLoginUrl();
        $this->load->view('login', $data);
    }

}
