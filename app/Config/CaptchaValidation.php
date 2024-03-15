<?php 
namespace Config;

class CaptchaValidation{

     public function verifycaptcha(string $str, ?string &$error = null): bool
     {

        $turnstile_secret     = service('settings')->get('Site.cfSecretKey');
        $turnstile_response   = $str;
        $url                  = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
        $post_fields          = "secret=$turnstile_secret&response=$turnstile_response";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        $return = curl_exec($ch);
        curl_close($ch);

        $response_data = json_decode($return);
        if ($response_data->success != 1) {
            return false;
        }

        return true;
     }

}