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
			<form action="/register" method="post" class="formbg text-center p-2 p-lg-3">
				@csrf
				<div class="addmodalarea modalarea col-12 col-lg-10 pt-5 pr-2 pb-5 pl-2 mt-3 mb-3 mt-lg-5 mb-lg-5 d-inline-block bg-white">
					<h4 class="font-weight-bold">登録する</h4>
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

					<h5 class=" text-left">メールアドレス</h5>
					<div id="" class="rebasemodal_inner d-flex mb-5 mb-lg-3">
						<div class="d-flex">
							<div>
							<input type="text" name="mailaddress" class="searchmember d-inline-block">
							</div>
						@error('mailaddress')
							<div class="ml-2">{{$message}}</div>
						@enderror
						</div>
					</div>
					<h5 class=" text-left">年齢</h5>
					<div id="" class="rebasemodal_inner d-flex mb-5 mb-lg-3">
						<div class="d-flex">
							<div>
							<input type="text" name="age" class="searchmember d-inline-block">
							</div>
						@error('age')
							<div class="ml-2">{{$message}}</div>
						@enderror
						</div>
					</div>
					<input type="submit" value="登録する" class="rebasebutton bgnavy d-block m-auto text-white font-weight-bold p-2 p-lg-3 border_radius grayshadowbutton">						
				</div>
			</form>
		</div>
	</div>
	<!--コンテンツ-->

	<!--フッター-->
	@include('commonparts.footer')
	<!--フッター-->

</body>
</html>