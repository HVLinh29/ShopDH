<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Tinh;
Use App\Huyen;
Use App\Xa;
Use App\Feeship;
use Toastr;
class DeliveryController extends Controller
{
    public function delivery(Request $request){
        $city = Tinh::orderby('matinh','ASC')->get();
        return view('admin.delivery.add_delivery')->with(compact('city'));
    }
    public function select_delivery(Request $request){
    	$data = $request->all();
    	if($data['action']){
    		$output = '';
    		if($data['action']=="city"){
    			$select_province = Huyen::where('matinh',$data['ma_id'])->orderby('mahuyen','ASC')->get();
    				$output.='<option>Chọn quận huyện</option>';
    			foreach($select_province as $key => $province){
    				$output.='<option value="'.$province->mahuyen.'">'.$province->tenhuyen.'</option>';
    			}

    		}else{

    			$select_wards = Xa::where('mahuyen',$data['ma_id'])->orderby('maxa','ASC')->get();
    			$output.='<option>Chọn xã phường</option>';
    			foreach($select_wards as $key => $ward){
    				$output.='<option value="'.$ward->maxa.'">'.$ward->tenxa.'</option>';
    			}
    		}
    		echo $output;
    	}
    	
    }
    public function update_delivery(Request $request){
		$data = $request->all();
		$fee_ship = Feeship::find($data['feeship_id']);
		$fee_value = rtrim($data['fee_value'],'.');// bo moi dau cham
		$fee_ship->fee_feeship = $fee_value;
		$fee_ship->save();
	}
	public function select_feeship(){
		$feeship = Feeship::orderby('fee_id','DESC')->get();
		$output = '';
		$output .= '<div class="table-responsive">  
			<table class="table table-bordered">
				<thread> 
					<tr>
						<th>Tên thành phố</th>
						<th>Tên quận huyện</th> 
						<th>Tên xã phường</th>
						<th>Phí ship</th>
					</tr>  
				</thread>
				<tbody>
				';

				foreach($feeship as $key => $fee){

				$output.='
					<tr>
						<td>'.$fee->city->tentinh.'</td>
						<td>'.$fee->province->tenhuyen.'</td>
						<td>'.$fee->wards->tenxa.'</td>
						<td contenteditable data-feeship_id="'.$fee->fee_id.'" class="fee_feeship_edit">'.number_format($fee->fee_feeship,0,',','.').'</td>
					</tr>
					';
				}

				$output.='		
				</tbody>
				</table></div>
				';

				echo $output;

		
	}
	public function insert_delivery(Request $request){
		$data = $request->all();
		$fee_ship = new Feeship();
		$fee_ship->mtinh = $data['city'];
		$fee_ship->mhuyen = $data['province'];
		$fee_ship->mxa = $data['wards'];
		$fee_ship->fee_feeship = $data['fee_ship'];
		$fee_ship->save();
		Toastr::success('Thêm phí vận chuyển thành công', 'Thành công');
	}
}
