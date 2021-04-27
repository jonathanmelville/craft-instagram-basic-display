<?php
/**
 * Instagram Basic Display plugin for Craft CMS 3.x
 *
 * This plugin creates endpoints in your Craft install for you to consume the Instagram Basic Display API as well as the oEmbed API. It also provides some helper methods for dealing with your access token and getting refresh tokens.
 *
 * @link      https://codemdd.io
 * @copyright Copyright (c) 2021 Jonathan Melville
 */

namespace melvilleco\instagrambasicdisplay\models;

use melvilleco\instagrambasicdisplay\InstagramBasicDisplay;

use Craft;
use craft\base\Model;

/**
 * InstagramBasicDisplayModel Model
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Jonathan Melville
 * @package   InstagramBasicDisplay
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $api = 'https://graph.instagram.com/';

    /**
     * @var string
     */
    public $oembed_api = 'https://graph.facebook.com/v8.0/';

    /**
     * @var string
     */
    public $refresh_endpoint = 'refresh_access_token';

    /**
     * @var string
     */
    public $media_endpoint = 'me/media';

    /**
     * @var string
     */
    public $oembed_endpoint = 'instagram_oembed';

    /**
     * @var string
     */
    public $fields = 'media_type,media_url,permalink,thumbnail_url';

    /**
     * @var bool
     */
    public $omit_script = true;

    /**
     * @var int
     */
    public $cache_duration = 1800;

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            ['api', 'string'],
            ['oembed_api', 'string'],
            ['refresh_endpoint', 'string'],
            ['media_endpoint', 'string'],
            ['oembed_endpoint', 'string'],
            ['fields', 'string'],
            ['omit_script', 'boolean'],
            ['cache_duration', 'integer']
        ];
    }
}
