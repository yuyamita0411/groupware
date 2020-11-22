<html>
<head>
	@include('commonparts.headinfo')
</head>
<body>
	<!--グローバルナビ-->
	@include('commonparts.globalnav')
	<!--グローバルナビ-->

	<!--コンテンツ-->
	<div>
		<div class="content_formarea">
			<form action="/login" method="post" class="formbg text-center p-2 p-lg-3">
				@csrf
				<div class="addmodalarea modalarea col-12 col-lg-10 pt-5 pr-2 pb-5 pl-2 mt-3 mb-3 mt-lg-5 mb-lg-5 d-inline-block bg-white">
					<h4 class="font-weight-bold">ログインする</h4>
					<h5 class=" text-left">ユーザー名</h5>
					<div id="" class="rebasemodal_inner d-flex mb-5 mb-lg-3">
						<div class="d-flex">
							<div>
							<input type="text" name="username" class="searchmember d-inline-block">
							</div>
						@error('username')
							<div class="ml-2">{{$message}}</div>
						@enderror
						</div>
					</div>
					<h5 class=" text-left">パスワード</h5>
					<div id="" class="rebasemodal_inner d-flex mb-5 mb-lg-3">
						<div class="d-flex">
							<div>
							<input type="text" name="password" class="searchmember d-inline-block">
							</div>
						@error('password')
							<div class="ml-2">{{$message}}</div>
						@enderror
						</div>
					</div>
					<input type="submit" value="ログイン" class="rebasebutton bgnavy d-block m-auto text-white font-weight-bold p-2 p-lg-3 border_radius grayshadowbutton">
				</div>
			</form>
		</div>
		<div class="text-center p-2 p-lg-3">
			<div class="addmodalarea modalarea col-12 col-lg-10 pt-5 pr-2 pb-5 pl-2 mt-3 mb-3 mt-lg-5 mb-lg-5 d-inline-block bg-white">
				<h2 class="font-weight-bold">会員登録がまだの方はこちら</h2>
				<a href="/register" class="rebasebutton bgnavy text-white font-weight-bold mt-5 p-2 p-lg-3 border_radius grayshadowbutton d-inline-block">会員登録ページへ</a>				
			</div>
		</div>
	</div>
	<!--コンテンツ-->

	<!--フッター-->
	@include('commonparts.footer')
	<!--フッター-->
</body>
</html>