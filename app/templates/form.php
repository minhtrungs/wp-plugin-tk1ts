<?php
if ( is_user_logged_in() ) {
    get_header(); 
    $dang_login = get_current_user_id();
    if(current_user_can('quan-ly-don-vi')){
        $don_vi = $dang_login;
    }else{
        $don_vi = get_user_meta($dang_login, '_manager_id', true);
    }
    ?>
    <style>
        @font-face {
            font-family: 'FontAwesome';
            src: url('<?= TLP_STYLES ?>/font-awesome/fonts/fontawesome-webfont.eot?v=4.7.0');
            src: url('<?= TLP_STYLES ?>/font-awesome/fonts/fontawesome-webfont.eot?#iefix&v=4.7.0') format('embedded-opentype'), url('<?= TLP_STYLES ?>/font-awesome/fontawesome-webfont.woff2?v=4.7.0') format('woff2'), url('<?= TLP_STYLES ?>/font-awesome/fontawesome-webfont.woff?v=4.7.0') format('woff'), url('<?= TLP_STYLES ?>/font-awesome/fontawesome-webfont.ttf?v=4.7.0') format('truetype'), url('<?= TLP_STYLES ?>/font-awesome/fontawesome-webfont.svg?v=4.7.0#fontawesomeregular') format('svg');
            font-weight: normal;
            font-style: normal
        }
    </style>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card" style="margin-top:20px;">
                    <div class="header">
                        <h2 style="font-size: 20px;"><?= the_title(); ?></h2>
                        <ul class="header-dropdown">
                            <li><button data-toggle="modal" data-target="#tlp-modal-info" class="btn btn-success tlp-add-new"><i class="fa fa-plus-circle"></i><span> Thêm mới</span></button></li>
                            <li><button data-toggle="modal" data-target="#tlp-modal-import" class="btn btn-primary"><i class="fa fa-database"></i><span> Nhập từ Excel</span></button></li>
                            <li><button data-toggle="modal" data-target="#tlp-modal-export" class="btn btn-info"><i class="fa fa-download"></i><span> Xuất ra Excel</span></button></li>
                            <li><?php tlp_logout(); ?></li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="tlp-search-contain">
                            <?php if(current_user_can('administrator')){ ?>
                            <form id="tlp-search-donvi" class="navbar-form donvi-form" method="POST" action="<?php echo admin_url('admin-ajax.php')?>">
                                <select class=" form-control search-donvi focus">
                                    <option value="">Đơn vị</option>
                                    <?php
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
                                    ?>
                                </select>
                            </form>
                            <button style="margin-left: 20px" class="btn btn-outline-danger delete-all">
                                <span>Xóa hàng loạt</span>
                            </button>
                            <?php }elseif(current_user_can('quan-ly-don-vi')){ ?>
                                <button class="btn btn-outline-danger delete-all">
                                    <span>Xóa hàng loạt</span>
                                </button>
                            <?php } ?>
                            <form id="tlp-search-key" class="navbar-form search-form" method="POST" action="<?php echo admin_url('admin-ajax.php')?>">
                                <input class="form-control search-key" placeholder="Nhập từ khóa..." type="text" style="width: 218px;">
                                <button type="submit" class="btn btn-default"><i class="icon-magnifier"></i></button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example dataTable table-custom table-striped m-b-0 c_list">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>
                                            <label class="fancy-checkbox">
                                                <input class="select-all" type="checkbox" name="checkbox-all">
                                                <span></span>
                                            </label>
                                        </th>
                                        <th>Mã số</th>
                                        <th>Họ tên</th>
                                        <th>Ngày sinh</th>
                                        <th>CMND</th>
                                        <th>Nội dung</th>
                                        <th>Hồ sơ</th>
                                        <th class="text-center">Chi tiết</th>
                                    </tr>
                                </thead>
                                <tbody id="tlp-table-body">
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button id="btn-load-more" class="btn btn-primary" >Xem thêm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tlp-loading">
        <div class="sk-chase">
            <?php for($i=1; $i<=6; $i++){echo '<div class="sk-chase-dot"></div>';}?>
        </div>
    </div>
    <script>
        var ajaxUrl = "<?php echo admin_url('admin-ajax.php')?>";
        jQuery(document).ready(function($){
            $.post( ajaxUrl, {
                action: "tlp_query",
                paged: 0
            }).done(function( data ) {
                $('#tlp-table-body').empty();
                $('#tlp-table-body').html(data);
                $('.tlp-loading').hide();
            });
            $('.delete-all').click(function(event) {
                $('.tlp-loading').show();
                var selected = [];
                $.each($("input[name='checkbox']:checked"), function(){
                    selected.push($(this).val());
                });
                // alert("My favourite sports are: " + selected.join(", "));
                if(selected.length == 0){
                    alert('Cần chọn ít nhất 1 dòng!');
                    $('.tlp-loading').hide();
                }else{
                    $.post( ajaxUrl, {
                        action: 'tlp_delete_all',
                        selected: selected
                    }).done(function( data ) {
                        $('#tlp-table-body').append(data);
                        $('.tlp-loading').hide();
                    });
                    $('.tlp-loading').hide();
                }
            });
            var paged = 10;
            $('#btn-load-more').click(function(event) {
                $('.tlp-loading').show();
                var search_donvi = $('.search-donvi').val();
                if(search_donvi==''){
                    var action = "tlp_query";
                }else{
                    var action = "tlp_search_donvi";
                }
                $.post( ajaxUrl, {
                    action: action,
                    search_donvi: search_donvi,
                    paged: paged
                }).done(function( data ) {
                    $('#tlp-table-body').append(data);
                    $('.tlp-loading').hide();
                    paged = paged + 10;
                });
            });
        });
    </script>
    <?php
    require_files( '/app/templates/template-part', array('info', 'import', 'export') );
    tlp_create_pdf_page();
    get_footer();
}else tlp_login();