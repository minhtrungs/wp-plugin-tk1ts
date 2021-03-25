<div class="modal animated zoomIn" id="tlp-modal-export" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
    <form id="tlp-form-export" method="POST" action="<?php echo admin_url('admin-ajax.php')?>" class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel">Xuất ra Excel</h6>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            $current_user = get_current_user_id();
                            if(current_user_can('quan-ly-don-vi')){
                                $don_vi = $current_user;
                            }else $don_vi = get_user_meta($current_user, '_manager_id', true);
                            $don_vi_info = get_user_by('id', $don_vi);
                            $ten_don_vi = $don_vi_info->display_name;
                            if(current_user_can('administrator')){
                                echo "<select class='form-control tlp-export-donvi focus'>";
                                    echo "<option value=''>Chọn đơn vị</option>";
                                    $args_user = array (
                                        'role__in' 	=> array('quan-ly-don-vi'),
                                        'order' 	=> 'ASC'
                                    );
                                    $wp_user_query = new WP_User_Query($args_user);
                                    $manager_users = $wp_user_query->get_results();
                                    if(!empty($manager_users)){
                                        foreach ($manager_users as $manager_user){
                                            $manager_id = $manager_user->ID;
                                            $manager_name = $manager_user->display_name;
                                            echo "<option value='$manager_id'>$manager_name</option>";
                                        }
                                    }
                                echo "</select>";
                            }else{
                                echo "<small class='form-text text-muted'>Xuất ra danh sách của <b>$ten_don_vi</b>.</small>";
                            }?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="tlp-submit-export" class="btn btn-primary">Xuất</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </form>
</div>