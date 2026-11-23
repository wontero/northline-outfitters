Northline Storefront
Shared base for Northline client stores (WordPress + WooCommerce + Storefront).

Git versions only the child theme northline-storefront. WordPress core, plugins, uploads and the database stay out of Git (see .gitignore).

What the base includes
Child theme northline-storefront. Installable zips are in Releases, and v1.1.1 is the validated version.
Sale prices: the crossed-out old price has readable contrast.
Mobile footer search: hidden until the Search button opens it.
"Shop by Brand" home section: shown only when a brand has products, with WooCommerce's brand styles.
LocalWP Blueprint northline-base-1.0.0. A clean copy of Northline: plugins, menu, static home and Yoast templates are already set. It has no orders, customers, Stripe keys or GA ID. It lives in LocalWP on the team machine, not in Git.
Plugin baseline (below).
Rule: don't edit the child theme for one client. A client's identity (logo, colors, texts) goes in Appearance → Customize. Code for a single store would go in a plugin for that store.

Create a new store from the Blueprint
LocalWP → + → Create from a Blueprint → northline-base-1.0.0.
Users → Profile: set a new admin password, because the Blueprint carries the base admin.
Set the site title (Settings → General) and the logo (Customize → Site Identity).
Apply the per-store settings (below).
UpdraftPlus: connect this store's remote storage and run Backup Now.
The store starts with theme 1.0.0. Install the validated release zip (see Install).
Rebuild without the Blueprint
New LocalWP site: WordPress 7.1.5, PHP 8.2.
Install the Storefront 4.6.2 parent theme and the plugins below at the listed versions.
Install the validated release zip and activate it.
Admin settings:
Static home page with Storefront's Homepage template.
Menu: Home, Shop, My account.
Remove the blog widgets and the sample post/page.
Category images.
Yoast: home and shop descriptions by hand; products and categories by template.
Apply the per-store settings.
Plugin baseline
Plugin	Tested version	Why	Configure per store
WooCommerce	11.3.0	The store	Currency, shipping, taxes
WooCommerce Stripe Gateway	11.2.0	Card payments	Own Stripe account, keys, webhook
Yoast SEO	28.9	Meta descriptions per page type	Home and shop descriptions
Google Analytics for WooCommerce	2.4.4	GA4 with store and purchase events	Own measurement ID
UpdraftPlus	1.26.16	Backups to cloud storage and restore	Own remote storage
Environments
Environment	Where	For
Local	northline-outfitters.local (this repo)	Developing and committing the theme
Staging	northline-staging.local (LocalWP Clone site)	Testing every release and update first
Production	Hosting (not part of this setup)	The live store
Code moves up (local → staging → production) as a versioned zip. Data moves down (production → staging), anonymized. Never push a database up to production.
Staging isolation (after cloning):
Stripe in test mode.
GA measurement ID empty.
Settings → Reading → Discourage search engines on.
Email is caught by LocalWP.
Plugin and WordPress updates go to staging first.
If a release needs an admin setting, its release notes say so, and it is applied by hand in each environment. Never copy a database to carry a setting.
Release, install, rollback
Release (developer)

Change the theme in Local and bump Version: in style.css.
Commit, then run git tag -a vX.Y.Z -m "..." and git push origin main --follow-tags.
Zip the northline-storefront folder; the folder must be at the root of the zip. GitHub's "Source code" zip does not install.
Create a GitHub Release for the tag, attach the zip, and list any admin settings in the notes.
Validate in staging:
Install the release and check the home page.
Run Lighthouse (mobile, home page) and compare it with the previous version.
Test the rollback.
Install (store owner)

Back up with UpdraftPlus (Backup Now).
Appearance → Themes → Add New Theme → Upload Theme → zip → Replace active with uploaded.
Check the home page, and apply any admin settings from the release notes.
Rollback

Theme only: upload the previous zip the same way. Logo and Customizer settings are kept.
Database restore: this overwrites orders placed since the backup, so use it only as a last resort.
Responsibilities
Developer: changes the theme, publishes the release and validates it in staging.
Store owner (one per store): backs up, installs the validated release, applies the settings from the release notes, and applies plugin updates after staging.
