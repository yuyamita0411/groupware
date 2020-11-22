<div class="gnavarea p-2 p-lg-3 bgnavy navshadow">
	<ul class="p-2 p-lg-3 bg-white border_gray_double_3px gnav_wrapper_radius">
		<?php if(empty($_COOKIE['username'])): ?>
		<li class="d-inline-block bgnavy p-2 p-lg-3 border_radius grayshadowbutton"><a href="/login" class="hover_decoration_none text-white font-weight-bold">ログイン</a></li>
		<li class="d-inline-block bgnavy p-2 p-lg-3 border_radius grayshadowbutton"><a href="/register" class="hover_decoration_none text-white font-weight-bold">登録する</a></li>
		<?php else:?>
		<li class="d-inline-block bgnavy p-2 p-lg-3 border_radius grayshadowbutton"><a href="/mypage?username=<?php echo $_COOKIE['username']; ?>" class="hover_decoration_none text-white font-weight-bold">Mypage</a></li>
		<li class="d-inline-block bgred p-2 p-lg-3 border_radius grayshadowbutton"><a href="/login" class="logout_button hover_decoration_none text-white font-weight-bold">ログアウト</a></li>
		<?php endif;?>
	</ul>
</div>