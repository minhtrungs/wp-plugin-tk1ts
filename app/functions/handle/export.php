<?php
function tlp_export_excel(){
    if(current_user_can('administrator')){
        $don_vi = is_numeric(handle_input($_POST['export_donvi']))?$_POST['export_donvi']:0;
    }else{
        $current_user = get_current_user_id();
        if(current_user_can('quan-ly-don-vi')){
            $don_vi = $current_user;
        }else $don_vi = get_user_meta($current_user, '_manager_id', true);
    }
    global $wpdb;
    $query_danh_sach = $wpdb->get_results("
        SELECT *
        FROM {$wpdb->prefix}tk1ts_danh_sach
        WHERE don_vi = {$don_vi}
        ORDER BY id DESC;
    ",OBJECT);
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->setTitle('Default');
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Ma_So')
                ->setCellValue('B1', 'Ho_Ten')
                ->setCellValue('C1', 'Gioi_Tinh(Nam 1/Nu 2)')
                ->setCellValue('D1', 'Ngay_Sinh')
                ->setCellValue('E1', 'Phuong_Xa')
                ->setCellValue('F1', 'Quan_Huyen')
                ->setCellValue('G1', 'Tinh_Thanh')
                ->setCellValue('H1', 'CMND')
                ->setCellValue('I1', 'Muc_Tien')
                ->setCellValue('J1', 'Phuong_Thuc')
                ->setCellValue('K1', 'Noi_KCB')
                ->setCellValue('L1', 'Noi_Dung')
                ->setCellValue('M1', 'Ho_So');
    $i = 2;
    if(count($query_danh_sach) > 0){
        foreach($query_danh_sach as $key => $value){
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
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $ma_so)
                ->setCellValue('B'.$i, $ho_ten)
                ->setCellValue('C'.$i, $gioi_tinh)
                ->setCellValue('D'.$i, $ngay_sinh)
                ->setCellValue('E'.$i, $phuong_xa)
                ->setCellValue('F'.$i, $quan_huyen)
                ->setCellValue('G'.$i, $tinh_thanh)
                ->setCellValue('H'.$i, $cmnd)
                ->setCellValue('I'.$i, $muc_tien)
                ->setCellValue('J'.$i, $phuong_thuc)
                ->setCellValue('K'.$i, $noi_kcb)
                ->setCellValue('L'.$i, $noi_dung)
                ->setCellValue('M'.$i, $ho_so);
            $i++;
        }
    }
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save(TLP_TEMP.'/export/Report_Data.xlsx');
    echo TLP_DIR.'temp/export/Report_Data.xlsx';
    die;
}
add_action('wp_ajax_nopriv_tlp_export_excel', 'tlp_export_excel');
add_action('wp_ajax_tlp_export_excel', 'tlp_export_excel');