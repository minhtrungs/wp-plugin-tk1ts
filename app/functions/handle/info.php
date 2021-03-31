<?php session_start();
function get_update_info(){
    $row_id = handle_input($_POST['row_id']);
    $row_id = is_numeric($row_id) ? $row_id : 0;
    $user_id = get_current_user_id();
    $don_vi = get_user_meta($user_id, '_manager_id', true);
    $info = new TLP_Data;
    $info->read($row_id);
    $info_don_vi = $info->don_vi;
    $ngay_sinh = $info->ngay_sinh;
    $ngay_sinh = date('d/m/Y', strtotime($ngay_sinh));
    echo "<script>";
    echo "$('.tlp-ma-so').val('$info->ma_so');";
    echo "$('.tlp-ho-ten').val('$info->ho_ten');";
    echo "$('.tlp-gioi-tinh').val('$info->gioi_tinh');";
    echo "$('.tlp-ngay-sinh').val('$ngay_sinh');";
    echo "$('.tlp-phuong-xa').val('$info->phuong_xa');";
    echo "$('.tlp-quan-huyen').val('$info->quan_huyen');";
    echo "$('.tlp-tinh-thanh').val('$info->tinh_thanh');";
    echo "$('.tlp-cmnd').val('$info->cmnd');";
    echo "$('.tlp-muc-tien').val('$info->muc_tien');";
    echo "$('.tlp-phuong-thuc').val('$info->phuong_thuc');";
    echo "$('.tlp-noi-kcb').val('$info->noi_kcb');";
    echo "$('.tlp-noi-dung').val('$info->noi_dung');";
    echo "$('.tlp-ho-so').val('$info->ho_so');";
    echo "$('.tlp-print').remove();";
    $print_btn = '<button type="button" class="btn btn-outline-secondary tlp-print" onclick="tlpPrint()"><i class="fa fa-print"></i> In</button>';
    echo "$('#tlp-submit-info').before('$print_btn');";
    if($info_don_vi===$don_vi||$info_don_vi===$user_id){
        $_SESSION['current_id'] = $row_id;
        if(current_user_can('quan-ly-don-vi')){
            echo "$('.tlp-delete').remove();";
            $delete_btn = '<button type="button" class="btn btn-danger tlp-delete">Xóa</button>';
            echo "$('#tlp-submit-info').after('$delete_btn');";
        }
        echo "$('#tlp-title-info').html('Chi tiết');";
        echo "$('#tlp-submit-info').removeClass('btn-danger');";
        echo "$('#tlp-submit-info').html('Cập nhật');";
        echo "$('.tlp-id').val('$row_id');";
    }else{
        echo "$('.tlp-delete').remove();";
        echo "$('#tlp-title-info').html('Chi tiết');";
        echo "$('#tlp-submit-info').addClass('btn-danger');";
        echo "$('#tlp-submit-info').html('Bạn không có quyền sửa người này');";
        echo "$('.tlp-id').val('0');";
    }
    echo "$('.tlp-reset').remove();";
    echo "$('.tlp-notice-info').html('');";
    echo "$('.tlp-ma-so').removeClass('parsley-error');";
    echo "$('.tlp-ma-so-error').html('');";
    echo "$('.tlp-ho-ten').removeClass('parsley-error');";
    echo "$('.tlp-gioi-tinh').removeClass('parsley-error');";
    echo "$('.tlp-gioi-tinh-error').html('');";
    echo "$('.tlp-ngay-sinh').removeClass('parsley-error');";
    echo "$('.tlp-ngay-sinh-error').html('');";
    echo "$('.tlp-phuong-xa').removeClass('parsley-error');";
    echo "$('.tlp-quan-huyen').removeClass('parsley-error');";
    echo "$('.tlp-tinh-thanh').removeClass('parsley-error');";
    echo "</script>";
    ?>
    <script>
    $('.tlp-delete').click(function(){
		var xac_nhan = confirm("Bạn có chắc chắn muốn xóa người này khỏi danh sách?");
		if (xac_nhan == true) {
            var xac_nhan2 = confirm("Thông tin này sẽ bị xóa hoàn toàn, không thể khôi phục lại được. Nếu đã chắc chắn, hãy nhấn OK để xác nhận lại một lần nữa.");
            if(xac_nhan2 == true){
                $('.tlp-loading').show();
                var tlp_id = $('.tlp-id').val();
                $.post( ajaxUrl, {
                    action: "delete_info",
                    tlp_id: tlp_id
                }).done(function( data ) {
                    $('#tlp-handle-info').remove();
                    $('#tlp-form-info').after('<div id ="tlp-handle-info">' + data + '</div>');
                    $('#tlp-handle-info').remove();
                    $('.tlp-loading').hide();
                });
            }
		}
	});
    function tlpPrint(){
        window.open('<?= home_url("pdf?view=$row_id");?>', '_blank');
    }
    </script>
    <?php
    die;
}
add_action('wp_ajax_nopriv_get_update_info', 'get_update_info');
add_action('wp_ajax_get_update_info', 'get_update_info');

