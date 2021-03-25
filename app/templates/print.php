<?php
if ( is_user_logged_in() ) {
    $row_id = handle_input($_GET['view']);
    $info = new TLP_Data;
    $check = $info->read($row_id);
    if($check > 0){
        $row_dv = $info->don_vi;
        $current_id = get_current_user_id();
        $current_dv = get_user_meta($current_id, '_manager_id', true);
        if(current_user_can('administrator') || $row_dv==$current_id || $row_dv==$current_dv){
            tlp_pdf(
                $info->ma_so, 
                $info->ho_ten, 
                $info->gioi_tinh, 
                $info->ngay_sinh,
                $info->phuong_xa, 
                $info->quan_huyen, 
                $info->tinh_thanh, 
                $info->cmnd, 
                $info->muc_tien, 
                $info->phuong_thuc, 
                $info->noi_kcb, 
                $info->noi_dung, 
                $info->ho_so
            );
        }else{
            wp_redirect(home_url());
            exit;
        }
    }else{
        wp_redirect(home_url());
        exit;
    }
}else{
    wp_redirect(home_url());
    exit;
}