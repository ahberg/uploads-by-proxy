# WordPress plugin Uploads by proxy

New release based on the orginal [Uploads by proxy](https://github.com/pdclark/uploads-by-proxy).

## Description

This plugin is meant to be used by developers who work on sites in a local development environment before deploying changes to a production (live) server. It allows you skip downloading the contents of `wp-content/uploads` to your local WordPress install. Instead, images missing from the uploads directory are loaded from the production server as needed. You have the option to download the files or to redirect to the original url.

## Setup

In wp-config.php
`define('UBP_SITEURL', 'http://example-live.com/wordpress');`
To define a 302 redirect to the original URL instead of downloading.
`define('UBP_REDIRECT', true);`
If you need you can also add a search-replace.
`define('UBP_REPLACE', [ '/app' => '/wp-content' ] );`

If you are on a staging server (not a local development environment) you may need to force the plugin to run with `define( 'UBP_IS_LOCAL', true );` in `wp-config.php`. Do not set this on a live site!

## Installation

1. Upload the `uploads-by-proxy` folder to the `/wp-content/plugins/` directory
1. In a local or staging development site, activate the Uploads by Proxy plugin through the 'Plugins' menu in WordPress
1. If your development site address is different than your live site address, or you are not using `WP_SITEURL`, set your live site address in `wp-config.php` like this: `define('UBP_SITEURL', 'http://example-live.com/wordpress');`

## Frequently Asked Questions

### Why would I want to use this?

Maybe you work on a site with gigabytes of images in the uploads directory, or maybe you use a version control system like SVN or Git, and prefer to not store `wp-content/uploads` in your repository. Either way, this plugin allows you to not worry about the uploads folder being up-to-date.

### What is a production environment/site/server?

"Production" is a term that's used to refer to a version of a site that is running live on the Internet. If you normally edit your site through the WordPress code editor or over FTP, you are making edits on the production server. Editing your site in this way risks crashing the site for your visitors each time you make an edit.

### What is a development environment/site/server?

"Development" refers to a version of your site that is in a protected area only accessible to you. Programs like [MAMP](http://www.mamp.info), [WAMP](http://www.wampserver.com/), and [XAMPP](http://www.apachefriends.org/en/xampp.html) allow you run a copy of your WordPress site in a way that is only accessible from your computer. This allows you to work on a copy and test changes without effecting the live site until you are ready to deploy your changes.

### An image changed on my live server, but it didn't update locally

This plugin only goes into action when an image is missing on your local copy. When it runs, it copies the file into your local wp-content/uploads folder and doesn't run again. If you'd like to update an image with the production copy again, delete your local copy.

### What will happen if I enable this plugin on a live site?

Nothing. The plugin only takes action if it detects it is on a local development environment.

### How does the plugin detect the difference between a production and development environment?

The plugin only loads if the server address and browser address are both `127.0.0.1`. This should catch most local environments, such as MAMP, WAMP, and XAMPP.

If your local domain is the same as the remote domain, and automatic IP detection doesn't work, use the <code>ubp_remote_ip</code> filter to set IP address programatticaly.

Example: <code>add_filter( 'ubp_remote_ip', function(){ return '12.34.56.789'; } );</code>

If you want to run the plugin on a staging server, or have some other situation where you want to force the plugin to run, set `define('UBP_IS_LOCAL', true);` in wp-config.php.

**Warning!** Do not force `UBP_IS_LOCAL` to `true` on a production site! If if have any 404 requests for images in the uploads directory, it will cause PHP to go into an infinite loop until Apache kills the process. This could make your site run very slowly.

### How does the plugin get around local DNS when production and development sites use the same domain?

It asks one of several remote servers what *it* thinks the IP address of your production domain is, then uses that IP to request the missing image. The correct domain name is sent in headers so that virtualhosts resolve.

## Changelog

### 2.1

* Add: Support for redirect instead of download. Thanks to [@ramonfincken](https://github.com/ramonfincken/uploads-by-proxy).

### 2.0

* Fix: Removed support for domain to ip service.
* Fix: Possible to enable on mutlisite installs.
