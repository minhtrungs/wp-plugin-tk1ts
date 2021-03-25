<?php
if ( is_user_logged_in() ) {
	if(current_user_can('quan-ly-don-vi')){
		get_header();
		global $post;
		$slug_page = $post->post_name;
		$username = $email = $displayname = $password = '';
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$username = handle_input($_POST["tlp-username"]);
			$email = handle_input($_POST["tlp-email"]);
			$displayname = handle_input($_POST["tlp-displayname"]);
			$password = handle_input($_POST["tlp-password"]);
		}
		if($username != '' && $email != '' && $displayname != '' && $password != ''){
			$user = new TLP_Auth;
			$register = $user->register($username, $email, $displayname, $password);
			if($register === true){
				$result = "<p style='color:green;'>Thêm người dùng mới thành công!</p>";
				$username = $email = $displayname = $password = '';
			}else $result = "<p style='color:red;'>$register</p>";
		}
		?>
		<div class="tlp-logout"></div>
		<div class="tlp-container tlp-container-register">
			<p class="tlp-title"><?php the_title(); ?></p>
			<?php if(isset($result)) echo $result; ?>
			<form name="tlp-register-form" id="tlp-register-form" action="<?php echo home_url($slug_page);?>" method="post">
				<p>
					<label for="tlp-username">Tên đăng nhập</label>
					<input type="text" name="tlp-username" id="tlp-username" value="<?= $username; ?>" placeholder="Username" required="required">
				</p>
				<p>
					<label for="tlp-email">Địa chỉ email</label>
					<input type="email" name="tlp-email" id="tlp-email" class="tlp-input" value="<?= $email; ?>" placeholder="Email Adress" required="required">
				</p>
				<p>
					<label for="tlp-displayname">Tên hiển thị</label>
					<input type="text" name="tlp-displayname" id="tlp-displayname" class="tlp-input" value="<?= $displayname; ?>" placeholder="Display Name" required="required">
				</p>
				<p>
					<label for="tlp-password">Mật khẩu</label>
					<input type="text" name="tlp-password" id="tlp-password" value="<?= $password; ?>" placeholder="Password" required="required">
				</p>
				<div class="form-submit">
					<input type="submit" name="tlp-submit" id="tlp-submit" class="tlp-submit-register" value="Xác nhận">
				</div>
			</form>
		</div>
		<?php
		get_footer();
	}else{
		wp_redirect(home_url());
		exit;
	}
}else tlp_login();


