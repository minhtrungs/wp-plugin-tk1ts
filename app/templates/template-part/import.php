<div class="modal animated zoomIn" id="tlp-modal-import" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
    <form id="tlp-form-import" method="POST" action="<?php echo admin_url('admin-ajax.php')?>" class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel">Nhập từ excel</h6>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5 class="tlp-notice-import text-danger text-center"></h5>
                            <h5 class="tlp-error-import text-danger text-center"></h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">                                            
                            <input type="file" class="form-control-file" id="tlp-upload-file">
                            <small class="form-text text-muted">Để dữ liệu được nhập vào đầy đủ và chính xác hãy kiểm tra kỹ file trước khi tải lên.</small>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="tlp-submit-import" class="btn btn-primary">Nhập</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </form>
</div>