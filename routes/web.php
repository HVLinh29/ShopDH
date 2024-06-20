<?php
use Illuminate\Support\Facades\Route;
//Fontend
Route::get('/','HomeController@index' );
Route::post('/load-more','HomeController@load_more' );
Route::get('/trang-chu','HomeController@index');
Route::post('/tim-kiem','HomeController@search');
Route::post('/autocomplete-ajax','HomeController@autocomplete_ajax');

//Danh muc san pham trang chu
Route::get('/danh-muc-san-pham/{category_id}','CategoryProduct@show_category_home');
Route::get('/thuong-hieu-san-pham/{brand_id}','BrandProduct@show_brand_home');
Route::get('/chi-tiet-san-pham/{product_id}','ProductController@details_product');
Route::get('/tag/{product_tag}','ProductController@tag');
Route::get('/comment','ProductController@list_comment');
//Binh luan va danh gia sao
Route::post('/quickview','ProductController@quickview');
Route::post('/load-comment','ProductController@load_comment');
Route::post('/send-comment','ProductController@send_comment');


Route::get('/delete-comment/{cmt_id}','ProductController@delete_comment');
Route::post('/insert-rating','ProductController@insert_rating');

//Lien he
Route::get('/lien-he','ContactController@lien_he');
Route::get('/infomation','ContactController@infomation');
Route::post('/save-info','ContactController@save_info');
Route::post('/update-info/{info_id}','ContactController@update_info');

//Danh muc bai viet
Route::get('/danh-muc-bai-viet/{baiviet_slug}','PostController@danh_muc_bai_viet');
Route::get('/bai-viet/{baiviet_slug}','PostController@bai_viet');

//Backend
Route::get('/admin','AdminController@index');
Route::get('/dashboard','AdminController@show');
Route::post('/admin-dashboard','AdminController@dashboard');
Route::get('/logout','AdminController@logout');

Route::post('/filter-by-date','AdminController@filter_by_date');
Route::post('/dashboard-filter','AdminController@dashboard_filter');
Route::post('/days-order','AdminController@days_order');


//Category Product
Route::get('/add-category-product','CategoryProduct@add_category_product');
Route::get('/edit-category-product/{category_product_id}','CategoryProduct@edit_category_product');
Route::get('/delete-category-product/{category_product_id}','CategoryProduct@delete_category_product');
Route::get('/all-category-product','CategoryProduct@all_category_product');
Route::get('/edit-category-product','CategoryProduct@add_category_product');

Route::post('/save-category-product','CategoryProduct@save_category_product');
Route::post('/update-category-product/{category_product_id}','CategoryProduct@update_category_product');

Route::get('/unactive-category-product/{category_product_id}','CategoryProduct@unactive_category_product');
Route::get('/active-category-product/{category_product_id}','CategoryProduct@active_category_product');

Route::post('/export-csv','CategoryProduct@export_csv');
Route::post('/import-csv','CategoryProduct@import_csv');


//Brand Product
Route::get('/add-brand-product','BrandProduct@add_brand_product');
Route::get('/edit-brand-product/{brand_product_id}','BrandProduct@edit_brand_product');
Route::get('/delete-brand-product/{brand_product_id}','BrandProduct@delete_brand_product');
Route::get('/all-brand-product','BrandProduct@all_brand_product');
Route::get('/edit-brand-product','BrandProduct@add_brand_product');

Route::post('/save-brand-product','BrandProduct@save_brand_product');
Route::post('/update-brand-product/{brand_product_id}','BrandProduct@update_brand_product');

Route::get('/unactive-brand-product/{brand_product_id}','BrandProduct@unactive_brand_product');
Route::get('/active-brand-product/{brand_product_id}','BrandProduct@active_brand_product');

//Product
Route::get('/add-product','ProductController@add_product');
Route::get('/edit-product/{product_id}','ProductController@edit_product');
Route::get('/delete-product/{product_id}','ProductController@delete_product');
Route::get('/all-product','ProductController@all_product');
Route::get('/edit-product','ProductController@add_product');

