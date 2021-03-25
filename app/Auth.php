<?php
class TLP_Auth
{
    public function handle(){
		add_filter( 'login_redirect', array($this, 'get_error'), 10, 3 );
		add_action( 'wp_logout', array($this, 'logout') );
		add_filter( 'show_admin_bar', array($this, 'remove_admin_bar'), 999 );
		add_action( 'show_user_profile', array($this, 'manager_field') );
		add_action( 'edit_user_profile', array($this, 'manager_field') );
		add_action( 'personal_options_update', array($this, 'save_manager_field') );
		add_action( 'edit_user_profile_update', array($this, 'save_manager_field') );
    }

    public function login(){
        $args = array(
			'echo'           => true,
			'remember'       => true,
			'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
			'form_id'        => 'tlp-login-form',
            'id_username'    => 'tlp-username',
			'id_password'    => 'tlp-password',
			'id_remember'    => 'tlp-remember',
			'id_submit'      => 'tlp-submit',
			'label_username' => __( 'Tên đăng nhập' ),
			'label_password' => __( 'Mật khẩu' ),
			'label_remember' => __( 'Ghi nhớ đăng nhập' ),
			'label_log_in'   => __( 'Đăng nhập' ),
			'value_username' => '',
			'value_remember' => false
		);
		wp_login_form($args);
    }	

	function get_error($redirect_to, $requested_redirect_to, $user) {
		$referrer = strtok(wp_get_referer(), '?');
		if (is_wp_error($user) &&  $referrer && ! strstr($referrer, 'wp-login') && ! strstr($referrer,'wp-admin')) {
			$error_types = array_keys($user->errors);
			$error_type = 'both_empty';
			if (is_array($error_types) && !empty($error_types)) {
				$error_type = $error_types[0];
			}
			wp_redirect( $referrer . "?login=" . $error_type ); 
			exit;
		}elseif(strstr($referrer, 'wp-login')){
            return  home_url('wp-admin');
        }else{
            return  $referrer;
        }
	}

	public function show_error(){
		if(isset($_GET['login'])){
			echo '<p style="color:red;">';
			$login = $_GET['login'];
			if($login == 'empty_username'){
				echo 'Chưa nhập tên đăng nhập!';
			}elseif($login == 'empty_password'){
				echo 'Chưa nhập mật khẩu!';
			}elseif($login == 'invalid_username'){
				echo 'Tên đăng nhập không tồn tại!';
			}elseif($login == 'incorrect_password'){
				echo 'Mật khẩu không đúng!';
			}else{
				echo 'Đăng nhập thành công!';
			}
			echo '</p>';
		}
	}

	public function logout(){
		$referrer = strtok(wp_get_referer(), '?');
		wp_redirect( $referrer );
		exit();
	}

	function remove_admin_bar(){
		if( current_user_can('administrator') ) {
			return true;
		}
		return false;
	}

	public function register($username, $email, $first_name, $password){
		$pattern_username = '/^[a-z\d]{4,20}$/';
		$pattern_password = '/^.{6,}$/';
		if (!preg_match($pattern_username, $username)) {
			return "Tên đăng nhập phải từ 4-20 ký tự, chỉ được bao gồm chữ thường và số!";
		}elseif (!preg_match($pattern_password, $password)) {
			return "Mật khẩu phải có ít nhất 6 ký tự!";
		}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			return "Email sai định dạng!";
		}else{
			$userdata = array(
				'user_login' 			=>	$username,
				'user_pass'  			=>	$password,
				'user_email' 			=>	$email,
				'first_name'			=>	$first_name,
				'role'					=>	'truc-thuoc-don-vi',
				'show_admin_bar_front'	=>	'false'
			);
			$user_id = wp_insert_user( $userdata ) ;
			if ( is_wp_error( $user_id ) ) {
				$error = $user_id->get_error_message();
				return $error;
			}else{
				$manager_id = get_current_user_id();
				add_user_meta($user_id, '_manager_id', $manager_id);
				return true;
			}
		}
	}

	function manager_field( $user ) { ?>
		<h2><?php _e("Thông tin đơn vị", "blank"); ?></h2>
		<table class="form-table">
			<tr>
				<th><label for="manager_id"><?php _e("Đơn vị quản lý"); ?></label></th>
				<td>
					<?php 
					$current_manager = get_the_author_meta( '_manager_id', $user->ID );
					$args_user = array (
						'role__in' 	=> array('quan-ly-don-vi'),
						'order' 	=> 'ASC'
					);
					$wp_user_query = new WP_User_Query($args_user);
					$manager_users = $wp_user_query->get_results();

					echo '<select name="manager_id">';
					echo '<option value="">Không thuộc đơn vị nào</option>';
						if(!empty($manager_users)){
							foreach ($manager_users as $manager_user){
								$manager_id = $manager_user->ID;
								$manager_name = $manager_user->display_name;
								$selected = '';
								if($manager_id == $current_manager) $selected = 'selected';
								echo "<option $selected value='$manager_id'>$manager_name</option>";
							}
						}
					echo '</select>';
					?>
				</td>
			</tr>
		</table>
		<?php 
	}

	function save_manager_field( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) ) { 
			return false; 
		}
		update_user_meta( $user_id, '_manager_id', $_POST['manager_id'] );
	}

	function change_password($mat_khau_cu, $mat_khau_moi, $xac_nhan){
		$user = get_current_user_id();
		$user_info = get_userdata($user);
      	$password = $user_info->user_pass;
		$pattern_password = '/^.{6,}$/';
		if($user==0||$mat_khau_cu==''||$mat_khau_moi==''||$xac_nhan==''){
			return "Lỗi hệ thống!";
		}elseif(!wp_check_password($mat_khau_cu, $password, $user)){
			return "Mật khẩu hiện tại không đúng!";
		}elseif (!preg_match($pattern_password, $mat_khau_moi)) {
			return "Mật khẩu phải từ 6 ký tự!";
		}elseif($mat_khau_moi!=$xac_nhan){
			return "Mật khẩu xác nhận không khớp!";
		}else{
			wp_set_password($mat_khau_moi, $user);
			return true;
		}
	}
}