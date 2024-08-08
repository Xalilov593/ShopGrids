@extends('layout.helper')
@section('content')

    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Cart</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{route('home')}}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="">Shop</a></li>
                        <li>Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="cart-list-head">
                <!-- Cart List Title -->
                <div class="cart-list-title">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-12">

                        </div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <p>Product Name</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Quantity</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Subtotal</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Discount</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <p>Remove</p>
                        </div>
                    </div>
                </div>

                @foreach($products as $product)
                    @php
                        $productId = $product->id;
                        $qnt = $qnts[$productId]['qnt'] ?? 1;
                    @endphp
                    <div class="cart-single-list" id="product-{{ $productId }}">
                        <div class="row align-items-center">
                            <div class="col-lg-1 col-md-1 col-12">
                                <a><img src="{{ ('uploads/' . $product->photo) }}" alt="#"></a>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <h5 class="product-name">{{$product->name}}</h5>
                                <p class="product-des">
                                    <span><em>Type:</em> {{$product->category->name}}</span>
                                </p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <div class="count-input">
                                    <select name="products[{{ $productId }}][qnt]" class="form-control" onchange="sendOrder({{ $productId }})">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ $i == $qnt ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p id="subtotal-{{ $productId }}">${{$qnt*($product->price)*(100-$product->percentage)/100}}</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p id="discount-display-{{ $productId }}">
                                    @if(!$product->percentage==0)
                                        ${{$qnt*($product->price)*($product->percentage)/100}}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                                <a class="remove-item" href="javascript:void(0)" onclick="removeProduct({{ $productId }})"><i class="lni lni-close"></i></a>
                            </div>
                            <span id="price-{{ $productId }}" style="display: none;">{{$product->price}}</span>
                            <span id="percentage-{{ $productId }}" style="display: none;">{{$product->percentage}}</span>
                            <span id="discount-{{ $productId }}" style="display: none;">{{$qnt*($product->price)*($product->percentage)/100}}</span>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">

                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="right">
                                    <ul>
                                        <li>Cart Subtotal<span id="cart-subtotal">$2560.00</span></li>
                                        <li>Shipping<span>Free</span></li>
                                        <li>You Save<span id="total-discount">$29.00</span></li>
                                        <li class="last">You Pay<span id="total-pay">$2531.00</span></li>
                                    </ul>
                                    <div class="button">
                                        <a role="button"  onclick="sendCart()" class="btn">Checkout</a>
                                        <a href="product-grids.html" class="btn btn-alt">Continue shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <script>
        function sendOrder(productId) {
            let productsLocal = window.localStorage.getItem('productsLocal');
            if (!productsLocal) {
                productsLocal = {};
            } else {
                productsLocal = JSON.parse(productsLocal);
            }

            let qntElement = document.querySelector(`select[name="products[${productId}][qnt]"]`);
            let qnt = qntElement ? qntElement.value : 1;

            let keyId = 'id' + productId;
            if (productsLocal[keyId]) {
                productsLocal[keyId].qnt = qnt;
            } else {
                productsLocal[keyId] = {
                    id: productId,
                    qnt: qnt
                };
            }

            window.localStorage.setItem('productsLocal', JSON.stringify(productsLocal));

            // Subtotal va Discountni yangilash
            let productPrice = parseFloat(document.getElementById(`price-${productId}`).innerText);
            let percentage = parseFloat(document.getElementById(`percentage-${productId}`).innerText);

            let subtotal = qnt * productPrice * (100 - percentage) / 100;
            let discount = qnt * productPrice * percentage / 100;

            document.getElementById(`subtotal-${productId}`).innerText = `$${subtotal.toFixed(2)}`;
            document.getElementById(`discount-display-${productId}`).innerText = discount > 0 ? `$${discount.toFixed(2)}` : '-';

            updateCartTotals();
        }

        function updateCartTotals() {
            let productsLocal = window.localStorage.getItem('productsLocal');
            if (!productsLocal) {
                productsLocal = {};
            } else {
                productsLocal = JSON.parse(productsLocal);
            }

            let cartSubtotal = 0;
            let totalDiscount = 0;

            Object.values(productsLocal).forEach(item => {
                let productPrice = parseFloat(document.getElementById(`price-${item.id}`).innerText);
                let percentage = parseFloat(document.getElementById(`percentage-${item.id}`).innerText);
                let subtotal = item.qnt * productPrice * (100 - percentage) / 100;
                let discount = item.qnt * productPrice * percentage / 100;

                cartSubtotal += subtotal;
                totalDiscount += discount;
            });

            document.getElementById('cart-subtotal').innerText = `$${cartSubtotal.toFixed(2)}`;
            document.getElementById('total-discount').innerText = `$${totalDiscount.toFixed(2)}`;
            document.getElementById('total-pay').innerText = `$${(cartSubtotal).toFixed(2)}`;
        }

        function removeProduct(productId) {
            let productsLocal = window.localStorage.getItem('productsLocal');
            if (productsLocal) {
                productsLocal = JSON.parse(productsLocal);
                delete productsLocal['id' + productId];
                window.localStorage.setItem('productsLocal', JSON.stringify(productsLocal));
                document.getElementById(`product-${productId}`).remove();
                updateCartTotals();
            }
        }

        window.onload = function() {
            updateCartTotals();
        }
        document.addEventListener("DOMContentLoaded", function() {
            let productsLocal = window.localStorage.getItem('productsLocal');
            if (productsLocal) {
                productsLocal = JSON.parse(productsLocal);
                Object.values(productsLocal).forEach(item => {
                    let qntElement = document.querySelector(`select[name="products[${item.id}][qnt]"]`);
                    if (qntElement) {
                        qntElement.value = item.qnt;
                    }
                    let productPrice = parseFloat(document.getElementById(`price-${item.id}`).innerText);
                    let percentage = parseFloat(document.getElementById(`percentage-${item.id}`).innerText);
                    let subtotal = item.qnt * productPrice * (100 - percentage) / 100;
                    let discount = item.qnt * productPrice * percentage / 100;

                    document.getElementById(`subtotal-${item.id}`).innerText = `$${subtotal.toFixed(2)}`;
                    document.getElementById(`discount-display-${item.id}`).innerText = discount > 0 ? `$${discount.toFixed(2)}` : '-';
                });
                updateCartTotals();
            }
        });



    </script>
    <!--/ End Shopping Cart -->
    <script>
        function sendCart(){
            let url = '?';
            let productsLocal = window.localStorage.getItem('productsLocal');
            if (!productsLocal) {
                productsLocal = {};
            } else {
                productsLocal = JSON.parse(productsLocal);
            }
            Object.values(productsLocal).forEach(item => {
                url += 'products['+item.id+'][id]='+ item.id+'&'+'products['+item.id+'][qnt]='+ item.qnt+'&';
            });
            window.location.replace('/cart'+url);
        }
    </script>


@endsection
