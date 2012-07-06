=== Checkfront Online Booking System ===

Contributors: checkfront
Stable tag: trunk
Tags: Booking, Reservation, Calendar, Availability, Online, Saas, Ajax, CRS, PMS, API, Secure, Cloud, Payments, Bookings
Requires at least: 2.0
License: GPLv2 or later
Tested up to: 3.4

Combine the sleek Checkfront back-office App with the ease and publishing power of WordPress. Online Booking Management has never been so easy!

== Description ==

**Checkfront** is an [Online Booking System](http://www.checkfront.com) that allows businesses to manage their inventories, centralize reservations, and process payments. This plugin connects your Wordpress site to your Checkfront account, and provides a powerful real time booking interface within your site.

Checkfront integrates seamlessly into Wordpress and does not force customers off to an external website to process bookings or view availability.  Checkfront keeps consumer data secure and separate from Wordpress.  The combined CMS features of Wordpress with the power, flexibility and security of the Checkfront back-end make for an industry leading booking management system.

You can configure Checkfront to manage your inventory, packages, accept reservations and process payments.

= Features include =

* Display real time availability, take reservations, bookings and process payments online within your website.
* SSL support keeps the customer on your website while making payment.
* Theme support allows you to tailor the look and feel of the booking portal.
* Multi-currency, multi-gateway payment processing including Paypal and Authorize.net, and SagePay.
* Further integration with [Salesforce, Zoho, Google Apps, Xero and more](http://www.checkfront.com/resources).
* Support for short codes, or custom theme pages in Wordpress.

== Installation ==
1. Install the Checkfront Booking plugin in your Wordpress admin by going to *'Plugins / Add New'* and  searching for *'Checkfront'*,  **(or)** If doing a manual install, download the plugin and unzip into your `/wp-content/plugins/` directory. 
1. Activate the the plugin through the 'Plugins' menu in WordPress.
= Configuration = 
1. Create your [Checkfront account](https://www.checkfront.com/start/ "Checkfront Setup")
1. Setup you inventory and configure your account on Checkfront.
1. Enable the Checkfront booking search widget in Wordpress.
1. Create a Wordpress **Post** and embed the Checkfront booking system by using the shortcode: `[checkfront]` (see the plugin for more options to pass to the shortcode).
1. If you wish to use a theme template instead of a shortcode, see the checkfront-custom-template-sample.php provided with the plugin.

== Frequently Asked Questions ==
1. [Checkfront Wordpress FAQ](https://www.checkfront.com/wordpress/#faq). 
1. [General Checkfront FAQ](https://www.checkfront.com/faq). 
1. [Additional Support and Documenation](https://www.checkfront.com/support/). 

== Screenshots ==

1. Booking Interface integrated into Wordpress
2. Checkfront Dashboard

== Changelog == 

= 2.6 = 

Updated Widget library. Increased permissions required to configure plugin.  

= 2.5.6 = 

Fixed issue with IE 9, and WP paragraph formating. 

= 2.5.5 = 
Updated v2.0 Widget library.  Fixed issue with v1 droplet call. 

= 2.5.3 = 
  * Split out CheckfrontWidget class so it can be used on its own.  Added custom template sample.  Fixed issue with category filter.

= 2.5 = 
* Added support for v2.0 Checkout.  Includes more configuration options, improved interfaced and payment integration.

= 1.5 = 
* Removed "Online Bookings by Checkfront" link

= 1.3 = 
* Added the ability to filter booking pages by category or item id.
* Upgraded to latest API.

= 1.2 = 
* Added sidebar widget.
* Improved calendar navigation.
* Better theme integration.

= 1.1 = 
* Fixed php shortcode issue.

= 1.0 = 
* Updated screenshots
* Removed legacy invoice insert.

= 0.9 =
* Moved to new 0.9 Checkfront API
* Now supports framed version of booking window should the theme interfere with the plugin
* Removed search widget: search functionality has been moved to main booking interface  - will reappear in another format.
* Improved compatibility fixes.  

= 0.8 = 

* Made compatible with wordpress 2.5+.  
* No longer loads remote javascript site wide, only on an embedded booking page.
* Improved warning messages and admin settings.
* Moved admin settings to plugin menu.

== Upgrade Notice ==

= 2.6 =

Improved ssl support, v2 interface and upgraded permissions.

= 2.5.5 =

Added support for v2.0 Booking Interface.  Includes more configuration options, advanced checkout, improved browser support and mode.  **IMPORTANT**: Once the update is complete, you must go to the plugin setup in Wordpress and switch from the Legacy 1.0 interface, to 2.0.
