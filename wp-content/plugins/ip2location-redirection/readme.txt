=== IP2Location Redirection ===
Contributors: IP2Location
Donate link: http://www.ip2location.com
Tags: ip2location, country redirection, website redirect, page redirector, redirection, targeted content, ip address, 301, 302, country, ipv4, ipv6, geolocation
Requires at least: 4.6
Tested up to: 6.7
Stable tag: 1.33.0

Redirects visitors to a blog page or a predefined URL based on their country and region geolocated using IP address.

== Description ==

*This plugin will NOT work if any cache plugin is enabled.*

As the name suggests itself, IP2Location Redirection is one of the most favorite plugins recommended to handle the task of redirection on a website or a custom predefined URL based on country and region geolocated by IP address.

It is a very simple yet powerful redirection plugin that helps you to manage all your website redirects including 301 & 302 redirection. With the ability of detecting IP address geolocation information, it can redirect the visitors to another location with ease even if you are unfamiliar with Apache .htaccess files.

Key Features

* Redirects visitors to a blog page based on their country and region
* Redirects visitors to a predefined URL based on their country and region
* Allows you to configure multiple redirection rules as needed
* Supports 301 & 302 redirection
* Supports IPv4 and IPv6
* Reduce old or broken links and help your website with the SEO site rankings

This redirection plugin supports both IP2Location IP geolocation BIN data and web service for IP address geolocation lookup. If you are using the BIN data, you can update the BIN data every month by using the wizard on the settings page for the accurate result. Alternatively, you can also manually download and update the BIN data file using the below links:

