<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class MyscheduleController extends Controller
{
    public function __construct(){
        $this->uniqueid = $_GET['uniqueid'];        
        $this->selectquery = 'select * from userschedule where uniqueid = "'.$this->uniqueid.'"';
        $this->databasedata = DB::select($this->selectquery);

        /*企業ごとにユーザーを分ける仕様にする場合はここを書き換える*/
        /*$this->userinfoquery = 'select * from userinfo where name != "'.$_COOKIE['username'].'"';*/
        $this->userinfoquery = 'select * from userinfo';
        $this->userinfodata = DB::select($this->userinfoquery);
        /*企業ごとにユーザーを分ける仕様にする場合はここを書き換える*/
    }

    public function index(Request $request){
        if(empty($_COOKIE['username'])){
            return redirect('/login');
        }

        $schedulecats = ['-', '会議', '面談', '来客', 'その他'];

        /*ステータスのラベルの色を設定*/
        $statuslabelcolor = [
            '-' => ['background' => 'gray', 'color' => '#ffff'],
            '会議' => ['background' => '#0099FF', 'color' => '#ffff'],
            '面談' => ['background' => '#006600', 'color' => '#ffff'],
            '来客' => ['background' => '#CC3300', 'color' => '#ffff'],
            'その他' => ['background' => '#AAAAAA', 'color' => '#ffff']
        ];
        /*ステータスのラベルの色を設定*/

        $timeparam1 = 
        [
            '-' => '-',
            '09' => '09',
            '10' => '10',
            '11' => '11',
            '12' => '12',
            '13' => '13',
            '14' => '14',
            '15' => '15',
            '16' => '16',
            '17' => '17',
            '18' => '18',
            '19' => '19',
            '20' => '20',
            '21' => '21',
            '22' => '22',
            '23' => '23'
        ];

        $timeparam2 = 
        [
            '-' => '-',
            '00' => '00',
            '05' => '05',
            '10' => '10',
            '15' => '15',
            '20' => '20',
            '25' => '25',
            '30' => '30',
            '35' => '35',
            '40' => '40',
            '45' => '45',
            '50' => '50',
            '55' => '55'
        ];

        $senddata['senddata']['schedulecats'] = $schedulecats;
        $senddata['senddata']['statuslabelcolor'] = $statuslabelcolor;
        $senddata['senddata']['timeparam1'] = $timeparam1;
        $senddata['senddata']['timeparam2'] = $timeparam2;

    	if(!empty($_GET['scheduletime'])){
            $senddata['senddata']['dateparam'] = $_GET['scheduletime'];
    	}else{
            $senddata['senddata']['dateparam'] = '';
    	}
    	/*日付のテーブルに格納されたスケジュールのデータを取り出す処理*/
        if(!empty($this->databasedata)){
            $senddata['senddata']['scheduledata'] = $this->databasedata;
        }else{
            $senddata['senddata']['scheduledata'] = [''];
            redirect('/mypage');
        }
    	/*日付のテーブルに格納されたスケジュールのデータを取り出す処理*/

        /*userinfoからユーザー一覧を取得する処理*/
        $usernameinfoarr['-'] = NULL;
        if(!empty($this->userinfodata)){
            foreach ($this->userinfodata as $userinfodatavalue) {
                $usernameinfoarr[] = $userinfodatavalue->name;
            }
        }
        $senddata['senddata']['userinfodata'] = $usernameinfoarr;
        /*userinfoからユーザー一覧を取得する処理*/
    	
        return view('mypage.myschedule', $senddata);
    	return view('mypage.myschedulemodule', $senddata);
    }

    public function formmethod(Request $request){
    	/*日付のデータを更新または追加する処理*/
        $date = $_GET['scheduletime'];

        $starttime = $date.' '.$request->scheduletime1_1.':'.$request->scheduletime1_2;
        $endtime = $date.' '.$request->scheduletime2_1.':'.$request->scheduletime2_2;

        /*スケジュールを追加する時*/
        if(empty($_COOKIE['username'])){
            setcookie('username', '');
            return redirect('/login');
        }
        $userarr = array_merge([$_COOKIE['username']], $request->schedulemember);

        if($request->scheduletime1_1 != '-' && $request->scheduletime1_2 != '-' && $request->scheduletime2_1 != '-' && $request->scheduletime2_2 != '-' && $request->schedulememo != '-'){
            DB::insert(
                'insert into userschedule
                (name, schedulecat, schedulestarttime, scheduleendtime, schedulemember, schedulememo, uniqueid) 
                values 
                (:name, :schedulecat, :schedulestarttime, :scheduleendtime, :schedulemember, :schedulememo, :uniqueid)',
                [
                    'name' => $_COOKIE['username'],
                    'schedulecat' => $request->schedulecats,
                    'schedulestarttime' => $starttime,
                    'scheduleendtime' => $endtime,
                    'schedulemember' => serialize(array_unique(array_filter(str_replace('-', '', $userarr)))),
                    'schedulememo' => $request->schedulememo,
                    'uniqueid' => $request->uniqueid
                ]
            );
            return redirect('/myschedule?scheduletime='.$date.'&uniqueid='.$request->uniqueid);
        }
        /*スケジュールを追加する時*/

        /*スケジュールを更新する時*/
        foreach ($_POST as $key => $value) {
            if(preg_match('/^rebase_time1_1/', $key)){
                $st_append1_1[] = $value[0];
                $updatekey[] = str_replace('rebase_time1_1', '', $key);
            }
            if(preg_match('/^rebase_time1_2/', $key)){
                $st_append1_2[] = $value[0];
            }
            if(preg_match('/^rebase_time2_1/', $key)){
                $st_append2_1[] = $value[0];
            }
            if(preg_match('/^rebase_time2_2/', $key)){
                $st_append2_2[] = $value[0];
            }
            if (preg_match('/^rebase_schedulecat/', $key)) {
                $scat_append[] = $value[0];
            }
            if (preg_match('/^rebase_memo/', $key)) {
                $rebasememo_append[] = $value[0];
            }

            if(preg_match('/^delete_schedule/', $key)){
                $delete_or_not[] = $value[0];
            }
            if(preg_match('/^rebase_usermember/', $key)){
                $re_member[] = $value;                
            }
        }

        if(!empty($st_append1_1)){
            foreach ($st_append1_1 as $key => $value) {

                $rebasestarttime = $date.' '.$st_append1_1[$key].':'.$st_append1_2[$key];
                $rebaseendtime = $date.' '.$st_append2_1[$key].':'.$st_append2_2[$key];
                $rebase_scat = $scat_append[$key];
                $rebasememo = $rebasememo_append[$key];
                if(empty($re_member[$key])){
                    break;
                }
                $rebase_member = serialize(array_unique(array_filter(str_replace('-', '', $re_member[$key]))));

                $param = [
                        'name' => $_COOKIE['username'],
                        'schedulecat' => $rebase_scat,
                        'schedulestarttime' => $rebasestarttime,
                        'scheduleendtime' => $rebaseendtime,
                        'schedulemember' => $rebase_member,
                        'schedulememo' => $rebasememo,                        
                        'uniqueid' => $updatekey[$key]
                        ];

                if($st_append1_1[$key] != '-' && $st_append1_2[$key] != '-' && $st_append2_1[$key] != '-' && $st_append2_2[$key] != '-'){
                   DB::update('update userschedule set 
                    name = :name, 
                    schedulecat = :schedulecat, 
                    schedulestarttime = :schedulestarttime, 
                    scheduleendtime = :scheduleendtime, 
                    schedulemember = :schedulemember, 
                    schedulememo = :schedulememo,                     
                    uniqueid = :uniqueid where uniqueid = "'.$updatekey[$key].'"', $param
                    );
                }

                if(!empty($delete_or_not[$key])){
                    $deletedata = $delete_or_not[$key];
                    DB::delete('delete from userschedule where uniqueid ="'.$updatekey[$key].'"', $param);
                    return redirect('/mypage');
                }             

            }
        }
        /*スケジュールを更新する時*/

    	/*日付のデータを更新または追加する処理*/

        /*リダイレクトURL*/
        if (!empty($_GET['scheduledetailtime'])) {
            $redirecturl = '?scheduletime='.$date.'&scheduledetailtime='.$_GET['scheduledetailtime'];
        }else{
            $redirecturl = '?scheduletime='.$date;
        }
        if(!empty($_COOKIE['username'])){
            $redirecturl .= '&uniqueid='.$this->uniqueid;
        }
        /*リダイレクトURL*/

        return redirect('myschedule'.$redirecturl);
    }
}