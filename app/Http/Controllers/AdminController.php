<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Diadiem;
use App\Comment;
use App\Bill;
use App\Tour;
use App\Http\Requests\SuaNguoiDungRequest;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function trangchu(){
        return view('admin.page_admin.trangchu');
    }

    public function getListUser($idquyen){
        if($idquyen == 1){
            $dskhach = User::where('quyen',1)->paginate(12);
            return view('admin.page_admin.danhsachnguoidung', compact('dskhach'));
        }elseif($idquyen == 2){
            $dshdv = User::where('quyen',2)->paginate(12);
            return view('admin.page_admin.danhsachnguoidung', compact('dshdv'));
        }
    }

    public function getUserEdit($id,$page){
        $dsk = User::find($id);
        return view('admin.page_admin.suathongtinuser',compact('dsk','page'));
    }

    public function postUserEdit(SuaNguoiDungRequest $request,$id,$page){
        $user = User::find($id);
        if($request->checkpassword == "on"){
        $user->password = bcrypt($request->password);
        }
        if($request->hasFile('anhdaidien')){
            $file = $request->file('anhdaidien');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != "png" && $duoi != "jpeg"){
                return redirect()->back()->with('loi','Định dạng ảnh phải là jpg, png, jpeg');
            }

            $name = $file->getClientOriginalName();
            $anhdaidien= str_random(4)."_".$name;
            while(file_exists("upload".$anhdaidien)){
                $anhdaidien= str_random(4)."_".$name;
            }
            
            $file->move("upload",$anhdaidien);
            $user->anhdaidien = $anhdaidien;
        }

        $user->hoten = $request->hoten;
        $user->gioitinh = $request->gioitinh;
        $user->sodienthoai=$request->sodienthoai;
        $user->diachi = $request->diachi;
        $user->save();
        if($user->quyen == 1)
        return redirect('admin/list-user/1?page='.$page)->with('thongbao','Sửa thông tin thành công');
        else
            return redirect('admin/list-user/2?page='.$page)->with('thongbao','Sửa thông tin thành công');
    }

    public function deleteUser($iduser){
        $user = User::find($iduser);
        $user->delete();
        return redirect()->back()->with('thongbao','Xóa thành công');
    }

    public function ChapnhanHDV($idhdv){
        $cn = User::find($idhdv);
        $cn->trangthaihdv =2;
        $cn->save();
        return redirect()->back()->with('thongbao','Bạn đã cấp quyền thành công');
    }

    public function DSBinhluan(){
        $comment = Comment::where('parent_id',0)->paginate(3);
        $traloi = Comment::where('parent_id','<>',0)->get();
        return view('admin.page_admin.dsbinhluan', compact('comment','traloi'));
    }

    public function Anbinhluan($idbl,$page){
        $comment = Comment::find($idbl);
        $comment->trangthaibinhluan = 0;
        $comment->save();
        return redirect('admin/dsbinhluan?page='.$page)->with('thongbao','Bình luận đã đưọc ẩn');
    }

    public function ThongkeDonhang(){
        $bill = Bill::paginate(12);
        return view('admin.page_admin.thongke', compact('bill'));
    }

    public function ThongkeDoanhthu(){
        $doanhthu = Bill::where('tinhtrangdon',3)->paginate(12);
        return view('admin.page_admin.thongke', compact('doanhthu'));
    }

    public function getTimkiem(Request $re,$tk){
        $this->validate($re,
            [
                'tukhoa'=>'required',
            ],
            [
                'tukhoa.required'=>'Nhập thông tin tìm kiếm',
            ]);
        $tukhoa = $re->tukhoa;
        if($tk == 'khach'){
            $dskhach = User::where('email','like','%'.$tukhoa.'%')->where('quyen','=',1)->paginate(100);
            return view('admin.page_admin.timkiemuser', compact('dskhach'));
        }elseif($tk=='hdv'){
            $dshdv = User::where('email','like','%'.$tukhoa.'%')->where('quyen','=',2)->paginate(100);
            return view('admin.page_admin.danhsachnguoidung', compact('dshdv'));
        }elseif($tk == 'binhluan'){
            $array = [];
            $arr = Tour::where('tentour','like','%'.$tukhoa.'%')->select('id')->get();
            foreach ($arr as $key => $value) {
                array_push($array, $value->id);
            }
            $comment = Comment::where('parent_id',0)->whereIn('tour_id',$array)->paginate(100);
            $traloi = Comment::where('parent_id','<>',0)->get();
            return view('admin.page_admin.tkbinhluan', compact('comment','traloi'));            
        }else{
            $dsdd = Diadiem::where('tendiadiem','like','%'.$tukhoa.'%')->paginate(100);
            return view('admin.page_admin.tkdiadiem',compact('dsdd'));
        }
    }
}
