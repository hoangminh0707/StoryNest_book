@extends('client.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center shadow-sm p-4 border-danger">
                    <div class="card-body">
                        <h2 class="text-danger mb-3">
                            <i class="bi bi-x-circle-fill"></i> Đặt hàng thất bại
                        </h2>
                        <p class="mb-4 text-muted">
                            Rất tiếc, đơn hàng của bạn chưa được xử lý thành công. Vui lòng kiểm tra lại hoặc thử lại sau.
                        </p>
                        <a href="{{ route('index') }}" class="btn btn-outline-sqr">
                            <i class="bi bi-arrow-left-circle"></i> Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection