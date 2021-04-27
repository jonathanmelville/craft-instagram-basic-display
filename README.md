# Instagram Basic Display plugin for Craft CMS 3.x

This plugin creates endpoints in your Craft install for you to consume the Instagram Basic Display API as well as the oEmbed API. It also provides some helper methods for dealing with your access token and getting refresh tokens.

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:
   
        cd /path/to/project
   
2. Then tell Composer to load the plugin:

        composer require melvilleco/instagram-basic-display

3. Obtain a [long-lived access token](https://developers.facebook.com/docs/instagram-basic-display-api/guides/long-lived-access-tokens/) from Instagram and [insert it into your database](#inserting-your-access-token).

## Instagram Basic Display Overview

This plugin provides some helper methods and endpoints for working with the [Instagram Basic Display API](https://developers.facebook.com/docs/instagram-basic-display-api/) and the [Instagram OEmbed](https://developers.facebook.com/docs/instagram/oembed) service.

The plugin makes available several useful console commands and controller actions to help you access your Instagram content.

## Inserting Your Access Token

By default, Instagram User Access Tokens are short-lived and are valid for one hour. However, short-lived tokens can be exchanged for long-lived tokens.

Long-lived tokens are valid for 60 days and can be refreshed as long as they are at least 24 hours old but have not expired, and the app user has granted your app the `instagram_graph_user_profile` permission.

After you obtain your long-lived token, run the following command to insert it into your database:

      ./craft instagram-basic-display/token/insert [YOUR_TOKEN_HERE]



## Refreshing Your Token

As long-lived tokens are only valid for 60 days, you will need to periodically request a refreshed token. You can easily do this by setting up a cron task that calls the refresh method of the plugin:

      ./craft instagram-basic-display/token/insert

Your old token will be used to obtain a new one, and the new token will be inserted into the database.

## Commands and Endpoints
### Console Commands
The following console commands are available:

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

### Controller Actions
The following controller actions are available:

***

Get your Instagram feed as a JSON response:

      /actions/instagram-basic-display/feed/get

## Instagram Basic Display Roadmap

Some things to do, and ideas for potential features:

* Add OEmbed docs.
* Work out solution for scaling images.

Brought to you by [Jonathan Melville](https://codemdd.io)