function get_new_info(){
    $_SESSION['current_id'] = 0;
    echo "<script>";
    echo "$('.tlp-id').val('0');";
    echo "$('.tlp-delete').remove();";
    echo "$('.tlp-print').remove();";
    echo "$('#tlp-submit-info').removeClass('btn-danger');";
    echo "$('#tlp-form-info').trigger('reset');";
    echo "$('#tlp-title-info').html('Thêm mới');";
    echo "$('#tlp-submit-info').html('Thêm');";
    echo "$('.tlp-notice-info').html('');";
    echo "$('.tlp-ma-so').removeClass('parsley-error');";
    echo "$('.tlp-ma-so-error').html('');";
    echo "$('.tlp-ho-ten').removeClass('parsley-error');";
    echo "$('.tlp-gioi-tinh').removeClass('parsley-error');";
    echo "$('.tlp-gioi-tinh-error').html('');";
    echo "$('.tlp-ngay-sinh').removeClass('parsley-error');";
    echo "$('.tlp-ngay-sinh-error').html('');";
    echo "$('.tlp-phuong-xa').removeClass('parsley-error');";
    echo "$('.tlp-quan-huyen').removeClass('parsley-error');";
    echo "$('.tlp-tinh-thanh').removeClass('parsley-error');";
    if($_SESSION['current_id'] == 0){
        echo "$('.tlp-reset').remove();";
        $reset_btn = '<button type="button" class="btn btn-success tlp-reset">Xóa trắng</button>';
        echo "$('#tlp-submit-info').after('$reset_btn');";
    }
    echo "</script>";
    ?>
    <script>
    $('.tlp-reset').click(function(){
		document.getElementById("tlp-form-info").reset();
	});
    </script>
    <?php
    die;
}
add_action('wp_ajax_nopriv_get_new_info', 'get_new_info');
add_action('wp_ajax_get_new_info', 'get_new_info');

