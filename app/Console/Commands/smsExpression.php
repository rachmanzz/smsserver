<?php

namespace App\Console\Commands;

use App\model\expression;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class smsExpression extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:expression';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read SMS Expression';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        while (1){
            $pattern =expression::where('encode','!=','')->get();
            $inbox =DB::table('inbox')->get();
            foreach ($pattern as $data){
                foreach ($inbox as $item){
                    if(preg_match($data->encode,$item->TextDecoded,$mach)){
                        $dbexpression=new \App\model\smsexpression();
                        $dbexpression->number = $item->SenderNumber;
                        $dbexpression->values = json_encode($mach);
                        $dbexpression->expressionID = $data->id;
                        $dbexpression->save();
                        DB::table('inbox')->where('ID',$item->ID)->delete();
                    }else{
                        echo "is not <br>";
                    }
                }
            }
            sleep(1*10);
        }
    }
}
