# Toolbar Links Test

A small test plugin for WordPress Core Trac ticket [#66258](https://core.trac.wordpress.org/ticket/66258) and the Make Core post [Call for feedback: the W and the site name in the Toolbar](https://make.wordpress.org/core/2026/10/12/call-for-feedback-the-w-and-the-site-name-in-the-toolbar/). It holds four prototypes for the first items of the Toolbar, so you can try each one on a real site and compare.

All four solve the same two problems: a way back to the Dashboard from the Post Editor and the Site Editor, and a first item in the Toolbar that is useful.

## The prototypes

| | The W | The site name |
|---|---|---|
| **1. The W goes to the Dashboard, the site name goes to the site** | Click goes to the Dashboard. Dashboard is the first item of the menu. Stays visible under 600px. | Click always goes to the site. Same menu everywhere: Visit Site, Plugins, Themes. |
| **2. Everything under the site name** | No change. | Click always goes to the site. Same menu everywhere: Dashboard, Visit Site, Plugins, Themes. |
| **3. Dashboard always in the site name menu** | No change. | Click works as today. Dashboard is always in the menu. In the admin and in the editors it comes after Visit Site. |
| **4. The W moves to the end of the Toolbar** | Moves to the right side, after the account menu. Same menu. | First item of the Toolbar. Works like prototype 3. |

In all four: on multisite, Manage Site stays in the site name menu. Classic themes keep Widgets, Menus, Background and Header. When the site has no site icon, the same default icon is used everywhere. A small "Prototype N" item on the right tells you which one is active.

## Try it

One click each, no install. Playground loads WordPress with the prototype active and lands on the Dashboard. Check the admin, the front end, the Post Editor and the Site Editor.

- [Prototype 1](https://playground.wordpress.net/#eyIkc2NoZW1hIjoiaHR0cHM6Ly9wbGF5Z3JvdW5kLndvcmRwcmVzcy5uZXQvYmx1ZXByaW50LXNjaGVtYS5qc29uIiwibGFuZGluZ1BhZ2UiOiIvd3AtYWRtaW4vIiwibG9naW4iOnRydWUsInByZWZlcnJlZFZlcnNpb25zIjp7InBocCI6IjguMyIsIndwIjoibGF0ZXN0In0sInN0ZXBzIjpbeyJzdGVwIjoiZGVmaW5lV3BDb25maWdDb25zdHMiLCJjb25zdHMiOnsiVExUX1BST1RPVFlQRSI6MX19LHsic3RlcCI6Imluc3RhbGxQbHVnaW4iLCJwbHVnaW5EYXRhIjp7InJlc291cmNlIjoiZ2l0OmRpcmVjdG9yeSIsInVybCI6Imh0dHBzOi8vZ2l0aHViLmNvbS9sbWVuZGVzLWRlc2lnbi90b29sYmFyLWxpbmtzLXRlc3QuZ2l0IiwicmVmIjoibWFpbiIsInBhdGgiOiIifSwib3B0aW9ucyI6eyJhY3RpdmF0ZSI6dHJ1ZX19XX0=)
- [Prototype 2](https://playground.wordpress.net/#eyIkc2NoZW1hIjoiaHR0cHM6Ly9wbGF5Z3JvdW5kLndvcmRwcmVzcy5uZXQvYmx1ZXByaW50LXNjaGVtYS5qc29uIiwibGFuZGluZ1BhZ2UiOiIvd3AtYWRtaW4vIiwibG9naW4iOnRydWUsInByZWZlcnJlZFZlcnNpb25zIjp7InBocCI6IjguMyIsIndwIjoibGF0ZXN0In0sInN0ZXBzIjpbeyJzdGVwIjoiZGVmaW5lV3BDb25maWdDb25zdHMiLCJjb25zdHMiOnsiVExUX1BST1RPVFlQRSI6Mn19LHsic3RlcCI6Imluc3RhbGxQbHVnaW4iLCJwbHVnaW5EYXRhIjp7InJlc291cmNlIjoiZ2l0OmRpcmVjdG9yeSIsInVybCI6Imh0dHBzOi8vZ2l0aHViLmNvbS9sbWVuZGVzLWRlc2lnbi90b29sYmFyLWxpbmtzLXRlc3QuZ2l0IiwicmVmIjoibWFpbiIsInBhdGgiOiIifSwib3B0aW9ucyI6eyJhY3RpdmF0ZSI6dHJ1ZX19XX0=)
- [Prototype 3](https://playground.wordpress.net/#eyIkc2NoZW1hIjoiaHR0cHM6Ly9wbGF5Z3JvdW5kLndvcmRwcmVzcy5uZXQvYmx1ZXByaW50LXNjaGVtYS5qc29uIiwibGFuZGluZ1BhZ2UiOiIvd3AtYWRtaW4vIiwibG9naW4iOnRydWUsInByZWZlcnJlZFZlcnNpb25zIjp7InBocCI6IjguMyIsIndwIjoibGF0ZXN0In0sInN0ZXBzIjpbeyJzdGVwIjoiZGVmaW5lV3BDb25maWdDb25zdHMiLCJjb25zdHMiOnsiVExUX1BST1RPVFlQRSI6M319LHsic3RlcCI6Imluc3RhbGxQbHVnaW4iLCJwbHVnaW5EYXRhIjp7InJlc291cmNlIjoiZ2l0OmRpcmVjdG9yeSIsInVybCI6Imh0dHBzOi8vZ2l0aHViLmNvbS9sbWVuZGVzLWRlc2lnbi90b29sYmFyLWxpbmtzLXRlc3QuZ2l0IiwicmVmIjoibWFpbiIsInBhdGgiOiIifSwib3B0aW9ucyI6eyJhY3RpdmF0ZSI6dHJ1ZX19XX0=)
- [Prototype 4](https://playground.wordpress.net/#eyIkc2NoZW1hIjoiaHR0cHM6Ly9wbGF5Z3JvdW5kLndvcmRwcmVzcy5uZXQvYmx1ZXByaW50LXNjaGVtYS5qc29uIiwibGFuZGluZ1BhZ2UiOiIvd3AtYWRtaW4vIiwibG9naW4iOnRydWUsInByZWZlcnJlZFZlcnNpb25zIjp7InBocCI6IjguMyIsIndwIjoibGF0ZXN0In0sInN0ZXBzIjpbeyJzdGVwIjoiZGVmaW5lV3BDb25maWdDb25zdHMiLCJjb25zdHMiOnsiVExUX1BST1RPVFlQRSI6NH19LHsic3RlcCI6Imluc3RhbGxQbHVnaW4iLCJwbHVnaW5EYXRhIjp7InJlc291cmNlIjoiZ2l0OmRpcmVjdG9yeSIsInVybCI6Imh0dHBzOi8vZ2l0aHViLmNvbS9sbWVuZGVzLWRlc2lnbi90b29sYmFyLWxpbmtzLXRlc3QuZ2l0IiwicmVmIjoibWFpbiIsInBhdGgiOiIifSwib3B0aW9ucyI6eyJhY3RpdmF0ZSI6dHJ1ZX19XX0=)

On your own site:

1. Download [toolbar-links-test.zip](https://github.com/lmendes-design/toolbar-links-test/releases/latest/download/toolbar-links-test.zip).
2. In wp-admin, go to Plugins, Add New Plugin, Upload Plugin. Upload the zip and activate it.
3. Pick a prototype in Settings > General, "Toolbar prototype". Or define `TLT_PROTOTYPE` (1 to 4) in wp-config.php.

Deactivate the plugin to get the current behavior back. The plugin stores one option, the chosen prototype. Uninstall removes it.

Requires WordPress 7.1 and PHP 7.4.

## Feedback

Leave feedback on the [Make Core post](https://make.wordpress.org/core/2026/10/12/call-for-feedback-the-w-and-the-site-name-in-the-toolbar/) or on the [Trac ticket](https://core.trac.wordpress.org/ticket/66258).

## Blueprints

The Playground links are the base64 form of the files in `blueprints/`. Regenerate them with:

```
python3 -c "import json,base64;print(base64.b64encode(json.dumps(json.load(open('blueprints/p1.json')),separators=(',',':')).encode()).decode())"
```

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).
