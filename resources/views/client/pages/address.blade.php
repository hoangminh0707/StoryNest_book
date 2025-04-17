@extends('client.layouts.app')

@section('content')
<div class="container">

    <h3>Địa chỉ đã lưu</h3>
    <form method="POST" action="{{ route('addresses.setDefault', 0) }}" id="set-default-form">
        @csrf
        <div class="row">
            @foreach ($addresses as $address)
                <div class="col-md-6 mb-3">
                    <div class="card p-3 @if($address->is_default) border-primary @endif">
                        <p><strong>{{ $address->full_name }}</strong> - {{ $address->phone }}</p>
                        <p>{{ $address->address_line }}, {{ $address->ward }}, {{ $address->district }}, {{ $address->city }}</p>

                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="default_address"
                                 onclick="document.getElementById('set-default-form').action='{{ route('addresses.setDefault', $address->id) }}'; document.getElementById('set-default-form').submit();"
                                 @if($address->is_default) checked @endif>
                          <label class="form-check-label">Đặt làm địa chỉ mặc định</label>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </form>

    <hr>

    <h3>Thêm địa chỉ mới</h3>

    <form action="{{ route('addresses.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Họ tên</label>
                <input type="text" name="full_name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Số điện thoại</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Tỉnh/Thành</label>
                <select name="city" id="city" class="form-control" required></select>
            </div>
            <div class="col-md-4 mb-3">
                <label>Quận/Huyện</label>
                <select name="district" id="district" class="form-control" required></select>
            </div>
            <div class="col-md-4 mb-3">
                <label>Phường/Xã</label>
                <select name="ward" id="ward" class="form-control" required></select>
            </div>
            <div class="col-md-12 mb-3">
                <label>Địa chỉ cụ thể</label>
                <input type="text" name="address_line" class="form-control" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" name="is_default" id="is_default">
                <label class="form-check-label" for="is_default">Đặt làm địa chỉ mặc định</label>
            </div>
            <button type="submit" class="btn btn-primary">Lưu địa chỉ</button>
        </div>
    </form>
</div>

<script>
  async function loadProvinces() {
    const res = await fetch("https://provinces.open-api.vn/api/?depth=3");
    const data = await res.json();

    const citySelect = document.getElementById('city');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');

    citySelect.innerHTML = '<option value="">Chọn tỉnh/thành</option>';
    districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
    wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';

    data.forEach(city => {
      const opt = new Option(city.name, city.name);
      opt.dataset.districts = JSON.stringify(city.districts);
      citySelect.appendChild(opt);
    });

    citySelect.onchange = () => {
      const selected = citySelect.options[citySelect.selectedIndex];
      const districts = JSON.parse(selected.dataset.districts || "[]");
      districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
      wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
      districts.forEach(d => {
        const opt = new Option(d.name, d.name);
        opt.dataset.wards = JSON.stringify(d.wards);
        districtSelect.appendChild(opt);
      });
    };

    districtSelect.onchange = () => {
      const selected = districtSelect.options[districtSelect.selectedIndex];
      const wards = JSON.parse(selected.dataset.wards || "[]");
      wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
      wards.forEach(w => {
        const opt = new Option(w.name, w.name);
        wardSelect.appendChild(opt);
      });
    };
  }

  document.addEventListener("DOMContentLoaded", loadProvinces);
</script>

@endsection
