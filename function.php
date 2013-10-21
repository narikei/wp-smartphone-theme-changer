<?php
/*
Plugin Name: SmartPhone theme changer
Description: スマートフォンからのアクセス時にスマートフォン専用テーマに切り替えて表示
Plugin URI: https://github.com/narikei/smartphone-theme-changer
Author: narikei
Author URI: http://narikei.ozonicsky.com
Version: 0.1
*/

add_action('admin_menu', 'add_adminMenu');

$sp_flg = wp_is_mobile();
if ($sp_flg) {
	add_filter('stylesheet', 'smartphomeTheme');
}


function add_adminMenu() {
	add_submenu_page('themes.php', 'SmartPhone theme changer', '専用テーマ変更', 'administrator', 'smartphone-theme-changer', 'adminPage');
}


function adminPage() {
	if (isset($_POST['theme'])) {
		update_option('smartphome-theme', $_POST['theme']);
	}
	$smartphometheme = get_option('smartphome-theme');
	
	echo '<h1>スマートフォン専用テーマ変更</h1>';
	$themes = get_themes();
	if (count($themes) >= 1) {
		echo '<form method="post">';
		
		$theme_names = array_keys($themes);
		
		foreach ($theme_names as $v) {
			if ($smartphometheme == $v)
			{
				echo '<label><input type="radio" name="theme" value="'.$v.'" checked>'.$v.'</label>';
			} else {
				echo '<label><input type="radio" name="theme" value="'.$v.'">'.$v.'</label>';
			}
			echo '<br>';
		}
		
		echo '<input type="submit" value="切り替え">';
		echo '</form>';
	} else {
		echo 'インストールされているテーマがありません';
	}
	
}


function smartphomeTheme(){
	$smartphometheme = get_option('smartphome-theme');
	$themes = get_themes();
	foreach ($themes as $v) {
		if ($v['Name'] == $smartphometheme) {
			return $v['Stylesheet'];
		}
	}
}