function handle_info(){
    $current_id = $_SESSION['current_id'];
    $selected_id = handle_input($_POST['tlp_id']);
    $selected_id = is_numeric($selected_id) ? $selected_id : 0;
    $tlp_ma_so = handle_input($_POST['tlp_ma_so']);
    $tlp_ho_ten = handle_input($_POST['tlp_ho_ten']);
    $tlp_gioi_tinh = handle_input($_POST['tlp_gioi_tinh']);
    $tlp_ngay_sinh = handle_input($_POST['tlp_ngay_sinh']);
    $tlp_phuong_xa = handle_input($_POST['tlp_phuong_xa']);
    $tlp_quan_huyen = handle_input($_POST['tlp_quan_huyen']);
    $tlp_tinh_thanh = handle_input($_POST['tlp_tinh_thanh']);
    $tlp_cmnd = handle_input($_POST['tlp_cmnd']);
    $tlp_muc_tien = handle_input($_POST['tlp_muc_tien']);
    $tlp_phuong_thuc = handle_input($_POST['tlp_phuong_thuc']);
    $tlp_noi_kcb = handle_input($_POST['tlp_noi_kcb']);
    $tlp_noi_dung = handle_input($_POST['tlp_noi_dung']);
    $tlp_ho_so = handle_input($_POST['tlp_ho_so']);
    $tlp_info = new TLP_Data;
    $tlp_info->set(
        $current_id,
        $tlp_ma_so,
        $tlp_ho_ten,
        $tlp_gioi_tinh,
        $tlp_ngay_sinh,
        $tlp_phuong_xa,
        $tlp_quan_huyen,
        $tlp_tinh_thanh,
        $tlp_cmnd,
        $tlp_muc_tien,
        $tlp_phuong_thuc,
        $tlp_noi_kcb,
        $tlp_noi_dung,
        $tlp_ho_so
    );
    echo "<script>";
    if($selected_id==$current_id){
        $validate = $tlp_info->validate();
        if($validate['validate'] == true){
            if($validate['info_role'] == true){
                echo "$('.tlp-notice-info').html('Bạn không có quyền thực hiện tác vụ này!');";
            }else echo "$('.tlp-notice-info').html('');";

            if($validate['ma_so_require'] == true){
                echo "$('.tlp-ma-so').addClass('parsley-error');";
                echo "$('.tlp-ma-so-error').html('');";
            }else{
                echo "$('.tlp-ma-so').removeClass('parsley-error');";
                if($validate['ma_so_exist'] == true){
                    echo "$('.tlp-ma-so-error').html('Trùng mã');";
                }else echo "$('.tlp-ma-so-error').html('');";
            }
            if($validate['ho_ten_require'] == true){
                echo "$('.tlp-ho-ten').addClass('parsley-error');";
            }else echo "$('.tlp-ho-ten').removeClass('parsley-error');";

            if($validate['gioi_tinh_require'] == true){
                echo "$('.tlp-gioi-tinh').addClass('parsley-error');";
                echo "$('.tlp-gioi-tinh-error').html('');";
            }else{
                echo "$('.tlp-gioi-tinh').removeClass('parsley-error');";
                if($validate['gioi_tinh_format'] == true){
                    echo "$('.tlp-gioi-tinh-error').html('Lỗi html');";
                }else echo "$('.tlp-gioi-tinh-error').html('');";
            }

            if($validate['ngay_sinh_require'] == true){
                echo "$('.tlp-ngay-sinh').addClass('parsley-error');";
                echo "$('.tlp-ngay-sinh-error').html('');";
            }else{
                echo "$('.tlp-ngay-sinh').removeClass('parsley-error');";
                if($validate['ngay_sinh_format'] == true){
                    echo "$('.tlp-ngay-sinh-error').html('Ngày không hợp lệ');";
                }else echo "$('.tlp-ngay-sinh-error').html('');";
            }
            if($validate['phuong_xa_require'] == true){
                echo "$('.tlp-phuong-xa').addClass('parsley-error');";
            }else echo "$('.tlp-phuong-xa').removeClass('parsley-error');";

            if($validate['quan_huyen_require'] == true){
                echo "$('.tlp-quan-huyen').addClass('parsley-error');";
            }else echo "$('.tlp-quan-huyen').removeClass('parsley-error');";

            if($validate['tinh_thanh_require'] == true){
                echo "$('.tlp-tinh-thanh').addClass('parsley-error');";
            }else echo "$('.tlp-tinh-thanh').removeClass('parsley-error');";
        }else{
            $tlp_ngay_sinh = date('d/m/Y', strtotime($tlp_ngay_sinh));
            if($current_id==0){
                $tlp_add_info = $tlp_info->add();            
                if($tlp_add_info==true){
                    echo "$('.tlp-notice-info').html('Thêm thành công!');";
                    echo "$(document).ready(function($){
                        $('#btn-load-more').attr('disabled', false);
                        $.post( ajaxUrl, {
                            action: 'tlp_query',
                            paged: 0
                        }).done(function( data ) {
                            $('#tlp-table-body').empty();
                            $('#tlp-table-body').html(data);
                            $('.tlp-loading').hide();
                        });
                    });";
                }else echo "$('.tlp-notice-info').html('Thêm thất bại!');";
            }else{
                $tlp_update_info = $tlp_info->update($current_id);            
                if($tlp_update_info==true){
                    echo "$('.tlp-notice-info').html('Cập nhật thành công!');";
                    echo "$('#tlp-row-$current_id > .tlp-col-ho-ten').html('<span>$tlp_ho_ten</span>');";
                    echo "$('#tlp-row-$current_id > .tlp-col-ma-so').html('<span>$tlp_ma_so</span>');";
                    echo "$('#tlp-row-$current_id > .tlp-col-ngay-sinh').html('<span>$tlp_ngay_sinh</span>');";
                    echo "$('#tlp-row-$current_id > .tlp-col-cmnd').html('<span>$tlp_cmnd</span>');";
                    echo "$('#tlp-row-$current_id > .tlp-col-noi-dung').html('<span>$tlp_noi_dung</span>');";
                    echo "$('#tlp-row-$current_id > .tlp-col-ho-so').html('<span>$tlp_ho_so</span>');";                    
                }else echo "$('.tlp-notice-info').html('Không có gì thay đổi, cập nhật thất bại!');";
            }
            echo "$('.tlp-ma-so').removeClass('parsley-error');";
            echo "$('.tlp-ma-so-error').html('');";
            echo "$('.tlp-ho-ten').removeClass('parsley-error');";
            echo "$('.tlp-gioi-tinh').removeClass('parsley-error');";
            echo "$('.tlp-gioi-tinh-error').html('');";
            echo "$('.tlp-ngay-sinh').removeClass('parsley-error');";
            echo "$('.tlp-ngay-sinh-error').html('');";
            echo "$('.tlp-phuong-xa').removeClass('parsley-error');";
            echo "$('.tlp-quan-huyen').removeClass('parsley-error');";
            echo "$('.tlp-tinh-thanh').removeClass('parsley-error');";
        }
    }else{
        echo "alert('Đã có lỗi xảy ra, hệ thống sẽ tự động tải lại để sửa lỗi!');";
        echo "location.reload();";
    }
    echo "</script>";
    die;
}
add_action('wp_ajax_nopriv_handle_info', 'handle_info');
add_action('wp_ajax_handle_info', 'handle_info');

