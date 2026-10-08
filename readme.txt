=== Toolbar Links Test ===
Contributors: lucasmdo
Tags: toolbar, admin bar
Requires at least: 7.1
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Test plugin for Trac #66258. Makes the W and the site name in the Toolbar behave the same in the admin, the editors and the front end.

== Description ==

This is a test plugin for WordPress Core Trac ticket #66258, "Toolbar: same W and site name behavior in the admin, the editors and the front end". It lets you try the proposal on a real site before it lands in Core.

With the plugin active:

* The W goes to the Dashboard instead of the About WordPress page. Dashboard becomes the first item in the W menu. The W stays visible on small screens (Core hides it under 600px).
* The site name always goes to the site. Today on the front end it goes to the Dashboard. Its menu is the same everywhere: Visit Site, Manage Site (multisite only), Plugins, Themes, plus Widgets, Menus, Background and Header on classic themes. The Dashboard item leaves this menu.
* When the site has no site icon, the same default icon is used everywhere. Today it is a house in the admin and a gauge on the front end.

Deactivate the plugin to get the current behavior back. Nothing is stored in the database.

Feedback goes to the Trac ticket: https://core.trac.wordpress.org/ticket/66258

== Installation ==

1. Download toolbar-links-test.zip from https://github.com/lmendes-design/toolbar-links-test/releases/latest/download/toolbar-links-test.zip
2. In wp-admin, go to Plugins, Add New Plugin, Upload Plugin.
3. Upload the zip and activate the plugin.
4. Deactivate it to compare with the current behavior.

You can also try it in WordPress Playground with no install: https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/lmendes-design/toolbar-links-test/main/blueprint.json

== Changelog ==

= 1.0.0 =
* First version.
