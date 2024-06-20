<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;
use Illuminate\Support\Facades\Redirect;
use Toastr;

session_start();

use Auth;
use App\Article;
use App\Gallery;
use App\Slider;
use App\Product;
use App\Comment;
use App\Sao;
use File;


class ProductController extends Controller
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
    public function add_product()
    {
        $this->AuthLogin();
        $cate_product = DB::table('t_danhmucsanpham')->orderby('category_id', 'DESC')->get();
        $brand_product = DB::table('t_thuonghieu')->orderby('brand_id','desc')->get(); 
        return view('admin.sanpham.add_product')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
    }
    public function all_product()
    {
        $this->AuthLogin();
        $all_product = DB::table('tbl_product')
            ->join('t_danhmucsanpham', 't_danhmucsanpham.category_id', '=', 'tbl_product.category_id')
            ->join('t_thuonghieu', 't_thuonghieu.brand_id', '=', 'tbl_product.brand_id')
            ->orderBy('tbl_product.product_id', 'DESC')->get();
        $manager_product = view('admin.sanpham.all_product')->with('all_product', $all_product);
        return view('admin_layout')->with('admin.all_product', $manager_product);
    }
    public function save_product(Request $request)
    {
        $this->AuthLogin();
        $data = array();

        $product_price = filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
        $product_cost = filter_var($request->product_cost, FILTER_SANITIZE_NUMBER_INT);
        $product_km = filter_var($request->product_km, FILTER_SANITIZE_NUMBER_INT);


        $data['product_name'] = $request->product_name;
        $data['product_tags'] = $request->product_tags;
        $data['product_slug'] = $request->product_slug;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_km'] = $product_km;
        $data['product_price'] = $product_price;
        $data['product_cost'] = $product_cost;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;

        $get_image = $request->file('product_image');
        $path = 'public/uploads/product/';
        $path_gallery = 'public/uploads/gallery/';
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            File::copy($path . $new_image, $path_gallery . $new_image);
            $data['product_image'] = $new_image;
        }

        $pro_id = DB::table('tbl_product')->insertGetId($data);
        $gallery = new Gallery();
        $gallery->g_name = $new_image;
        $gallery->g_image = $new_image;
        $gallery->product_id = $pro_id;
        $gallery->save();

        Toastr::success('Thêm sản phẩm thành công', 'Thành công');
        return Redirect::to('all-product');
    }
    public function unactive_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 1]);
        Toastr::error('Không kích hoạt sản phẩm thành công', 'Không thành công');
       
        return Redirect::to('all-product');
    }
    public function active_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 0]);
        Toastr::success('Kích hoạt sản phẩm thành công', 'Thành công');

        return Redirect::to('all-product');
    }
    public function edit_product($product_id)
    {
        $this->AuthLogin();
        $cate_product = DB::table('t_danhmucsanpham')->orderby('category_id', 'desc')->get();
      
        $brand_product = DB::table('t_thuonghieu')->orderby('brand_id','desc')->get(); 
        $edit_product = DB::table('tbl_product')->where('product_id', $product_id)->get();
        $manager_product = view('admin.sanpham.edit_product')->with('edit_product', $edit_product)->with('cate_product', $cate_product)
            ->with('brand_product', $brand_product);
        return view('admin_layout')->with('admin.edit_product', $manager_product);
    }
    public function update_product(Request $request, $product_id)
    {
        $this->AuthLogin();
        $data = array();
        $product_price = filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
        $product_cost = filter_var($request->product_cost, FILTER_SANITIZE_NUMBER_INT);
        $product_km = filter_var($request->product_km, FILTER_SANITIZE_NUMBER_INT);

        $data['product_name'] = $request->product_name;
        $data['product_tags'] = $request->product_tags;
        $data['product_slug'] = $request->product_slug;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_price'] = $product_price;
        $data['product_km'] = $product_km;
        $data['product_cost'] = $product_cost;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $get_image = $request->file('product_image');

        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_imgae = current(explode('.', $get_name_image));
            $new_image = $name_imgae . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
            Toastr::success('Cập nhật sản phẩm thành công', 'Thành công');
            return Redirect::to('all-product');
        }

        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Toastr::success('Cập nhật sản phẩm thành công', 'Thành công');
        return Redirect::to('all-product');
    }
    public function delete_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->delete();
        Toastr::error('Xóa sản phẩm thành côngg', 'Thành công');
        // Session::put('message', 'Xóa sản phẩm thành công');
        return Redirect::to('all-product');
    }

    //Trang chu giao dien
    public function details_product(Request $request, $product_slug)
    {
        $category_post = Article::orderBy('article_id', 'DESC')->get();
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        $cate_product = DB::table('t_danhmucsanpham')->where('danhmuc_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('t_thuonghieu')->where('thuonghieu_status','0')->orderby('brand_id','desc')->get(); 

        $details_product = DB::table('tbl_product')
            ->join('t_danhmucsanpham', 't_danhmucsanpham.category_id', '=', 'tbl_product.category_id')
            ->join('t_thuonghieu', 't_thuonghieu.brand_id', '=', 'tbl_product.brand_id')
            ->where('tbl_product.product_slug', $product_slug)->get();

        foreach ($details_product as $key => $val) {
            $category_id = $val->category_id;
            $product_id = $val->product_id;
            $product_cate = $val->tendanhmuc;
            $cate_slug = $val->danhmuc_slug;
            //seo 
            $meta_desc = "$val->product_desc";
            $meta_keywords = "$val->product_slug";
            $meta_title = "$val->product_name";
            $url_canonical = $request->url();
            //--seo
        }

        //gallery
        $gallery = Gallery::where('product_id', $product_id)->get();

        //update view
        $product = Product::where('product_id', $product_id)->first();
        $product->product_view = $product->product_view + 1;
        $product->save();

        $splienquan = DB::table('tbl_product')
            ->join('t_danhmucsanpham', 't_danhmucsanpham.category_id', '=', 'tbl_product.category_id')
            ->join('t_thuonghieu', 't_thuonghieu.brand_id', '=', 'tbl_product.brand_id')
            ->where('t_danhmucsanpham.category_id', $category_id)->whereNotIn('tbl_product.product_slug', [$product_slug])->get();

        $rating = Sao::where('product_id', $product_id)->avg('sosao');
        $rating = round($rating);
        $ratingCount = Sao::where('product_id', $product_id)->count();

        return view('pages.sanpham.show_details')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('product_details', $details_product)->with('splienquan', $splienquan)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical)->with('category_post', $category_post)
            ->with('gallery', $gallery)->with('slider', $slider)->with('product_cate', $product_cate)
            ->with('cate_slug', $cate_slug)->with('rating', $rating)->with('ratingCount', $ratingCount);
    }
    public function tag(Request $request, $product_tag)
    {
        $category_post = Article::orderBy('article_id', 'DESC')->get();
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        $cate_product = DB::table('t_danhmucsanpham')->where('danhmuc_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('t_thuonghieu')->where('thuonghieu_status','0')->orderby('brand_id','desc')->get(); 

        $tag = str_replace("-", "", $product_tag);// thay the dau gach bang chuoi rong
        $pro_tag = Product::where('product_status', '0')->where('product_name', 'LIKE', '%' . $tag . '%')
            ->orWhere('product_tags', 'LIKE', '%' . $tag . '%')->orWhere('product_slug', 'LIKE', '%' . $tag . '%')->get();

        $meta_desc = 'Tags:' . $product_tag;
        $meta_keywords = 'Tags:' . $product_tag;
        $meta_title = 'Tags:' . $product_tag;
        $url_canonical = $request->url();

        return view('pages.sanpham.tag')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('slider', $slider)->with('category_post', $category_post)->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)
            ->with('product_tag', $product_tag)->with('pro_tag', $pro_tag);
    }
    public function quickview(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::find($product_id);
        $gallery = Gallery::where('product_id', $product_id)->get();
        $output['product_gallery'] = '';
        foreach ($gallery as $ket => $gal) {
            $output['product_gallery'] .= '<p><img  width="100%" src="public/uploads/gallery/' . $gal->g_image . '"> </p>';
        }

        $output['product_name'] = $product->product_name;
        $output['product_id'] = $product->product_id;
        $output['product_price'] = number_format($product->product_price, 0, ',', '.') . 'VND';
        $output['product_desc'] = $product->product_desc;
        $output['product_content'] = $product->product_content;
        $output['product_image'] = '<p><img width="100%" src="public/uploads/product/' . $product->product_image . '"</p>';

        $output['product_button'] = ' <input type="button" value="Mua ngay"
        class="btn btn-success btn-sm add-to-cart-quickview" 
        data-id_product="' . $product->product_id . '"  name="add-to-cart">';

        $output['product_quickview_value'] = '
        <input type="hidden" value="' . $product->product_id . '"
                class="cart_product_id_' . $product->product_id . '">
        <input type="hidden" value="' . $product->product_name . ' }}"
                class="cart_product_name_' . $product->product_id . '">
        <input type="hidden" value="' . $product->product_quantity . ' }}"
                class="cart_product_quantity_' . $product->product_id . '">
        <input type="hidden" value="' . $product->product_image . ' }}"
                class="cart_product_image_' . $product->product_id . '">   
        <input type="hidden" value="' . $product->product_price . ' }}"
                 class="cart_product_price_' . $product->product_id . '">                  
        <input type="hidden" value="1"
                class="cart_product_qty_' . $product->product_id . '">';
        echo json_encode($output);// tra ve du lieu dang json de xu li o javascript va hien thi trong model
    }
    public function load_comment(Request $request)
    {
        $product_id = $request->product_id;
        $comment = Comment::where('cmt_pr_id', $product_id)->get();
        $output = '';
        foreach ($comment as $key => $com) {
            $output .= '
            <div class="col-md-10">
                <div class="comment-box" style=" margin-bottom: 10px;">
                    <p style="color: green; font-weight: bold;">' . htmlspecialchars($com->cmt_name) . '</p>
                    <p style="color: #000; font-size: 12px;">' . htmlspecialchars($com->cmt_date) . '</p>
                    <p>' . nl2br(htmlspecialchars($com->cmt)) . '</p>
                </
                </div>
                ';
            $output .= '</div>';

            echo $output;
        }
    }
    public function send_comment(Request $request)
    {
        $product_id = $request->product_id;
        $cmt_name = $request->cmt_name;
        $comment_content = $request->comment_content;
        $comment = new Comment();
        $comment->cmt_pr_id = $product_id;
        $comment->cmt_name = $cmt_name;
        $comment->cmt = $comment_content;
       
        $comment->save();
    }
    public function list_comment()
    {
        $comment = Comment::with('product')->get();
        return view('admin.comment.list_comment')->with(compact('comment'));
    }
   
    
    public function delete_comment($cmt_id)
    {
        // Kiểm tra xem comment_id có tồn tại không
        if ($cmt_id) {
            // Xóa bình luận từ CSDL
            $deleted = Comment::where('cmt_id', $cmt_id)->delete();

            // Kiểm tra xem xóa bình luận thành công hay không
            if ($deleted) {
                Toastr::success('Bình luận đã được xóa thành công', 'Thành công');
                return redirect()->back()->with('success', 'Bình luận đã được xóa thành công.');
            } else {
                Toastr::error('Xóa bình luận thất bại. Vui lòng thử lại sau.', 'Lỗi');
                return redirect()->back()->with('error', 'Xóa bình luận thất bại. Vui lòng thử lại sau.');
            }
        } else {
            Toastr::error('Không tìm thấy bình luận cần xóa.', 'Lỗi');
            return redirect()->back()->with('error', 'Không tìm thấy bình luận cần xóa.');
        }
    }

    public function insert_rating(Request $request)
    {
        try {
            \Log::info('Request Data: ', $request->all()); 

            $data = $request->all();

            if (!isset($data['product_id']) || !isset($data['index'])) {
                \Log::error('Thiếu Id sản phẩm', $data);
                return response()->json(['message' => 'Thiếu Id sản phẩm'], 400);
            }

            $rating = new Sao();
            $rating->product_id = $data['product_id'];
            $rating->sosao = $data['index'];
            $rating->save();

            return response()->json(['message' => 'done'], 200);
        } catch (\Exception $e) {
            \Log::error('Lỗi khi đánh giá sao: ' . $e->getMessage());
            return response()->json(['message' => 'Server Error'], 500);
        }
    }
}
