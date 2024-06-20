<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();
use Toastr;
use Auth;
use App\Gallery;

class GalleryController extends Controller
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
    public function add_gallery($product_id)
    {
        $pro_id = $product_id;
        return view('admin.gallery.add_gallery')->with(compact('pro_id'));
    }
    public function select_gallery(Request $request)
    {
        $product_id = $request->pro_id;
        $gallery = Gallery::where('product_id', $product_id)->get();//lay tât ca anh thuoc san pham co product id do
        $gallery_count = $gallery->count(); // dêm sp luong anh
        // tao 1 bien output  va 1 csrf de bao ve form khoi bi tan cong
        $output = ' <form>  
        ' . csrf_field() . '
        <table class="table table-hover">
            <thead>
              <tr>
                <th>Thứ tự</th>
                <th>Tên hình ảnh</th>
                <th>Hình ảnh</th>
                <th>Quản lý</th>
              </tr>
            </thead>
            <tbody>';
        if ($gallery_count > 0) {
            $i = 0;
            foreach ($gallery as $key => $gal) {
                $i++;
                $output .= '
               
                <tr>
                    <td>' . $i . '</td>
                    <td contenteditable class="edit_gal_name" data-gal_id="' . $gal->g_id . '">' . $gal->g_name . '</td>
                    <td>
                    <img src="' . url('public/uploads/gallery/' . $gal->g_image) . '" class="img-thumbnail" 
                    width="100px" height="100px">
                    <input type="file" class="file_image" style="width:40%" data-gal_id="' . $gal->g_id . '" 
                    id="file-' . $gal->g_id . '" name="file" accept="image/*"/>
                    </td>
                    <td>
                        <button type="button" data-gal_id="' . $gal->g_id . '" class="btn btn-danger delete-gallery">Xóa</button>
                    </td>
                    </tr>
                    ';
            }
        } else {
            $output .= '<tr>
                <td colspan="4">Sản phẩm chưa có thư viện ảnh</td>
            </tr>';
        }
        $output .= '</tbody></table> </form>';
        echo $output;
    }

    public function insert_gallery(Request $request, $pro_id)
    {
        $get_image = $request->file('file');//lay tap ten hinh anh tu request 
        if ($get_image) {// neu co anh duoc tai len
            foreach ($get_image as $image) {
                $get_name_image = $image->getClientOriginalName();// lay ten cua hinh anh
                $name_image = current(explode('.', $get_name_image)); // lay ten anh trupc dau cham
                $new_image = $name_image . rand(0, 99) . '.' . $image->getClientOriginalExtension();// tao ten moi voi so ngau nhien
                
                $image->move('public/uploads/gallery', $new_image);// luu anh vao day

                $gallery = new Gallery();
                $gallery->g_name = $new_image;
                $gallery->g_image = $new_image;
                $gallery->product_id = $pro_id;
                $gallery->save();
            }
        }
        Toastr::success('Thêm thư viện ảnh thành công.', 'Thành công');
       
        return redirect()->back();
    }
    public function update_gallery_name(Request $request)
    {
        $gal_id = $request->gal_id;
        $gal_text = $request->gal_text;
        $gallery = Gallery::find($gal_id);
        $gallery->g_name = $gal_text;
        $gallery->save();
    }
    public function delete_gallery(Request $request)
    {
        $gal_id = $request->gal_id;
        $gallery = Gallery::find($gal_id);
        unlink('public/uploads/gallery/' . $gallery->g_image);
        $gallery->delete();
    }
    public function update_gallery(Request $request)
    {

        $get_image = $request->file('file');
        $gal_id = $request->gal_id;
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            
            $get_image->move('public/uploads/gallery', $new_image);

            $gallery = Gallery::find($gal_id);
            unlink('public/uploads/gallery/' . $gallery->g_image);
            $gallery->g_image = $new_image;
            $gallery->save();
        }
    }
}
