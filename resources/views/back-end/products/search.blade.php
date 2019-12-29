@extends('back-end.layouts.master')
@section('content')
<!-- main content - noi dung chinh trong chu -->
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Sản phẩm</li>
			</ol>
		</div><!--/.row-->
		<div class="row">
			<div class="col-lg-12">
				 <div class="container">


        <h2 class="text-center">
            Laravel Excel/CSV Import
        </h2>

        @if ( Session::has('thanhcong') )
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <strong>{{ Session::get('thanhcong') }}</strong>
    </div>
    @endif

    @if ( Session::has('thatbai') )
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <strong>{{ Session::get('thatbai') }}</strong>
    </div>
    @endif
<form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
   <div class="col-md-9"> Choose your xls/csv File : <input type="file" name="file" class="form-control"  style="margin-bottom: 30px;"></div>

   <div class="col-md-3"> <input type="submit" class="btn btn-primary" style="margin-top: 20px;"></div>
</form>

</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-10"><div class="form-group">
								<label for="inputLoai" class="col-sm-3 control-label"><strong> Chọn sản phẩm </strong></label>
								<div class="col-md-6">
									<select name="sltCate" id="inputLoai" class="form-control">
						      			<option value="0">- CHỌN MỘT THƯƠNG HIỆU --</option>
						      			<?php MenuMulti($cat,0,$str='---| ',$loai); ?>   		
						      		</select>
									<script>
									    document.getElementById("inputLoai").onchange = function() {
									        if (this.selectedIndex!==0) {
									            window.location.href = this.value;
									        }        
									    };
									</script>
								</div>
								<div class="col-md-3">
									<!-- <input type="text" id="myInput" class="form-control" onkeyup="Product()" placeholder="Tìm sản phẩm..."> -->
								
									<form action="{{route('search')}}" id="formUser" method="get" role="search">
										<input type="hidden"value="{{csrf_token()}}">
										<div class="col-sm-9">	<div class="form-group sear">
											<input type="text" id="myInput" name="key" class="form-control" placeholder="Tìm kiếm sản phẩm" required>
										<!-- <input type="text"  placeholder="Search for names.." title="Type in a name"> -->
									</div></div>
										<div class="col-sm-3">	<button type="submit" class="btn btn-primary pull-right">Tìm</button></div>
									</form>
								</div>
							</div>
								
								
							</div>
							<div class="col-md-2">
								@if ($loai =='all')
									<a href="{!!url('admin/sanpham/'.$loai.'/add')!!}" title=""><button type="button" class="btn btn-primary pull-right">Thêm Mới Sản Phẩm</button></a>
								@endif
							</div>
						</div> 
						
					</div>
					@if (count($errors) > 0)
					    <div class="alert alert-danger">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					    @elseif (Session()->has('flash_level'))
					    	<div class="alert alert-success">
						        <ul>
						            {!! Session::get('flash_massage') !!}	
						        </ul>
						    </div>
						@endif
					<div class="panel-body" style="font-size: 12px;">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>										
										<th>ID</th>										
										<th>Hình ảnh</th>
										<th>Tên sản phẩm</th>
										<th>Tóm tắt chức năng</th>
										<th>Thương hiệu</th>
										<th>Giá bán</th>
										<th>Trạng thái</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="myTable">
									<?php $stt=0; ?>
									@foreach($pro as $row)
									<?php $stt++; ?>
										<tr>
											<td>{!!$stt!!}</td>
											<td> <img src="{!!url('uploads/products/'.$row->images)!!}" alt="iphone" width="50" height="40"></td>
											<td>{!!$row->name!!}</td>
											<td>{!!$row->intro!!}</td>
											<td>{!!$row->category->name!!}</td>
											<td>{!!$row->price!!} đ</td>
											<td>
												@if($row->status ==1)
													<span style="color:blue;">Còn hàng</span>
												@else
													Tạm hết hàng
												@endif
											</td>
											<td>
											    <a href="{!!url('admin/sanpham/mobile/edit/'.$row->id)!!}" title="Sửa"><span class="glyphicon glyphicon-edit">edit</span> </a>
											    <a href="{!!url('admin/sanpham/del/'.$row->id)!!}"  title="Xóa" onclick="return xacnhan('Xóa danh mục này ?')"><span class="glyphicon glyphicon-remove">remove</span> </a>
											</td>
										</tr>
									@endforeach								
								</tbody>
							</table>

						</div>
						{!! $pro->render() !!}
					</div>
				</div>
			</div>
		</div><!--/.row-->		
	</div>	<!--/.main-->
<!-- =====================================main content - noi dung chinh trong chu -->
@endsection