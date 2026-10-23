=== Toolbar Links Test ===
Contributors: lucasmdo
Tags: toolbar, admin bar
Requires at least: 7.1
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 2.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Test plugin for Trac #66258. Four prototypes for the W and the site name in the Toolbar.

== Description ==

This is a test plugin for WordPress Core Trac ticket #66258 and the Make Core post "Call for feedback: the W and the site name in the Toolbar". It holds four prototypes for the first items of the Toolbar, so you can try each one on a real site and compare.

All four solve the same two problems: a way back to the Dashboard from the Post Editor and the Site Editor, and a first item in the Toolbar that is useful.

* Prototype 1: the W goes to the Dashboard, the site name goes to the site. Dashboard is the first item of the W menu. The site name menu is the same everywhere: Visit Site, Plugins, Themes. The W stays visible on small screens.
* Prototype 2: everything under the site name. The site name goes to the site. Its menu is the same everywhere: Dashboard, Visit Site, Plugins, Themes. The W does not change.
* Prototype 3: Dashboard always in the site name menu. The click works as today. Dashboard is always in the menu, in the admin and in the editors too. The W does not change.
* Prototype 4: the W moves to the end of the Toolbar. The site name is the first item and works like prototype 3. The W menu moves to the right side, next to the account menu.

Pick a prototype in Settings > General, "Toolbar prototype". Or define TLT_PROTOTYPE (1 to 4) in wp-config.php. A small "Prototype N" item on the right of the Toolbar tells you which one is active.

Deactivate the plugin to get the current behavior back. The plugin stores one option, the chosen prototype. Uninstall removes it.

Feedback goes to the Make Core post https://make.wordpress.org/core/2026/10/12/call-for-feedback-the-w-and-the-site-name-in-the-toolbar/ or to the Trac ticket https://core.trac.wordpress.org/ticket/66258

== Installation ==

1. Download toolbar-links-test.zip from https://github.com/lmendes-design/toolbar-links-test/releases/latest/download/toolbar-links-test.zip
2. In wp-admin, go to Plugins, Add New Plugin, Upload Plugin.
3. Upload the zip and activate the plugin.
4. Pick a prototype in Settings > General.
5. Deactivate it to compare with the current behavior.

You can also try each prototype in WordPress Playground with no install. The links are in the README: https://github.com/lmendes-design/toolbar-links-test#try-it

== Changelog ==

= 2.0.0 =
* Four prototypes instead of one. Switch in Settings > General or with the TLT_PROTOTYPE constant.
* A "Prototype N" item on the right of the Toolbar shows the active one.

= 1.0.0 =
* First version.