BIN file download: [IP2Location Commercial database](https://ip2location.com "IP2Location commercial database") | [IP2Location LITE database](https://lite.ip2location.com "IP2Location LITE database")

To use the IP2Location IP geolocation web service (REST API) for geolocation, you'll need to register an account at [IP2Location.io IP Geolocation API](https://www.ip2location.io "IP2Location.io IP Geolocation API"). A free plan is available.

= More Information =
Please visit us at [https://www.ip2location.com](https://www.ip2location.com "https://www.ip2location.com")

== Frequently Asked Questions ==
= Do I need to download the BIN file after the plugin installation? =
Yes, please download the latest DB1 BIN file for a quick test from https://lite.ip2location.com/database/ip-country
If you need redirect by region, kindly use DB3 at https://lite.ip2location.com/database/ip-country-region-city

= Where can I download the BIN file? =
You can download the IP geolocation LITE edition which is free at [https://lite.ip2location.com](https://lite.ip2location.com "https://lite.ip2location.com") or commercial edition at [https://www.ip2location.com](http://www.ip2location.com "https://www.ip2location.com"). Decompress the downloaded .BIN file and upload it to `wp-content/uploads/ip2location`.

= Do I need to update the BIN file? =
We encourage you to update your BIN file every month so that your plugin works with the latest IP geolocation result. The update usually be ready on the 1st week of every calendar month.

= Can I select multiple countries or region for redirection? =
Yes, you can.

= Does this plugin works with "Cache Plugin", such as W3 Total Cache?
No. Please disable the "Cache Plugin" for our plugin to function correctly.

= How do I test the plugin?
You can use https://www.locabrowser.com to test the result.

= Unable to find your answer here? =
Send us an email at support@ip2location.com

== Screenshots ==

1. Redirect visitor from California and New York to https://google.com.

== Changelog ==
* 1.33.0 Added cache plugin warning.
* 1.32.2 Tested up to WordPress 6.7.
* 1.32.1 Fixed warning message on mobile device.
* 1.32.0 Added option to append parameter on destination URL.
* 1.31.1 Minor update.
* 1.31.0 Added feature to override real IP header.
* 1.30.1 Tested up to WordPress 6.6.
* 1.30.0 Added backup/restore feature.
* 1.29.4 Fixed CIDR matching in IPv6.
* 1.29.3 Tested up to WordPress 6.5.1.
* 1.29.2 Fixed CSRF issues.
* 1.29.1 Fixed database decompress error under Linux environment.
* 1.29.0 Updated setup wizard to include IP2Location.io Geolocation API service.
* 1.28.5 Added a private key to protect debug log.
* 1.28.4 Randomize debug log to protect unwanted access.
* 1.28.3 Tested up to WordPress 6.4.
* 1.28.2 Fixed deprecated setcookie error.
* 1.28.1 Fixed database download issue for some users.
* 1.28.0 Added IP detection for website behind Securi firewall.
* 1.27.1 Improved accuracy of IP detection with CloudFlare.
* 1.27.0 Improved IP detection for reverse proxy and CloudFlare services.
* 1.26.11 Stop obtain client IP from custom header to prevent IP spoofing.
* 1.26.10 Updated documentation and UI tweaks.
* 1.26.9 Added extra validation on first visit cookie.
* 1.26.8 Tested up to WordPress 6.2
* 1.26.7 Added source field into API web service.
* 1.26.6 Updated to use IP2Location.io IP Geolocation API.
* 1.26.5 Updated "Requires at least" information.
* 1.26.4 Tested up to WordPress 6.1.
* 1.26.3 Fixed WPML code not working with home page redirection.
* 1.26.2 Fixed invalid URL generated during redirection. Fixed origin/destination search field missing.
* 1.26.1 Fixed URL rule not display properly.
* 1.26.0 Added search function on page/post listing.
* 1.25.19 Improved home page redirection.
* 1.25.18 Improved cache clear process and remove debug.log when option is disabled.
* 1.25.17 Tested up to WordPress 6.0.
* 1.25.16 Fixed issue values being reset to default on re-activation.
* 1.25.15 Enhanced checking.
* 1.25.14 Fixed invalid redirection for some pages.
* 1.25.13 Added IP detection for GTranslate.
* 1.25.12 Tested up to WordPress 5.9.
* 1.25.11 Improved IP detection for IP forwarded by other services.
* 1.25.10 Added better handler when BIN lookup failed.
* 1.25.9 Removed non-exist assets.
* 1.25.8 Removed session dependencies.
* 1.25.7 Fixed API response.
* 1.25.6 Prevent redirection in administrator login page.
* 1.25.5 Fixed administrator detection. Improved infinite redirection handling.
* 1.25.4 Prevented empty destination from saving that lead to redirection error.
* 1.25.3 Fixed 404 error. Fixed duplicated language codes in WooCommerce.
* 1.25.2 Fixed CSS styling issues.
* 1.25.1 Fixed bugs and improvements.
* 1.25.0 Fine tuned backends and redirection.
* 1.24.1 Fixed WPML code warning.
* 1.24.0 Added WooCommerce and WPML supports.
* 1.23.14 Fixed issue detecting home page.
* 1.23.13 Fixed permission issue when updating database from settings.
* 1.23.12 Fixed error when using IPv6 CIDR in whitelist.
* 1.23.11 Fixed administrator notice keep showing after dismissed.
* 1.23.10 Fixed IP range mismatched when using CIDR.
* 1.23.9 Fixed setup issue for commercial database.
* 1.23.8 Fixed infinite redirection when using custom URL.
* 1.23.7 Updated domain validations to support more domain extensions.
* 1.23.6 Fixed whitespace issue in Ajax calling.
* 1.23.5 Tested up to WordPress 5.7.
* 1.23.4 Fixed file permission issues for some users.
* 1.23.3 Fixed issue download token not updated.
* 1.23.2 Fixed looping issue when using API service.
* 1.23.1 Fixed database download issue.
* 1.23.0 Added setup guide.
* 1.22.1 Minor bug fixes.
* 1.22.0 Added scheduled task to flush caches.
* 1.21.2 Tested up to WordPress 5.6.
* 1.21.1 Updated IP2Location library to support earlier version of PHP.
* 1.21.0 Updated file structures to use composer for IP2Location libraries.
* 1.20.0 Added feature to enable or disable existing rule.
* 1.19.3 Fixed deactivation issue when conflicting with other plugins.
* 1.19.2 Tested with WordPress 5.5.
* 1.19.1 Updated IP2Location library to support older PHP version.
* 1.19.0 Implemented internal cache and fixed several bugs.
* 1.18.0 Added whitelist feature.
* 1.17.4 Cleaned up codes and sanitized user inputs.
* 1.17.3 Added attribution instructions.
* 1.17.2 Fixed deactivation issue.
* 1.17.1 Fixed missing version tag.
* 1.17.0 Added option to ignore query string.
* 1.16.4 Tested with WordPress 5.4.
* 1.16.3 Prevented Ajax based job manager from redirection.
* 1.16.2 Fixed error message.
* 1.16.1 Updated plugin description.
* 1.16.0 Added redirection by region.
* 1.15.13 Increased timeout in BIN download.
* 1.15.12 Fixed existing BIN database not updated issue.
* 1.15.11 Minor fixes.
* 1.15.10 Added feedback request.
* 1.15.9 Tested with WordPress 5.3.2.
* 1.15.8 Updated IP2Location library to 8.1.0.
* 1.15.7 Fixed a bug when page does not exist.
* 1.15.6 Fixed issue when customized theme is used.
* 1.15.5 Fixed issue with multi-site WordPress.
* 1.15.4 Updated manual upload instructions.
* 1.15.3 Fixed issue download token not saved.
* 1.15.2 Fixed BIN database download issue.
* 1.15.1 Fixed redirection with WooCommerce shopping cart.
* 1.15.0 Moved database file to WordPress upload directory to prevent existing BIN file from deleted.
  Re-structured debugging log and grouped each visitor into same section.
  Improved session cache for faster speed and save Web service queries.
* 1.14.4 No longer look up for BIN file when Web service is used.
* 1.14.3 Updated documentation links.
* 1.14.2 Tested up to WordPress 5.1.1.
* 1.14.1 Fixed IP2Location API check credit interface.
* 1.14.0 Upgraded IP2Location API to v2.
* 1.13.10 Fixed database file detection in both Windows and Linux environment.
* 1.13.9 Prevent redirection when IP2Location database is missing or corrupted.
* 1.13.8 BIN database no longer shipped together to prevent local copy being overwritten.
* 1.13.7 Added LinkedIn and Pinterest into crawler list.
* 1.13.6 Tested with WordPress 5.0.1.
* 1.13.5 Fixed IP detection when server forwarded wrong IP address.
* 1.13.4 Updated country list based on latest ISO-3166 standards.
* 1.13.3 Added page not found handler.
* 1.13.2 Fix bug which prevented rules from being saved.
* 1.13.1 Fix rule insertion bug.
* 1.13.0 Multiple countries redirection is now available with single rule.
* 1.12.0 Domain redirection will now remain the path and query string. Fine tuned rule validations.
* 1.11.2 Minor fixes.
* 1.11.1 Ignore "www." when redirect domain.
* 1.11.0 Added debug log.
* 1.10.2 Minor bugs fixed.
* 1.10.1 Fixed notice dismiss issue.
* 1.10.0 Added domain redirection.
* 1.9.3 Fixed rule validation bugs.
* 1.9.2 Fixed bugs.
* 1.9.1 Minor changes.
* 1.9.0 IP2Location database update changed to use download token.
* 1.8.0 Added option to enable redirection for first time only. Custom URL allowed in "From" page.
* 1.7.6 Prevent duplicated cart items during redirection.
* 1.7.5 Fixed bots detection.
* 1.7.4 Minor changes.
* 1.7.3 Fixed checkbox issues in configuration page.
* 1.7.2 Bug fixes.
* 1.7.1 Minor update.
* 1.7.0 Added exclude option to redirect all countries except a specified country.
* 1.6.0 Added option to stop redirection when bots / crawlers detected. Fixed infinites loop bug with some pages.
* 1.5.0 Refined GUI and performance improvements.
* 1.4.1 Fixed checkbox issue.
* 1.4.0 Added home page as redirection source.
* 1.3.3 Fixed infinite loop when redirect within same domain using URL mode.
* 1.3.2 Fixed conflicts when multiple IP2Location plugins installed.
* 1.3.1 Added support for custom GET parameter.
* 1.3.0 Use IP2Location PHP 8.0.2 library for lookup.
* 1.2.7 Use latest IP2Location library for lookup.
* 1.2.6 Fixed close sticky information panel issue.
* 1.2.5 Redirection has been disabled on administrator.
* 1.2.4 Fix uninstall function.
* 1.2.3 Prevent settings lost when deactivate/activate the plugin.
* 1.2.2 Use latest IP2Location library and updated the setting page.
* 1.2.1 The redirection source and destination will list out all possible posts & pages now.
* 1.2.0 Multiple country selection added.
* 1.1.15 Tested with WordPress 4.4.
* 1.1.14 Ignore redirection in admin page.
* 1.1.13 Fixed linking issue to database file. Prevent infinite loop if wildcard chosen.
* 1.1.12 Fixed save issues.
* 1.1.11 Fixed warning message in WordPress 4.3.
* 1.1.10 Fixed redirection issues. Fixed errors with earlier version of PHP.
* 1.1.9 Fixed compatible issues with PHP 5.3 or earlier.
* 1.1.8 Fixed errors with PHP 5.3 or earlier.
* 1.1.7 Fixed class name issue when upgrade from previous version.
* 1.1.6 Fixed redirection issue in iOS devices. Use latest IP2Location library.
* 1.1.5 Remain query string after redirected to external URL.
* 1.1.4 Fix redirect issue when URL rewrite is using.
* 1.1.3 Will remain query string in URL after redirection.
* 1.1.0 Added supports for IP2Location Web Service.
* 1.0.1 Fixed issue on activation.
* 1.0.0 First public release.


== Installation ==
### Using WordPress Dashboard
1. Select **Plugins -> Add New**.
1. Search for "IP2Location Redirection".
1. Click on *Install Now* to install the plugin.
1. Click on *Activate* button to activate the plugin.
1. Register a download account https://lite.ip2location.com (Free) or https://www.ip2location.com (Commercial).
1. Get the download token from your account page.
1. Go to "Redirection" form WordPress sidebar.
1. Go through the setup wizard step by step.
1. You can now start using IP2Location Redirection to block visitors.

### Manual Installation
1. Upload the plugin to `/wp-content/plugins/ip2location-redirection` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Download IP2Location database from https://lite.ip2location.com (Free) or https://www.ip2location.com (Commercial).
1. Decompress the .BIN file and upload to `wp-content/plugins/ip2location-redirection`.
1. If you have IP2Location Web service purchased at https://www.ip2location.com/web-service, insert your API key in the Settings tab.
1. You can now start using IP2Location Redirection to redirect visitors.

Please take note that this plugin requires minimum **PHP version 5.4**.

* If you are using IP2Location LITE database, please follow [these instructions](https://blog.ip2location.com/knowledge-base/how-to-add-an-attribution-in-wordpress-when-using-ip2location-lite-database/) to add attribution into your website.