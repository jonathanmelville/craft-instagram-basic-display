# Instagram Basic Display plugin for Craft CMS 3.x

This plugin creates endpoints in your Craft install for you to consume the Instagram Basic Display API as well as the oEmbed API. It also provides some helper methods for dealing with your access token and getting refresh tokens.

<img width="100" src="https://raw.githubusercontent.com/jonathanmelville/craft-instagram-basic-display/master/resources/img/plugin-logo.png">

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:
   
        cd /path/to/project
   
2. Then tell Composer to load the plugin:

        composer require melvilleco/instagram-basic-display

3. Obtain a [long-lived access token](https://developers.facebook.com/docs/instagram-basic-display-api/guides/long-lived-access-tokens/) from Instagram (see example video below) and [insert it into your database](#inserting-your-access-token).

<a href="https://www.loom.com/share/687cc456759d4fb89772075b77cf64e1"> <p>How to get an initial access token for the Instagram Basic Display API - Watch Video</p> <img style="max-width:300px;" src="https://cdn.loom.com/sessions/thumbnails/687cc456759d4fb89772075b77cf64e1-with-play.gif"> </a>

## Instagram Basic Display Overview

This plugin provides some helper methods and endpoints for working with the [Instagram Basic Display API](https://developers.facebook.com/docs/instagram-basic-display-api/) and the [Instagram OEmbed](https://developers.facebook.com/docs/instagram/oembed) service.

The plugin makes available several useful console commands and controller actions to help you access your Instagram content.

## Configuration

Configuration is done via the `src/config.php` config file. It should be renamed to `instagram-basic-display.php` and copied to your `config/` directory to take effect. 

The most likely options you may want to change are `cache_duration` and `fields`. `fields` simply determines [what data is returned](https://developers.facebook.com/docs/instagram-basic-display-api/reference/media/#fields) by the request. 


## Inserting Your Access Token

By default, Instagram User Access Tokens are short-lived and are valid for one hour. However, short-lived tokens can be exchanged for long-lived tokens.

Long-lived tokens are valid for 60 days and can be refreshed as long as they are at least 24 hours old but have not expired, and the app user has granted your app the `instagram_graph_user_profile` permission.

After you obtain your long-lived token, run the following command to insert it into your database:

      ./craft instagram-basic-display/token/insert [YOUR_TOKEN_HERE]



## Refreshing Your Token

As long-lived tokens are only valid for 60 days, you will need to periodically request a refreshed token. You can easily do this by setting up a cron task that calls the refresh method of the plugin:

      ./craft instagram-basic-display/token/refresh

Your old token will be used to obtain a new one, and the new token will be inserted into the database.

## Commands and Endpoints
### Console Commands
The following console commands are available:

***

Get the expiration date/time of the current token:

      ./craft instagram-basic-display/token/exp

***

Echo out the current access token:

      ./craft instagram-basic-display/token/get

***

Manually insert an access token into the database:

      ./craft instagram-basic-display/token/insert

***

Refresh the current token:

      ./craft instagram-basic-display/token/refresh

***

### Accessing your Instagram feed as JSON
If accessing your feed from inside a Vue or React component, you can hit the following endpoint to get a JSON response:

      /actions/instagram-basic-display/feed/get

### Getting Your Feed in Twig
You can also output your feed inside your Twig templates using a `{% for %}` loop:

```html
<ul>
   {% for media in craft.instagram.getFeed() %}
      {% if media.media_type == 'IMAGE' %}
         <a href="{{ media.permalink }}">
            <img src="{{ media.media_url }}" alt="">
         </a>
      {% endif %}
   {% endfor %}
</ul>
```

## Instagram Basic Display Roadmap

Some things to do, and ideas for potential features:

* Add OEmbed docs.
* Create better docs for how to get an initial token.
* Work out solution for scaling images.

Brought to you by [Jonathan Melville](https://codemdd.io)
