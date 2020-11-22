<html>
	<head>
		@include('commonparts.headinfo')
		<link rel="stylesheet" href="design/css/myschedule/style.css">
		<script type="text/javascript" src="design/js/myschedule/script.js"></script>
	</head>
	<body class="">
		<!--グローバルナビ-->
		@include('commonparts.globalnav')
		<!--グローバルナビ-->
		<?php
			class strmethod{
				public function strreplace($replacepattern, $replaceto, $targetstr){
					$newphrase = str_replace($replacepattern, $replaceto, $targetstr);
					return $newphrase;
				}
				public function strreplace_def($targetstr){
					return str_replace(array(" ", $_GET['scheduletime']), array("", ""), $targetstr);
				}			
			}
			$strmethod = new strmethod;
		?>
		<!--コンテンツ-->
		@if(gettype($senddata['scheduledata'][0]) === 'object')
		<div class="p-2 p-lg-3">
			<div class="content_formarea">				
				<h4 class="mt-4 font-weight-bold">スケジュール詳細</h4>
				<!--スマホデザイン-->
				<div class="schedulesp w-100">
				@foreach($senddata['scheduledata'] as $eachsenddata)
					@if(!empty($eachsenddata))
					<?php
					$scheduletime = $strmethod->strreplace_def($eachsenddata->schedulestarttime.'~'.$eachsenddata->scheduleendtime);
					?>
					<div class="border_bottom_double d-inline-block w-100">
						<div class="bglightblue p-2 p-lg-3 d-inline-block w-50 float-left"><h5 class="mb-0">時間帯</h5></div>
						<div class="d-inline-block w-50 float-right p-2 p-lg-3">{{$scheduletime}}</div>
					</div>
					<div class="border_bottom_double d-inline-block w-100">
						<div class="bglightblue p-2 p-lg-3 d-inline-block w-50 float-left"><h5 class="mb-0">予定</h5></div>
						<div class="d-inline-block w-50 float-right p-2 p-lg-3">{{$eachsenddata->schedulecat}}</div>
					</div>
					<div class="border_bottom_double d-inline-block w-100">
						<div class="bglightblue p-2 p-lg-3 d-inline-block w-50 float-left"><h5 class="mb-0">メモ</h5></div>
						<div class="d-inline-block w-50 float-right p-2 p-lg-3">{{$eachsenddata->schedulememo}}</div>
					</div>
					<div class="border_bottom_double d-inline-block w-100">
						<div class="bglightblue p-2 p-lg-3 d-inline-block w-50 float-left"><h5 class="mb-0">メンバー</h5></div>
						<div class="d-inline-block w-50 float-right p-2 p-lg-3">
						<?php foreach(unserialize($eachsenddata->schedulemember) as $mkey => $mval):?>
						{{$mval}}
						<?php endforeach; ?>
						</div>
					</div>
					@endif
				@endforeach
				<div class="d-inline-block w-100 pt-4 pb-4">
					<span id ="" class="rebase_area rebase_schedule p-3 bgnavy text-white font-weight-bold d-inline-block float-left float-lg-none border_radius grayshadowbutton">修正する</span>
					<span id ="" class="delete_area delete_schedule p-3 bgred text-white font-weight-bold d-inline-block float-right float-lg-none border_radius grayshadowbutton">削除する</span>
				</div>

				</div>
				<!--スマホデザイン-->
				<!--PCデザイン-->
				<div class="schedulepc">					
					<table class="col-12 scheduletable mb-lg-5">
						<thead>
						</thead>
						<tbody>
							<tr>
								<th class="bglightblue p-2 p-lg-3 border_bottom_double">時間帯</th>
								<th class="bglightblue p-2 p-lg-3 border_bottom_double">予定</th>
								<th class="bglightblue p-2 p-lg-3 border_bottom_double">メモ</th>
								<th class="bglightblue p-2 p-lg-3 border_bottom_double">メンバー</th>
							</tr>
						@foreach($senddata['scheduledata'] as $eachsenddata)
							@if(!empty($eachsenddata))
							<tr>
								<td class="p-2 p-lg-3">
									<?php
									$scheduletime = $strmethod->strreplace_def($eachsenddata->schedulestarttime.'~'.$eachsenddata->scheduleendtime);
									?>
									{{$scheduletime}}										
								</td>
								<td class="p-2 p-lg-3">{{$eachsenddata->schedulecat}}</td>
								<td class="p-2 p-lg-3">{{$eachsenddata->schedulememo}}</td>
								<td>
									<?php foreach(unserialize($eachsenddata->schedulemember) as $mkey => $mval):?>
									{{$mval}}
									<?php endforeach; ?>
								</td>
								<td class="p-2 pt-lg-3 pr-lg-3 pb-lg-0 pl-lg-3 d-none d-lg-block">
									<span id ="" class="rebase_area rebase_schedule p-3 bgnavy text-white font-weight-bold d-inline-block float-left float-lg-none border_radius grayshadowbutton">修正する</span>
									<span id ="" class="delete_area delete_schedule p-3 bgred text-white font-weight-bold d-inline-block float-right float-lg-none border_radius grayshadowbutton">削除する</span>
								</td>
							</tr>
							@endif
						@endforeach
						</tbody>
					</table>
					<div class="d-inline-block d-lg-none w-100 mt-3 mb-4">
						<span id ="" class="rebase_area rebase_schedule p-2 p-lg-3 bgnavy text-white font-weight-bold d-inline-block float-left float-lg-none border_radius grayshadowbutton">修正する</span>
						<span id ="" class="delete_area delete_schedule p-2 p-lg-3 bgred text-white font-weight-bold d-inline-block float-right float-lg-none border_radius grayshadowbutton">削除する</span>
					</div>
				</div>				
			</div>
		</div>
		@endif
		<form method="post" action="" class="text-center formbg p-2 p-lg-3">
		@csrf
