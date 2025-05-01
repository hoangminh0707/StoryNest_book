<div class="header-main-area sticky">
  <div class="container">
    <div class="row align-items-center position-relative">

      <!-- start logo area -->
      <div class="col-lg-2">
        <div class="logo">
          <a href="{{ route('index') }}">
            <img src="https://i.ibb.co/HDdt9T0j/STORYNEST-BOOK-2.png" alt="Brand Logo">
          </a>
        </div>
      </div>
      <!-- start logo area -->

      <!-- main menu area start -->
      <div class="col-lg-6 position-static">
        <div class="main-menu-area">
          <div class="main-menu">
            <!-- main menu navbar start -->
            <nav class="desktop-menu">
              <ul>
                <li class="active"><a href="{{ route('index') }}">Trang chủ</a>

                </li>
                <li class="position-static"><a href="#">Danh Mục <i class="fa fa-angle-down"></i></a>
                  <ul class="megamenu dropdown">

                    @if($danhMucSachs)
                    <li class="mega-title"><span>{{ $danhMucSachs->name }}</span>
                      <ul>
                        @foreach($danhMucSachs->childrenRecursive as $child)
                        <li><a href="{{ route('shop', ['category_id' =>$child->id]) }}">{{ $child->name }}</a></li>
                        @endforeach
                      </ul>
                    </li>
                    @endif

                    @if($danhMucDungCu)
                    <li class="mega-title"><span>{{ $danhMucDungCu->name }}</span>
                      <ul>
                        @foreach($danhMucDungCu->childrenRecursive as $child)
                        <li><a href="{{ route('shop', ['category_id' =>$child->id]) }}">{{ $child->name }}</a></li>
                        @endforeach
                      </ul>
                    </li>
                    @endif

                    @if($danhMucDoChoi)
                    <li class="mega-title"><span>{{ $danhMucDoChoi->name }}</span>
                      <ul>
                        @foreach($danhMucDoChoi->childrenRecursive as $child)
                        <li><a href="{{ route('shop', ['category_id' =>$child->id]) }}">{{ $child->name }}</a></li>
                        @endforeach
                      </ul>
                    </li>
                    @endif

                    @if($danhMucHanhTrang)
                    <li class="mega-title"><span>{{ $danhMucHanhTrang->name }}</span>
                      <ul>
                        @foreach($danhMucHanhTrang->childrenRecursive as $child)
                        <li><a href="{{ route('shop', ['category_id' =>$child->id]) }}">{{ $child->name }}</a></li>
                        @endforeach
                      </ul>
                    </li>
                    @endif

                  </ul>
                </li>


                <li><a href="{{ route('shop') }}">Cửa hàng</a></li>
                <li><a href="{{ route('blogs.index') }}">Blog</a></li>
                <li><a href="{{ route('about') }}">Giới thiệu</a></li>
              </ul>
            </nav>
            <!-- main menu navbar end -->
          </div>
        </div>
      </div>
      <!-- main menu area end -->

      <!-- mini cart area start -->
      <div class="col-lg-4">
        <div class="header-right d-flex align-items-center justify-content-end">
          <div class="header-configure-area">
            <ul class="nav justify-content-end">
              <li class="header-search-container mr-0">
                <button class="search-trigger d-block"><i class="pe-7s-search"></i></button>
                <form class="header-search-box d-none" role="search">
                  <input type="text" id="search" placeholder="Search" class="header-search-field"
                    value="{{ request('search') }}" name="search">
                  <button class="header-search-btn"><i class="pe-7s-search"></i></button>
                </form>
              </li>
              <li class="user-hover">
                <a href="#">
                  <i class="pe-7s-user"></i>
                </a>
                <ul class="dropdown-list p-3" style="min-width: 180px;">
                  @guest
                  <li class="mb-2">
                    <a class="text-decoration-none d-block" href="{{ route('login') }}">Đăng nhập</a>
                  </li>
                  <li>
                    <a class="text-decoration-none d-block" href="{{ route('register') }}">Đăng ký</a>
                  </li>
                  @endguest

                  @auth
                  <li class="mb-2">
                    <span class="fw-bold d-block">{{ Auth::user()->name }}</span>
                  </li>
                  <hr class="my-2">

                  <li class="mb-2">
                    <a class="text-decoration-none d-flex align-items-center" href="{{ route('profile.index') }}">
                      <i class="bi bi-gear-fill me-2"></i> Cài đặt
                    </a>
                  </li>

                  <li class="mb-2">
                    <a class="text-decoration-none d-flex align-items-center" href="{{ route('orders.index') }}">
                      <i class="bi bi-bag-fill me-2"></i> Đơn hàng
                    </a>
                  </li>

                  <li>
                    <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="btn btn-link p-0 text-decoration-none d-flex align-items-center">
                        <i class="bi bi-box-arrow-left me-2"></i> Đăng xuất
                      </button>
                    </form>
                  </li>
                  @endauth
                </ul>
              </li>
              <li>
                <a href="{{ route('wishlist.index') }}">
                  <i class="pe-7s-like"></i>
                  <div class="notification">{{ $wishlistItems->count() }}</div>
                </a>
              </li>
              <li>
                <a href="#" class="minicart-btn">
                  <i class="pe-7s-shopbag"></i>
                  <div class="notification">{{ auth()->check() ? $cartItems->count() : 0 }}</div>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- mini cart area end -->

    </div>
  </div>
