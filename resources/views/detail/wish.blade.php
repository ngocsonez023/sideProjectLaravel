@extends('layouts.new-master')
@section('content')
<div class="container">
  <a href="{!!url('yeu-thich/delete/{id}')!!}"></a>
  <div class="row">
      <?php 
      $stt=0;
      if(empty($wish)){ ?>
          <h4 style="margin-left: 15px;">không có sản phẩm</h4>
        <?php } else { ?>
    @foreach($wish as $row)
    <?php $stt++; ?>
      @if(Auth::user()->id == $row->user_id)
        <div class="col-sm-3">
            <article class="col-item">
            <div class="photo">
              <div class="options">
                <a href="{!!url('yeu-thich/delete/'.$row->id)!!}" class="btn btn-default" type="submit" data-toggle="tooltip" data-placement="top" title="Xóa khỏi yêu thích">
                  <i class="fa fa-close"></i>
                </a>
                <button class="btn btn-default  " type="submit" data-toggle="tooltip" data-placement="top" title="Compare">
                  <i class="fa fa-exchange"></i>
                </button>
              </div>
              <div class="options-cart">
                <button class="btn btn-default" title="Add to cart">
                  <span class="fa fa-shopping-cart"></span>
                </button>
              </div>
              <a href="#"> <img src="" class="img-responsive" alt="Product Image" /> </a>
            </div>
            <div class="info">
              <div class="row">
                <div class="price-details col-md-6">
                  <h1>{!!$row->name!!}</h1>
                  <span class="price-new">{{number_format($row->price)}} Vnd</span>
                </div>
              </div>
            </div>
          </article>
            <p class="text-center">Hover over image</p>
        </div>
        @endif
      @endforeach 
     <?php } ?>
       </div>
</div>
<script type="text/javascript">
  $(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection