<?php
function tlp_query(){
    $current_id = get_current_user_id();
    $current_dv = get_user_meta($current_id, '_manager_id', true);
    $paged = $_POST['paged'];
    global $wpdb;
    if(current_user_can('administrator')){
        $count_danh_sach = $wpdb->get_results("
            SELECT *
            FROM {$wpdb->prefix}tk1ts_danh_sach
            ORDER BY id DESC
        ",OBJECT);
        $query_danh_sach = $wpdb->get_results("
            SELECT *
            FROM {$wpdb->prefix}tk1ts_danh_sach
            ORDER BY id DESC
            LIMIT $paged,10
        ",OBJECT);
    }elseif(current_user_can('quan-ly-don-vi')){
        $count_danh_sach = $wpdb->get_results("
            SELECT *
            FROM {$wpdb->prefix}tk1ts_danh_sach
            WHERE don_vi = {$current_id}
            ORDER BY id DESC
        ",OBJECT);
        $query_danh_sach = $wpdb->get_results("
            SELECT *
            FROM {$wpdb->prefix}tk1ts_danh_sach
            WHERE don_vi = {$current_id}
            ORDER BY id DESC
            LIMIT $paged,10
        ",OBJECT);
    }else{
        $count_danh_sach = $wpdb->get_results("
            SELECT *
            FROM {$wpdb->prefix}tk1ts_danh_sach
            WHERE nguoi_nhap = {$current_dv}
            ORDER BY id DESC
        ",OBJECT);
        $query_danh_sach = $wpdb->get_results("
            SELECT *
            FROM {$wpdb->prefix}tk1ts_danh_sach
            WHERE nguoi_nhap = {$current_dv}
            ORDER BY id DESC
            LIMIT $paged,10
        ",OBJECT);
    }
    tlp_foreach($query_danh_sach);
    $script = TLP_SCRIPTS.'/update.js';
    echo "<script src='$script'></script>";
    if(count($count_danh_sach) <= $paged){
        echo "<script>$('#btn-load-more').attr('disabled', true);</script>";
    }
    die;
}
add_action('wp_ajax_nopriv_tlp_query', 'tlp_query');
add_action('wp_ajax_tlp_query', 'tlp_query');

function tlp_search_key(){
    $search_key = handle_input($_POST['search_key']);
    $current_id = get_current_user_id();
    $current_dv = get_user_meta($current_id, '_manager_id', true);
    global $wpdb;
    if(empty($search_key)){
        if(current_user_can('administrator')){
            $query_danh_sach = $wpdb->get_results("
                SELECT *
                FROM {$wpdb->prefix}tk1ts_danh_sach
                ORDER BY id DESC
            ",OBJECT);
        }else{
            $query_danh_sach = $wpdb->get_results("
                SELECT *
                FROM {$wpdb->prefix}tk1ts_danh_sach
                WHERE don_vi = {$current_dv}
                ORDER BY id DESC
            ",OBJECT);
        }
    }else{
        if(current_user_can('administrator')){
            $query_danh_sach = $wpdb->get_results("
                SELECT *
                FROM {$wpdb->prefix}tk1ts_danh_sach
                WHERE '{$search_key}' IN (ma_so, ho_ten, cmnd)
                ORDER BY id DESC
            ",OBJECT);
        }else{
            $query_danh_sach = $wpdb->get_results("
                SELECT *
                FROM {$wpdb->prefix}tk1ts_danh_sach
                WHERE '{$search_key}' IN (ma_so, ho_ten, cmnd)
                AND don_vi = {$current_dv}
                ORDER BY id DESC
            ",OBJECT);
        }
    }
    tlp_foreach($query_danh_sach);
    $script = TLP_SCRIPTS.'/update.js';
    echo "<script src='$script'></script>";
    die;
}
add_action('wp_ajax_nopriv_tlp_search_key', 'tlp_search_key');
add_action('wp_ajax_tlp_search_key', 'tlp_search_key');

function tlp_search_donvi(){
    $search_donvi = handle_input($_POST['search_donvi']);
    $paged = $_POST['paged'];
    global $wpdb;
    if(current_user_can('administrator')){
        $count_danh_sach = $wpdb->get_results("
            SELECT *
            FROM {$wpdb->prefix}tk1ts_danh_sach
            WHERE don_vi = {$search_donvi}
            ORDER BY id DESC
        ",OBJECT);
        $query_danh_sach = $wpdb->get_results("
            SELECT *
            FROM {$wpdb->prefix}tk1ts_danh_sach
            WHERE don_vi = {$search_donvi}
            ORDER BY id DESC
            LIMIT $paged,10
        ",OBJECT);
    }
    tlp_foreach($query_danh_sach);
    $script = TLP_SCRIPTS.'/update.js';
    echo "<script src='$script'></script>";
    if(count($count_danh_sach) <= $paged){
        echo "<script>$('#btn-load-more').attr('disabled', true);</script>";
    }
    die;
}
add_action('wp_ajax_nopriv_tlp_search_donvi', 'tlp_search_donvi');
add_action('wp_ajax_tlp_search_donvi', 'tlp_search_donvi');

function tlp_foreach($query){
    if(count($query) > 0){
        foreach($query as $key => $value){
            $id = $value->id;
            $don_vi = $value->don_vi;
            $nguoi_nhap = $value->nguoi_nhap;
            $ngay_nhap = $value->ngay_nhap;
            $ma_so = $value->ma_so;
            $ho_ten = $value->ho_ten;
            $gioi_tinh = $value->gioi_tinh;
            $ngay_sinh = $value->ngay_sinh;
            $ngay_sinh = date('d/m/Y', strtotime($ngay_sinh));
            $phuong_xa = $value->phuong_xa;
            $quan_huyen = $value->quan_huyen;
            $tinh_thanh = $value->tinh_thanh;
            $cmnd = $value->cmnd;
            $muc_tien = $value->muc_tien;
            $phuong_thuc = $value->phuong_thuc;
            $noi_kcb = $value->noi_kcb;
            $noi_dung = $value->noi_dung;
            $ho_so = $value->ho_so;
            ?>
            <tr id="tlp-row-<?= $id;?>">
                <td class="width45">
                    <label class="fancy-checkbox">
                        <input class="checkbox-tick" type="checkbox" name="checkbox" value="<?= $id;?>">
                        <span></span>
                    </label>
                </td>
                <td class="tlp-col-ma-so"><span><?= $ma_so;?></span></td>
                <td class="tlp-col-ho-ten"><span><?= $ho_ten;?></span></td>
                <td class="tlp-col-ngay-sinh"><span><?= $ngay_sinh;?></span></td>
                <td class="tlp-col-cmnd"><span><?= $cmnd;?></span></td>
                <td class="tlp-col-noi-dung"><span><?= $noi_dung;?></span></td>
                <td class="tlp-col-ho-so"><span><?= $ho_so;?></span></td>
                <td class="text-center"> 
                    <button type="button" data-toggle="modal" data-target="#tlp-modal-info" val="<?= $id;?>" class="btn btn-sm btn-outline-success tlp-detail" title="Chi tiết"><i class="fa fa-eye"></i></button>
                </td>
            </tr>
            <?php
        }
    }else{
        echo "<tr><td colspan=8 class='text-center'>Không có dữ liệu để hiển thị!</td></tr>";
    }
}