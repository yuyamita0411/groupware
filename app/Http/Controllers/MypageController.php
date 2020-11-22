<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\MypageRequest;

use Validator;

use App\Rules\Mypagerule;

use Illuminate\Support\Facades\DB;

class MypageController extends Controller
{
    public function __construct(){
        $this->dates = date("Y-m-d");//今日の日付
        $this->year = date("Y");//年
        $this->month = date("m");//月
        $this->date = date("d");//日

    }

    public function rest(Request $request){
        return view('mypage.rest');
    }

    public function calenderinfo($interval){
        $appendinterval1 = '-'.strval($interval).' day';
        $appendinterval2 = '+'.strval($interval).' day';

        if(!empty($_GET['date'])){
            $dateparam = $_GET['date'];
            $datearr = explode('~', $dateparam);

            $startdate = $datearr[0];
            $enddate = $datearr[1];

            $prevstartdate = date("Y-m-d",strtotime($startdate . $appendinterval1));
            $prevenddate = date("Y-m-d",strtotime($enddate. $appendinterval1));
            $nextstartdate = date("Y-m-d",strtotime($startdate . $appendinterval2));
            $nextenddate = date("Y-m-d",strtotime($enddate. $appendinterval2));
        }else{
            $startdate = $this->dates;
            $enddate = date("Y-m-d",strtotime($startdate. '+ 6day'));

            $prevstartdate = date("Y-m-d",strtotime($this->dates . $appendinterval1));
            $prevenddate = date("Y-m-d",strtotime($prevstartdate. '+ 6day'));
            $nextstartdate = date("Y-m-d",strtotime($this->dates . $appendinterval2));
            $nextenddate = date("Y-m-d",strtotime($nextstartdate. '+ 6day'));
        }

        $button_param_arr = [
            'startdate' => $startdate,
            'enddate' => $enddate,
            'prev' => $prevstartdate.'~'.$prevenddate,
            'next' => $nextstartdate.'~'.$nextenddate
        ];

        return $button_param_arr;
    }

    public function index(Request $request){
        if(empty($_COOKIE['username'])){
            return redirect('/login');
        }

        $startdate = self::calenderinfo(1)['startdate'];
        $enddate = self::calenderinfo(1)['enddate'];
        $prev1 = self::calenderinfo(1)['prev'];
        $next1 = self::calenderinfo(1)['next'];
        $prev2 = self::calenderinfo(7)['prev'];
        $next2 = self::calenderinfo(7)['next'];

        $schedulequery = 
        /*'select * from userschedule where name = "'.$_COOKIE['username'].'" and 
        schedulestarttime between "'.$startdate.'" and "'.$enddate.'"';*/
        'select * from userschedule where schedulestarttime between "'.$startdate.'" and "'.$enddate.'"';
        $scheduledata = DB::select($schedulequery);


        $otheraccountinfoquery = 
        'select * from userinfo where name != "'.$_COOKIE['username'].'"';
        $otheruserdata = DB::select($otheraccountinfoquery);

        $allshedulequery =
        'select * from userschedule order by schedulestarttime';
        $allscheduledata = DB::select($allshedulequery);

        /*ステータスのラベルの色を設定*/
        $statuslabelcolor = [
            '会議' => ['background' => '#0099FF', 'color' => '#ffff'],
            '面談' => ['background' => '#006600', 'color' => '#ffff'],
            '来客' => ['background' => '#CC3300', 'color' => '#ffff'],
            'その他' => ['background' => '#AAAAAA', 'color' => '#ffff']
        ];
        /*ステータスのラベルの色を設定*/

        $mypageinfoar = [
            'username' => $_COOKIE['username'],
            'loginmessage' => 'こんにちは'.$_COOKIE['username'].'さん',
            'startdate' => $startdate,
            'enddate' => $enddate,
            'prev1' => $prev1,
            'next1' => $next1,
            'prev2' => $prev2,
            'next2' => $next2,
            'scheduledata' => $scheduledata,
            'otheruserdata' => $otheruserdata,
            'allscheduledata' => $allscheduledata,
            'schedulecolor' => $statuslabelcolor
        ];

        return view('mypage.index', $mypageinfoar);
    }

    public function formmethod(Request $request){
        return view('mypage.index');
    }

}