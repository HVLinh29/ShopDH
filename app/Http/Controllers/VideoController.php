<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;
use App\Video;
use Illuminate\Support\Facades\Redirect;

session_start();

use App\Slider;
use App\CatePost;
use Auth;

class VideoController extends Controller
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
    public function video()
    {
        return view('admin.video.list_video');
    }
    public function select_video(Request $request)
    {

        $video = Video::orderBy('video_id', 'DESC')->get();
        $video_count = $video->count();
        $output = ' <form>
        ' . csrf_field() . '
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
            <th style="color: brown">Thứ tự</th>
              <th style="color: brown">Tên Video</th>
              <th style="color: brown">Slug Video</th>
              <th style="color: brown">Hình ảnh Video</th>
              <th style="color: brown">Link</th>
              <th style="color: brown">Mô tả</th>
              <th style="color: brown">Demo Video</th>
              <th style="color: brown">Quản lí</th>
            
            
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>';
        if ($video_count > 0) {
            $i = 0;
            foreach ($video as $key => $vid) {
                $i++;
                $output .= '
               
                <tr>
                <td>' . $i . '</td>
              <td contenteditable data-video_id="' . $vid->video_id . '" data-video_type="video_title" 
              class="video_edit" id="video_title_' . $vid->video_id . '">' . $vid->video_title . '</td>   

              <td contenteditable data-video_id="' . $vid->video_id . '" data-video_type="video_slug" 
              class="video_edit" id="video_slug_' . $vid->video_id . '"">' . $vid->video_slug . '</td> 
              
              <td>
              <img src="' . url('public/uploads/videos/' . $vid->video_image) . '" class="img-thumbnail" 
              width="100px" height="100px">
              <input type="file" class="file_img_video" data-video_id="' . $vid->video_id . '" 
              id="file-video-' . $vid->video_id . '" name="file" accept="image/*"/>
              </td>

              <td contenteditable data-video_id="' . $vid->video_id . '" data-video_type="video_link" 
              class="video_edit" id="video_link_' . $vid->video_id . '"">https://youtu.be/' . $vid->video_link . '</td>
              
              <td contenteditable data-video_id="' . $vid->video_id . '" data-video_type="video_desc" 
              class="video_edit" id="video_desc_' . $vid->video_id . '"">' . $vid->video_desc . '</td>
              <td><iframe width="200" height="200" src="https://www.youtube.com/embed/' . $vid->video_link . '" 
                title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; 
                encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" 
                allowfullscreen></iframe></td>
              <td><button type="button" data-video_id="' . $vid->video_id . '" class=" btn btn-danger btn-delete-video">Xóa video</button></td>
            </tr>
                    ';
            }
        } else {
            $output .= '<tr>
                <td colspan="4"Chưa có video </td>
            </tr>';
        }
        $output .= '</tbody></table> </form>';
        echo $output;
    }
    public function update_video(Request $request)
    {
        $data = $request->all();
        $video_id = $data['video_id'];
        $video_edit = $data['video_edit'];
        $video_check = $data['video_check'];


        if ($video_check == 'video_title') {
            $video = Video::find($video_id);
            $video->video_title = $video_edit;
            $video->save();
        } elseif ($video_check == 'video_desc') {
            $video = Video::find($video_id);
            $video->video_desc = $video_edit;
            $video->save();
        } elseif ($video_check == 'video_link') {
            $video = Video::find($video_id);
            $sub_link = substr($video_edit, 17);
            $video->video_link = $sub_link;
            $video->save();
        } else {
            $video = Video::find($video_id);
            $video->video_slug = $video_edit;
            $video->save();
        }
    }
    public function insert_video(Request $request)
    {
        $data = $request->all();
        $video = new Video();
        $sub_link = substr($data['video_link'], 17);
        $video->video_title = $data['video_title'];
        $video->video_slug = $data['video_slug'];
        $video->video_link = $sub_link;
        $video->video_desc = $data['video_desc'];

        $get_image = $request->file('file');
        if ($get_image) {

            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            // Inside the foreach loop, correct the file move operation
            $get_image->move('public/uploads/videos', $new_image);

            $video->video_image = $new_image;
        }
        $video->save();
    }
    public function delete_video(Request $request)
    {
        $data = $request->all();
        $video_id = $data['video_id'];
        $video = Video::find($video_id);
        unlink('public/uploads/videos/' . $video->video_image);
        $video->delete();
    }
    public function video_home(Request $request)
    {

        //post
        $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();

        //slider
        $slider = Slider::orderBy('slider_id', 'desc')->where('slider_status', '1')->take(3)->get();

        //seo 
        $meta_desc = "Video cong ty LINHWATCH";
        $meta_keywords = "Dong ho dep lam, phu kien nua";
        $meta_title = "Video Linh Watch";
        $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $all_video = DB::table('tbl_videos')->limit(9)->get();

        return view('pages.video.video')->with('category', $cate_product)->with('brand', $brand_product)->with('all_video', $all_video)
            ->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical)->with('slider', $slider)->with('category_post', $category_post);
    }
    public function update_video_image(Request $request){
        $get_image = $request->file('file');
        $video_id = $request->video_id;
        if ($get_image) {
            $video = Video::find($video_id);
            unlink('public/uploads/videos/' . $video->video_image);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            // Inside the foreach loop, correct the file move operation
            $get_image->move('public/uploads/videos', $new_image);

           
            $video->video_image = $new_image;
            $video->save();
        }
    }
    public function watch_video(Request $request){
        $video_id = $request->video_id;
       $video = Video::find($video_id);
       $output['video_title'] = $video->video_title;
       $output['video_desc'] = $video->video_desc;
       $output['video_link'] = '<iframe width="100%" height="500px" src="https://www.youtube.com/embed/' . $video->video_link . '" 
        title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; 
        encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" 
        allowfullscreen></iframe>';
       echo json_encode($output);
    }
}
