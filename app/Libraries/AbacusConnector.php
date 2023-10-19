<?php
namespace App\Libraries;

class AbacusConnector {

    private string $token;

    private $apiPath = '/api/entity/v1/mandants/';

    public function __construct()
    {
        $this->auth();

    }

    private function auth(){

        $postData = [
            'client_id='. service('settings')->get('Abacus.clientId'),
            'client_secret='. service('settings')->get('Abacus.clientSecret'),
            'grant_type=' . 'client_credentials'
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, service('settings')->get('Abacus.url') .'/oauth/oauth2/v1/token');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'
        ));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, implode('&', $postData));
        $output = json_decode(curl_exec($curl));

        curl_close($curl);

        $this->token = $output->access_token;
    }

    public function requestGet($path, $param = false){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, service('settings')->get('Abacus.url') . $this->apiPath . service('settings')->get('Abacus.mandant') . '/' . sprintf("%s?%s", $path, http_build_query($param)));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->token
        ));
        $output = json_decode(curl_exec($curl));

        die(print_r($output));
        curl_close($curl);
    }
}