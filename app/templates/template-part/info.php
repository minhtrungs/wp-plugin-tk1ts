<div class="modal animated zoomIn" id="tlp-modal-info" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="tlp-form-info" method="POST" action="<?php echo admin_url('admin-ajax.php')?>" class="modal-content">
            <div class="modal-header">
                <h6 id="tlp-title-info" class="title">Chi tiết</h6>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5 class="tlp-notice-info text-danger text-center"></h5>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="ma-so" class="field__label">Mã số</label>
                            <input type="text" name="ma-so"class="tlp-ma-so form-control" placeholder="Mã số">
                            <span class='tlp-ma-so-error text-danger'></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">  
                            <label for="ho-ten" class="field__label">Họ tên</label>   
                            <input type="text" name="ho-ten" class="tlp-ho-ten form-control" placeholder="Họ tên">
                        </div>
                    </div>  
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="gioi-tinh" class="field__label">Giới tính</label>
                            <select name="gioi-tinh" class="tlp-gioi-tinh form-control">
                                <option value="">Giới tính</option>
                                <option value="1">Nam</option>
                                <option value="2">Nữ</option>
                            </select>
                            <span class='tlp-gioi-tinh-error text-danger'></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ngay-sinh" class="field__label">Ngày sinh</label>
                            <input type="text" name="ngay-sinh" class="tlp-ngay-sinh form-control datepicker-here" data-language='vi'  data-date-format="dd/mm/yyyy" placeholder="Ngày sinh">
                            <span class='tlp-ngay-sinh-error text-danger'></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="phuong-xa" class="field__label">Phường xã</label>
                            <input type="text" name="phuong-xa" class="tlp-phuong-xa form-control" placeholder="Phường Xã">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="quan-huyen" class="field__label">Quận huyện</label>
                            <input type="text" name="quan-huyen" class="tlp-quan-huyen form-control" placeholder="Quận Huyện">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tinh-thanh" class="field__label">Tỉnh thành</label>
                            <input type="text" name="tinh-thanh" class="tlp-tinh-thanh form-control" placeholder="Tỉnh Thành">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cmnd" class="field__label">CMND</label>
                            <input type="text" name="cmnd" class="tlp-cmnd form-control" placeholder="CMND">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="muc-tien" class="field__label">Mức tiền</label>
                            <input type="text" name="muc-tien" class="tlp-muc-tien form-control" placeholder="Mức tiền">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="phuong-thuc" class="field__label">Phương thức đóng</label>
                            <input type="text" name="phuong-thuc" class="tlp-phuong-thuc form-control" placeholder="Phương thức">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="noi-kcb" class="field__label">Nơi KCB</label>
                            <input type="text" name="noi-kcb" class="tlp-noi-kcb form-control" placeholder="Nơi KCB">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="noi-dung" class="field__label">Nội dung</label>
                            <select name ="noi-dung" class="tlp-noi-dung form-control">
                                <option value="">Chọn nội dung</option>
                                <?php $noidung = tlp_info_noidung();
                                foreach($noidung as $val){
                                    echo "<option value='$val'>$val</option>";
                                }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="ho-so" class="field__label">Hồ sơ</label>
                            <select name="ho-so" class="tlp-ho-so form-control">
                                <option value="">Chọn hồ sơ</option>
                                <?php $hoso = tlp_info_hoso();
                                foreach($hoso as $val){
                                    echo "<option value='$val'>$val</option>";
                                }?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" class="tlp-id" value="0">
                <button type="submit" id="tlp-submit-info" class="btn btn-primary">Thêm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </form>
    </div>
</div>