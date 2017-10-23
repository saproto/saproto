<?php

namespace Proto\CustomClasses;

use League\OAuth1\Client\Credentials\TokenCredentials;

class FlickrOauthClient extends \League\OAuth1\Client\Server\Server
{

    const API_URL = "https://api.flickr.com/services/";

    /**
     * Get the URL for retrieving temporary credentials.
     *
     * @return string
     */
    public function urlTemporaryCredentials()
    {
        return self::API_URL . 'oauth/request_token';
    }

    /**
     * Get the URL for redirecting the resource owner to authorize the client.
     *
     * @return string
     */
    public function urlAuthorization()
    {
        return self::API_URL . 'oauth/authorize';
    }

    /**
     * Get the URL retrieving token credentials.
     *
     * @return string
     */
    public function urlTokenCredentials()
    {
        return self::API_URL . 'oauth/access_token';
    }

    /**
     * Get the URL for retrieving user details.
     *
     * @return string
     */
    public function urlUserDetails()
    {
        return self::API_URL . "rest";
    }

    /**
     * We don't use these....
     */
    public function userDetails($data, TokenCredentials $tokenCredentials)
    {
        return null;
    }

    public function userUid($data, TokenCredentials $tokenCredentials)
    {
        return null;
    }

    public function userEmail($data, TokenCredentials $tokenCredentials)
    {
        return null;
    }

    public function userScreenName($data, TokenCredentials $tokenCredentials)
    {
        return null;
    }

}