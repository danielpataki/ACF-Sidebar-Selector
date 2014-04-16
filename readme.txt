=== Advanced Custom Fields: Sidebar Selector Field ===
Contributors: danielpataki
Tags:
Requires at least: 3.4
Tested up to: 3.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This field allows you to select a sidebar

== Description ==

Allows the selection of a registered WordPress sidebar. Also allows for null values if needed.

= Compatibility =

This add-on will work with:

* version 4 and up
* version 3 and bellow

== Installation ==

This add-on can be treated as both a WP plugin and a theme include.

= Plugin =
1. Copy the 'acf-sidebar_selector' folder into your plugins folder
2. Activate the plugin via the Plugins admin page

= Include =
1.	Copy the 'acf-sidebar_selector' folder into your theme folder (can use sub folders). You can place the folder anywhere inside the 'wp-content' directory
2.	Edit your functions.php file and add the code below (Make sure the path is correct to include the acf-sidebar_selector.php file)

`
add_action('acf/register_fields', 'my_register_fields');

function my_register_fields()
{
	include_once('acf-sidebar_selector/acf-sidebar_selector.php');
}
`

== Changelog ==

= 1.0 =
* Initial Release.
