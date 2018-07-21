<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diadiem;

class DiaDiemController extends Controller
{

    public function index()
    {
        $dsdd = Diadiem::paginate(12);
        return view('admin.page_admin.danhsachdiadiem', compact('dsdd'));
    }

    public function create()
    {
        return view('admin.page_admin.themdiadiem');
    }

    public function store(Request $request)
    {
        $this-> validate($request,
            [
                'tendiadiem'=>'required|unique:diadiem,tendiadiem'
            ],
            [
                'tendiadiem.required'=>'Tên địa điểm không đưọc để trống',
                'tendiadiem.unique'=>'Địa điểm này đã tồn tại'
            ]);
        $dd = new Diadiem();
        $dd->tendiadiem = $request->tendiadiem;
        $dd->save();
        return redirect()->back()->with('thanhcong','Thêm đại điểm thành công');
    }


    public function edit($str)
    {
        $id = $str[0];
        $dd = Diadiem::find($id);
        return view('admin.page_admin.themdiadiem',compact('dd','str'));
    }

    public function update(Request $request, $str)
    {
        $arr = explode(' ',$str);
        $id = $arr[0];
        $page = $arr[1];
        $diadiem = Diadiem::find($id);
        $this-> validate($request,
            [
                'tendiadiem'=>'required|unique:diadiem,tendiadiem'
            ],
            [
                'tendiadiem.required'=>'Tên địa điểm không đưọc để trống',
                'tendiadiem.unique'=>'Địa điểm này đã tồn tại'
            ]);
        $diadiem->tendiadiem = $request->tendiadiem;
        $diadiem->save();
        return redirect('admin/diadiem?page='.$page)->with('thongbao','Sửa địa điểm thành công');
    }

    public function destroy($str)
    {
        $arr = explode(' ',$str);
        $id = $arr[0];
        $page = $arr[1];
        Diadiem::find($id)->delete();
        return redirect('admin/diadiem?page='.$page)->with('thongbao','Xóa thành công');    
    }
}
