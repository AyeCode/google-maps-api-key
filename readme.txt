=== API KEY for Google Maps ===
Contributors: stiofansisland, paoltaia
Tags:  Google Maps, Google Maps KEY, Google Maps API KEY, Google Maps callback, Google Maps API callback
Donate link: https://wpgeodirectory.com
Requires at least: 5.0
Tested up to: 6.9
Stable tag: 1.2.14
Requires PHP: 5.6
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Retroactively add Google Maps API KEY to any theme or plugin.

== Description ==

Retroactively add Google Maps API KEY to any theme or plugin.

Simply activate, go to Settings>Google API KEY and enter your key.
The plugin will then attempt to add this key to all the places it is needed on the front of your website.
NOTE: this will only work if the Google API has been added as per WordPress standards)

Since January 2023 Google Maps JavaScript API requires callback parameter. This plugin also fixes JavaScript Error: [Loading the Google Maps JavaScript API without a callback is not supported](https://developers.google.com/maps/documentation/javascript/url-params#required_parameters).

The plugin was created by the GeoDirectory team: <https://wpgeodirectory.com>

== Installation ==

= Minimum Requirements =

* WordPress 5.0 or greater
* PHP version 5.6 or greater
* MySQL version 5.0 or greater

= Automatic installation =

Automatic installation is the easiest option. To do an automatic install log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type Google Maps API KEY and click Search Plugins. Once you've found the plugin you install it by simply clicking Install Now.

= Manual installation =

The manual installation method involves downloading the plugin and uploading it to your webserver via your favourite FTP application. The WordPress codex will tell you more [here](https://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Updating =

Automatic updates should seamlessly work. We always suggest you backup up your website before performing any automated update to avoid unforeseen problems.

== Frequently Asked Questions ==

Ask and they shall be answered

== Screenshots ==

1. Settings page.
2. Generate API KEY.
3. Copy API KEY, paste in Settings and save.

== Changelog ==

= 1.2.14 - 2025-12-03 =
* WordPress v6.9 compatibility check - CHANGED

= 1.2.13 - 2024-11-28 =
* WordPress v6.7 compatibility check - CHANGED

= 1.2.12 - 2024-08-21 =
* WordPress v6.6 compatibility check - CHANGED

= 1.2.11 - 2024-04-11 =
* WordPress v6.5 compatibility check - CHANGED

= 1.2.10 - 2023-12-06 =
* WordPress v6.4 compatibility check - CHANGED

= 1.2.9 - 2023-08-10 =
* WordPress v6.3 compatibility - CHANGED

= 1.2.8 - 2023-03-30 =
* WordPress v6.2 compatibility - CHANGED

= 1.2.7 - 2023-02-02 =
* Add .gitattributes file - ADDED
* Generate Google API Key is no longer working - FIXED
* Loading the Google Maps JavaScript API without a callback is not supported - CHANGED

= 1.2.3 =
* Plugin version update - CHANGED

= 1.2.2 =
* Compatibility checked with WordPress 6.0 - CHECKED
* Now tries to add api key even if no key param is found - CHANGED
* Now only users with "manage_options" ability can update the API key - SECURITY

= 1.2.1 =
* Compatibility checked with WordPress 5.9

= 1.2.0 =
* frame api generation broken (by Google iframe restrictions) changed to new window popup - FIXED
* Updated Generate API KEY button to add access for all APIs - CHANGED

= 1.1.0 =
* Added a Generate API KEY button for easier generation of API KEY - ADDED

= 1.0.0 =
* Initial release

== Upgrade Notice ==