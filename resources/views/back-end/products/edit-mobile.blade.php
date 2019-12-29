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
				<h1 class="page-header"><small>Sửa sản phẩm </small></h1>
			</div>
		</div><!--/.row-->		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">					
					<div class="panel-body" style="background-color: #ecf0f1; color:#27ae60;">
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
						<form action="" method="POST" role="form" enctype="multipart/form-data">
				      		{{ csrf_field() }}
				      		<div class="form-group">
					      		<label for="input-id">Chọn danh mục</label>

					      		<select name="sltCate" id="inputSltCate" required class="form-control">
					      			<option value="">--Chọn thương hiệu--</option>
					      			@foreach($loai as $dt)
					      				<option value="{!!$dt->name!!}" @if( $product->cat == $dt->name) selected @endif >{!!'--|--|'.$dt->name!!}</option> 	
					      			@endforeach	
					      		</select>
				      		</div>
				      		<div class="form-group">
				      			<label for="input-id">Tên sản phẩm</label>
				      			<input type="text" name="txtname" id="inputTxtname" class="form-control"  value="{{ $product->name}}"  required="required">
				      		</div>

				      		<div class="form-group">
				      			<label for="input-id">Điểm nổi bật</label>
				      			<input type="text" name="txtintro" id="inputTxtintro" class="form-control" value="{{$product->intro}}" required="required">
				      		</div>
				      		<div class="form-group">
				      			<label for="input-id">Gồm có : </label>
				      			<input type="text" name="txtpacket" id="inputtxtpacket" value="{{$product->packet}}" class="form-control" >
				      		</div>
				      		<div class="form-group">
				      			<label for="input-id">Khuyễn mãi (tối đa 3 mục vào 3 ô)</label>
				      			<div class="row">
					      			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					      				khuyễn mại 1 : <input type="text" name="txtpromo1" id="inputtxtpromo1" value="{{$product->promo1}}" class="form-control" >
					      			</div>
					      			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					      				khuyễn mại 2 : <input type="text" name="txtpromo2" id="inputtxtpromo2" value="{{$product->promo2}}" class="form-control" >
					      			</div>
					      			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					      				khuyễn mại 3 : <input type="text" name="txtpromo3" id="inputtxtpromo3" value="{{$product->promo3}}" class="form-control" >
					      			</div>
					      		</div>				      			
				      		</div>
				      		<div class="form-group">				      			
				      			<div class="row">
					      			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					      				Hình ảnh : <input type="file" name="txtimg" accept="image/png" id="inputtxtimg"  class="form-control" >
					      				Ảnh cũ: <img src="{!!url('uploads/products/'.$product->images)!!}" alt="{!!$product->images!!}" width="80" height="60">
					      			</div>
					      			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					      				Giá bán : <input type="number" name="txtprice" id="inputtxtprice" class="form-control" value="{{$product->price}}" required="required">
					      			</div>
					     		<!-- <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">	
 										
 										  <input type="checkbox" id="myCheck" name="sale_status" value="ON"  onclick="myFunction()"
 										  <?php if($product->sale_status == 'ON') { ?>
 										   checked
 										   <?php } ?>>Bật
					      				Giá khuyến mãi : 
					      				<input type="text" 
					      				<?php if($product->sale_status == 'ON'){ ?>
					      					style="display:block"
					      					<?php } else { ?> style="display:none"<?php } ?> name="price_sale"  id="text" class="form-control" value="{{$product->price_sale}}">
					      				 
					      			</div> -->
					      			<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">	
 										 <input type="checkbox" id="myCheck" name="sale_status" value="ON"  onclick="myFunction()"
 										  <?php if($product->sale_status == 'ON') { ?>
 										   checked
 										   <?php } ?>>Bật Giá khuyến mãi : 
						      			<div id="text" <?php if($product->sale_status == 'ON'){ ?> style="display:block" <?php } else { ?> style="display:none"<?php } ?>>
						      				 <input type="text" name="price_sale" value="{{$product->price_sale}}" class="form-control">
											  <div class="form-group">
												  <div class='input-group date' id='datetimepicker2'>
												       <input type='text' value="{{$product->start_date}}" name="start_date" class="form-control" />
												          <span class="input-group-addon">
												             <span class="glyphicon glyphicon-calendar"></span>
												           </span>
												     </div>
											   </div>
											   <div class="form-group">
												  <div class='input-group date' id='datetimepicker3'>
												       <input type='text' value="{{$product->end_date}}" name="end_date" class="form-control" />
												          <span class="input-group-addon">
												             <span class="glyphicon glyphicon-calendar"></span>
												           </span>
												     </div>
											   </div>
						      			</div>
					      			</div>
					      			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
					      				Tag : <input type="text" name="txttag" id="inputtag" value="{{$product->tag}}" class="form-control">
					      			</div>
					      		</div>				      			
				      		</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					      				<label for="input-id">Bài đánh giá chi tiết</label>
					      				<textarea name="content" id="inputtxtReview" class="form-control" rows="4">{{$product->content}}</textarea>
					      				<script type="text/javascript">
											var editor = CKEDITOR.replace('content',{
												language:'vi',
												filebrowserImageBrowseUrl : '../../../../plugin/ckfinder/ckfinder.html?Type=Images',
												filebrowserFlashBrowseUrl : '../../../../plugin/ckfinder/ckfinder.html?Type=Flash',
												filebrowserImageUploadUrl : '../../../../plugin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
												filebrowserFlashUploadUrl : '../../../../plugin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
											});
										</script>
					      			</div>
					      		</div>				      			
				      		</div>		      				      		

				      		<input type="submit" name="btnCateAdd" class="btn btn-primary" value="Lưu lại" class="button" />
				      	</form>			      	
					</div>
				</div>
			</div>
		</div><!--/.row-->		
	</div>	<!--/.main-->
		<script>
function myFunction() {
  var checkBox = document.getElementById("myCheck");
  var text = document.getElementById("text");
  if (checkBox.checked == true){
    text.style.display = "block";
  } else {
     text.style.display = "none";
  }
}
</script>
<!-- =====================================main content - noi dung chinh trong chu -->
@endsection