=== Businessx Extensions ===

Contributors: acosmin
Tags:
Requires at least: 4.5
Tested up to: 5.0
Stable tag: 1.0.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds sections and new features to Businessx WordPress theme. 12 sections Slider, Features, About Us, Team, Clients, Portfolio, Actions, Testimonials, Pricing, FAQ, Hero, Blog) are included to make your homepage look awesome.

== Description ==

Adds sections and new features to Businessx WordPress theme. 14 sections (Slider, Features, About Us, Team, Clients, Portfolio, Actions, Testimonials, Pricing, FAQ, Hero, Blog, Contact, Google Map) are included to make your homepage look awesome. You can download <a href="http://www.acosmin.com/theme/businessx/?utm_source=wporg&utm_medium=readme&utm_campaign=bx_plugin_page" title="Download Businessx WordPress Theme" rel="friend">Businessx WordPress theme</a> from here.

== Changelog ==

= 1.0.6 =
* Fixed Jetpack converting GMap iframes to shortcodes and the section not displaying them.
* Fixed typo in FAQ section.
* Fixed Portfolio button not displaying the correct label.
* Remade the Sections drag & drop functionality, now it triggers the Publish/Save Draft button (also works with drafts).
* Remade the `Insert Front Page` modal, it uses Magnific Popup now.

= 1.0.5 =
* Added two new sections, Contact and Google Map.
* Added Polylang support, you can now go to `Customizer > Settings > Extensions` to enable it.
* Added link options for some widgets that use images (Clients for example, you can add a link on the logo).
* Added a button to the Portfolio and Blog section, you can link to some pages if you want.
* New escaping/sanitization for some sections, making it posible to add more html tags (section descriptions for example).
* Removed parallax.js usage for sections, it now uses simple CSS parallax.
* Remade the JS part for most of the plugin.
* Remade the sections and widgets to use actions and filters.
* Fixed repeating fields for the Team and Pricing widgets.
* Fixed Team section widget to keep the underline if the position is empty.
* Fixed placeholder text for each section

= 1.0.4.2 =
* Changed how the plugin behaves when the theme isn't activated. Now it will not disable automatically.

= 1.0.4.1 =
* Fixed compatibility issues with WordPress v4.7.
* Added a modal window asking if you want to add a static front page, helping users skip a few steps.
* Changed the name of "Sections" panel to "Front Page Sections".

= 1.0.3.1 =
* Added option to show/hide slider navigation arrows.
* Added option to remove helping/placeholder messages for all sections.
* Added function_exists checks for all functions.
* Moved businessx_section_parallax() from theme to plugin.
* Moved $businessx_icons_simple global from theme to plugin.
* Updated .po files.

= 1.0.2.3 =
* Fixed Testimonials displaying placeholder text.
* Changed defined version.

= 1.0.2.2 =
* Fixed problem with .org SVN

= 1.0.2 =
* Created functions folder and helpers.php file. Also, required it in businessx-extensions.php.
* Movde hero/slider options from theme to plugin, in helpers.php.
* Added check for Jetpack's Mobile Theme module.
* Output notice if Jetpack's Mobile Theme is active. Businessx isn't compatible with this module, the theme is already responsive.
* Changed thumbnail's prefix name in section-blog.php.

= 1.0.1 =
* Fixed - jQuery Syntax Error in customizer.
* Fixed - FAQ Section displaying a placeholder message even after adding an item.
* Fixed - Minor bugs.

= 1.0.0 =
* Initial release.
