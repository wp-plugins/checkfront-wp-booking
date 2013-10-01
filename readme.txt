=== Checkfront Online Booking System ===

Contributors: checkfront
Stable tag: trunk
Tags: Booking, Booking System, Reservation, Reservation System, Online Booking, Booking Engine, Tours, Tour Operator, Booking Plugin, Reservation Plugin, Booking Software, Reservation Payment System, Activity Booking, Rental Booking, Reservation Payments, Tour Booking, Passbook, Availability, Online, Saas, Ajax, CRS, PMS, API, Secure, Cloud, Payments, Bookings
Requires at least: 2.0
License: GPLv2 or later
Tested up to: 3.6.1

The Premier Wordpress Plugin for Easy Online Booking of Tours, Activities, Rentals & More.

== Description ==

**Checkfront** is an [Online Booking System](http://www.checkfront.com) that allows businesses to manage their rental inventories, centralize reservations, and process online payments. This plugin connects your Wordpress site to your Checkfront account, and provides a powerful real-time booking interface - right within your existing Wordpress site.

= Features include =

* Display real time availability, take reservations, bookings and process payments online within your website.
* SSL support keeps the customer on your website while making payment.
* Seamlessly blends in with your existing Wordpress theme design.
* Multi-currency, multi-gateway payment processing including Paypal and Authorize.net, and SagePay & dozens more.
* Further integration with [Salesforce, Zoho, Google Apps, Xero and many, many more](http://www.checkfront.com/resources).
* Support for short codes, or custom theme pages in Wordpress.

Checkfront integrates seamlessly into Wordpress and does not force customers off to an external website to process bookings or view availability.  Checkfront keeps consumer data secure and separate from Wordpress.  The combined CMS features of Wordpress with the power, flexibility and security of the Checkfront back-end make for an industry leading booking management system.

See It In Action:
[youtube http://www.youtube.com/watch?v=VlvzZWiAySU&rel=0]

You can configure Checkfront to manage your rental inventory, packages, accept reservations and process payments.


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

== Upgrade Notice ==

= 2.9.1 =

* Improved rendering performance and updated libraries.  Fixed issue with short tags in the admin resulting in a blank page.

== Changelog == 
* September 30th 2013*:
	
  Added support for new interface library, updated Widget library and support for end_date shortcode.

* June 27  2012 *:
  * Split out CheckfrontWidget class so it can be used on its own.  Added custom template sample.  Fixed issue with category filter.
* June 25  2012*:
  * Added support for v2.0 Checkout.  Includes more configuration options.
* *May 11 2010*:
  * Removed "Online Bookings by Checkfront" link
* *Apr 29 2010*:
  * Added the ability to filter booking pages by category or item id.
  * Upgraded to latest API.
* *Mar 21 2010*:
  * Added sidebar widget.
  * Improved calendar navigation.
  * Better theme integration.
* *Feb 28 2010*:
  * Fixed php shortcode issue.
* *Feb 24 2010*:
  * Updated screenshots
  * Removed legacy invoice insert.
* *Feb 18 2010*:
  * Moved to new 0.9 Checkfront API
  * Now supports framed version of booking window should the theme interfere with the plugin
  * Removed search widget: search functionality has been moved to main booking interface  - will reappear in another format.
* *Nov 30 2009*: 
 * Improved compatibility fixes.  
* *Nov 13 2009*: 
 * Made compatible with wordpress 2.5+.  
 * No longer loads remote javascript site wide, only on an embedded booking page.
 * Improved warning messages and admin settings.
 * Moved admin settings to plugin menu.
* *Nov 6 2009*: Updated readme, small IE fix.
* *Nov 5 2009*: Initial public beta.
