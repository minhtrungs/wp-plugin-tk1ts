<?php
class TLP_Data
{
    public $id;
    public $don_vi;
    public $nguoi_nhap;
    public $ngay_nhap;
    public $ma_so;
    public $ho_ten;
    public $gioi_tinh;
    public $ngay_sinh;
    public $phuong_xa;
    public $quan_huyen;
    public $tinh_thanh;
    public $cmnd;
    public $muc_tien;
    public $phuong_thuc;
    public $noi_kcb;
    public $noi_dung;
    public $ho_so;

    public function set($id, $ma_so, $ho_ten, $gioi_tinh, $ngay_sinh, $phuong_xa, $quan_huyen, $tinh_thanh, $cmnd, $muc_tien, $phuong_thuc, $noi_kcb, $noi_dung, $ho_so){    
        $this->id = $id;
        $this->ma_so = $ma_so;
        $this->ho_ten = $ho_ten;
        $this->gioi_tinh = $gioi_tinh;
        $this->ngay_sinh = $ngay_sinh;
        $this->phuong_xa = $phuong_xa;
        $this->quan_huyen = $quan_huyen;
        $this->tinh_thanh = $tinh_thanh;
        $this->cmnd = $cmnd;
        $this->muc_tien = $muc_tien;
        $this->phuong_thuc = $phuong_thuc;
        $this->noi_kcb = $noi_kcb;
        $this->noi_dung = $noi_dung;
        $this->ho_so = $ho_so;
    }

    public function validate(){
        $id = $this->id;
        $ma_so = $this->ma_so;
        $ho_ten = $this->ho_ten;
        $gioi_tinh = $this->gioi_tinh;
        $ngay_sinh = $this->ngay_sinh;
        $phuong_xa = $this->phuong_xa;
        $quan_huyen = $this->quan_huyen;
        $tinh_thanh = $this->tinh_thanh;
        $count_true = 0;
        $curent_user = get_current_user_id();
        if(current_user_can('quan-ly-don-vi')){
            $don_vi = $curent_user;
        }else $don_vi = get_user_meta($curent_user, '_manager_id', true);
        $find_info = new TLP_Data;
        $read_info = new TLP_Data;
        $read_info->read($id);
        $ma_so_selected = $read_info->ma_so;
        $don_vi_selected = $read_info->don_vi;

        if(empty($don_vi)){
            $validate['info_role'] = true;
            $count_true++;
        }else{
            $validate['info_role'] = false;
        }
        if(empty($ma_so)){
            $validate['ma_so_require'] = true;
            $count_true++;
        }else{
            $validate['ma_so_require'] = false;
            if($id==0){
                if($find_info->find($ma_so) >= 1){
                    $validate['ma_so_exist'] = true;
                    $count_true++;
                }else $validate['ma_so_exist'] = false;
            }else{
                if($don_vi_selected==$don_vi){
                    $validate['info_role'] = false;
                }else{
                    $validate['info_role'] = true;
                    $count_true++;
                }
                if($ma_so_selected==$ma_so && $find_info->find($ma_so) >= 1){
                    $validate['ma_so_exist'] = false;
                }elseif($ma_so_selected!=$ma_so && $find_info->find($ma_so) >= 1){
                    $validate['ma_so_exist'] = true;
                    $count_true++;
                }else $validate['ma_so_exist'] = false;
            }
        }
        if(empty($ho_ten)){
            $validate['ho_ten_require'] = true;
            $count_true++;
        }else $validate['ho_ten_require'] = false;

        if(empty($gioi_tinh)){
            $validate['gioi_tinh_require'] = true;
            $count_true++;
        }else{
            $validate['gioi_tinh_require'] = false;
            if($gioi_tinh > 2||$gioi_tinh < 1 ||!is_numeric($gioi_tinh)){
                $validate['gioi_tinh_format'] = true;
                $count_true++;
            }else $validate['gioi_tinh_format'] = false;
        }

        if(empty($ngay_sinh)){
            $validate['ngay_sinh_require'] = true;
            $count_true++;
        }else{
            $validate['ngay_sinh_require'] = false;
            if ($ngay_sinh==9999){
                $validate['ngay_sinh_format'] = true;
                $count_true++;
            }else{
                $validate['ngay_sinh_format'] = false;
                $this->ngay_sinh = date('Y-m-d', strtotime($ngay_sinh));
            }
        }

        if(empty($phuong_xa)){
            $validate['phuong_xa_require'] = true;
            $count_true++;
        }else $validate['phuong_xa_require'] = false;

        if(empty($quan_huyen)){
            $validate['quan_huyen_require'] = true;
            $count_true++;
        }else $validate['quan_huyen_require'] = false;

        if(empty($tinh_thanh)){
            $validate['tinh_thanh_require'] = true;
            $count_true++;
        }else $validate['tinh_thanh_require'] = false;

        if($count_true > 0){
            $validate['validate'] = true;
        }else $validate['validate'] = false;

        return $validate;
    }

