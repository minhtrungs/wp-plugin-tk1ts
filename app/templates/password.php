<?php
if ( is_user_logged_in() ) {
	get_header();
	global $post;
	$slug_page = $post->post_name;
	$username = $email = $displayname = $password = '';
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$old_pass = handle_input($_POST["tlp-old-pass"]);
		$new_pass = handle_input($_POST["tlp-new-pass"]);
		$confirm_pass = handle_input($_POST["tlp-confirm-pass"]);
	}
	if($old_pass != '' && $new_pass != '' && $confirm_pass != ''){
		$user = new TLP_Auth;
		$change = $user->change_password($old_pass, $new_pass, $confirm_pass);
		if($change === true){
			$result = "<p style='color:green;'>Đổi mật khẩu thành công!</p>";
			$old_pass = $new_pass = $confirm_pass = '';
		}else $result = "<p style='color:red;'>$change</p>";
	}
	?>
	<div class="tlp-logout"></div>
	<div class="tlp-container tlp-container-register">
		<p class="tlp-title"><?php the_title(); ?></p>
		<?php if(isset($result)) echo $result; ?>
		<form name="tlp-register-form" id="tlp-register-form" action="<?php echo home_url($slug_page);?>" method="post">
			<p>
				<label for="tlp-old-pass">Mật khẩu hiện tại</label>
				<input type="password" class="tlp-input" name="tlp-old-pass" id="tlp-old-pass" value="<?= $old_pass; ?>" placeholder="Mật khẩu hiện tại" required="required">
			</p>
			<p>
				<label for="tlp-new-pass">Mật khẩu mới</label>
				<input type="password" class="tlp-input" name="tlp-new-pass" id="tlp-new-pass" value="<?= $new_pass; ?>" placeholder="Mật khẩu mới" required="required">
			</p>
			<p>
				<label for="tlp-confirm-pass">Xác nhận mật khẩu</label>
				<input type="password" class="tlp-input" name="tlp-confirm-pass" id="tlp-confirm-pass" value="<?= $confirm_pass; ?>" placeholder="Xác nhận mật khẩu" required="required">
			</p>
			<div class="form-submit">
				<input type="submit" name="tlp-submit" id="tlp-submit" class="tlp-submit-password" value="Xác nhận">
			</div>
		</form>
	</div>
	<?php
	get_footer();
}else tlp_login();


