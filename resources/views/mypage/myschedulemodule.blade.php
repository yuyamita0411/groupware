<script type="text/javascript">
	/*ユーザーの一覧データを配列で作る*/
	var arraystr = "<?php foreach($senddata['userinfodata'] as $key => $value){echo $value.','; } ?>";
	var alluser = arraystr.split(',');
	var appenduserarr = [];
	/*ユーザーの一覧データを配列で作る*/

	/*selectタグの親要素にデータを持たせておく。*/
	document.querySelectorAll('.rebasemodal_inner > .rebasememberarea > div > select').forEach((stag, i) => {
		var dataname = stag.getAttribute('name');
		stag.parentNode.parentNode.dataset.name = dataname;
	});
	document.querySelectorAll('.rebasemodal_inner > .rebasememberarea > div > select').forEach((stag, i) => {
		var dataname = stag.getAttribute('name');
		stag.parentNode.parentNode.dataset.name = dataname;
	});
	/*selectタグの親要素にデータを持たせておく。*/

	/*ユーザーの情報に基づいてタグを生成して特定の要素にappendするメソッド*/
	function create_userlist(createtag, tagclass, parentnode){
		alluser.forEach((usertxt, i) => {
			if(usertxt != ''){
				var createdelem = document.createElement(createtag);
				createdelem.setAttribute('class', usertxt+' '+tagclass);
				createdelem.innerText = usertxt;
				createdelem.addEventListener('click', function(){
					var appends = createdelem.parentNode.parentNode.previousElementSibling.children;
					var lastch = appends.length;
					var appendselector = appends[lastch-1];
					var parentselect = createdelem.parentNode.parentNode.previousElementSibling;
					var childnodes = parentselect.children;	

					var createdivtag = document.createElement('div');
					createdivtag.setAttribute('class', 'float-left mb-2 d-flex');

					var createdselecttag = document.createElement('select');
					createdselecttag.setAttribute('class', 'pl-2 pr-2 mr-1 border_radius grayshadowbutton');

					var createspantag = document.createElement('span');
					createspantag.setAttribute('class', 'pmbutton minus_button text-white font-weight-bold mr-2 border_radius grayshadowbutton');
					createspantag.innerText = '×';

					createspantag.addEventListener('click', function(){
						createspantag.parentNode.remove();
					});
					
					var createdoptiontag = document.createElement('option');					
					createdoptiontag.value = usertxt;
					createdoptiontag.innerText = usertxt;
					for(var i = 0; i < childnodes.length; i++){
						var childnodeattribute = childnodes[i].dataset.name;
					}
					createdselecttag.setAttribute('name', childnodeattribute);

					createdselecttag.appendChild(createdoptiontag);
					createdivtag.appendChild(createdselecttag);
					createdivtag.appendChild(createspantag);
					appendselector.appendChild(createdivtag);
				});

				document.querySelectorAll(parentnode).forEach((elem, i) => {
					elem.appendChild(createdelem);
				});

			}
		});
	}
	/*ユーザーの情報に基づいてタグを生成して特定の要素にappendするメソッド*/

	/*検索欄に入力した文字と、要素のクラス名が合致していたら要素に指定のクラス名を付け加える。そうでなければクラス名を外す。*/
	function create_suggest_area(parentnode, suggest_c_selector, appendclass){
		alluser.forEach((userdatatext, i) => {
			document.querySelectorAll(parentnode).forEach((elem, i) => {
				elem.addEventListener('keydown', function(){
					document.querySelectorAll(suggest_c_selector).forEach((resuleelem, i) => {
						var targetclassname = resuleelem.getAttribute('class');
						if(targetclassname.indexOf(elem.value) !== -1){
							resuleelem.classList.remove(appendclass);
						}else if(userdatatext == '' || targetclassname.indexOf(elem.value) == -1){
							resuleelem.classList.add(appendclass);
						}
					});

				});
			});
			document.querySelectorAll(parentnode).forEach((elem, i) => {
				var blurtimer = function(){
					document.querySelectorAll(suggest_c_selector).forEach((resuleelem, i) => {
						resuleelem.classList.add(appendclass);
					});
				}
				elem.addEventListener('blur', function(){
					setTimeout(blurtimer, 500)
				});
			});
		});
	}
	/*検索欄に入力した文字と、要素のクラス名が合致していたら要素に指定のクラス名を付け加える。そうでなければクラス名を外す。*/

	/*修正、追加エリアに重複する名前があればアラートを出す*/

	function make_suggest_alert(parentnode, selecttag, inputselector, alerttag){
		const selectcheck1 = document.querySelectorAll(parentnode)[0];

		const observer = new MutationObserver(records => {
			//変化があったとき
			var optiontextarr = [];
			var selectelem = document.querySelectorAll(selecttag);
			selectelem.forEach((el, i) => {
				optiontextarr.push(el.children[0].innerText);
			});
			console.log(optiontextarr);

			var str = new Set(optiontextarr);
			if(str.size != optiontextarr.length == true){
				document.querySelectorAll(inputselector).forEach((inputselector, i) => {
					inputselector.disabled = true;
				});
				document.querySelectorAll(alerttag).forEach((elem, i) => {
					elem.innerText = "ユーザーが重複しています。";
				});
			}else{
				document.querySelectorAll(inputselector).forEach((inputselector, i) => {
					inputselector.disabled = false;
				});
				document.querySelectorAll(alerttag).forEach((elem, i) => {
					elem.innerText = "";
				});
			}
		});
		observer.observe(selectcheck1, {
			childList:true
		});
	}
	/*修正、追加エリアに重複する名前があればアラートを出す*/

	create_userlist(
		'span',
		'd-none pointer bglightgray p-2 mr-1 z1',
		'#rebase_area .usersearchresult'
	);
	create_userlist(
		'span',
		'd-none pointer bglightgray p-2 mr-1 z1',
		'#add_schedule_area .usersearchresult'
	);
	create_suggest_area(
		'#rebase_area .searchmember',
		'#rebase_area .searchresultwrapper .usersearchresult > span',
		'd-none'
	);
	create_suggest_area(
		'#add_schedule_area .searchmember',
		'#add_schedule_area .searchresultwrapper .usersearchresult > span',
		'd-none'
	);
	make_suggest_alert(
		'#rebase_area .rebasememberarea',
		'#rebase_area .rebasememberarea > div > select',
		'#rebase_area input[type="submit"]',
		'#rebase_area .user_alert > p'
	);
	make_suggest_alert(
		'#add_schedule_area .rebasememberarea',
		'#add_schedule_area .rebasememberarea > div > select',
		'#add_schedule_area input[type="submit"]',
		'#add_schedule_area .user_alert > p'
	);

	document.querySelectorAll('.minus_button').forEach((mbutton, i) => {
		mbutton.addEventListener('click', function(){			
			mbutton.previousElementSibling.remove();
			mbutton.remove();
		});
	});
</script>