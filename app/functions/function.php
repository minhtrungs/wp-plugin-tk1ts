<?php
function tlp_create_db(){
    global $wpdb;
    $charset_collate  = $wpdb->get_charset_collate();
    if ( ! function_exists( 'dbDelta' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    }
    
    $table_danh_sach = $wpdb->prefix . 'tk1ts_danh_sach';
    $wpdb->tk1ts_danh_sach = $table_danh_sach;
    $danh_sach  = " CREATE TABLE IF NOT EXISTS $table_danh_sach ( ";
    $danh_sach .= " id bigint(20) unsigned NOT NULL auto_increment, ";
    $danh_sach .= " don_vi bigint(20) NOT NULL, ";
    $danh_sach .= " nguoi_nhap bigint(20) NOT NULL, ";
    $danh_sach .= " ngay_nhap date NOT NULL, ";
    $danh_sach .= " ma_so varchar(20) NOT NULL UNIQUE, ";
    $danh_sach .= " ho_ten text NOT NULL, ";
    $danh_sach .= " gioi_tinh int(1) NOT NULL, ";
    $danh_sach .= " ngay_sinh date NOT NULL, ";
    $danh_sach .= " phuong_xa text NOT NULL, ";
    $danh_sach .= " quan_huyen text NOT NULL, ";
    $danh_sach .= " tinh_thanh text NOT NULL, ";
    $danh_sach .= " cmnd varchar(20), ";
    $danh_sach .= " muc_tien bigint(20), ";
    $danh_sach .= " phuong_thuc text, ";
    $danh_sach .= " noi_kcb text, ";
    $danh_sach .= " noi_dung text, ";
    $danh_sach .= " ho_so text, ";
    $danh_sach .= " PRIMARY KEY (id), ";
    $danh_sach .= " KEY don_vi_quan_ly (don_vi), ";
    $danh_sach .= " KEY thanh_vien_nhap (nguoi_nhap) ";
    $danh_sach .= " ) $charset_collate; ";
    dbDelta( $danh_sach );
}

function tlp_delete_db(){
    global $wpdb;
    $tableArray = [
        $wpdb->prefix . 'tk1ts_danh_sach',
    ];
    foreach($tableArray as $table){
        $wpdb->query("DROP TABLE IF EXISTS $table");
    }
}

function handle_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function tlp_handle_date($date){
    $date_type = substr_count($date, '/');
    if($date_type == 2){
        $date_element = explode('/', $date);
        if($date_element[0]<1 || $date_element[0] >31) return false;
        if($date_element[1]<1 || $date_element[1] >12) return false;
        if($date_element[2]<1900 || $date_element[2] >2020) return false;
        return $date_element[2].'-'.$date_element[1].'-'.$date_element[0];
    }else return false;
}

function tlp_create_pdf_page(){
	$data_page = array(
		array(
			'name'	    =>	'PDF',
			'post_name'	=>	'pdf',
			'template'	=>	'print.php'
		)
	);
	foreach($data_page as $key => $value){		
		global $wpdb;
		$exist_page = $wpdb->get_row('SELECT ID,COUNT(ID) AS COUNT FROM '.$wpdb->prefix.'posts WHERE post_type="page" AND post_name="'.$value['post_name'].'"',ARRAY_A);
		if($exist_page['COUNT'] == 0){
			$args = array(
				'post_title'    =>  $value['name'],
				'post_name'     =>  $value['post_name'],
				'post_type'     =>  'page',
				'post_status'   =>  'publish',
				'page_template'  =>  $value['template']
			);
			$post_id = wp_insert_post($args);
		}else{
            $page_template = get_post_meta($exist_page['ID'], '_wp_page_template', true);
            if($page_template!=$value['template']){
                update_post_meta( $exist_page['ID'], '_wp_page_template', $value['template'] );
            }
        }
	}
}