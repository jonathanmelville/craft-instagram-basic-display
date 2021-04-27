<?php

/**
 * Instagram Basic Display plugin for Craft CMS 3.x
 *
 * This plugin creates endpoints in your Craft install for you to consume the Instagram Basic Display API as well as the oEmbed API. It also provides some helper methods for dealing with your access token and getting refresh tokens.
 *
 * @link      https://codemdd.io
 * @copyright Copyright (c) 2021 Jonathan Melville
 */

namespace melvilleco\instagrambasicdisplay\variables;

use melvilleco\instagrambasicdisplay\InstagramBasicDisplay;

class InstagramVariable {
    public function getFeed() {
        return InstagramBasicDisplay::$plugin->instagramBasicDisplayService->getFeed();
    }
}