</div>







<!-- offcanvas mini cart start -->
<div class="offcanvas-minicart-wrapper">
  <div class="minicart-inner">
    <div class="offcanvas-overlay"></div>
    <div class="minicart-inner-content">
      <div class="minicart-close">
        <i class="pe-7s-close"></i>
      </div>
      <div class="minicart-content-box">
        <div class="minicart-item-wrapper">
          @php $total = 0; @endphp
          @forelse($cartItems as $item)
          @php
          $product = $item->product;
          $total += $item->price * $item->quantity;
          @endphp
          <ul>
            <li class="minicart-item">
              <div class="minicart-thumb">
                <a href="{{ route('product.show', $product->id) }}">
                  <img src="{{ Storage::url($product->images->first()->image_path) }}" alt="product" width="85px">
                </a>
              </div>
              <div class="minicart-content">
                <h3 class="product-name">
                  <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
                </h3>
                <p>
                  <span class="cart-quantity">{{$item->quantity}} <strong>&times;</strong></span>
                  <span class="cart-price">{{ number_format($item->price * $item->quantity) }} đ</span>
                  <br>
                  @if ($item->variant && $item->variant->attributeValues->isNotEmpty())
                  @foreach ($item->variant->attributeValues as $attributeValue)
                  <span class="cart-variran">Loại : {{ $attributeValue->value }} </span>
                  @endforeach
                  @else
                  <span class="cart-variran">
                    Loại : Mặc Định
                  </span>
                  @endif
                </p>
              </div>

              <a onclick="event.preventDefault(); this.nextElementSibling.submit();" class="minicart-remove"><i
                  class="pe-7s-close"></i></a>

              <form action="{{ route('cart.remove', $item->product_id) }}" method="POST" style="display: none;">
                @csrf
              </form>

            </li>
            @empty
            <li class="list-group-item bg-transparent text-center">Giỏ hàng trống</li>
            @endforelse
          </ul>
        </div>

        <div class="minicart-pricing-box">
          <ul>


            <li class="total">
              <span>Tổng</span>
              <span><strong>{{ number_format($total)}} đ</strong></span>
            </li>
          </ul>
        </div>

        <div class="minicart-button">
          <a href="{{ route('cart.index') }}"><i class="fa fa-shopping-cart"></i> Xem giỏ hàng</a>
          <a href="{{ route('checkout') }}"><i class="fa fa-share"></i> Thanh toán</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- offcanvas mini cart end -->