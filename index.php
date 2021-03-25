<?php
/*
Plugin Name: TK1-TS
Version: 2.0.4
Description: 
Author: Lê Minh Trung
Author URI: PHP Dev
Edited 2.0.3: Phân trang và thêm label cho form
Edited 2.0.4: Xóa hàng loạt
*/

define( 'TLP_VERSION', 	'2.0.4');
define( 'TLP_DIR',		plugin_dir_url(__FILE__) );
define( 'TLP_ROOT',		plugin_dir_path(__FILE__) );
define( 'TLP_TEMP',  	TLP_ROOT . 'temp' );
define( 'TLP_IMAGES',  	TLP_DIR . 'images' );
define( 'TLP_SCRIPTS', 	TLP_DIR . 'js' );
define( 'TLP_STYLES',  	TLP_DIR . 'css' );

if (! function_exists( 'require_files' ) ){
	function require_files($folder, $files_require){
		foreach ( $files_require as $file ) {
			$path = TLP_ROOT . $folder . '/' . $file . '.php';
			if( file_exists( $path ) ) {
				require $path;
			}
		}
	}
}

$files = array(
	'Frontend',
	'Data',
	'Template',
	'Auth',
	'Excel',
	'PDF',
	'functions/function',
	'functions/auth',
	'functions/data',
	'functions/handle/info',
	'functions/handle/query',
	'functions/handle/import',
	'functions/handle/export',
	'functions/handle/pdf',
);
require_files( '/app', $files );

register_activation_hook( __FILE__, 'after_active' );
function after_active() { 
	$roles = array(
		'truc-thuoc-don-vi' => 'Trưc thuộc đơn vị',
		'quan-ly-don-vi' 	=> 'Quản lý đơn vị',
	);
	foreach($roles as $key => $name){
		if(empty(get_role($key))){
			add_role($key, $name);
		}
	}
	tlp_create_db();
}

$template = new TLP_Template;
$template->handle();
$auth = new TLP_Auth;
$auth->handle();
