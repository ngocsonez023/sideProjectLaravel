@extends('back-end.layouts.master')
@section('content')
<!-- main content - noi dung chinh trong chu -->
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Nhân viên</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"><small>Sửa thông tin nhân viên</small></h1>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">					
					<div class="panel-body">
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
						<form action="" method="POST" role="form">
				      		{{ csrf_field() }}
				      		<div class="form-group">
					      		<label for="input-id"> Chọn Quyền </label>
					      		<select name="level" id="inputSltCate" class="form-control">
					      		@if($data->level == 1)	
					      			<option value="1" selected>- Quản trị --</option>
					      		@else	 	
					      			<option value="2" selected>- Nhân viên --</option> 
					      		@endif
					      		</select>
				      		</div>
				      		<div class="form-group">
				      			<label for="input-id">Tên Nhân viên</label>
				      			<input type="text" name="name" id="inputTxtName" class="form-control" value="{{$data->name}}" required="required">
				      		</div>
				      		<div class="form-group">
				      			<label for="input-id">Email</label>
				      			<input type="text" name="email" class="form-control" value="{{$data->email}}" required="required">
				      		</div>
				      		<div class="form-group">
				      			<label for="input-id">Password</label>
				      			<input type="password" name="password" class="form-control"  required="required">
				      		</div>
				      		<input type="submit" name="btnCateAdd" class="btn btn-primary" value="Thêm danh mục" class="button" />
				      	</form>					      	
					</div>
				</div>
			</div>
		</div><!--/.row-->		
	</div>	<!--/.main-->
<!-- =====================================main content - noi dung chinh trong chu -->
@endsection