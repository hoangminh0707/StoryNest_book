@extends('client.layouts.app')

@section('content')
  <div class="container py-4">
    <div class="card shadow-sm rounded-3 p-4">
    <h4 class="mb-4">📍 Địa chỉ đã lưu</h4>
    <div class="row">
      @foreach ($addresses as $address)
      <div class="col-md-6 mb-3">
      <div class="border rounded p-3 position-relative @if($address->is_default) border-primary @endif">
      <div class="position-absolute top-0 end-0 p-2 d-flex gap-2">
      <a href="{{ route('addresses.edit', $address->id) }}" class="btn btn-sm btn-outline-primary">
        <i class="bi bi-pencil-square"></i>
      </a>
      <form action="{{ route('addresses.destroy', $address->id) }}" method="POST"
        onsubmit="return confirm('Bạn có chắc chắn muốn xoá địa chỉ này không?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger">
        <i class="bi bi-trash"></i>
        </button>
      </form>
      </div>
      <p class="fw-bold mb-1">{{ $address->full_name }} - {{ $address->phone }}</p>
      <p class="mb-2">{{ $address->address_line }}, {{ $address->ward }}, {{ $address->district }},
      {{ $address->city }}
      </p>
      <form method="POST" action="{{ route('addresses.setDefault', 0) }}" id="set-default-form">
      @csrf
      <div class="form-check">
        <input class="form-check-input" type="radio" name="default_address"
        onclick="document.getElementById('set-default-form').action='{{ route('addresses.setDefault', $address->id) }}'; document.getElementById('set-default-form').submit();"
        @if($address->is_default) checked @endif>
        <label class="form-check-label">Đặt làm địa chỉ mặc định</label>
      </div>
      </form>
      </div>
      </div>
    @endforeach
    </div>

    <hr class="my-4">

    <h4 class="mb-4">➕ Thêm địa chỉ mới</h4>
    <form action="{{ route('addresses.store') }}" method="POST">
      @csrf
      <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Họ tên</label>
        <input type="text" name="full_name" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Số điện thoại</label>
        <input type="text" name="phone" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Tỉnh/Thành</label>
        <select name="city" id="city" class="form-control" required></select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Quận/Huyện</label>
        <select name="district" id="district" class="form-control" required></select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Phường/Xã</label>
        <select name="ward" id="ward" class="form-control" required></select>
      </div>
      <div class="col-md-12">
        <label class="form-label">Địa chỉ cụ thể</label>
        <input type="text" name="address_line" class="form-control" required>
      </div>
      <div class="form-check ms-3">
        <input class="form-check-input" type="checkbox" name="is_default" id="is_default">
        <label class="form-check-label" for="is_default">Đặt làm địa chỉ mặc định</label>
      </div>
      <div class="mt-3">
        <button type="submit" class="btn btn-sqr">💾 Lưu địa chỉ</button>
      </div>
      </div>
    </form>
    </div>
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