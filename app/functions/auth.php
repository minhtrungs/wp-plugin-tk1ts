<?php
function tlp_login(){
    get_header();
	echo '<div class="tlp-logout"></div><div class="tlp-container tlp-container-login"><p class="tlp-title">Đăng nhập</p>';
	$login = new TLP_Auth;
	$login->show_error();
	$login->login();
	echo '</div>';
	get_footer();
}

 function tlp_logout(){ ?>
	<button class="btn btn-outline-danger" onclick="location.href='<?= wp_logout_url(wp_get_referer()); ?>'">
		<i class='fa fa-sign-out'></i><span> Đăng xuất</span>
	</button>
	<?php
}
