# Northline Storefront

Shared base for Northline client stores (WordPress + WooCommerce + Storefront).

Git versions **only the child theme** `northline-storefront`. WordPress core, plugins, uploads and the database stay out of Git (see `.gitignore`).

## What the base includes

- **Child theme `northline-storefront`.** Installable zips are in [Releases](https://github.com/wontero/northline-outfitters/releases), and **v1.1.1 is the validated version**.
  - Sale prices: the crossed-out old price has readable contrast.
  - Mobile footer search: hidden until the Search button opens it.
  - "Shop by Brand" home section: shown only when a brand has products, with WooCommerce's brand styles.
- **LocalWP Blueprint `northline-base-1.0.0`.** A clean copy of Northline: plugins, menu, static home and Yoast templates are already set. It has no orders, customers, Stripe keys or GA ID. It is not in Git: LocalWP saves it as `northline-base-1.0.0.zip` in its `blueprints` folder (Windows: `%APPDATA%\Local\blueprints`). Share that zip in the team Drive, and re-create it with a new version when the plugin baseline changes. The theme is not re-created there: each new store installs the validated release (step 6 below).
- **Plugin baseline** (below).

**Rule:** don't edit the child theme for one client. A client's identity (logo, colors, texts) goes in *Appearance → Customize*. Code for a single store would go in a plugin for that store.

## Create a new store from the Blueprint

1. LocalWP → **+** → *Create from a Blueprint* → `northline-base-1.0.0`.
2. *Users → Add New User*: create **your own admin account**, log in with it, and delete the base admin that the Blueprint carries, assigning its content to your new account.
3. Set the site title (*Settings → General*) and the logo (*Customize → Site Identity*).
4. Apply the per-store settings (below).
5. UpdraftPlus: connect this store's own remote storage (its own Google account) and run **Backup Now**.
6. The store starts with theme **1.0.0**. Install the validated release zip (see *Install*).

## Rebuild without the Blueprint

1. New LocalWP site: WordPress 7.1.5, PHP 8.2.
2. Install the Storefront 4.6.2 parent theme and the plugins below at the listed versions.
3. Install the validated release zip and activate it.
4. Admin settings:
   - Static home page with Storefront's *Homepage* template.
   - Menu: Home, Shop, My account.
   - Remove the blog widgets and the sample post/page.
   - Category images.
   - Yoast: home and shop descriptions by hand; products and categories by template (*Yoast SEO → Settings → Content types / Categories*):
     - Products: `%%title%% from %%sitename%%. Browse our %%ct_product_cat%% and order online with secure card checkout.`
     - Product categories: `Shop %%term_title%% at %%sitename%%: outdoor apparel and accessories with secure card checkout.`
5. Apply the per-store settings.

## Plugin baseline

| Plugin | Tested version | Why | Configure per store |
|---|---|---|---|
| WooCommerce | 11.3.0 | The store | Currency, shipping, taxes |
| WooCommerce Stripe Gateway | 11.2.0 | Card payments | Own Stripe account, keys, webhook |
| Yoast SEO | 28.9 | Meta descriptions per page type | Home and shop descriptions |
| Google Analytics for WooCommerce | 2.4.4 | GA4 with store and purchase events | Own measurement ID |
| UpdraftPlus | 1.26.16 | Backups to cloud storage and restore | Own remote storage |

## Environments

| Environment | Where | For |
|---|---|---|
| Local | `northline-outfitters.local` (this repo) | Developing and committing the theme |
| Staging | `northline-staging.local` (LocalWP *Clone site*) | Testing every release and update first |
| Production | Hosting (not part of this setup) | The live store |

- **Code moves up only** (local → staging → production) as a versioned zip. Never push a database up to production, and don't copy real customer data to staging; staging uses the sample catalog.
- **Staging isolation** (after cloning):
  - Stripe in test mode.
  - GA measurement ID empty.
  - *Settings → Reading → Discourage search engines* on.
  - Email is caught by LocalWP. On a host's staging, block outgoing email before testing.
  - UpdraftPlus: point it to staging's own storage. The free version always uses a Drive folder named `UpdraftPlus`, so use a separate Google account per site, or backups of different sites mix.
- Plugin and WordPress updates go to staging first.
- **Security:** one admin account per person; in production, `define( 'DISALLOW_FILE_EDIT', true );` in `wp-config.php` turns off the theme and plugin file editors; no keys in Git.
- If a release needs an admin setting, its release notes say so, and it is applied by hand in each environment. Never copy a database to carry a setting.

## Release, install, rollback

**Release (developer)**

1. Change the theme in Local and bump `Version:` in `style.css`.
2. Commit, then run `git tag -a vX.Y.Z -m "..."` and `git push origin main --follow-tags`.
3. Zip the `northline-storefront` folder; the folder must be at the root of the zip. GitHub's "Source code" zip does not install.
4. Create a GitHub Release for the tag, attach the zip, and list any admin settings in the notes.
5. Validate in staging:
   - Install the release and check the home page.
   - Run Lighthouse (mobile, home page) and compare it with the previous version.
   - Test the rollback.

**Install (developer, once the store owner approves)**

1. Back up with UpdraftPlus (*Backup Now*).
2. *Appearance → Themes → Add New Theme → Upload Theme* → zip → **Replace active with uploaded**.
3. Check the home page, and apply any admin settings from the release notes.

**Rollback**

- **Theme only:** upload the previous **validated** zip the same way. From v1.1.1, that is v1.0.0 (v1.1.0 is not validated). Logo and Customizer settings are kept.
- **Database restore:** this overwrites orders placed since the backup, so use it only as a last resort.

## Responsibilities

- **Developer:** changes the theme, publishes the release, validates it in staging, then backs up each store, installs the release, and applies plugin updates after staging.
- **Store owner (one per store):** approves each update and checks the store afterwards.
