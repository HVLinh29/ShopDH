<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use Illuminate\Support\Facades\Session;
use Redirect;
use Illuminate\Support\Facades\DB;
use Auth;
use Toastr;
class SliderController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Auth::id();
    
        if ($admin_id) {
            return Redirect::to('admin.dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function manage_slider()
    {
        $all_slider = Slider::orderBy('slider_id', 'DESC')->get();
        return view('admin.slider.list_slider')->with(compact('all_slider'));
    }

    public function add_slider()
    {
        return view('admin.slider.add_slider');
    }

    public function insert_slider(Request $request)
    {
        $data = $request->all();

        $get_image = $request->file('slider_image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_imgae = current(explode('.', $get_name_image));
            $new_image = $name_imgae. rand(0, 99). '.'. $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/slider', $new_image);

            $slider = new Slider();
            $slider->slider_name = $data['slider_name'];
            $slider->slider_image = $new_image;
            $slider->slider_status = $data['slider_status'];
            $slider->slider_desc = $data['slider_desc'];
            $slider->save();
            Toastr::success('Thêm slider thành công', 'Thành công');
            return Redirect::to('managa-slider');
        } else {
            Toastr::error('Làm ơn thêm hình ảnh', 'Thêm hình ảnh');
            return Redirect::to('add-slider');
        }
    }
    public function unactive_slider($slider_id){
        $this->AuthLogin();
        DB::table('t_slider')->where('slider_id',$slider_id)->update(['slider_status'=>0]);
        Toastr::error('Chưa kích hoạt được slider', 'Chưa kích hoạt');
        return Redirect::to('managa-slider');
    }
    public function active_slider($slider_id){
        $this->AuthLogin();
        DB::table('t_slider')->where('slider_id',$slider_id)->update(['slider_status'=>1]);
        Toastr::success('Kích hoạt Slider thành công', 'Thành công');
        return Redirect::to('managa-slider');
    }
    public function delete_slider($slider_id){
        $slider = Slider::find($slider_id);
        $slider->delete();
        Toastr::error('Xóa Slider thành công', 'Thành công');
        return Redirect::to('managa-slider');
    }
}