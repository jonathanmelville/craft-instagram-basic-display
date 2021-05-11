<?php
/**
 * Instagram Basic Display plugin for Craft CMS 3.x
 *
 * This plugin creates endpoints in your Craft install for you to consume the Instagram Basic Display API as well as the oEmbed API. It also provides some helper methods for dealing with your access token and getting refresh tokens.
 *
 * @link      https://codemdd.io
 * @copyright Copyright (c) 2021 Jonathan Melville
 */

namespace melvilleco\instagrambasicdisplay\console\controllers;

use Exception;
use melvilleco\instagrambasicdisplay\InstagramBasicDisplay;
use Psr\Http\Message\StreamInterface;
use yii\console\Controller;

/**
 * Instagram Basic Display
 *
 * The first line of this class docblock is displayed as the description
 * of the Console Command in ./craft help
 *
 * Craft can be invoked via commandline console by using the `./craft` command
 * from the project root.
 *
 *
 * @author    Jonathan Melville
 * @package   InstagramBasicDisplay
 * @since     1.0.0
 */
class TokenController extends Controller
{
    // Public Methods
    // =========================================================================

    /**
     * Echo out the current access token.
     */
    public function actionGet()
    {
        InstagramBasicDisplay::$plugin->instagramBasicDisplayService->dumpAccessToken();
    }

    /**
     * Manually insert an access token into the database.
     *
     * @param $token
     * @return bool|Exception|\yii\db\Exception
     */
    public function actionInsert($token) {
        return InstagramBasicDisplay::$plugin->instagramBasicDisplayService->insertAccessToken($token);
    }

    /**
     * Refresh the current token.
     *
     * @return StreamInterface|string
     */
    public function actionRefresh() {
        return InstagramBasicDisplay::$plugin->instagramBasicDisplayService->refreshToken();
    }

    /**
     * Get the expiration time of the current token.
     *
     * @throws Exception
     */
    public function actionExp()
    {
        InstagramBasicDisplay::$plugin->instagramBasicDisplayService->getTokenExpirationTime();
    }
}
