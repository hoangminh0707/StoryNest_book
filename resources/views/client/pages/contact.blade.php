<?php
?>

@extends('client.layouts.app')
@section('title', 'Dashboards')

@section('content')


  <main>
    <div class="contact-area section-padding pt-0">

    <div class="container">
      <div class="row">

      {{-- Form liên hệ --}}
      <div class="col-lg-6">
        <div class="contact-message">
        <h4 class="contact-title">Hãy cho chúng tôi biết bạn đang cần gì!</h4>


        @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
      @endif

        <form action="{{ route('contact.send') }}" method="POST">
          @csrf
          <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <input name="name" placeholder="Họ và tên *" type="text" required>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <input name="phone" placeholder="Số điện thoại *" type="text" required>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <input name="email" placeholder="Email *" type="email" required>

          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <input name="subject" placeholder="Tiêu đề *" type="text">
          </div>
          <div class="col-12">
            <div class="contact2-textarea text-center">
            <textarea placeholder="Nội dung *" name="message" class="form-control2" required></textarea>
            </div>
            <div class="contact-btn">
            <button class="btn btn-sqr" type="submit">Gửi</button>
            </div>
          </div>

          </div>
        </form>
        </div>

      </div>

      {{-- Thông tin liên hệ --}}
      <div class="col-lg-6">
        <div class="contact-info">
        <h4 class="contact-title">Liên hệ</h4>
        <p>Hãy liên hệ với chúng tôi nếu bạn có thắc mắc hoặc cần hỗ trợ.</p>
        <ul>
          <li><i class="fa fa-fax"></i> Địa chỉ: 123 Đường Sách, Q.1, TP.HCM</li>
          <li><i class="fa fa-envelope-o"></i> Email: info@storynest.com</li>
          <li><i class="fa fa-phone"></i> Hotline: 0909 123 456</li>
        </ul>
        <div class="working-time">
          <h6>Thời gian làm việc</h6>
          <p><span>Thứ 2 – Thứ 7:</span> 08:00 – 22:00</p>
        </div>
        </div>
      </div>


      </div>
    </div>
    </div>
  </main>



@endsection
