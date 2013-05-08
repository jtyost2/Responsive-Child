<?php
//Define Constants
define('RESPONSIVE_CHILD_TEMPLATE_DIR', plugin_dir_path(__FILE__));
define('RESPONSIVE_CHILD_TEMPLATE_PATH', plugin_dir_path(__FILE__));
define('RESPONSIVE_CHILD_TEMPLATE_URI', get_stylesheet_directory_uri());

define('RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_FIELD', 'responsive_child_options');
define('RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS', 'responsive_child_theme_options');
define('RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE', 'responsive_child');


//Setup Custom Options
include_once(RESPONSIVE_CHILD_TEMPLATE_PATH."/library/responsive_child_theme_custom_options.php");
if (class_exists('ResponsiveChildThemeCustomOptions')) {
	$_ResponsiveChildThemeCustomOptions = new ResponsiveChildThemeCustomOptions();
}

//Setup Custom Posts
include_once(RESPONSIVE_CHILD_TEMPLATE_PATH."/library/responsive_child_theme_custom_posts.php");
if (class_exists('ResponsiveChildThemeCustomPosts')) {
	$_ResponsiveChildThemeCustomPosts = new ResponsiveChildThemeCustomPosts();
}

//Setup Custom Display Features
include_once(RESPONSIVE_CHILD_TEMPLATE_PATH."/library/responsive_child_theme_custom_display.php");
if (class_exists('ResponsiveChildThemeCustomDisplay')) {
	$_ResponsiveChildThemeCustomDisplay = new ResponsiveChildThemeCustomDisplay();
}

//Setup Hubinfo Button
include_once(RESPONSIVE_CHILD_TEMPLATE_PATH."/library/responsive_child_hubinfo_button.php");
if (class_exists('ResponsiveChildHubinfoButton')) {
	$_ResponsiveChildHubinfoButton = new ResponsiveChildHubinfoButton();
}

?>