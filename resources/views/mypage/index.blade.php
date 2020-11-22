<html>
<head>
	@include('commonparts.headinfo')
	<link rel="stylesheet" href="design/css/mypage/style.css">
	<script type="text/javascript" src="design/js/mypage/script.js"></script>
</head>
<body>
	<!--グローバルナビ-->
	@include('commonparts.globalnav')
	<!--グローバルナビ-->
	<!--コンテンツ-->
	<?php
	class make_dateval{
		public function make_dates_for_calender($startdate, $i){
			return date("m月d日",strtotime($startdate . '+ '.strval($i).'day'));
		}
		public function make_dates($startdate, $i){
			return date("Y-m-d", strtotime($startdate . '+ '.strval($i).'day'));
		}
		public function make_later($startdate, $i){
			return date("Y-m-d", strtotime($startdate . '+ '.strval($i+1).'day'));
		}
		public function make_schedule_displaydata($startdate, $i, $schedulestarttime){
			$dates = date("Y-m-d", strtotime($startdate . '+ '.strval($i).'day'));
			$later = date("Y-m-d", strtotime($startdate . '+ '.strval($i+1).'day'));
			$start = str_replace($dates, "", str_replace(" ", "", $schedulestarttime));
			$end = str_replace($dates, "", str_replace(" ", "", $schedulestarttime));
			return substr($start, 0, strlen($start)-3).'~'.substr($end, 0, strlen($end)-3);
		}
	}
	$makedate_val = new make_dateval;
	?>
	<?php
	date_default_timezone_set('Asia/Tokyo');
    /*一番新しい予定を抽出*/
    $schedulearr = [];
    foreach ($scheduledata as $key => $value) {
        $date = new DateTime($value->schedulestarttime);
        $scheduledate = $date->format("Y-m-d H:i:s");
        if(date("Y-m-d H:i:s") < $scheduledate && strpos($value->schedulemember, $username) != false){
            $schedulearr[$value->schedulestarttime] = [$value];
        }
    }
    ksort($schedulearr);
    if(!empty($schedulearr)){
	    $startdate_for_notice = date("Y/m/d H:i:s", strtotime(current($schedulearr)[0]->schedulestarttime));

	    $uniqueid_for_notice = current($schedulearr)[0]->uniqueid;
	    $link_for_notice = "/myschedule?scheduletime=".explode(" ", $startdate_for_notice)[0].'&uniqueid='.$uniqueid_for_notice;
	    /*一番新しい予定を抽出*/
		$noticeareahtml = 
		'<p class="notice">
			<span class="font-weight-bold pr-3">NOTICE:</span>
			<span>
				<span>直近の予定まであと</span>
				<span class="schedule_yes noticetime font-weight-bold"></span>
			</span>
			<a href="'.$link_for_notice.'">
				<span class="d-inline-block bgred pl-2 pr-2 text-white font-weight-bold border_radius grayshadowbutton">直近の予定へ ▶</span>
			</a>
		</p>';
		?>
		<script type="text/javascript">
			var newest_schedule_str = "<?php echo $startdate_for_notice; ?>";

			var log = function(){
				var amountsecond = new Date(newest_schedule_str) - new Date();
				var date = (((amountsecond / 1000) / 60) / 60) / 24; var date_append = Math.floor(date);
				var hour = (date - date_append) * 24; var hour_append = Math.floor(hour);
				var minute = (hour - hour_append) * 60; var minute_append = Math.floor(minute);
				var second = (minute - minute_append) * 60; var second_append = Math.floor(second);

				var noticetext = "";
				if(0 < date_append){
					noticetext += date_append + '日';
				}
				if(0 < hour_append){
					noticetext += hour_append + '時間';
				}
				if(0 < minute_append){
					noticetext += minute_append + '分';
				}
				if(0 < second_append){
					noticetext += second_append + '秒';
				}
				document.querySelectorAll('.notice > span > .noticetime').forEach((elem, i) => {
					elem.innerText = noticetext;
				});
			}
			setInterval(log, 1000);
		</script>
		<?php
    }else{
    	$noticeareahtml = '';
    }
	?>
	<!--パソコン用デザイン-->
	<div class="p-2 p-lg-3 scedulepc">		
		<div class="content_formarea bg-white p-2 p-lg-3">
			<div>
				<p class="loginmessage font-weight-bold">{{$loginmessage}}</p>
				<?php echo $noticeareahtml; ?>
				<p>
					<a href="/mypage?username=<?php echo $_COOKIE['username']; ?>" class="font-weight-bold">スケジュール管理</a>
				</p>
			</div>
			<!--日付-->
			<div class="datelabel d-flex">
				<div class="schedulearea p-2 p-lg-3">
					<div class="d-inline-block"></div>
				</div>
			@for($i = 0; $i <= 6; $i++)
				<div class="schedulearea">
					<div class="d-inline-block w-100 p-2">
						<p class="w-100 d-inline-block text-center mb-0">
							{{$makedate_val->make_dates_for_calender($startdate, $i)}}
						</p>
					</div>
				</div>
			@endfor
			</div>
			<!--日付-->
			<div class="myschedule d-flex mb-lg-2">
				<div class="usernamearea position-relative text-center">
					<p class="mastericon mb-0 position-absolute">{{$username}}</p>
				</div>
			@for($i = 0; $i <= 6; $i++)
				<div class="schedulearea p-2 position-relative">
					<table class="w-100 d-inline-block text-center">
					<!--入力したスケジュールが来る-->
					@foreach($allscheduledata as $usercheckdata)
					@if(in_array($username, unserialize($usercheckdata->schedulemember)) && $makedate_val->make_dates($startdate, $i) <= $usercheckdata->schedulestarttime && $usercheckdata->schedulestarttime <= $makedate_val->make_later($startdate, $i))
					<tr class="d-inline-block float-left">
						<td>
						<span class="d-inline-block w-100 mb-3">
							<a href="/myschedule?scheduletime={{$makedate_val->make_dates($startdate, $i)}}&uniqueid={{$usercheckdata->uniqueid}}" class="smallfont d-inline-block font-weight-bold">
							{{$makedate_val->make_schedule_displaydata($startdate, $i, $usercheckdata->schedulestarttime)}}
							</a>
							<span class="schedulelabel gnav_wrapper_radius d-inline-block smallfont font-weight-bold" style="background: {{$schedulecolor[$usercheckdata->schedulecat]['background']}}; color: {{$schedulecolor[$usercheckdata->schedulecat]['color']}};">
								{{$usercheckdata->schedulecat}}
							</span>
						</span>
						</td>
					</tr>
					@endif
					@endforeach
					<!--入力したスケジュールが来る-->	                
	                </table>
	                <a href="/myschedule?scheduletime={{$makedate_val->make_dates($startdate, $i)}}&uniqueid=" class="morebutton smallfont float-right font-weight-bold text-right position-absolute">
	                	<img src="design/img/plus_button.png" class="d-inline-block w-100">
	                </a>
                </div>
			@endfor
			</div>
			@foreach($otheruserdata as $otheruserdatakey => $otheruserdataval)
			<div class="otherschedule d-flex mb-lg-2">
				<div class="usernamearea position-relative text-center">
					<p class="otherusericon mb-0 position-absolute">{{$otheruserdataval->name}}</p>
				</div>
			@for($i = 0; $i <= 6; $i++)
				<div class="schedulearea p-2">
					<table class="w-100 d-inline-block text-center">
					<!--入力したスケジュールが来る-->
					@foreach($allscheduledata as $usercheckdata)
					@if(in_array($otheruserdataval->name, unserialize($usercheckdata->schedulemember)) && $makedate_val->make_dates($startdate, $i) <= $usercheckdata->schedulestarttime && $usercheckdata->schedulestarttime <= $makedate_val->make_later($startdate, $i))
					<tr class="d-inline-block float-left">
						<td>
						<span class="mb-3 d-inline-block w-100">

							<a href="/myschedule?scheduletime={{$makedate_val->make_dates($startdate, $i)}}&uniqueid={{$usercheckdata->uniqueid}}" class="smallfont d-inline-block font-weight-bold">
							{{$makedate_val->make_schedule_displaydata($startdate, $i, $usercheckdata->schedulestarttime)}}
							</a>
							<span class="schedulelabel gnav_wrapper_radius d-inline-block smallfont font-weight-bold" style="background: {{$schedulecolor[$usercheckdata->schedulecat]['background']}}; color: {{$schedulecolor[$usercheckdata->schedulecat]['color']}};">
								{{$usercheckdata->schedulecat}}
							</span>
						</span>
						</td>
					</tr>
					@endif
					@endforeach
					<!--入力したスケジュールが来る-->
	                </table>
                </div>
            @endfor
			</div>
			@endforeach
			<div class="d-inline-block w-100">
				<ul class="d-inline-block w-100 mt-2 mb-3">
					<li class="d-inline-block float-left">
						<a href="?date={{$prev1}}&username=&username={{$username}}" class="yesterdaybutton gnav_wrapper_radius text-white font-weight-bold pr-2 pl-2">昨日へ</a>
					</li>
					<li class="d-inline-block float-right">
						<a href="?date={{$next1}}&username=&username={{$username}}" class="tmorrowbutton gnav_wrapper_radius text-white font-weight-bold pr-2 pl-2">明日へ</a>
					</li>
				</ul>
				<ul class="d-inline-block w-100">
					<li class="d-inline-block float-left">
						<a href="?date={{$prev2}}&username=&username={{$username}}" class="lastweekbutton gnav_wrapper_radius text-white font-weight-bold pr-2 pl-2">先週へ</a>
					</li>
					<li class="d-inline-block float-right">
						<a href="?date={{$next2}}&username=&username={{$username}}" class="nextweekbutton gnav_wrapper_radius text-white font-weight-bold pr-2 pl-2">来週へ</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!--パソコンデザイン-->

	<!--スマホデザイン-->
	<div class="p-2 p-lg-3 scedulesp">
		<div class="pt-3">
			<p class="loginmessage font-weight-bold">{{$loginmessage}}</p>
			<?php echo $noticeareahtml; ?>
			<p>
				<a href="/mypage?username=<?php echo $_COOKIE['username']; ?>" class="font-weight-bold">スケジュール管理</a>
			</p>
		</div>
		<div class="position-relative bglightblue d-inline-block w-100">
		<div class="mastericon spnamaearea pt-lg-3 pb-lg-3 text-left d-inline-block w-25 float-left">
			<p>{{$username}}</p>
		</div>
		<div class="pl-1 bg-white d-inline-block w-75 float-right">
		<!--予定がくる-->
		@for($i = 0; $i <= 6; $i++)
			<div class="<?php if($i != 6){echo 'border_bottom_double'; } ?> d-inline-block mb-3 w-100">
				<div class="dateicon bgnavy text-white font-weight-bold d-inline-block w-100 p-2">
					{{$makedate_val->make_dates_for_calender($startdate, $i)}}
					<span class="datetriangle triangle_rotate">▼</span>
				</div>
				<div class="schedule_aboutarea_sp scheduleabout_show w-100 pl-2 position-relative">
				<!--入力したスケジュールが来る-->
				@foreach($allscheduledata as $usercheckdata)
				@if(in_array($username, unserialize($usercheckdata->schedulemember)) && $makedate_val->make_dates($startdate, $i) <= $usercheckdata->schedulestarttime && $usercheckdata->schedulestarttime <= $makedate_val->make_later($startdate, $i))
				<span class="spscheduledate d-inline-block mt-3 w-100">
					<a href="/myschedule?scheduletime={{$makedate_val->make_dates($startdate, $i)}}&uniqueid={{$usercheckdata->uniqueid}}" class="d-inline-block">
						{{$makedate_val->make_schedule_displaydata($startdate, $i, $usercheckdata->schedulestarttime)}}
					</a>
					<span class="schedulelabel gnav_wrapper_radius d-inline-block font-weight-bold" style="background: {{$schedulecolor[$usercheckdata->schedulecat]['background']}}; color: {{$schedulecolor[$usercheckdata->schedulecat]['color']}};">
						{{$usercheckdata->schedulecat}}
					</span>
				</span>
				@endif
				@endforeach
				<!--入力したスケジュールが来る-->
		    		<a href="/myschedule?scheduletime={{$makedate_val->make_dates($startdate, $i)}}&uniqueid=" class="morebutton smallfont float-right font-weight-bold d-inline-block position-absolute">
		    			<img src="design/img/plus_button.png" class="d-inline-block w-100">
		    		</a>
				</div>
			</div>
			@endfor
		<!--予定がくる-->
		</div>
		</div>
		@foreach($otheruserdata as $otheruserdatakey => $otheruserdataval)
		<div class="position-relative bglightblue d-inline-block w-100 mt-2">
			<div class="otherusericon spnamaearea pt-lg-3 pb-lg-3 text-left d-inline-block w-25 float-left">
				<p>{{$otheruserdataval->name}}</p>
			</div>
		<div class="pl-1 bg-white d-inline-block w-75 float-right">
		<!--予定がくる-->
		@for($i = 0; $i <= 6; $i++)
			<?php $schedulenames = []; ?>
			@foreach($allscheduledata as $usercheckdata)
			@if(in_array($otheruserdataval->name, unserialize($usercheckdata->schedulemember)) && $makedate_val->make_dates($startdate, $i) <= $usercheckdata->schedulestarttime && $usercheckdata->schedulestarttime <= $makedate_val->make_later($startdate, $i))
			<?php $schedulenames[] = $startdate; ?>
			@endif
			@endforeach
			<div class="<?php if($i != 6){echo 'border_bottom_double'; } ?> d-inline-block mb-3 w-100">
				<div class="dateicon bgnavy text-white font-weight-bold d-inline-block w-100 p-2">
					{{$makedate_val->make_dates_for_calender($startdate, $i)}}
					<span class="datetriangle">▼</span>
					@if(0 < count($schedulenames))
					<span class="schedule_yes ml-2">予定あり</span>
					@endif
				</div>
				<div class="schedule_aboutarea_sp w-100 pl-2 position-relative">
				<!--入力したスケジュールが来る-->
				@foreach($allscheduledata as $usercheckdata)
				@if(in_array($otheruserdataval->name, unserialize($usercheckdata->schedulemember)) && $makedate_val->make_dates($startdate, $i) <= $usercheckdata->schedulestarttime && $usercheckdata->schedulestarttime <= $makedate_val->make_later($startdate, $i))
				<span class="spscheduledate d-inline-block mt-3 w-100">
					<a href="/myschedule?scheduletime={{$makedate_val->make_dates($startdate, $i)}}&uniqueid={{$usercheckdata->uniqueid}}" class="d-inline-block">
					{{$makedate_val->make_schedule_displaydata($startdate, $i, $usercheckdata->schedulestarttime)}}
					</a>
					<span class="schedulelabel gnav_wrapper_radius d-inline-block font-weight-bold" style="background: {{$schedulecolor[$usercheckdata->schedulecat]['background']}}; color: {{$schedulecolor[$usercheckdata->schedulecat]['color']}};">{{$usercheckdata->schedulecat}}</span>
				</span>
				@endif
				@endforeach
				<!--入力したスケジュールが来る-->
		    		<a href="/myschedule?scheduletime={{$makedate_val->make_dates($startdate, $i)}}&uniqueid=" class="morebutton smallfont float-right font-weight-bold d-inline-block position-absolute">
		    			<img src="design/img/plus_button.png" class="d-inline-block w-100">
		    		</a>
				</div>
			</div>
		@endfor
		<!--予定がくる-->
		</div>
		</div>
	@endforeach
		<div class="d-inline-block w-100">
			<ul class="d-inline-block w-100 mt-2 mb-3">
				<li class="d-inline-block float-left">
					<a href="?date={{$prev1}}&username=&username={{$username}}" class="yesterdaybutton gnav_wrapper_radius text-white font-weight-bold pr-2 pl-2">昨日へ</a>
				</li>
				<li class="d-inline-block float-right">
					<a href="?date={{$next1}}&username=&username={{$username}}" class="tmorrowbutton gnav_wrapper_radius text-white font-weight-bold pr-2 pl-2">明日へ</a>
				</li>
			</ul>
			<ul class="d-inline-block w-100">
				<li class="d-inline-block float-left">
					<a href="?date={{$prev2}}&username=&username={{$username}}" class="lastweekbutton gnav_wrapper_radius text-white font-weight-bold pr-2 pl-2">先週へ</a>
				</li>
				<li class="d-inline-block float-right">
					<a href="?date={{$next2}}&username=&username={{$username}}" class="nextweekbutton gnav_wrapper_radius text-white font-weight-bold pr-2 pl-2">来週へ</a>
				</li>
			</ul>
		</div>
	</div>
	<!--スマホデザイン-->

	<!--コンテンツ-->
	<!--フッター-->
	@include('commonparts.footer')
	<!--フッター-->
</body>
</html>