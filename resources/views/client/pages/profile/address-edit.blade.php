@extends('client.layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Sửa địa chỉ</h4>
    <form action="{{ route('addresses.update', $address->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="full_name">Họ tên</label>
            <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $address->full_name) }}">
        </div>

        <div class="mb-3">
            <label for="phone">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $address->phone) }}">
        </div>

        <div class="mb-3">
            <label for="address_line">Địa chỉ cụ thể</label>
            <input type="text" name="address_line" class="form-control" value="{{ old('address_line', $address->address_line) }}">
        </div>

        {{-- Dropdown chọn tỉnh / huyện / xã --}}
        <div class="mb-3">
            <label for="city">Tỉnh/Thành</label>
            <select id="city" name="city" class="form-control" required></select>
        </div>

        <div class="mb-3">
            <label for="district">Quận/Huyện</label>
            <select id="district" name="district" class="form-control" required></select>
        </div>

        <div class="mb-3">
            <label for="ward">Phường/Xã</label>
            <select id="ward" name="ward" class="form-control" required></select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>


<script>
    async function loadProvinces() {
      const selectedCity = @json(old('city', $address->city));
      const selectedDistrict = @json(old('district', $address->district));
      const selectedWard = @json(old('ward', $address->ward));
  
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
        if (city.name === selectedCity) {
          opt.selected = true;
        }
        citySelect.appendChild(opt);
      });
  
      // Nếu đã chọn tỉnh/thành trước → load quận/huyện tương ứng
      const selectedCityObj = data.find(c => c.name === selectedCity);
      if (selectedCityObj) {
        districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
        selectedCityObj.districts.forEach(d => {
          const opt = new Option(d.name, d.name);
          opt.dataset.wards = JSON.stringify(d.wards);
          if (d.name === selectedDistrict) {
            opt.selected = true;
          }
          districtSelect.appendChild(opt);
        });
  
        // Nếu đã chọn quận/huyện trước → load phường/xã tương ứng
        const selectedDistrictObj = selectedCityObj.districts.find(d => d.name === selectedDistrict);
        if (selectedDistrictObj) {
          wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
          selectedDistrictObj.wards.forEach(w => {
            const opt = new Option(w.name, w.name);
            if (w.name === selectedWard) {
              opt.selected = true;
            }
            wardSelect.appendChild(opt);
          });
        }
      }
  
      // Các sự kiện onchange bình thường
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
