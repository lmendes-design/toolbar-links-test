# Toolbar Links Test

A small test plugin for WordPress Core Trac ticket [#66258](https://core.trac.wordpress.org/ticket/66258), "Toolbar: same W and site name behavior in the admin, the editors and the front end". It changes where the W and the site name in the Toolbar go, so you can try the proposal on a real site before it lands in Core. Nothing is stored in the database.

## What changes

- The W goes to the Dashboard instead of the About WordPress page. Dashboard becomes the first item in the W menu. The W stays visible on small screens (Core hides it under 600px).
- The site name always goes to the site. Today on the front end it goes to the Dashboard. Its menu is the same everywhere: Visit Site, Manage Site (multisite only), Plugins, Themes, plus Widgets, Menus, Background and Header on classic themes. The Dashboard item leaves this menu.
- When the site has no site icon, the same default icon is used everywhere. Today it is a house in the admin and a gauge on the front end.

## Try it

One click, no install: [open in WordPress Playground](https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/lmendes-design/toolbar-links-test/main/blueprint.json).

Manual install:

1. Download [toolbar-links-test.zip](https://github.com/lmendes-design/toolbar-links-test/releases/latest/download/toolbar-links-test.zip).
2. In wp-admin, go to Plugins, Add New Plugin, Upload Plugin.
3. Upload the zip and activate it.

Deactivate the plugin to get the current behavior back and compare.

Requires WordPress 7.1 and PHP 7.4.

## Feedback

Leave feedback on the [Trac ticket](https://core.trac.wordpress.org/ticket/66258).

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).
