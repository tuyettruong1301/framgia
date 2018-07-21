<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//--------------------HDV------------------
Route::group(['prefix'=>'hdv','middleware'=>'CheckHDV'], function(){
    Route::get('trang-chu',['as' => 'trang-chu-hdv', 'uses'=>'HdvController@trangchu']);
    Route::resource('tour','TourController');
    Route::post('anhienTour/{id}',['as'=>'anhienTour','uses'=>'TourController@anhienTour']);

    Route::get('dsdontour',['as'=>'dsdontour', 'uses'=>'HdvController@getDSdontour']);
    Route::get('dsdontourmoi',['as'=>'dsdontourmoi', 'uses'=>'HdvController@getDSdontourmoi']);
    Route::get('dsdontourchapnhan',['as'=>'dsdontourchapnhan', 'uses'=>'HdvController@getDSdontourchapnhan']);
    Route::get('dsdontourthanhtoan',['as'=>'dsdontourthanhtoan', 'uses'=>'HdvController@getDSdontourthanhtoan']);
    Route::get('edit-bill/{id}/{page}','HdvController@getEditBill');

    Route::post('cndontour/{idd}',['as'=>'chapnhan', 'uses'=>'HdvController@postChapnhandon']);
    Route::post('tcdontour/{idd}',['as'=>'tuchoi', 'uses'=>'HdvController@postTuchoidon']);
    Route::post('xacnhan/{idd}',['as'=>'xacnhanditour', 'uses'=>'HdvController@postXacnhanditour']);
    Route::post('xacnhantt/{idd}',['as'=>'xacnhantt', 'uses'=>'HdvController@postXacnhantt']);
    Route::post('xoatour/{id}',['as'=>'xoatour','uses'=>'HdvController@postXoaTour']);
    Route::post('edit-bill/{id}/{page}',['as'=>'edit-bill','uses'=>'HdvController@postEditBill']);

});


//------------------ADMIN------------------
Route::group(['prefix'=>'admin','middleware'=>'CheckAdmin'],function(){
    Route::get('trang-chu',['as'=>'trang-chu-admin', 'uses'=> 'AdminController@trangchu']);

    //quan ly nguoi dung
    Route::get('list-user/{idquyen}',['as'=>'list-user', 'uses'=> 'AdminController@getListUser']);
    Route::delete('xoa-user/{iduser}',['as'=>'xoa-user', 'uses'=> 'AdminController@deleteUser']);
    Route::post('chapnhan/{idhdv}',['as'=>'cnhdv1', 'uses'=> 'AdminController@ChapnhanHdv']);
    Route::get('edit-user/{id}/{page}',['as'=>'edit-user','uses'=>'AdminController@getUserEdit']);
    Route::post('edit-user/{id}/{page}',['as'=>'edit-user','uses'=>'AdminController@postUserEdit']);

    //quan ly binh luan
    Route::get('dsbinhluan',['as'=>'dsbinhluan', 'uses'=>'AdminController@DSBinhluan']);
    Route::get('xoabinhluan/{idbl}',['as'=>'xoabinhluan', 'uses'=>'AdminController@Xoabinhluan']);
    Route::post('anbinhluan/{idbl}/{page}',['as'=>'anbinhluan', 'uses'=>'AdminController@Anbinhluan']);

    //quan ly dia diem
    Route::resource('diadiem','DiaDiemController', ['except'=>['show']]);

    //quan ly thong ke
    Route::get('thongke-donhang',['as'=>'thongke-donhang', 'uses'=> 'AdminController@ThongkeDonhang']);
    Route::get('thongke-doanhthu',['as'=>'thongke-doanhthu', 'uses'=> 'AdminController@ThongkeDoanhthu']);

    //tim kiem
    Route::get('tim-kiem/{tk}','AdminController@getTimkiem');
});

