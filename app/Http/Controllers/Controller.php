<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param int $code [1.成功2失败]
     * @param string $msg [提示信息]
     * @param array $data [返回数据]
     */
    public function result($code=1,$msg='成功',$data=[]){
        exit(json_encode([
            'code'=>$code,
            'msg'=>$msg,
            'data'=>$data,
        ]));
    }
}
