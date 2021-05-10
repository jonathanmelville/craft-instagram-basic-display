<?php
/**
 * Instagram Basic Display plugin for Craft CMS 3.x
 *
 * This plugin creates endpoints in your Craft install for you to consume the Instagram Basic Display API as well as the oEmbed API. It also provides some helper methods for dealing with your access token and getting refresh tokens.
 *
 * @link      https://codemdd.io
 * @copyright Copyright (c) 2021 Jonathan Melville
 */

namespace melvilleco\instagrambasicdisplay\services;

use melvilleco\instagrambasicdisplay\InstagramBasicDisplay;
use Craft;
use DateTime;
use craft\helpers\DateTimeHelper;
use craft\base\Component;
use craft\db\Query;
use craft\helpers\App;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use yii\db\Exception;

/**
 * InstagramBasicDisplayService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Jonathan Melville
 * @package   InstagramBasicDisplay
 * @since     1.0.0
 */
class InstagramBasicDisplayService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * Echo out the current access token.
     */
    public function dumpAccessToken()
    {
        echo (!empty($this->_getAccessToken()) ? 'Current token: ' . $this->_getAccessToken() : 'No access token!') . "\n";
    }

    /**
     * Manually insert an access token into the database.
     */
    public function insertAccessToken($token)
    {
        try {
            Craft::$app->getDb()->createCommand()
                ->truncateTable('instagram_access_token')->execute();
        } catch (Exception $e) {
            return $e;
        }
        try {
            (new Query())
                ->createCommand()
                ->insert('instagram_access_token', [
                    'access_token' => serialize($token),
                ])->execute();
        } catch (Exception $e) {
            return $e;
        }
        return true;
    }

    /**
     * Refresh the current token.
     *
     * @return \Psr\Http\Message\StreamInterface|string
     */
    public function refreshToken()
    {
        $settings = InstagramBasicDisplay::$plugin->getSettings();

        $client = new Client([
            'base_uri' => $settings['api'],
        ]);
        try {
            $response = $client->request('GET', $settings['refresh_endpoint'], [
                'query' => [
                    'grant_type' => 'ig_refresh_token',
                    'access_token' => $this->_getAccessToken()
                ]
            ]);

            $token = json_decode($response->getBody(), true)['access_token'];

            try {
                $exists = (new Query())
                    ->select(['access_token'])
                    ->from('instagram_access_token')
                    ->limit(1)
                    ->all();

                if ($exists) {
                    (new Query())
                        ->createCommand()
                        ->update('instagram_access_token', [
                            'access_token' => serialize($token),
                        ])->execute();
                }
            } catch (Exception $e) {
                Craft::error($e->getMessage(), __METHOD__);
                echo $e->getMessage();
                die();
            }
            return $response->getBody();
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }
    }


    /**
     * Return the age of the current token.
     *
     * @throws \Exception
     */
    public function getTokenAge()
    {
        echo 'Token age';
    }

    /**
     * Get the full Instagram feed.
     * @return mixed
     */
    public function getFeed()
    {
        $settings = InstagramBasicDisplay::$plugin->getSettings();
        $cache = Craft::$app->getCache();

        return $cache->getOrSet('instagram_feed', function() use ($settings) {
            $client = new Client([
                'base_uri' => $settings['api'],
            ]);
            try {
                $response = $client->request('GET', $settings['media_endpoint'], [
                    'query' => [
                        'fields' => $settings['fields'],
                        'access_token' => $this->_getAccessToken()
                    ]
                ]);
                return json_decode($response->getBody()->getContents(), true)['data'];
            } catch (GuzzleException $e) {
                return $e->getMessage();
            }
        }, $settings['cache_duration']);
    }

    /**
     * Get full oembed html from Instagram post.
     *
     * @param $url
     * @return mixed
     */
    public function getOEmbed($url)
    {
        $settings = InstagramBasicDisplay::$plugin->getSettings();
        $cache = Craft::$app->getCache();
        $cache_key = 'instagram_oembed_' . $url;

        return $cache->getOrSet($cache_key, static function() use ($settings, $url) {
            $client = new Client([
                'base_uri' => $settings['oembed_api'],
            ]);
            try {
                $response = $client->request('GET', $settings['oembed_endpoint'], [
                    'query' => [
                        'url' => $url,
                        'maxwidth' => 600,
                        'omitscript' => $settings['omit_script'],
                        'access_token' => App::env('INSTAGRAM_APP_ACCESS_TOKEN')
                    ]
                ]);
                return json_decode($response->getBody(), false);
            } catch (GuzzleException $e) {
                return $e->getMessage();
            }
        }, $settings['cache_duration']);
    }

    /**
     * Retrieve the current token from the database.
     *
     * @return mixed
     */
    private function _getAccessToken()
    {
        $token = (new Query())
            ->select(['access_token'])
            ->from('instagram_access_token')
            ->limit(1)
            ->all();
        return unserialize(($token[0]['access_token'] ?? null), [true]);
    }

    /**
     * Retrieve dateUpdated of current token.
     *
     * @return mixed
     */
    private function _getAccessTokenAge()
    {
        $token = (new Query())
            ->select(['dateUpdated'])
            ->from('instagram_access_token')
            ->limit(1)
            ->all();
        return ($token[0]['dateUpdated'] ?? null);
    }
}
