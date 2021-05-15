<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    /*
     * ---------------------------------------------------------------
     * Base Url
     * ---------------------------------------------------------------
     *
     * The ClubKonnect base url upon which others is based, if not set it's going to use the sandbox version
     */
    'base_url' => env('CLUBKONNECT_BASE_URL', 'https://www.nellobytesystems.com/'),


    /*
     * ---------------------------------------------------------------
     * UserID
     * ---------------------------------------------------------------
     *
     * Your ClubKonnect UserID
     */
    'user_id' => env('CLUBKONNECT_USER_ID'),


    /*
     * ---------------------------------------------------------------
     * APIKey
     * ---------------------------------------------------------------
     *
         * Your ClubKonnect APIKey
     */
    'api_key' => env('CLUBKONNECT_API_KEY'),

    /*
     * ---------------------------------------------------------------
     * APIKey
     * ---------------------------------------------------------------
     *
         * Your ClubKonnect APIKey
     */
    'default_redirect_url' => env('CLUBKONNECT_DEFAULT_REDIRECT_URL'),

];