Route::post('/save-product','ProductController@save_product');
Route::post('/update-product/{product_id}','ProductController@update_product');

Route::get('/unactive-product/{product_id}','ProductController@unactive_product');
Route::get('/active-product/{product_id}','ProductController@active_product');

//Gio hang
Route::post('/save-cart','CartController@save_cart');
Route::get('/show-cart','CartController@show_cart');
Route::get('/delete-to-cart/{rowId}','CartController@delete_to_cart');
Route::post('/update-cart-quantity','CartController@update_cart_quantity');
Route::post('/add-cart-ajax','CartController@add_cart_ajax');
Route::get('/gio-hang','CartController@gio_hang');
Route::post('/update-cart','CartController@update_cart');
Route::get('/del-product/{session_id}','CartController@delete_product');
Route::get('/del-all-product','CartController@delete_all_product');
Route::get('/show-cart','CartController@show_cart_qty');


//Ma giam gia
Route::post('/check-coupon','CartController@check_coupon');
//admin
Route::get('/unset-coupon','CouponController@unset_coupon');
Route::get('/insert-coupon','CouponController@insert_coupon');
Route::get('/list-coupon','CouponController@list_coupon');
Route::get('/delete-coupon/{coupon_id}','CouponController@delete_coupon');
Route::post('/insert-coupon-code','CouponController@insert_coupon_code');

//Thanh toan
Route::get('/login-checkout','CheckoutController@login_checkout');
Route::get('/logout-checkout','CheckoutController@logout_checkout');
Route::get('/dang-ki','CheckoutController@dangki');
Route::post('/add-customer','CheckoutController@add_customer');
Route::post('/login-customer','CheckoutController@login_customer');
Route::get('/thanhtoan','CheckoutController@checkout')->name('thanhtoan');
Route::get('/payment','CheckoutController@payment');
Route::post('/save-checkout-customer','CheckoutController@save_checkout_customer');
Route::post('/order-place','CheckoutController@order_place');
Route::post('/select-delivery-home','CheckoutController@select_delivery_home');
Route::post('/calculate-fee','CheckoutController@calculate_fee');
Route::get('/del-fee','CheckoutController@del_fee');
Route::post('/confirm-order','CheckoutController@confirm_order');
Route::get('/handcash','CheckoutController@handcash');

//Don hang dat 
Route::get('/lich-su-don-hang/{order_code}','OrderController@lich_su_don_hang');
Route::get('/lichsudh','OrderController@lichsudh');
Route::get('/print-order/{checkout_code}','OrderController@print_order');
Route::get('/manage-order','OrderController@manage_order');
Route::get('/delete-order/{orderCode}','OrderController@delete_order');
Route::get('/view-order/{order_code}','OrderController@view_order');
Route::post('/update-order-qty','OrderController@update_order_qty');
Route::post('/update-qty','OrderController@update_qty');
Route::post('/huy-don-hang','OrderController@huy_don_hang');

//Van chuyen
Route::get('/delivery','DeliveryController@delivery');
Route::post('/select-delivery','DeliveryController@select_delivery');
Route::post('/insert-delivery','DeliveryController@insert_delivery');
Route::post('/select-feeship','DeliveryController@select_feeship');
Route::post('/update-delivery','DeliveryController@update_delivery');

//SenD Mail
Route::get('/send-mail','MailController@send_mail');
Route::get('/send-coupon-vip/{coupon_time}/{coupon_condition}/{coupon_number}/{coupon_code}','MailController@send_coupon_vip');
Route::get('/send-coupon/{coupon_time}/{coupon_condition}/{coupon_number}/{coupon_code}','MailController@send_coupon');
Route::get('/quen-mk','MailController@quen_mk');
Route::get('/new-pass','MailController@new_pass');
Route::post('/new-pass-new','MailController@new_pass_new');
Route::post('/recover-pass','MailController@recover_pass');

//Login google
Route::get('/login-google','AdminController@login_google');
Route::get('/google/callback','AdminController@callback_google');

//Thanh toan Online
Route::post('/vnpay-payment','CheckoutController@vnpay_payment');
Route::post('/momo-payment','CheckoutController@momo_payment');