function delete_info(){
    $current_id = $_SESSION['current_id'];
    $selected_id = handle_input($_POST['tlp_id']);
    $selected_id = is_numeric($selected_id) ? $selected_id : 0;
    echo "<script>";
    if($selected_id==$current_id){
        $tlp_info = new TLP_Data;
        $tlp_info->read($current_id);
        $tlp_delete = $tlp_info->delete();
        if($tlp_delete==true){
            echo "alert('Xóa thành công!');";
            echo "$('#tlp-row-$current_id').remove();";
        }else{
            echo "alert('Đã có lỗi xảy ra, xóa thất bại!');";
        }
        echo "$('#tlp-modal-info').modal('hide');";
    }else{
        echo "alert('Đã có lỗi xảy ra, hệ thống sẽ tự động tải lại để sửa lỗi!');";
        echo "location.reload();";
    }
    echo "</script>";
    
    die;
}
add_action('wp_ajax_nopriv_delete_info', 'delete_info');
add_action('wp_ajax_delete_info', 'delete_info');

function tlp_delete_all(){
    $selected = $_POST['selected'];
    foreach($selected as $value){
        $selected_id = $value;
        $selected_id = is_numeric($selected_id) ? $selected_id : 0;
        echo "<script>";
        if($selected_id){
            $tlp_info = new TLP_Data;
            $tlp_info->read($selected_id);
            $ten = $tlp_info->ho_ten;
            $tlp_delete = $tlp_info->delete();
            if($tlp_delete==true){
                echo "$('#tlp-row-$selected_id').remove();";
            }else{
                echo "alert('Đã có lỗi xảy ra, xóa thất bại $ten!');";
            }
            echo "$('#tlp-modal-info').modal('hide');";
        }else{
            echo "alert('Đã có lỗi xảy ra, hệ thống sẽ tự động tải lại để sửa lỗi!');";
            echo "location.reload();";
        }
        echo "</script>";
    }
    die;
}
add_action('wp_ajax_nopriv_tlp_delete_all', 'tlp_delete_all');
add_action('wp_ajax_tlp_delete_all', 'tlp_delete_all');