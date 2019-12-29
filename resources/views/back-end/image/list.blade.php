@extends('back-end.layouts.master')
@section('content')
<!-- main content - noi dung chinh trong chu -->
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Thư viện hình ảnh</li>
			</ol>
		</div><!--/.row-->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel-heading">
					Thư viện hình ảnh sản phẩm					
				</div>
				<a href="{!!url('admin/thuvien/add')!!}" title=""><button type="button" class="btn btn-primary pull-right">Thêm mới hình ảnh</button></a>
				<div class="panel panel-default">					
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
					<div class="panel-body" style="font-size: 13px;">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>										
										<td>Số thứ tự </td>
										<td>Tên Hình ảnh</td>
										<td>Hình ảnh</td>
									</tr>
								</thead>
								<?php $stt=0; ?>
									@foreach($image as $row)
									<?php $stt++; ?>
										<tr>
											<td>{{ $stt }}</td>
											<td>{!!$row->image!!}</td>
											<td> <img src="{!!url('uploads/products/'.$row->image)!!}" alt="iphone" width="50" height="40"></td>
										</tr>
									@endforeach			
								<tbody>
														
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->		
	</div>	<!--/.main-->
<!-- =====================================main content - noi dung chinh trong chu -->
@endsection