<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Google extends BaseConfig
{    /**
     * Google OAuth Client ID
     */
    public string $clientId;

    /**
     * Google OAuth Client Secret
     */
    public string $clientSecret;

    /**
     * Google OAuth Redirect URI
     */
    public string $redirectUri;

    /**
     * Google OAuth Scopes
     */
    public array $scopes = [];

    /**
     * Google OAuth Authorization URL
     */
    public string $authUrl;

    /**
     * Google OAuth Token URL
     */
    public string $tokenUrl;

    /**
     * Google User Info URL
     */
    public string $userInfoUrl;



                        public function __construct()
                        {
                            parent::__construct();

                            // Load values from environment
                            $this->clientId     = getenv('GOOGLE_CLIENT_ID');
                            $this->clientSecret = getenv('GOOGLE_CLIENT_SECRET');
                            $this->redirectUri  = getenv('GOOGLE_REDIRECT_URI');

                            // You can hardcode the URLs if they never change
                            $this->authUrl      = 'https://accounts.google.com/o/oauth2/auth';
                            $this->tokenUrl     = 'https://oauth2.googleapis.com/token';
                            $this->userInfoUrl  = 'https://www.googleapis.com/oauth2/v2/userinfo';

                            // Define default scopes
                            $this->scopes = [
                                'email',
                                'profile',
                            ];
                        }

}