<!--スケジュールデータがあるとき-->
		@if($_GET['uniqueid'] && gettype($senddata['scheduledata'][0]) === 'object')
			@foreach($senddata['scheduledata'] as $eachsenddata)
			<div class="rebasemodalwrapper w-100 h-100 p-lg-5"></div>
			<div id="rebase_area" class="rebasemodalarea modalarea mb-lg-5 modalclose p-3 p-lg-5">
				<!--修正モーダル-->
				<span class="rebasemodalclosebutton minus_button text-white font-weight-bold border_radius grayshadowbutton">×</span>
				<h5 class=" text-left">時間</h5>		
				@if(!empty($eachsenddata))
					<?php
					$scheduletime = $strmethod->strreplace_def($eachsenddata->schedulestarttime.'~'.$eachsenddata->scheduleendtime);
					$startvalsformodal = $strmethod->strreplace_def($eachsenddata->schedulestarttime);
					$startvalarr = explode(':', $startvalsformodal);
					$endvalsformodal = $strmethod->strreplace_def($eachsenddata->scheduleendtime);
					$endvalarr = explode(':', $endvalsformodal);
					?>
					<div class="rebasemodalshow">
						<div class="rebasemodal_inner d-lg-flex mb-5">
							<div class="d-flex">
								<div class="w-50">
								<select name="rebase_time1_1{{$eachsenddata->uniqueid}}[]" class="pl-2 pr-2">
									<option value="{{$startvalarr[0]}}">{{$startvalarr[0]}}</option>
									@foreach($senddata['timeparam1'] as $eachtime1 => $eachtimeval1)
									<option value="{{$eachtime1}}">{{$eachtimeval1}}</option>
									@endforeach
								</select>
								</div>
								<div class="text-center">:</div>
								<div class="w-50">
								<select name="rebase_time1_2{{$eachsenddata->uniqueid}}[]" class="pl-2 pr-2">
									<option value="{{$startvalarr[1]}}">{{$startvalarr[1]}}</option>
									@foreach($senddata['timeparam2'] as $eachtime2 => $eachtimeval2)
									<option value="{{$eachtime2}}">{{$eachtimeval2}}</option>
									@endforeach
								</select>
								</div>
							</div>
							<div class="timefrom text-center">~</div>
							<div class="d-flex">								
								<div class="w-50">
									<select name="rebase_time2_1{{$eachsenddata->uniqueid}}[]" class="pl-2 pr-2">
									<option value="{{$endvalarr[0]}}">{{$endvalarr[0]}}</option>
									@foreach($senddata['timeparam1'] as $eachtime1 => $eachtimeval1)
									<option value="{{$eachtime1}}">{{$eachtimeval1}}</option>
									@endforeach
									</select>
								</div>
								<div class="text-center">:</div>
								<div class="w-50">
									<select name="rebase_time2_2{{$eachsenddata->uniqueid}}[]" class="pl-2 pr-2">
										<option value="{{$endvalarr[1]}}">{{$endvalarr[1]}}</option>
										@foreach($senddata['timeparam2'] as $eachtime2 => $eachtimeval2)
										<option value="{{$eachtime2}}">{{$eachtimeval2}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="d-flex mt-3 mt-lg-0">								
								<div class="w-100">
									<select name="rebase_schedulecat{{$eachsenddata->uniqueid}}[]" class="pl-2 pr-2">
										<option value="{{$eachsenddata->schedulecat}}">{{$eachsenddata->schedulecat}}</option>
										@foreach($senddata['schedulecats'] as $skey => $sval)
										<option value="{{$sval}}">{{$sval}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="rebasemodal_inner d-inline-block w-100">
							<div class="memberwrapper d-inline-block w-100 mb-2">
								<h5 class="text-left">メンバー</h5>
								<input type="text" class="searchmember text-left float-left">
							</div>									
							<div class="d-inline-block w-100 rebasememberarea mb-lg-3">
							@foreach(unserialize($eachsenddata->schedulemember) as $mkey => $mval)
								<div class="float-left mb-2 d-flex">
									<select name="rebase_usermember{{$eachsenddata->uniqueid}}[]" class="pl-2 pr-2 mr-2 border_radius grayshadowbutton">
										<option value="{{$mval}}">{{$mval}}</option>									
									</select>
									<span class="pmbutton minus_button text-white font-weight-bold mr-2 border_radius grayshadowbutton">×</span>
								</div>
							@endforeach									
							</div>
						</div>
					<div class="searchresultwrapper w-100">
						<div class="usersearchresult position-absolute bg-white"></div>
					</div>
					<div class="user_alert w-100"><p style="color:red;"></p></div>
					<div class="member_and_memo mt-5 mb-5">
						<div class="mb-lg-3">
							<h5 class="text-left">メモ</h5>
							<textarea name="rebase_memo{{$eachsenddata->uniqueid}}[]" value="{{$eachsenddata->schedulememo}}" class="w-100">{{$eachsenddata->schedulememo}}</textarea>
						</div>
					</div>
				</div>
				@endif
				<input type="submit" value="修正する" class="rebasebutton bgnavy d-block m-auto text-white font-weight-bold p-lg-3 border_radius grayshadowbutton">
			</div>
			@endforeach

			@foreach($senddata['scheduledata'] as $eachsenddata)
			<div class="deletemodalwrapper w-100 h-100 p-lg-5"></div>
			<div id="delete_area" class="delete_modal_area modalclose p-3 p-lg-5">
				<!--削除モーダル-->
				<!--スマホデザイン-->
				<div class="schedulesp w-100">
					<span class="deletemodalclosebutton minus_button text-white font-weight-bold border_radius grayshadowbutton">×</span>
				@foreach($senddata['scheduledata'] as $eachsenddata)
					@if(!empty($eachsenddata))
					<?php
					$scheduletime = $strmethod->strreplace_def($eachsenddata->schedulestarttime.'~'.$eachsenddata->scheduleendtime);
					?>
					<div class="border_bottom_double d-inline-block w-100">
						<div class="bglightblue p-2 p-lg-3 d-inline-block w-50 float-left"><h5 class="mb-0">時間帯</h5></div>
						<div class="d-inline-block w-50 float-right p-2 p-lg-3">{{$scheduletime}}</div>
					</div>
					<div class="border_bottom_double d-inline-block w-100">
						<div class="bglightblue p-2 p-lg-3 d-inline-block w-50 float-left"><h5 class="mb-0">予定</h5></div>
						<div class="d-inline-block w-50 float-right p-2 p-lg-3">{{$eachsenddata->schedulecat}}</div>
					</div>
					<div class="border_bottom_double d-inline-block w-100">
						<div class="bglightblue p-2 p-lg-3 d-inline-block w-50 float-left"><h5 class="mb-0">メモ</h5></div>
						<div class="d-inline-block w-50 float-right p-2 p-lg-3">{{$eachsenddata->schedulememo}}</div>
					</div>
					<div class="border_bottom_double d-inline-block w-100">
						<div class="bglightblue p-2 p-lg-3 d-inline-block w-50 float-left"><h5 class="mb-0">メンバー</h5></div>
						<div class="d-inline-block w-50 float-right p-2 p-lg-3">
						<?php foreach(unserialize($eachsenddata->schedulemember) as $mkey => $mval):?>
						{{$mval}}
						<?php endforeach; ?>
						</div>
					</div>
					@endif
				@endforeach
					<div class="d-inline-block w-100 mt-5">
						<input type="checkbox" name="delete_schedule{{$eachsenddata->uniqueid}}[]" class="deletecheckbox mb-5 d-none">
						<input type="submit" value="スケジュールを削除する" class="deleteschedulebutton bgred d-block m-auto text-white font-weight-bold p-3 border_radius grayshadowbutton">
					</div>
				</div>
				<!--スマホデザイン-->

				<!--パソコンデザイン-->
				<div class="schedulepc w-100">
					<span class="deletemodalclosebutton minus_button text-white font-weight-bold border_radius grayshadowbutton">×</span>
					<table class="col-12 scheduletable mb-5">
						<thead>
						</thead>
						<tbody>
							<tr>
								<th class="bglightblue p-2 p-lg-3 border_bottom_double">時間帯</th>
								<th class="bglightblue p-2 p-lg-3 border_bottom_double">予定</th>
								<th class="bglightblue p-2 p-lg-3 border_bottom_double">メモ</th>
								<th class="bglightblue p-2 p-lg-3 border_bottom_double">メンバー</th>
							</tr>				
							@if(!empty($eachsenddata))
							<tr>
								<td class="p-2 p-lg-3">
									<?php
									$scheduletime = $strmethod->strreplace_def($eachsenddata->schedulestarttime.'~'.$eachsenddata->scheduleendtime);
									?>
									{{$scheduletime}}
								</td>
								<td class="p-2 p-lg-3">{{$eachsenddata->schedulecat}}</td>
								<td class="p-2 p-lg-3">{{$eachsenddata->schedulememo}}</td>
								<td class="p-2 p-lg-3">
									<?php foreach(unserialize($eachsenddata->schedulemember) as $mkey => $mval):?>
									{{$mval}}
									<?php endforeach; ?>
								</td>
							</tr>
							@endif				
						</tbody>
					</table>
					<!--パソコンデザイン-->
					<input type="checkbox" name="delete_schedule{{$eachsenddata->uniqueid}}[]" class="deletecheckbox mb-5 d-none">
					<input type="submit" value="スケジュールを削除する" class="deleteschedulebutton bgred d-block m-auto text-white font-weight-bold p-3 border_radius grayshadowbutton">
				</div>
			</div>
			@endforeach
			@endif
<!--スケジュールデータがあるとき-->

<!--共通-->
			<div id="add_schedule_area" class="addmodalarea modalarea col-12 col-lg-9 pt-5 pr-2 pb-5 pr-2 mt-3 mb-3 mt-lg-5 mb-lg-5 d-inline-block bg-white">
				<!--追加-->
				@if($_GET['uniqueid'] && gettype($senddata['scheduledata'][0]) === 'object')
				<h4 class="font-weight-bold text-left text-lg-center">違う時間帯に<br class="sp">スケジュールを追加する</h4>
				@else
				<h4 class="font-weight-bold text-left text-lg-center">スケジュールを追加する</h4>
				@endif
				<h5 class=" text-left">時間</h5>					
				<div class="rebasemodalshow">
					<div class="rebasemodal_inner d-lg-flex mb-5">
						<div class="d-flex">
							<div class="w-50">
								<select name="scheduletime1_1" class="pl-2 pr-2">
									@foreach($senddata['timeparam1'] as $eachtime1 => $eachtimeval1)
									<option value="{{$eachtime1}}">{{$eachtimeval1}}</option>
									@endforeach
								</select>
							</div>
							<div class="text-center">:</div>
							<div class="w-50">
								<select name="scheduletime1_2" class="pl-2 pr-2">
									@foreach($senddata['timeparam2'] as $eachtime2 => $eachtimeval2)
									<option value="{{$eachtime2}}">{{$eachtimeval2}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="text-center timefrom">~</div>
						<div class="d-flex">
							<div class="w-50">
								<select name="scheduletime2_1" class="pl-2 pr-2">
								@foreach($senddata['timeparam1'] as $eachtime1 => $eachtimeval1)
								<option value="{{$eachtime1}}">{{$eachtimeval1}}</option>
								@endforeach
								</select>
							</div>
							<div class="text-center">:</div>
							<div class="w-50">
								<select name="scheduletime2_2" class="pl-2 pr-2">
									@foreach($senddata['timeparam2'] as $eachtime2 => $eachtimeval2)
									<option value="{{$eachtime2}}">{{$eachtimeval2}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="d-flex mt-3 mt-lg-0">
							<div class="w-100">
								<select name="schedulecats">
									@foreach($senddata['schedulecats'] as $schedulecat)
									<option value="{{$schedulecat}}">{{$schedulecat}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="rebasemodal_inner d-inline-block w-100">
						<div class="memberwrapper d-inline-block w-100 mb-2">
							<div>
								<h5 class="mr-2 text-left">メンバー</h5>
							</div>
							<input type="text" class="searchmember float-left">
						</div>
						<div class="d-inline-block w-100 rebasememberarea mb-lg-3">
							<div class="d-inline-block float-left">
								<select name="schedulemember[]" class="schedulemember pl-2 pr-2 mr-2 d-none">
									<option value="-"></option>
								</select>
							</div>
						</div>
					</div>
					<div class="searchresultwrapper w-100">
						<div class="usersearchresult position-absolute bg-white"></div>
					</div>
					<div class="user_alert w-100"><p style="color:red;"></p></div>
					<div class="member_and_memo mt-5 mb-5">
						<div class="mb-lg-3">
							<h5 class="text-left">メモ</h5>
							<textarea name="schedulememo" class="mb-3 mb-lg-0 w-100"></textarea>
						</div>
					</div>
					<input type="hidden" name="uniqueid" value="<?php echo $strmethod->strreplace(array(' ', ':', '-'), array('', '', ''), date("Y-m-d H:i:s").uniqid()); ?>">
					<input type="submit" value="スケジュールを追加する" class="rebasebutton bgnavy d-block m-auto text-white font-weight-bold p-2 p-lg-3 border_radius grayshadowbutton">
				</div>
			</div>
<!--共通-->

		</form>
		@include('mypage.myschedulemodule')
		<!--コンテンツ-->
		<!--フッター-->
		@include('commonparts.footer')
		<!--フッター-->
	</body>
</html>