    public function add(){
        $nguoi_nhap = get_current_user_id();
        if(current_user_can('quan-ly-don-vi')){
            $don_vi = $nguoi_nhap;
        }else $don_vi = get_user_meta($nguoi_nhap, '_manager_id', true);
        $ngay_nhap = current_time('Y-m-d');
        $this->don_vi = $don_vi;
        $this->nguoi_nhap = $nguoi_nhap;
        $this->ngay_nhap = $ngay_nhap;
        global $wpdb;
        $table_danh_sach = $wpdb->prefix.'tk1ts_danh_sach';
        $insert_danh_sach = $wpdb->insert(
            $table_danh_sach, 
            array(
                'id' 	        =>	'NULL',
                'don_vi' 		=>	$this->don_vi,
                'nguoi_nhap' 	=>	$this->nguoi_nhap,
                'ngay_nhap'		=>	$this->ngay_nhap,
                'ma_so' 		=>	$this->ma_so,
                'ho_ten' 		=>	$this->ho_ten,
                'gioi_tinh' 	=>	$this->gioi_tinh,
                'ngay_sinh'		=>	$this->ngay_sinh,
                'phuong_xa'		=>	$this->phuong_xa,
                'quan_huyen'	=>	$this->quan_huyen,
                'tinh_thanh'	=>	$this->tinh_thanh,
                'cmnd'		    =>	$this->cmnd,
                'muc_tien'		=>	$this->muc_tien,
                'phuong_thuc'	=>	$this->phuong_thuc,
                'noi_kcb'		=>	$this->noi_kcb,
                'noi_dung'		=>	$this->noi_dung,
                'ho_so'		    =>	$this->ho_so,
            )
        );
        $this->id = $wpdb->insert_id;
        if($insert_danh_sach == 1) return true;
        return false;
    }

    public function update($id){
        $this->id = $id;
        global $wpdb;
        $table_danh_sach = $wpdb->prefix.'tk1ts_danh_sach';
        $update_danh_sach = $wpdb->update(
            $table_danh_sach,
            array(
                'ma_so' 		=>	$this->ma_so,
                'ho_ten' 		=>	$this->ho_ten,
                'gioi_tinh' 	=>	$this->gioi_tinh,
                'ngay_sinh'		=>	$this->ngay_sinh,
                'phuong_xa'		=>	$this->phuong_xa,
                'quan_huyen'	=>	$this->quan_huyen,
                'tinh_thanh'	=>	$this->tinh_thanh,
                'cmnd'		    =>	$this->cmnd,
                'muc_tien'		=>	$this->muc_tien,
                'phuong_thuc'	=>	$this->phuong_thuc,
                'noi_kcb'		=>	$this->noi_kcb,
                'noi_dung'		=>	$this->noi_dung,
                'ho_so'		    =>	$this->ho_so,
            ),
            array(
                'id'            =>	$this->id,
            )
        );
        if($update_danh_sach == 1) return true;
        return false;
    }

    public function read($id){
        global $wpdb;
        $query_danh_sach = $wpdb->get_results("
            SELECT *
            FROM {$wpdb->prefix}tk1ts_danh_sach
            WHERE id = {$id}
        ",OBJECT);
        if(count($query_danh_sach) == 1){
            foreach($query_danh_sach as $key => $value){
                $this->id = $value->id;
                $this->don_vi = $value->don_vi;
                $this->nguoi_nhap = $value->nguoi_nhap;
                $this->ngay_nhap = $value->ngay_nhap;
                $this->ma_so = $value->ma_so;
                $this->ho_ten = $value->ho_ten;
                $this->gioi_tinh = $value->gioi_tinh;
                $this->ngay_sinh = $value->ngay_sinh;
                $this->phuong_xa = $value->phuong_xa;
                $this->quan_huyen = $value->quan_huyen;
                $this->tinh_thanh = $value->tinh_thanh;
                $this->cmnd = $value->cmnd;
                $this->muc_tien = $value->muc_tien;
                $this->phuong_thuc = $value->phuong_thuc;
                $this->noi_kcb = $value->noi_kcb;
                $this->noi_dung = $value->noi_dung;
                $this->ho_so = $value->ho_so;
            }
        }
        return count($query_danh_sach);
    }

    public function find($ma_so){
        global $wpdb;
        $query_danh_sach = $wpdb->get_results("
            SELECT *
            FROM {$wpdb->prefix}tk1ts_danh_sach
            WHERE ma_so = '{$ma_so}'
        ",OBJECT);
        if(count($query_danh_sach) == 1){
            foreach($query_danh_sach as $key => $value){
                $this->id = $value->id;
                $this->don_vi = $value->don_vi;
                $this->nguoi_nhap = $value->nguoi_nhap;
                $this->ngay_nhap = $value->ngay_nhap;
                $this->ma_so = $value->ma_so;
                $this->ho_ten = $value->ho_ten;
                $this->gioi_tinh = $value->gioi_tinh;
                $this->ngay_sinh = $value->ngay_sinh;
                $this->phuong_xa = $value->phuong_xa;
                $this->quan_huyen = $value->quan_huyen;
                $this->tinh_thanh = $value->tinh_thanh;
                $this->cmnd = $value->cmnd;
                $this->muc_tien = $value->muc_tien;
                $this->phuong_thuc = $value->phuong_thuc;
                $this->noi_kcb = $value->noi_kcb;
                $this->noi_dung = $value->noi_dung;
                $this->ho_so = $value->ho_so;
            }
        }
        return count($query_danh_sach);
    }
    
    public function delete(){
        $nguoi_xoa = get_current_user_id();
        $don_vi_nguoi_xoa = get_user_meta($nguoi_xoa, '_manager_id', true);
        if(current_user_can('quan-ly-don-vi') && $don_vi_nguoi_xoa == $this->don_vi || current_user_can('administrator')){
            global $wpdb;
            $table = $wpdb->prefix.'tk1ts_danh_sach';
            $delete = $wpdb->delete( $table, array( 'id' => $this->id ) );
            if($delete > 0) return true;
            return false;
        }
        return false;
    }
}