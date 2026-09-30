# [API KEY for Google Maps](https://wordpress.org/plugins/api-key-for-google-maps/)

**Retroactively add Google Maps API KEY to any theme or plugin.**

## Description

Many themes and plugins load Google Maps without an API key, or without a setting to enter one. Google requires an API key for every Maps JavaScript API request, so these maps fail with "This page can't load Google Maps correctly" or show a "For development purposes only" watermark.

**API KEY for Google Maps** fixes this without touching theme or plugin code. Enter your key once and the plugin adds it to every Google Maps JavaScript API script enqueued on the site.

### Features

* Adds your API key to Google Maps JavaScript API scripts enqueued by any theme or plugin.
* Replaces an outdated or different key already present in the script URL with your own.
* Adds the callback parameter Google has required since January 2023, fixing the JavaScript error [Loading the Google Maps JavaScript API without a callback is not supported](https://developers.google.com/maps/documentation/javascript/url-params#required_parameters).
* Works on the front end of your site and in the WordPress admin.
* One-click **Generate API Key** button that opens the Google Cloud Console with the Maps APIs selected.
* Quick link to a free tool that checks your site for Google Maps API key errors.
* Lightweight: a single settings field and a tiny inline script. The saved key is removed when you delete the plugin.

### How to use

1. Activate the plugin and go to **Settings > Google API KEY**.
2. Click **Generate API Key** (you must be signed in to your Google account), or paste a key you already have.
3. Click **Save Changes**. Your maps now load with your key.

### Requirements and tips

* The theme or plugin must load Google Maps the standard WordPress way (with `wp_enqueue_script()`). Scripts that are hard-coded into templates or injected by JavaScript can not be changed.
* Browser API keys are visible in your page source. In the Google Cloud Console, restrict your key to your website's domain (HTTP referrers) and to the Maps APIs you use.

### For developers

When the Google Maps API has loaded, the plugin sets `window.rgmkGoogleMapsCallback` to `true` and triggers the jQuery event `rgmkGoogleMapsLoad` on `document`. Use the `rgmk_google_map_callback_script` filter to change the callback script.

The plugin was created by the [GeoDirectory](https://wpgeodirectory.com) team.

## Installation

### Minimum Requirements

* WordPress 6.0 or greater
* PHP version 7.4 or greater
* MySQL version 8.0 or greater

### Automatic installation

Automatic installation is the easiest and fastest method. Follow these simple steps:

1. Log in to your WordPress admin dashboard.
2. Navigate to **Plugins** > **Add New**.
3. Type "API KEY for Google Maps" into the search bar.
4. Once you find the plugin, click **Install Now** and then **Activate**.

### Manual installation

The manual installation method involves downloading our [API KEY for Google Maps](https://wordpress.org/plugins/api-key-for-google-maps/) plugin and uploading it to your webserver via your favourite FTP application. The WordPress codex will tell you more [here](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).


### Updating

Automatic updates should seamlessly work. We always suggest you backup up your website before performing any automated update to avoid unforeseen problems.


## Security

To report a security vulnerability, please review our [vulnerability disclosure policy](https://ayecode.io/vulnerability-disclosure-policy/)


## Changelog

Changelog can be found [here](https://wordpress.org/plugins/api-key-for-google-maps/#developers)
