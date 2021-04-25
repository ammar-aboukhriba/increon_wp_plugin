<?php
/**
 * Plugin Name:       Increon Users
 * Plugin URI:        https://github.com/flashpack
 * Description:       WordPress-Users in tabellarischer Form
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Ammar Aboukhriba
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 **/

if(! defined('ABSPATH')){
	die();
}
require plugin_dir_path( __FILE__ ) . 'includes/IncreonUserPlugin.php';


$increonUserPlugin = new IncreonUserPlugin(plugin_dir_path(__FILE__));
$increonUserPlugin->register();
register_activation_hook(__FILE__, [$increonUserPlugin,'activate']);
register_deactivation_hook(__FILE__, [$increonUserPlugin,'deactivate']);



?>