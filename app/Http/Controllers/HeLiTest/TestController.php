<?php
namespace App\Http\Controllers\HeLiTest;
use App\Appointment;
use App\Car;
use App\Http\Controllers\Controller;
use App\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    //预约列表
    public function appointmentsList(Request $request){
        $workshop_id=$request->get('workshop_id');
        $res=Appointment::with(['workshop','car','car.contact']);
        if($workshop_id){
            $res->where('workshop_id',$workshop_id);
        }
        $list=$res->get()->toArray();
        $this->result(1,'成功',$list);
    }
    //创建预约
    public function saveAppointments(Request $request){
        $car_id=$request->post('car_id');
        $workshop_id=$request->post('workshop_id');
        if($car_id||$workshop_id){
            $this->result(2,'参数错误');
        }
        $start_time=$request->post('start_time');
        $end_time=$request->post('end_time');
        if($end_time>$start_time){
            $this->result(2,'结束时间不能大于开始时间');
        }
        $created_at=date('Y-m-d H:i:s');
        //查找当前车间预约时段是否有重叠
        $res=Appointment::where(['workshop_id'=>$workshop_id,['start_time','<=',$end_time],['end_time','>=',$start_time]])->get()->toArray();
        if($res){
            $this->result(2,'当前时段该车间已有预约');
        }
        //查找同一时间段是否有预约
        $carRes=Appointment::where(['car_id'=>$car_id,['start_time','<=',$end_time],['end_time','>=',$start_time]])->get()->toArray();
        if($carRes){
            $this->result(2,'当前时段您已有预约');
        }
        $appointment=new Appointment();
        $appointment->car_id=$car_id;
        $appointment->workshop_id=$workshop_id;
        $appointment->start_time=$start_time;
        $appointment->end_time=$end_time;
        $appointment->created_at=$created_at;
        if($appointment->save()){
            $this->result(1,'预约成功');
        }else{
            $this->result(2,'预约失败,请稍后重试');
        }
    }
    //车间列表
    public function workshopsList(Request $request){
    	//获取当前定位经纬度
    	$lat=$request->post('lat')?:30.59903;
    	$lng=$request->post('lng')?:114.311204;
        $start_time=$request->post('start_time')?:date("Y-m-d H:i:s");
        $end_time=$request->post('end_time')?:date("Y-m-d H:i:s");
        $res=Workshop::whereNotIn('id', function($query)use($start_time,$end_time){ 
            $query->select('workshop_id') 
            ->from('appointments') 
            ->where('start_time','>',$end_time)->orwhere('end_time','<',$start_time); 
        })->orderBy(DB::raw('ROUND(6378.137 * 2 * ASIN(SQRT(POW(SIN(('.$lat.' * PI() / 180 - latitude * PI() / 180) / 2),2) + COS('.$lat.' * PI() / 180) * COS(latitude * PI() / 180) * POW(SIN(('.$lng.' * PI() / 180 - longitude * PI() / 180) / 2),2))))'),'desc')->get()->toArray();
        $this->result(1,'成功',$res);
    }
   
}