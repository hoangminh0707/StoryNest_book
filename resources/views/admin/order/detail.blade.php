@extends('admin.layouts.app')
@section('title', 'Dashboards')

@section('content')
<div class="row">
    <div class="col-12 table-responsive">
        <table id="example" class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Products</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user_id ? $order->user->name : $order->guest_email }}</td>
                        @foreach ($order->items as $item)
                            <td> {{ $item->product_id}}</td>
                            <td> {{ $item->quantity }} </<td>
                            <td>  {{ number_format($item->price) }} vnđ</<td>
                        @endforeach
                    </td>
                    <td>{{ number_format($order->total_price) }} vnđ</td>
                    <td>{{ $order->created_at }}</td>

                    <td>
                        <form action="{{ route('updateOrder', $order->id) }}" method="POST">
                            @csrf
                            <select name="status">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Đã giao hàng</option>
                                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Đã huỷ</option>
                            </select>
                        </form>
                    </td>
                    <td><button type="submit" class="btn btn-primary">Update Status</button></td>
                </tr>
            </tbody>
        </table>
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