//Banner
Route::get('/managa-slider','SliderController@manage_slider');
Route::get('/add-slider','SliderController@add_slider');
Route::post('/insert-slider','SliderController@insert_slider');
Route::get('/unactive-slider/{slider_id}','SliderController@unactive_slider');
Route::get('/active-slider/{slider_id}','SliderController@active_slider');
Route::get('/delete-slider/{slider_id}','SliderController@delete_slider');

//Phan quyen
Route::get('/register-auth','AuthController@register_auth');
Route::get('/login-auth','AuthController@login_auth');
Route::get('/logout-auth','AuthController@logout_auth');
Route::post('/register','AuthController@register');
Route::post('/login','AuthController@login');

//User
Route::group(['middleware' => 'auth.roles', 'aurh.roles'=>['admin','author']], function () {
	Route::get('/add-product','ProductController@add_product');
	Route::get('/edit-product/{product_id}','ProductController@edit_product');
});
Route::get('users','UserController@index')->middleware('auth.roles');
Route::get('add-users','UserController@add_users')->middleware('auth.roles');
Route::get('delete-user-roles/{admin_id}','UserController@delete_user_roles')->middleware('auth.roles');
Route::get('transferrights/{admin_id}','UserController@transferrights');
Route::get('transferrights-destroy','UserController@transferrights_destroy');
Route::post('store-users','UserController@store_users');
Route::post('assign-roles','UserController@assign_roles')->middleware('auth.roles');

//Danh muc Bai viet
Route::get('/add-category-post','CategoryPost@add_category_post');
Route::get('/edit-category-post/{article_id}','CategoryPost@edit_category_post');
Route::post('/save-category-post','CategoryPost@save_category_post');
Route::get('list-category-post','CategoryPost@list_category_post');
Route::get('/danh-muc-bai-viet/{article_slug}','CategoryPost@danh_muc_bai_viet');
Route::post('/update-category-post/{cate_id}','CategoryPost@update_category_post');
Route::get('/delete-category-post/{cate_id}','CategoryPost@delete_category_post');

//Bai viet
Route::get('/add-post','PostController@add_post');
Route::get('/list-post','PostController@list_post');
Route::post('/save-post','PostController@save_post');
Route::get('/delete-post/{id_baiviet}','PostController@delete_post');
Route::get('/edit-post/{id_baiviet}', 'PostController@edit_post');
Route::post('/update-post/{id_baiviet}', 'PostController@update_post');


//Gallery
Route::get('/add-gallery/{product_id}','GalleryController@add_gallery');
Route::post('/select-gallery','GalleryController@select_gallery');
Route::post('/insert-gallery/{pro_id}','GalleryController@insert_gallery');
Route::post('/update-gallery-name','GalleryController@update_gallery_name');
Route::post('/delete-gallery','GalleryController@delete_gallery');
Route::post('/update-gallery','GalleryController@update_gallery');

//video
Route::get('/video','VideoController@video');
Route::get('/video-linhwatch','VideoController@video_home');
Route::post('/select-video','VideoController@select_video');
Route::post('/insert-video','VideoController@insert_video');
Route::post('/update-video','VideoController@update_video');
Route::post('/delete-video','VideoController@delete_video');
Route::post('/update-video-image','VideoController@update_video_image');
Route::post('/watch-video','VideoController@watch_video');

//Dang nhap khach hang bang google
Route::get('/customer-gg','AdminController@customer_gg');
Route::get('/google/callback','AdminController@callback_google_customer');

//Thanh toan paypal
Route::get('create-transaction', 'PayPalController@createTransaction')->name('createTransaction');
Route::get('process-transaction', 'PayPalController@processTransaction')->name('processTransaction');
Route::get('success-transaction', 'PayPalController@successTransaction')->name('successTransaction');
Route::get('cancel-transaction', 'PayPalController@cancelTransaction')->name('cancelTransaction');



Route::post('/add-to-wishlist', 'WishlistController@addToWishlist');

Route::get('/yeuthichhhh', 'WishlistController@showWishlist');









