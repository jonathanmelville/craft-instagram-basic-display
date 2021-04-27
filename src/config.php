<?php
/**
 * Instagram Basic Display plugin for Craft CMS 3.x
 *
 * Provides endpoints and helper console commands that make it easier to work with the Instagram Basic Display API.
 *
 * @link      https://codemdd.io
 * @copyright Copyright (c) 2021 Jonathan Melville
 */

/**
 * Instagram Basic Display config.php
 *
 * This file exists only as a template for the Instagram Basic Display settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'instagram-basic-display.php'
 * and make your changes there to override default settings.
 *
 */

return [
    // The Basic Display API .
    'api' => 'https://graph.instagram.com/',

    // The oembed API.
    'oembed_api' => 'https://graph.facebook.com/v8.0/',

    // The endpoint for refreshing an access token.
    'refresh_endpoint' => 'refresh_access_token',

    // The endpoint for getting a user's feed.
    'media_endpoint' => 'me/media',

    // The endpoint for oembed.
    'oembed_endpoint' => 'instagram_oembed',

    // Which fields do we want to pull from the media endpoint.
    'fields' => 'media_type,media_url,permalink,thumbnail_url',

    // Whether or not to omit the embed script with oembed responses.
    'omit_script' => 1,

    // How long to cache API responses.
    'cache_duration' => 1800
];