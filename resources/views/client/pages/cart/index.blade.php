@extends('client.layouts.app')

  @section('content')
<div class="container py-4">
    <h2>Giỏ hàng</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(count($cart))
        <table class="table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ number_format($item['price']) }}₫</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control w-50 d-inline">
                                <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                            </form>
                        </td>
                        <td>{{ number_format($subtotal) }}₫</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                    <td colspan="2" class="fw-bold">{{ number_format($total) }}₫</td>
                </tr>
            </tbody>
        </table>
    @else
        <p>Giỏ hàng của bạn đang trống.</p>
    @endif
</div>
@endsection
