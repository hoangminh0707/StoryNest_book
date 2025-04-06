@extends('admin.layouts.app')
@section('title', 'Dashboards')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Danh sách đơn hàng</h4>
                <div class="btn-group" role="group">
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Mã Order</th>
                                <th>Người dùng</th>
                                <th>Tổng tiền</th>
                                <th>Trang thái</th>
                                <th>Ngày đặt</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user_id ? $order->user->name : $order->guest_email }}</td>
                                <td>{{ $order->total_price }}</td>
                                <td> {{ $order->status }}</td>
                                <td> {{ $order->created_at }}</td>
                                <td>
                                     <a href="{{ route('orderDetail', $order->id) }}"  class="btn btn-primary">Chi tiết </a></button>
                                </td>
                            </tr>
@endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styleHome')
<!-- Include DataTable CSS -->
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
@endpush

@push('scriptHome')
<!-- Include jQuery and DataTable JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable();  // Khởi tạo DataTable cho bảng có id 'example'
    });
</script>
@endpush
