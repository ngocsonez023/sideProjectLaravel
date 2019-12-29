@extends('layouts.master') @section('content')
<section class="product-news">
    <div class="container">
 <script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
      alert(msg);
    }
  </script>
<div id="retrieve-resources"></div>
        <div class="title-products">
            <h4> Sản phẩm giảm giá </h4></div>
        <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel" data-interval="1000">
            <div class="MultiCarousel-inner">
                @foreach($products as $row) @if($row->start_date < $timenow && $row->end_date > $timenow )
                    <div class="item">
                        <div class="image-products">
                            <img src="{!!url('uploads/products/'.$row->images)!!}" alt="Avatar" class="image" style="width:100%">
                            <?php $flash = $row->price - $row->price_sale  ?>
                                <div class="flash">Giảm {{number_format($flash)}} Vnđ</div>
                                <a href="{!!url('gio-hang/addcart/'.$row->id)!!}" >
                                    <div class="text">
                                        Thêm vào giỏ hàng
                                    </div>
                                </a>
                                <a href="{!!url('mobile/'.$row->id.'-'.$row->slug)!!}"><h4><small class="title-mobile">{!!$row->name!!}</small></h4></a>
                                <div class="row">
                                    <span class="price-home-sale"><strong> {!!number_format($row->price_sale)!!}</strong> đ </span>
                                    <span class="price-home"><strong> {!!number_format($row->price)!!}</strong> Đ </span>
                                </div>
                        </div>
                    </div>
                    @endif @endforeach
            </div>
            <button class="btn btn-primary leftLst"><</button>
                    <button class="btn btn-primary rightLst">></button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <h3 class="title-slider">
                   Sản phẩm mới</h3>
        </div>
        <div class="col-md-3">
            <!-- Controls -->
            <div class="controls pull-right hidden-xs">
                <a class="left fa fa-chevron-left btn btn-success" href="#carousel-example" data-slide="prev"></a>
                <a class="right fa fa-chevron-right btn btn-success" href="#carousel-example" data-slide="next"></a>
            </div>
        </div>
    </div>

    <div id="carousel-example" class="carousel slide hidden-xs" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <div class="row">
                    <?php $stt=0; ?>
                        @foreach($products_new as $row)
                        <?php $stt++; ?>
                            @if($stt > 0 && $stt < 5) <div class="col-sm-3">
                                <div class="col-item">
                                    <div class="photo">
                                        <img src="{!!url('uploads/products/'.$row->images)!!}" class="img-responsive" alt="a" />
                                    </div>
                                    <div class="info">
                                        <div class="row">
                                            <div class="price col-md-6">
                                                <h5>
                                               {{$row->name}}</h5>
                                                <h5 class="price-text-color">
                                              @if(isset($row->price_sale) && $row->sale_status == 'ON' && $row->start_date < $timenow && $row->end_date > $timenow)
                                                <span class="price-home-sale"><strong> {!!number_format($row->price_sale)!!}</strong> đ </span>
                                                  <span class="price-home"><strong> {!!number_format($row->price)!!}</strong> Đ </span>
                                              @else
                                                  <span class="price-home-sale"><strong> {!!number_format($row->price)!!}</strong> đ </span>
                                              @endif
                                            </h5>
                                            </div>
                                            <div class="rating hidden-sm col-md-6">
                                                <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                            </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                            </i><i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="separator clear-left">
                                            <p class="btn-add">
                                                <i class="fa fa-shopping-cart"></i>
                                                <!-- <a href="{!!url('gio-hang/addcart/'.$row->id)!!}" class="hidden-sm">Thêm vào giỏ hàng</a> -->
                                                <button onclick="addToCart({{$row->id}})" class="hidden-sm">Thêm vào giỏ hàng</button>

                                            </p>
                                           <!--  <p class="btn-details">
                                                <i class="fa fa-list"></i><a href="{!!url('mobile/'.$row->id.'-'.$row->slug)!!}" class="hidden-sm">Chi tiết sản phẩm</a></p> -->
                                                @if(\Auth::check() && $row->id == $row->pro_id && $row->user_id == Auth::user()->id)
                                                    <p>Đã yêu thích</p>
                                                @else
                                                     @if (Auth::guest())
                                                      <button type="submit" class="btn" onclick="myLoginCart()">Yêu thích </button>
                                                    <!-- <input id="b1" type='button'  value='Yêu thích'> -->
                                                     @else
                                                    <form action="{{route('addwishlist')}}" method="post" role="form">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" value="{{$row->id}}" name="pro_id">
                                                        <button type="submit" class="btn">Yêu thích </button>

                                                    </form>
                                                @endif
                                                @endif
                                        </div>
                                        <div class="clearfix">
                                        </div>
                                    </div>
                                </div>
                </div>
                @endif @endforeach
            </div>
        </div>
        <div class="item">
            <div class="row">
                <?php $stt=0; ?>
                    @foreach($products_new as $row)
                    <?php $stt++; ?>
                        @if($stt > 4 && $stt< 9) <div class="col-sm-3">
                            <div class="col-item">
                                <div class="photo">
                                    <img src="{!!url('uploads/products/'.$row->images)!!}" class="img-responsive" alt="a" />
                                </div>
                                <div class="info">
                                    <div class="row">
                                        <div class="price col-md-6">
                                            <h5>
                                               {{$row->name}}</h5>
                                            <h5 class="price-text-color">
                                              @if(isset($row->price_sale) && $row->sale_status == 'ON' && $row->start_date < $timenow && $row->end_date > $timenow)
                                                <span class="price-home-sale"><strong> {!!number_format($row->price_sale)!!}</strong> đ </span>
                                                  <span class="price-home"><strong> {!!number_format($row->price)!!}</strong> Đ </span>
                                              @else
                                                  <span class="price-home-sale"><strong> {!!number_format($row->price)!!}</strong> đ </span>
                                              @endif
                                            </h5>
                                        </div>
                                        <div class="rating hidden-sm col-md-6">
                                            <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                            </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                            </i><i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <div class="separator clear-left">
                                        <p class="btn-add">
                                            <i class="fa fa-shopping-cart"></i><a href="{!!url('gio-hang/addcart/'.$row->id)!!}" class="hidden-sm">Thêm vào giỏ hàng</a></p>
                                        <p class="btn-details">
                                            <i class="fa fa-list"></i><a href="{!!url('mobile/'.$row->id.'-'.$row->slug)!!}" class="hidden-sm">Chi tiết sản phẩm</a></p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
            </div>
            @endif @endforeach
        </div>
    </div>
    </div>
    </div>
    </div>
    <!--    <div class="row">
        <div class="row">
            <div class="col-md-9">
                <h3>
                    Carousel Product Cart Slider</h3>
            </div>
            <div class="col-md-3">
                <div class="controls pull-right hidden-xs">
                    <a class="left fa fa-chevron-left btn btn-primary" href="#carousel-example-generic"
                        data-slide="prev"></a><a class="right fa fa-chevron-right btn btn-primary" href="#carousel-example-generic"
                            data-slide="next"></a>
                </div>
            </div>
        </div>
        <div id="carousel-example-generic" class="carousel slide hidden-xs" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="col-item">
                                <div class="photo">
                                    <img src="http://placehold.it/350x260" class="img-responsive" alt="a" />
                                </div>
                                <div class="info">
                                    <div class="row">
                                        <div class="price col-md-6">
                                            <h5>
                                                Sample Product</h5>
                                            <h5 class="price-text-color">
                                                $199.99</h5>
                                        </div>
                                        <div class="rating hidden-sm col-md-6">
                                            <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                            </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                            </i><i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <div class="separator clear-left">
                                        <p class="btn-add">
                                            <i class="fa fa-shopping-cart"></i><a href="http://www.jquery2dotnet.com" class="hidden-sm">Add to cart</a></p>
                                        <p class="btn-details">
                                            <i class="fa fa-list"></i><a href="http://www.jquery2dotnet.com" class="hidden-sm">More details</a></p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-item">
                                <div class="photo">
                                    <img src="http://placehold.it/350x260" class="img-responsive" alt="a" />
                                </div>
                                <div class="info">
                                    <div class="row">
                                        <div class="price col-md-6">
                                            <h5>
                                                Product Example</h5>
                                            <h5 class="price-text-color">
                                                $249.99</h5>
                                        </div>
                                        <div class="rating hidden-sm col-md-6">
                                        </div>
                                    </div>
                                    <div class="separator clear-left">
                                        <p class="btn-add">
                                            <i class="fa fa-shopping-cart"></i><a href="http://www.jquery2dotnet.com" class="hidden-sm">Add to cart</a></p>
                                        <p class="btn-details">
                                            <i class="fa fa-list"></i><a href="http://www.jquery2dotnet.com" class="hidden-sm">More details</a></p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-item">
                                <div class="photo">
                                    <img src="http://placehold.it/350x260" class="img-responsive" alt="a" />
                                </div>
                                <div class="info">
                                    <div class="row">
                                        <div class="price col-md-6">
                                            <h5>
                                                Next Sample Product</h5>
                                            <h5 class="price-text-color">
                                                $149.99</h5>
                                        </div>
                                        <div class="rating hidden-sm col-md-6">
                                            <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                            </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                            </i><i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <div class="separator clear-left">
                                        <p class="btn-add">
                                            <i class="fa fa-shopping-cart"></i><a href="http://www.jquery2dotnet.com" class="hidden-sm">Add to cart</a></p>
                                        <p class="btn-details">
                                            <i class="fa fa-list"></i><a href="http://www.jquery2dotnet.com" class="hidden-sm">More details</a></p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="col-item">
                                <div class="photo">
                                    <img src="http://placehold.it/350x260" class="img-responsive" alt="a" />
                                </div>
                                <div class="info">
                                    <div class="row">
                                        <div class="price col-md-6">
                                            <h5>
                                                Product with Variants</h5>
                                            <h5 class="price-text-color">
                                                $199.99</h5>
                                        </div>
                                        <div class="rating hidden-sm col-md-6">
                                            <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                            </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                            </i><i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <div class="separator clear-left">
                                        <p class="btn-add">
                                            <i class="fa fa-shopping-cart"></i><a href="http://www.jquery2dotnet.com" class="hidden-sm">Add to cart</a></p>
                                        <p class="btn-details">
                                            <i class="fa fa-list"></i><a href="http://www.jquery2dotnet.com" class="hidden-sm">More details</a></p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-item">
                                <div class="photo">
                                    <img src="http://placehold.it/350x260" class="img-responsive" alt="a" />
                                </div>
                                <div class="info">
                                    <div class="row">
                                        <div class="price col-md-6">
                                            <h5>
                                                Grouped Product</h5>
                                            <h5 class="price-text-color">
                                                $249.99</h5>
                                        </div>
                                        <div class="rating hidden-sm col-md-6">
                                        </div>
                                    </div>
                                    <div class="separator clear-left">
                                        <p class="btn-add">
                                            <i class="fa fa-shopping-cart"></i><a href="http://www.jquery2dotnet.com" class="hidden-sm">Add to cart</a></p>
                                        <p class="btn-details">
                                            <i class="fa fa-list"></i><a href="http://www.jquery2dotnet.com" class="hidden-sm">More details</a></p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-item">
                                <div class="photo">
                                    <img src="http://placehold.it/350x260" class="img-responsive" alt="a" />
                                </div>
                                <div class="info">
                                    <div class="row">
                                        <div class="price col-md-6">
                                            <h5>
                                                Product with Variants</h5>
                                            <h5 class="price-text-color">
                                                $149.99</h5>
                                        </div>
                                        <div class="rating hidden-sm col-md-6">
                                            <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                            </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                            </i><i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <div class="separator clear-left">
                                        <p class="btn-add">
                                            <i class="fa fa-shopping-cart"></i><a href="http://www.jquery2dotnet.com" class="hidden-sm">Add to cart</a></p>
                                        <p class="btn-details">
                                            <i class="fa fa-list"></i><a href="http://www.jquery2dotnet.com" class="hidden-sm">More details</a></p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
</section>

@endsection