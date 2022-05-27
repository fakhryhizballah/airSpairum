<?php

namespace App\Controllers;

class Oauth extends BaseController
{
    public function __construct()
    {
    }
    public function index()
    {
        $clientID = '479807555120-3cp5jte7th6gnreujjbrrjmn8647rhls.apps.googleusercontent.com';
        $clientSecret = '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';
        // $redirectUri = 'http://localhost:8080/Oauth/redirect'; //Harus sama dengan yang kita daftarkan
        // $redirectUri = 'https://app.spairum.my.id/Oauth/redirect'; //Harus sama dengan yang kita daftarkan
        $redirectUri = 'https://air.spairum.my.id/Oauth/redirect'; //Harus sama dengan yang kita daftarkan

        // require_once APPPATH . '../vendor/autoload.php';
        $client = new \Google_Client();
        // $client = new Google\Client();

        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");
        echo '<a href="' . $client->createAuthUrl() . '">Login</a>';
    }
    public function redirect()
    {
        // dd($_GET["code"]);
        $clientID = '479807555120-3cp5jte7th6gnreujjbrrjmn8647rhls.apps.googleusercontent.com';
        $clientSecret = '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';
        $redirectUri = 'http://localhost:8080/Oauth/redirect'; //Harus sama dengan yang kita daftarkan
        // $redirectUri = 'https://app.spairum.my.id/Oauth/redirect'; //Harus sama dengan yang kita daftarkan
        // $redirectUri = 'https://air.spairum.my.id/Oauth/redirect'; //Harus sama dengan yang kita daftarkan

        // require_once APPPATH . '../vendor/autoload.php';
        $client = new \Google_Client();
        // $client = new Google\Client();

        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");
        $code = $this->request->getGet('code');
        $token = $client->fetchAccessTokenWithRefreshToken($code);
        dd($code);
        // $client = new \Google_Client();
        if (!isset($token["error"])) {
            $client->setAccessToken($token['access_token']);
            $this->session->set_userdata('access_token', $token['access_token']);
            $google_service = new \Google_Service_Oauth2($client);
            $data = $google_service->userinfo->get();
        }
    }
}
