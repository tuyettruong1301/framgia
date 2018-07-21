@extends('admin.layout_admin.index')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">      
            <div class="col-lg-12">
                <h1 class="page-header">Danh sách
                    <small>Bình luận</small>
                </h1>
            </div>
            @if(session('thongbao'))
                <div class="alert alert-success thongbao">
                    {{session('thongbao')}}
                </div>
            @endif  
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr align="center">
                        <th>Tên tour</th>
                        <th>Email bình luận</th>
                        <th>Nội dung bình luận</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody> 
                    @foreach($comment as $bl)
                            <tr class="odd gradeX">
                                <td><a href="{{route('chi-tiet',$bl->tour_id)}}">{{$bl->tour->tentour}}</a></td>
                                <td>{{$bl->users->email}}</td>
                                <td>{{$bl->noidung}}</td>
                                <td>
                                    @if($bl->trangthaibinhluan == 0)
                                        <div style="color: red"> Ẩn </div>
                                    @else
                                        <form action="admin/anbinhluan/{{$bl->id}}/{{$comment->currentPage()}}" method="post" onclick="return an()">
                                               <input type="hidden" name="_token" value="{{csrf_token()}}">
                                               <button type="submit" class="btn btn-primary">Hiện </button>    
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @foreach($traloi as $tl)
                                @if($tl->parent_id == $bl->id && $bl->trangthaibinhluan == 1)
                                    <tr class="odd gradeX">
                                        <td></td>
                                        <td>{{$tl->users->email}}</td>
                                        <td>{{$tl->noidung}}</td>
                                        <td>
                                            @if($tl->trangthaibinhluan == 0)
                                                <div style="color: red"> Ẩn </div>
                                            @else
                                                <form action="admin/anbinhluan/{{$tl->id}}/{{$comment->currentPage()}}" method="post" onclick="return an()">
                                                       <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                       <button type="submit" class="btn btn-primary">Hiện </button>    
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        function an(){
            return confirm('Bạn có chắc chắn muốn ẩn bình luận này?')
        }
    </script>
@endsection