<?php

namespace Proto\Http\Middleware;

use Closure;
use Auth;

class UtwenteAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $username = $request->input('email');
        $password = $request->input('password');

        $regex = '/^[smx]\d\d\d\d\d\d\d$/';

        if(preg_match($regex, $username)) {

            // Do weird escape character stuff, because DotEnv doesn't support newlines :(
            $publicKey = str_replace('_!n_', "\n", env('UTWENTEAUTH_KEY'));

            $token = md5(rand()); // Generate random token

            // Store userdata in array to create JSON later on
            $userData = array(
                'user' => $username,
                'password' => $password,
                'token' => $token
            );

            // Encrypt userData in JSON with public key
            openssl_public_encrypt(json_encode($userData), $userDataEncrypted, $publicKey);

            // Start CURL to secureAuth on WESP
            $url = env('UTWENTEAUTH_SRV');
            $ch = curl_init($url);

            // Tell CURL to post encrypted userData in base64
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "challenge=".urlencode(base64_encode($userDataEncrypted)));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute CURL, store response
            $response = curl_exec($ch);
            curl_close($ch);

            // If response matches token, user is verified.
            if($response == $token) {
                // Login as Jonathan Juursema when password and username are verified on RADIUS.
                // TODO: use members table to login as proper user.
                Auth::loginUsingId(1);
                return redirect('/');
            }else{
                return $next($request);
            }

        }else {
            return $next($request);
        }
    }
}

?>