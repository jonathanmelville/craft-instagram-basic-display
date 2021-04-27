<?php
/**
 * Instagram Basic Display plugin for Craft CMS 3.x
 *
 * This plugin creates endpoints in your Craft install for you to consume the Instagram Basic Display API as well as the oEmbed API. It also provides some helper methods for dealing with your access token and getting refresh tokens.
 *
 * @link      https://codemdd.io
 * @copyright Copyright (c) 2021 Jonathan Melville
 */

namespace melvilleco\instagrambasicdisplay\controllers;

use craft\helpers\Json;
use melvilleco\instagrambasicdisplay\InstagramBasicDisplay;

use Craft;
use craft\web\Controller;
use craft\web\Request;
use phpDocumentor\Reflection\Types\Object_;

/**
 * Default Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    Jonathan Melville
 * @package   InstagramBasicDisplay
 * @since     1.0.0
 */
class FeedController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['get', 'get-oembed'];

    // Public Methods
    // =========================================================================


    /**
     * Get full Instagram feed: `actions/instagram-basic-display/feed/get`
     *
     * @return \yii\web\Response
     */
    public function actionGet(): \yii\web\Response
    {
        return $this->asJson(InstagramBasicDisplay::$plugin->instagramBasicDisplayService->getFeed());
    }

    /**
     * Get the oEmbed for an Instagram post: `actions/instagram-basic-display/feed/get-oembed?url={postUrl}`
     *
     * @return \yii\web\Response
     */
    public function actionGetOembed(): \yii\web\Response
    {
        $request = new Request;
        return $this->asJson(InstagramBasicDisplay::$plugin->instagramBasicDisplayService->getOEmbed($request->get('url')));
    }
}
