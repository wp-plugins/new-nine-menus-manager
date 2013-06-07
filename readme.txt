=== New Nine Menus Manager===
Contributors: New Nine
Author URI: http://www.newnine.com
Tags: menus, navigation
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: trunk
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Register new menu locations right from the menu screen. Never write register_nav_menu again and keep your functions file clean!

== Description ==

The New Nine Menus Manager adds a section to the 'Appearance -> Menus' section of your dashboard so you can quickly and easily create and delete menu locations on the fly.

Why? Because we're tired of jumping back and forth between our functions file and the dashboard. Because we're tired of writing `register_nav_menu` over and over again every time we start a new site.

And because there seems to be a disconnect here - just about every site needs to have a navigation menu, there are no configuration options for `register_nav_menu`, and it just seems to make sense to be able to create and delete menu locations in the dashboard.

This plugin was built by [New Nine Media & Advertising](http://www.newnine.com/ "New Nine Media & Advertising").

__Single Site & Network Compatible__

The New Nine Menus Manager works on both individual sites and WordPress Networks.

__MU Compatible__

The plugin is also **Must Use** compatible for both single sites and network installations.

== Installation ==

Use the WordPress installer; or, download and unzip the files.

__For Standard Plugin Installation__

Put the folder `n9m-menus-manager` into the `/wp-content/plugins/` directory.

Activate the plugin through the 'Plugins' menu in WordPress.

__For Must Use (MU) Installation__

If you don't have a folder called `mu-plugins` in `wp-content`, create it.

Put the file `n9m-menus-manager.php` into the `/wp-content/mu-plugins/` directory.

__No Bloat Code__

This plugin doesn't add any JavaScript to your site and only makes one small option in your database.

== Screenshots ==

1. Menus Manager is added to the 'Appearance -> Menus' section of your dashboard. From here, you can create a new menu, view your current menus and ids for use in `wp_nav_menu`, and delete menus you don't use.

2. You can hide the Menus Manager using the *Screen Options* twirldown menu. This is great so that you (or your clients) don't accidentally delete menus.