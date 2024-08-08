@extends('layout.helper')
@section('content')
    <!-- Start Hero Area -->
    <section class="hero-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 custom-padding-right">
                    <div class="slider-head">
                        <!-- Start Hero Slider -->
                        <div class="hero-slider">
                            <!-- Start Single Slider -->
                            @foreach($products as $product=>$value)
                                <div class="single-slider"
                                     style="background-image: url({{ url('uploads/' . $value->photo) }});">
                                    <div class="content">
                                        <h2><span>{{$value->category->name}}</span>
                                            {{$value->name}}
                                        </h2>
                                        <p>{{$value->description}}</p>
                                        <h3><span>Now Only</span> ${{($value->price)*(100-$value->percentage)/100}}</h3>
                                        <div class="button">
                                            <a href="product-grids.html" class="btn">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- End Single Slider -->
                        </div>
                        <!-- End Hero Slider -->
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-12 md-custom-padding">
                            <!-- Start Small Banner -->
                            <div class="hero-small-banner"
                                 style="background-image: url('assets/front/assets/images/hero/slider-bnr.jpg');">
                                <div class="content">
                                    <h2>
                                        <span>New line required</span>
                                        iPhone 12 Pro Max
                                    </h2>
                                    <h3>$259.99</h3>
                                </div>
                            </div>
                            <!-- End Small Banner -->
                        </div>
                        <div class="col-lg-12 col-md-6 col-12">
                            <!-- Start Small Banner -->
                            <div class="hero-small-banner style2">
                                <div class="content">
                                    <h2>Weekly Sale!</h2>
                                    <p>Saving up to 50% off all online store items this week.</p>
                                    <div class="button">
                                        <a class="btn" href="product-grids.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Start Small Banner -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero Area -->

    <!-- Start Trending Product Area -->
    <section class="trending-product section" style="margin-top: 12px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Products</h2>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                            suffered alteration in some form.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($products_main as $product => $value)
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Start Single Product -->
                        <div class="single-product">
                            <div class="product-image">
                                <img src="{{ ('uploads/' . $value->photo) }}" alt="#">
                                @if($value->percentage>0)
                                    <span class="sale-tag">-{{number_format($value->percentage), 2}}%</span>
                                @endif
                                <div class="button">
                                    <button onclick="addProductCart({{$value->id}},'{{$value->name}}', {{$value->price}}, {{$value->percentage}} )" id="id{{$value->id}}" class="btn add-to-cart-btn">
                                        <i class="lni lni-cart"></i>
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <span class="category">{{$value->category->name}}</span>
                                <h4 class="title">
                                    <a href="{{route('product.details', $value->id)}}">{{$value->name}}</a>
                                </h4>
                                <ul class="review">
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><span>5.0 Review(s)</span></li>
                                </ul>
                                <div class="price">
                                    @if($value->percentage==0)
                                        <span>${{number_format($value->price), 2}}</span>
                                    @else
                                        <span>${{number_format(($value->price)*(100-$value->percentage)/100), 2}}</span>
                                    @endif
                                    @if($value->percentage>0)
                                        <span class="discount-price">${{number_format($value->price), 2}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- End Single Product -->
                    </div>
                @endforeach
                    <script>
                        function addProductCart(id, name, price, per) {
                            let productsLocal = window.localStorage.getItem('productsLocal')
                            if (!productsLocal) {
                                productsLocal = {};
                            } else {
                                productsLocal = JSON.parse(productsLocal);
                            }
                            let keyId = 'id'+id
                            let key = true
                            let productsLocalNew = {}
                            Object.values(productsLocal).forEach(item => {
                                if(item.id === id){
                                    key = false
                                    document.getElementById('id'+item.id).innerHTML = 'Add to Cart'
                                }else{
                                    let k = 'id'+item.id
                                    productsLocalNew[k] = {
                                        id:item.id,
                                        name: item.name,
                                        price: item.price,
                                        per: item.per,
                                        qnt: item.qnt
                                    }
                                }
                            });
                            if(key){
                                productsLocalNew[keyId] = {
                                    id:id,
                                    name: name,
                                    price: price,
                                    per: per,
                                    qnt: 1
                                }
                            }
                            window.localStorage.setItem('productsLocal', JSON.stringify(productsLocalNew));
                            checkBtnText()
                        }
                        function checkBtnText(){

                            let productsLocal = window.localStorage.getItem('productsLocal')
                            if (!productsLocal) {
                                productsLocal = {};
                            } else {
                                productsLocal = JSON.parse(productsLocal);
                            }

                            Object.values(productsLocal).forEach(item => {
                                document.getElementById('id'+item.id).innerHTML = 'Remove Cart'
                            });
                        }
                        window.addEventListener("load", function(event) {
                            checkBtnText()
                        });
                    </script>
            </div>
        </div>
    </section>
    <!-- End Trending Product Area -->

    <!-- Start Call Action Area -->
    <section class="call-action section">
        <div class="container">
            <div class="row ">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="inner">
                        <div class="content">
                            <h2 class="wow fadeInUp" data-wow-delay=".4s">Currently You are using free<br>
                                Lite version of ShopGrids</h2>
                            <p class="wow fadeInUp" data-wow-delay=".6s">Please, purchase full version of the template
                                to get all pages,<br> features and commercial license.</p>
                            <div class="button wow fadeInUp" data-wow-delay=".8s">
                                <a href="javascript:void(0)" class="btn">Purchase Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Call Action Area -->

    <!-- Start Banner Area -->
    <section class="banner section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="single-banner"
                         style="background-image:url({{('uploads/' . $product1->photo)}})">
                        <div class="content">
                            <h2>{{$product1->name}}</h2>
                            <p>{{$product1->description}} <br>Black/Volt Real Sport Band </p>
                            <div class="button">
                                <a href="{{route('product.details', $product1->id)}}" class="btn">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="single-banner custom-responsive-margin"
                         style="background-image:url({{('uploads/' . $product2->photo)}})">
                        <div class="content">
                            <h2>{{$product2->name}}</h2>
                            <p> {{$product2->description}}<br>eiusmod tempor
                                incididunt ut labore.</p>
                            <div class="button">
                                <a href="{{route('product.details', $product2->id)}}" class="btn">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!-- Start Shipping Info -->
    <section class="shipping-info">
        <div class="container">
            <ul>
                <!-- Free Shipping -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-delivery"></i>
                    </div>
                    <div class="media-body">
                        <h5>Free Shipping</h5>
                        <span>On order over $99</span>
                    </div>
                </li>
                <!-- Money Return -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-support"></i>
                    </div>
                    <div class="media-body">
                        <h5>24/7 Support.</h5>
                        <span>Live Chat Or Call.</span>
                    </div>
                </li>
                <!-- Support 24/7 -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-credit-cards"></i>
                    </div>
                    <div class="media-body">
                        <h5>Online Payment.</h5>
                        <span>Secure Payment Services.</span>
                    </div>
                </li>
                <!-- Safe Payment -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-reload"></i>
                    </div>
                    <div class="media-body">
                        <h5>Easy Return.</h5>
                        <span>Hassle Free Shopping.</span>
                    </div>
                </li>
            </ul>
        </div>
    </section>
















@endsection







