<?php
function tlp_import_excel(){
    echo "<script>";
    if($_FILES) {
        $target_file = TLP_TEMP.'/import/' . basename($_FILES["file_upload"]["name"]);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if(file_exists($target_file)){
            unlink($target_file);
            echo "$('.tlp-notice-import').html('Đã xảy ra lỗi, hãy thử lại!');";
        }elseif($fileType == "xls" || $fileType == "xlsx"){
            move_uploaded_file($_FILES["file_upload"]["tmp_name"], $target_file);
            if ($fileType == 'xlsx') {
                $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            }else if ($fileType == 'xls'){
                $objReader = PHPExcel_IOFactory::createReader('Excel5');
            }
            $objPHPExcel = $objReader->load($target_file, $encode = 'utf-8');
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $A1 = $objPHPExcel->getActiveSheet()->getCell("A1")->getValue();
            $D1 = $objPHPExcel->getActiveSheet()->getCell("D1")->getValue();
            $H1 = $objPHPExcel->getActiveSheet()->getCell("H1")->getValue();
            if($A1!='Ma_So'||$D1!='Ngay_Sinh'||$H1!='CMND'){
                echo "$('.tlp-notice-import').html('Dữ liệu không đúng định dạng. Hãy dùng và giữ nguyên định dạng của file mẫu admin cung cấp!');";
            }else{
                $data = new TLP_Data;
                $success_count = 0;
                $real_row = $highestRow-1;
                $error_row = '';
                for($i=2; $i <= $highestRow; $i++){
                    $ma_so = $objPHPExcel->getActiveSheet()->getCell("A" .$i)->getValue();
                    $ho_ten = $objPHPExcel->getActiveSheet()->getCell("B" .$i)->getValue();
                    $gioi_tinh = $objPHPExcel->getActiveSheet()->getCell("C" .$i)->getValue();
                    $ngay_sinh = $objPHPExcel->getActiveSheet()->getCell("D" .$i)->getFormattedValue();
                    $ngay_sinh = tlp_handle_date($ngay_sinh);
                    $phuong_xa = $objPHPExcel->getActiveSheet()->getCell("E" .$i)->getValue();
                    $quan_huyen = $objPHPExcel->getActiveSheet()->getCell("F" .$i)->getValue();
                    $tinh_thanh = $objPHPExcel->getActiveSheet()->getCell("G" .$i)->getValue();
                    $cmnd = $objPHPExcel->getActiveSheet()->getCell("H" .$i)->getValue();
                    $muc_tien = $objPHPExcel->getActiveSheet()->getCell("I" .$i)->getValue();
                    $phuong_thuc = $objPHPExcel->getActiveSheet()->getCell("J" .$i)->getValue();
                    $noi_kcb = $objPHPExcel->getActiveSheet()->getCell("K" .$i)->getValue();
                    $noi_dung = $objPHPExcel->getActiveSheet()->getCell("L" .$i)->getValue();
                    $ho_so = $objPHPExcel->getActiveSheet()->getCell("M" .$i)->getValue();
                    $data->set(0, $ma_so, $ho_ten, $gioi_tinh, $ngay_sinh, $phuong_xa, $quan_huyen, $tinh_thanh, $cmnd, $muc_tien, $phuong_thuc, $noi_kcb, $noi_dung, $ho_so);
                    $validate = $data->validate();
                    if($validate['validate'] != true){
                        $add = $data->add();
                        if($add == true) $success_count++;
                        else $error_row .= $i.', ';
                    }else $error_row .= $i.', ';
                }
                echo "$('.tlp-notice-import').html('Đã nhập thành công $success_count/$real_row');";
                if(!empty($error_row))  echo "$('.tlp-error-import').html('Hãy kiểm tra lại các dòng lỗi: $error_row');";
                echo "$(document).ready(function($){
                    $.post( ajaxUrl, {
                        action: 'tlp_query',
                    }).done(function( data ) {
                        $('#tlp-table-body').empty();
                        $('#tlp-table-body').html(data);
                        $('.tlp-loading').hide();
                    });
                });";
            }
            unlink($target_file);
        }else{
            echo "$('.tlp-notice-import').html('Hệ thống chỉ chấp nhận file Excel!');";
        }
    }else{
        echo "$('.tlp-notice-import').html('Chưa chọn file Excel!');";
    }
    echo "</script>";
    die;
}
add_action('wp_ajax_nopriv_tlp_import_excel', 'tlp_import_excel');
add_action('wp_ajax_tlp_import_excel', 'tlp_import_excel');