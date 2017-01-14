<?php

namespace App\Http\Controllers\service;

use App\model\Category;
use App\model\contact;
use App\model\expression;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class ResourceAplication extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth', ['except' => ['postLogin']]);
    }
    public function postLogin(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            echo json_encode(['status'=>'success']);
        }else{
            echo json_encode(['status'=>'failed']);
        }
    }
    public function postContact(Request $request,$action){
        $requests = [
            'get' => function($request){
                return response()->json(contact::where('user',$request->user()->id)->get());
            },
            'insert'=>function($request){

                    $rules=[
                        'name'  => 'min:3}max:15|required|unique:contact',
                        'phone' => 'regex:/^08[0-9]+/|min:9|max:15|required|unique:contact'
                    ];
                    $validator = \Illuminate\Support\Facades\Validator::make($request->input(), $rules,
                        [
                            'name.min' => 'Nama kontak minimal :min karakter',
                            'name.max' => 'Nama kontak maksimal :max karakter',
                            'name.required' => 'Nama kontak harus diisi',
                            'name.unique' => 'Nama kontak ini sudah ada',
                            'phone.min' => 'Nomor HP minimal :min karakter',
                            'phone.max' => 'Nomor HP maksimal :max karakter',
                            'phone.required' => 'Nomor HP harus ada',
                            'phone.regex' => 'Format Nomor HP tidak sesuai',
                            'phone.unique' => 'Nomor HP ini sudah ada'
                        ]);
                    if(!$validator->fails()){
                        $contact = new contact();
                        $contact->name = $request->input('name');
                        $contact->phone= $request->input('phone');
                        $contact->category_id= $request->input('category');
                        $contact->user = $request->user()->id;
                        $contact->save();
                        return response()->json(['status'=>'success']);
                    }else{
                        return response()->json(['status'=>'error','error'=>$validator->messages()],200);
                    }

            },
            'update' => function(Request $request){

            },
            'delete'=> function(Request $request){

            }
        ];
        return $requests[$action]($request);
    }
    public function postCategory(Request $request,$action){
        $requests = [
            'get' => function($request){
                return response()->json(DB::table('phonecategory')
                ->leftJoin('contact',function ($join){
                    $join->on('phonecategory.category_id','=','contact.category_id');
                })
                ->select('phonecategory.*',DB::raw('count(contact.category_id) as contact'))->groupBy('phonecategory.category_id')->get([
                        'phonecategory.name',
                        'contact'
                    ]));
            },
            'getall' => function($request){
                return response()->json(Category::all());
            }
            ,
            'insert'=>function($request){
                if(Category::where('user',$request->user()->id)->where('name',$request->input('name'))->count() == 0){
                    $rules=[
                        'name'  => 'min:3}max:15|required'
                    ];
                    $validator = \Illuminate\Support\Facades\Validator::make($request->input(), $rules,
                        [
                            'name.min' => 'Nama kategori minimal :min karakter',
                            'name.max' => 'Nama kategori maksimal :max karakter',
                            'name.required' => 'Nama kategori harus diisi',
                            'name.unique' => 'Nama kategori ini sudah ada'
                        ]);
                    if(!$validator->fails()){
                        $Category = new Category();
                        $Category->name = $request->input('name');
                        $Category->user = $request->user()->id;
                        $Category->save();
                        return response()->json(['status'=>'success']);
                    }else{
                        return response()->json(['status'=>'error','error'=>$validator->messages()],200);
                    }
                }
                else{
                    return response()->json(['status'=>'error','error'=>[['name'=>'Nama kategori ini sudah ada']]]);
                }
            },
            'update' => function(Request $request){

            },
            'delete'=> function(Request $request){

            }
        ];
        return $requests[$action]($request);
    }
    public function postMessages(Request $request,$action){
        $requests = [
            'get' => function($request){
                $inbox = DB::table('inbox')->orderBy('ReceivingDateTime','desc')->get();
                $result=[];
                foreach ($inbox as $item){
                    $result[]=['sender'=>contact::where('phone','0'.substr($item->SenderNumber,3))->count() == 1 ?
                        contact::where('phone','0'.substr($item->SenderNumber,3))->first()->name :
                        $item->SenderNumber,
                        'date'=>(new \DateTime($item->ReceivingDateTime))->format('ymd'),
                        'time'=>(new \DateTime($item->ReceivingDateTime))->format('h:i'),
                        'text'=>$item->TextDecoded];
                }
                return response()->json($result);

            },
            'getcontact'=> function($request){
                $contact = [];
                foreach (contact::all() as $item){
                    $contact[] = $item->name;
                }
                return response()->json([
                    'query' => 'Unit',
                    'suggestions' => $contact
                ]);
            },
            'send'=>function($request){
                DB::table('outbox')->insert([
                    'DestinationNumber' => contact::where('name',$request->input('kontak'))->first()->phone,
                    'TextDecoded'=>$request->input('text'),
                    'SenderID' => 'E173Eu',
                    'CreatorID'=>$request->user()->id
                ]);
                return response()->json(['status'=>'success']);
            },
            'update' => function(Request $request){

            },
            'delete'=> function(Request $request){

            }
        ];
        return $requests[$action]($request);
    }
    public function postExpression(Request $request, $action){
        $requests = [
            'get' => function($request){
                return response()->json(expression::all());
            },
            'getid' => function($request){
                return response()->json(expression::where('id',$request->input('id'))->first());
            }
            ,
            'execute' => function($request){
                $expression = expression::where('id',$request->input('id'));
                $setExp = $request->input('expression');
                $lenght = $request->input('lenght');
                preg_match_all('/\{\{[0-9a-zA-Z\\s]+\}\}/',$expression->first()->values,$mach);
                $encode = [];
                for ($x = 0; $x < count($request->input('expression')); $x++) {
                    if(!empty($lenght[$x]) && is_numeric($lenght[$x])){
                        if($setExp[$x] == 'a-z'){
                            $encode[] = '([a-z]{'.$lenght[$x].'})';
                        }
                        if ($setExp[$x] == 'a-Z'){
                            $encode[] = '([a-zA-Z]{'.$lenght[$x].'})';
                        }
                        if ($setExp[$x] == 'a-Z:Space'){
                            $encode[] = '([a-zA-Z\\s]{'.$lenght[$x].'})';
                        }
                        if ($setExp[$x] == '0-9'){
                            $encode[] = '([0-9]{'.$lenght[$x].'})';
                        }
                        if ($setExp[$x] == '0-9a-Z'){
                            $encode[] = '([0-9a-zA-Z]{'.$lenght[$x].'})';
                        }
                        if ($setExp[$x] == '0-9a-Z:Space'){
                            $encode[] = '([0-9a-zA-Z\\s]{'.$lenght[$x].'})';
                        }
                    }
                    else{
                        if($setExp[$x] == 'a-z'){
                            $encode[] = '([a-z]+)';
                        }
                        if ($setExp[$x] == 'a-Z'){
                            $encode[] = '([a-zA-Z]+)';
                        }
                        if ($setExp[$x] == 'a-Z:Space'){
                            $encode[] = '([a-zA-Z\\s]+)';
                        }
                        if ($setExp[$x] == '0-9'){
                            $encode[] = '([0-9]+)';
                        }
                        if ($setExp[$x] == '0-9a-Z'){
                            $encode[] = '([0-9a-zA-Z]+)';
                        }
                        if ($setExp[$x] == '0-9a-Z:Space'){
                            $encode[] = '([0-9a-zA-Z\\s]+)';
                        }
                    }
                }
                $expression->update(['encode'=>'/^'.str_replace($mach[0],$encode,$expression->first()->values).'$/']);
                return response()->json(['status'=>'success']);
            }
            ,
            'insert'=>function($request){
                $rules = [
                    'expname' => 'min:4|max:15|required|unique:expresiondb',
                    'values'    => 'min:4|required'
                ];
                $validator = \Illuminate\Support\Facades\Validator::make($request->input(), $rules);
                if(!$validator->fails()){
                    $expression = new expression();
                    $expression->expname = $request->input('expname');
                    $expression->values = $request->input('values');
                    $expression->user = $request->user()->id;
                    $expression->save();
                    return response()->json(['status'=>'success']);
                }else{
                    return response()->json(['status'=>'error','error'=>$validator->messages()],200);
                }

            },
            'update' => function(Request $request){

            },
            'delete'=> function(Request $request){

            }
        ];
        return $requests[$action]($request);
    }
}
