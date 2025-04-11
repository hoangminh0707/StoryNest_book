
<?php
?>

@extends('client.layouts.app')
@section('title', 'Dashboards')

@section('content')


<section class="hero-section position-relative padding-large" style="background-image: url(assetClient/images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
    <div class="hero-content">
      <div class="container">
        <div class="row">
          <div class="text-center">
            <h1>Thanh toán</h1>
            <div class="breadcrumbs">
              <span class="item">
                <a href="index.html">Home &gt; </a>
              </span>
              <span class="item text-decoration-underline">Thanh toán</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="checkout-wrap padding-large">
    <div class="container">
      <form class="form-group">
        <div class="row d-flex flex-wrap">
          <div class="col-lg-6">
            <h3 class="mb-3">Chi tiết thanh toán</h3>
            <div class="billing-details">
              <label for="fname">First Name*</label>
              <input type="text" id="fname" name="firstname" class="form-control mt-2 mb-4 ps-3">
              <label for="lname">Họ*</label>
              <input type="text" id="lname" name="lastname" class="form-control mt-2 mb-4 ps-3">
              <label for="cname">Tên công ty(optional)*</label>
              <input type="text" id="cname" name="companyname" class="form-control mt-2 mb-4">
              <label for="cname">Quốc gia / Khu vực*</label>
              <select class="form-select form-control mt-2 mb-4" aria-label="Default select example">
                <option selected="" hidden="">United States</option>
                <option value="1">UK</option>
                <option value="2">Australia</option>
                <option value="3">Việt Nam</option>
              </select>
              <label for="address">Địa chỉ đường phố*</label>
              <input type="text" id="adr" name="address" placeholder="Số nhà và tên phố" class="form-control mt-3 ps-3 mb-3">
              <input type="text" id="adr" name="address" placeholder="Căn hộ, phòng suite, v.v." class="form-control ps-3 mb-4">
              <label for="city">Town / City *</label>
              <input type="text" id="city" name="city" class="form-control mt-3 ps-3 mb-4">
              <label for="state">State *</label>
              <select class="form-select form-control mt-2 mb-4" aria-label="Default select example">
                <option selected="" hidden="">Florida</option>
                <option value="1">New York</option>
                <option value="2">Chicago</option>
                <option value="3">Texas</option>
                <option value="3">San Jose</option>
                <option value="3">Houston</option>
              </select>
              <label for="zip">Mã bưu chính*</label>
              <input type="text" id="zip" name="zip" class="form-control mt-2 mb-4 ps-3">
              <label for="email">Số điện thoại *</label>
              <input type="text" id="phone" name="phone" class="form-control mt-2 mb-4 ps-3">
              <label for="email">Địa chỉ email *</label>
              <input type="text" id="email" name="email" class="form-control mt-2 mb-4 ps-3">
            </div>
          </div>
          <div class="col-lg-6">
            <div>
              <h3 class="mb-3">Thông tin bổ sung</h3>
              <div class="billing-details">
                <label for="fname">Order notes (optional)</label>
                <textarea class="form-control pt-3 pb-3 ps-3 mt-2" placeholder="Notes about your order. Like special notes for delivery."></textarea>
              </div>
            </div>

            <div class="cart-totals padding-medium pb-0">
              <h3 class="mb-3">Tổng số giỏ hàng</h3>
              <div class="total-price pb-3">
                <table cellspacing="0" class="table text-capitalize">
                  <tbody>
                    <tr class="subtotal pt-2 pb-2 border-top border-bottom">
                      <th>Tổng Gía</th>
                      <td data-title="Subtotal">
                        <span class="price-amount amount text-primary ps-5 fw-light">
                          <bdi>
                            <span class="price-currency-symbol">$</span>2,400.00
                          </bdi>
                        </span>
                      </td>
                    </tr>
                    <tr class="order-total pt-2 pb-2 border-bottom">
                      <th>Tổng cộng</th>
                      <td data-title="Total">
                        <span class="price-amount amount text-primary ps-5 fw-light">
                          <bdi>
                            <span class="price-currency-symbol">$</span>2,400.00</bdi>
                        </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="list-group">
                <label class="list-group-item d-flex gap-2 border-0">
                  <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" value="" checked="">
                  <span>
                    <p class="mb-1">Chuyển khoản ngân hàng trực tiếp</p>
                    <small>Make your payment directly into our bank account. Please use your Order ID. Your order will
                        shipped after funds have cleared in our account.</small>
                  </span>
                </label>
                <label class="list-group-item d-flex gap-2 border-0">
                  <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios2" value="">
                  <span>
                    <p class="mb-1">Kiểm tra thanh toán</p>
                    <small>Vui lòng gửi séc đến Tên cửa hàng, Đường phố của cửa hàng, Thị trấn của cửa hàng, Tiểu bang/Quận của cửa hàng, Mã bưu chính của cửa hàng.</small>
                  </span>
                </label>
                <label class="list-group-item d-flex gap-2 border-0">
                  <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios3" value="">
                  <span>
                    <p class="mb-1">Thanh toán khi nhận hàng</p>
                    <small>Thanh toán bằng tiền mặt khi nhận hàng.</small>
                  </span>
                </label>
                <label class="list-group-item d-flex gap-2 border-0">
                  <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios3" value="">
                  <span>
                    <p class="mb-1">Paypal</p>
                    <small>Thanh toán qua PayPal; bạn có thể thanh toán bằng thẻ tín dụng nếu bạn không có tài khoản PayPal.</small>
                  </span>
                </label>
              </div>
              <div class="button-wrap mt-3">
                <button type="submit" name="submit" class="btn">Đặt hàng</button>
              </div>
            </div>

          </div>

        </div>
      </form>
    </div>
  </section>


  <section id="instagram">
    <div class="container">
      <div class="text-center mb-4">
        <h3>Instagram</h3>
      </div>
      <div class="row">
        <div class="col-md-2">
          <figure class="instagram-item position-relative rounded-3">
            <a href="https://templatesjungle.com/" class="image-link position-relative">
              <div class="icon-overlay position-absolute d-flex justify-content-center">
                <svg class="instagram">
                  <use xlink:href="#instagram"></use>
                </svg>
              </div>
              <img src="assetClient/images/insta-item1.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
            </a>
          </figure>
        </div>
        <div class="col-md-2">
          <figure class="instagram-item position-relative rounded-3">
            <a href="https://templatesjungle.com/" class="image-link position-relative">
              <div class="icon-overlay position-absolute d-flex justify-content-center">
                <svg class="instagram">
                  <use xlink:href="#instagram"></use>
                </svg>
              </div>
              <img src="assetClient/images/insta-item2.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
            </a>
          </figure>
        </div>
        <div class="col-md-2">
          <figure class="instagram-item position-relative rounded-3">
            <a href="https://templatesjungle.com/" class="image-link position-relative">
              <div class="icon-overlay position-absolute d-flex justify-content-center">
                <svg class="instagram">
                  <use xlink:href="#instagram"></use>
                </svg>
              </div>
              <img src="assetClient/images/insta-item3.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
            </a>
          </figure>
        </div>
        <div class="col-md-2">
          <figure class="instagram-item position-relative rounded-3">
            <a href="https://templatesjungle.com/" class="image-link position-relative">
              <div class="icon-overlay position-absolute d-flex justify-content-center">
                <svg class="instagram">
                  <use xlink:href="#instagram"></use>
                </svg>
              </div>
              <img src="assetClient/images/insta-item4.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
            </a>
          </figure>
        </div>
        <div class="col-md-2">
          <figure class="instagram-item position-relative rounded-3">
            <a href="https://templatesjungle.com/" class="image-link position-relative">
              <div class="icon-overlay position-absolute d-flex justify-content-center">
                <svg class="instagram">
                  <use xlink:href="#instagram"></use>
                </svg>
              </div>
              <img src="assetClient/images/insta-item5.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
            </a>
          </figure>
        </div>
        <div class="col-md-2">
          <figure class="instagram-item position-relative rounded-3">
            <a href="https://templatesjungle.com/" class="image-link position-relative">
              <div class="icon-overlay position-absolute d-flex justify-content-center">
                <svg class="instagram">
                  <use xlink:href="#instagram"></use>
                </svg>
              </div>
              <img src="assetClient/images/insta-item6.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
            </a>
          </figure>
        </div>
      </div>
    </div>
  </section>




@endsection
