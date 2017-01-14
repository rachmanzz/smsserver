<?php

namespace App\Http\Controllers\service;

use App\model\Category;
use App\model\expression;
use App\model\smsexpression;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SmsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex(){
        return view('server.views.index');
    }
    public function getContact(){
        $db['category']=Category::all();
        return view('server.views.contact',$db);
    }
    public function getCategory(){
        return view('server.views.category');
    }
    public function getPesan(){
        return view('server.views.pesan');
    }
    public function getExpression(){
        return view('server.views.expression');
    }
    public function getExpressionDatabase(){
        return view('server.views.expdatabase');
    }
    public function getExpressionId($id){
        $expession = DB::table('expresiondb')
            ->where('id',$id)
            ->get();
        $header=[];
        foreach ($expession as $data){
            if(preg_match_all('/\{\{[0-9a-zA-Z\\s]+\}\}/',$data->values,$mach)){
                foreach ($mach[0] as $macthitem){
                    if(preg_match('/\{\{([0-9a-zA-Z\\s]+)\}\}/',$macthitem,$getmach)){
                        $header[] = $getmach[1];
                    }
                }
            }
        }
        $sms=smsexpression::where('expressionID',$id)
            ->get();
        $values=[];
        $extract=[];
        foreach ($sms as $item){
            $values[] =$item->values;
        }
        foreach ($values as $item){
            $extract[]= json_decode($item);
        }
        return view('server.views.expid',['header'=>$header,'extract'=>$extract]);
    }
}
