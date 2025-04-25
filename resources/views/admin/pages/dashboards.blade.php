@extends('admin.layouts.app')
@section('title', 'Bảng điều khiển')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="h-100">
                    <div class="row mb-3 pb-1">
                        <div class="col-12">
                            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                <div class="d-flex flex-column flex-grow-1">
                                    <h4 class="fs-18 fw-semibold mb-1 text-primary">Chào, {{ $user->name }}!</h4>
                                    <p class="text-muted mb-0">Hãy xem những cập nhật mới nhất về cửa hàng của bạn hôm nay.
                                    </p>
                                </div>
                                <div class="mt-3 mt-lg-0">
                                    <form method="GET" action="{{ route('admin.dashboard') }}">
                                        <div class="row g-3 mb-0 align-items-center">
                                            <!-- Bộ chọn ngày -->
                                            <div class="col-sm-auto">
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control border-0 dash-filter-picker shadow"
                                                        name="date_range" data-provider="flatpickr" data-range-date="true"
                                                        data-date-format="d M, Y" placeholder="Chọn khoảng ngày"
                                                        value="{{ request('date_range') }}">
                                                    <div class="input-group-text bg-primary border-primary text-white">
                                                        <i class="ri-calendar-2-line"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Nút Add Product -->
                                            <div class="col-auto">
                                                <a href="{{ route('admin.products.create') }}" class="btn btn-soft-success">
                                                    <i class="ri-add-circle-line align-middle me-1"></i> Thêm sản phẩm
                                                </a>
                                            </div>

                                            <!-- Nút tùy chọn thêm (icon) -->
                                            <div class="col-auto">
                                                <button type="button"
                                                    class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn">
                                                    <i class="ri-pulse-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!--end row-->
                                </form>
                            </div>
                        </div><!-- end card header -->

                    </div>
                    <!--end row-->

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Doanh thu</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                +{{ number_format(16.24, 2) }} %
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                <span class="counter-value" data-target="{{ $revenueToday }}">
                                                    {{ number_format($revenueToday, 0, ',', '.') }}
                                                </span> ₫
                                            </h4>

                                            <a href="#" class="text-decoration-underline">Xem thu nhập ròng</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="bx bx-dollar-circle text-success"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->

                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn hàng hôm
                                                nay</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-muted fs-14 mb-0">
                                                <i class="ri-shopping-bag-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                <span class="counter-value" data-target="{{ $ordersToday }}">
                                                    {{ number_format($ordersToday) }}
                                                </span>
                                            </h4>

                                            <a href="#" class="text-decoration-underline">Xem tất cả đơn hàng</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-warning-subtle rounded fs-3">
                                                <i class="bx bx-cart text-warning"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->

                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tổng sản phẩm
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-muted fs-14 mb-0">
                                                <i class="ri-archive-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                <span class="counter-value" data-target="{{ $productsCount }}">
                                                    {{ number_format($productsCount) }}
                                                </span>
                                            </h4>

                                            <a href="#" class="text-decoration-underline">Xem danh sách sản phẩm</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                                <i class="bx bx-box text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->

                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Người dùng mới
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-muted fs-14 mb-0">
                                                <i class="ri-user-add-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                <span class="counter-value" data-target="{{ $usersToday }}">
                                                    {{ number_format($usersToday) }}
                                                </span>
                                            </h4>

                                            <a href="{{ route('admin.userIndex') }}" class="text-decoration-underline">Xem
                                                người dùng</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-danger-subtle rounded fs-3">
                                                <i class="bx bx-user text-danger"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->

                        </div><!-- end col -->
                    </div> <!-- end row-->

                    {{-- Biểu đồ Doanh thu --}}
                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card">
                                {{-- Card header với filter buttons --}}
                                <div class="card-header border-0 d-flex align-items-center">
                                    <h4 class="card-title mb-0 flex-grow-1">Doanh thu</h4>
                                    <div>
                                        <button type="button" class="btn btn-soft-secondary btn-sm filter-btn"
                                            data-range="today">Hôm nay</button>
                                        <button type="button" class="btn btn-soft-secondary btn-sm filter-btn"
                                            data-range="yesterday">Hôm qua</button>
                                        <button type="button" class="btn btn-soft-secondary btn-sm filter-btn"
                                            data-range="week">Tuần</button>
                                        <button type="button" class="btn btn-soft-secondary btn-sm filter-btn"
                                            data-range="month">Tháng</button>
                                        <button type="button" class="btn btn-soft-primary btn-sm filter-btn"
                                            data-range="year">Năm</button>
                                    </div>
                                </div>

                                {{-- Summary row --}}
                                <div class="card-header p-0 border-0 bg-light-subtle">
                                    <div class="row g-0 text-center">
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1">
                                                    <span class="counter-value" data-target="{{ $totalOrdersAll }}">0</span>
                                                </h5>
                                                <p class="text-muted mb-0">Đơn hàng</p>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1">
                                                    ₫<span class="counter-value"
                                                        data-target="{{ round($totalEarningsAll / 1000, 2) }}">0</span>k
                                                </h5>
                                                <p class="text-muted mb-0">Doanh thu</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Biểu đồ --}}
                                <div class="card-body p-0 pb-2">
                                    <div id="customer_impression_charts" class="apex-charts" style="min-height:300px"></div>
                                </div>
                            </div>
                        </div>



                        {{-- Top Sellers theo Danh mục --}}
                        <div class="col-xl-4">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Top Sellers Theo Danh mục</h4>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="btn btn-soft-primary btn-sm" id="export-report">
                                            Export Report
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {{-- Chart dạng donut --}}
                                    <div id="sales-by-categories"
                                        data-colors='["--vz-primary","--vz-warning","--vz-success","--vz-info"]'
                                        class="apex-charts" dir="ltr" style="height: 269px;">
                                    </div>

                                    {{-- Danh sách tỉ lệ --}}
                                    <div class="px-2 py-2 mt-1">
                                        {{-- Trước vòng lặp, tính tổng doanh số --}}
                                        @php
                                            $totalCategorySales = $topCategories->sum('total_sales');
                                        @endphp

                                        @foreach($topCategories as $category)
                                                                            {{-- Nếu tổng bằng 0 sẽ cho percent = 0 --}}
                                                                            @php
                                                                                $percent = $totalCategorySales
                                                                                    ? round($category->total_sales / $totalCategorySales * 100, 2)
                                                                                    : 0;
                                                                            @endphp

                                                                            <p class="mb-1">
                                                                                {{ $category->name }}
                                                                                <span class="float-end">{{ $percent }}%</span>
                                                                            </p>
                                                                            <div class="progress mt-2" style="height: 6px;">
                                                                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar"
                                                                                    style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}"
                                                                                    aria-valuemin="0" aria-valuemax="100">
                                                                                </div>
                                                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->


                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Best Selling Products</h4>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown card-header-dropdown">
                                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown">
                                                <span class="fw-semibold text-uppercase fs-12">Sort by:</span>
                                                <span class="text-muted">Today<i
                                                        class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Today</a>
                                                <a class="dropdown-item" href="#">Yesterday</a>
                                                <a class="dropdown-item" href="#">Last 7 Days</a>
                                                <a class="dropdown-item" href="#">Last 30 Days</a>
                                                <a class="dropdown-item" href="#">This Month</a>
                                                <a class="dropdown-item" href="#">Last Month</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                            <tbody>
                                                @foreach($topProducts as $prod)
                                                    <tr>
                                                        <!-- Tên & Ngày tạo -->
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <h5 class="fs-14 my-1">
                                                                        <a href="{{ route('admin.products.edit', $prod->id) }}"
                                                                            class="text-reset">
                                                                            {{ $prod->name }}
                                                                        </a>
                                                                    </h5>
                                                                    <span class="text-muted">
                                                                        {{ \Carbon\Carbon::parse($prod->created_at)->format('d M Y') }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <!-- Giá -->
                                                        <td>
                                                            <h5 class="fs-14 my-1 fw-normal">
                                                                {{ number_format($prod->price, 0, ',', '.') }} ₫
                                                            </h5>
                                                            <span class="text-muted">Price</span>
                                                        </td>

                                                        <!-- Tổng Orders -->
                                                        <td>
                                                            <h5 class="fs-14 my-1 fw-normal">
                                                                {{ $prod->total_orders }}
                                                            </h5>
                                                            <span class="text-muted">Orders</span>
                                                        </td>

                                                        <!-- Doanh thu Amount -->
                                                        <td>
                                                            <h5 class="fs-14 my-1 fw-normal">
                                                                {{ number_format($prod->total_amount, 0, ',', '.') }} ₫
                                                            </h5>
                                                            <span class="text-muted">Amount</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Recent Orders</h4>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="btn btn-soft-info btn-sm">
                                            <i class="ri-file-list-3-line align-middle"></i> Generate Report
                                        </button>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th scope="col">Mã đơn</th>
                                                    <th scope="col">Khách hàng</th>
                                                    <th scope="col">Ngày</th>
                                                    <th scope="col">Tổng tiền</th>
                                                    <th scope="col">Trạng thái</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recentOrders as $order)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                                class="fw-medium link-primary">#{{ $order->id }}</a>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 me-2">
                                                                    <img src="{{ asset('assets/images/users/' . $order->user->avatar) }}"
                                                                        alt="" class="avatar-xs rounded-circle" />
                                                                </div>
                                                                <div class="flex-grow-1">{{ $order->user->name }}</div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                                        <td>
                                                            <span
                                                                class="text-success">{{ number_format($order->total_amount, ) }}đ</span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge bg-{{ $order->status == 'paid' ? 'success' : 'danger' }}-subtle text-{{ $order->status == 'paid' ? 'success' : 'danger' }}">
                                                                {{ ucfirst($order->status) }}
                                                            </span>
                                                        </td>
                                                    </tr><!-- end tr -->
                                                @endforeach
                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->
                                    </div>
                                </div>
                            </div> <!-- .card-->
                        </div> <!-- .col-->

                    </div> <!-- end row-->
                </div>
            </div>

@endsection


        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            flatpickr(".dash-filter-picker", {
                mode: "range",
                dateFormat: "d M, Y",
                defaultDate: "{{ request('date_range') }}"
            });
        </script>

        <!-- biểu đồ doanh thu -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Khởi tạo dữ liệu mẫu
                let labels = @json($revenueLabels);
                let values = @json($revenueValues);

                // Cấu hình biểu đồ ban đầu
                const options = {
                    series: [{
                        name: 'Doanh thu (k)',
                        data: values
                    }],
                    chart: {
                        type: 'line',
                        height: 300,
                        toolbar: {
                            show: false
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    xaxis: {
                        categories: labels
                    },
                    colors: ['#007bff'],
                    grid: {
                        borderColor: '#f1f1f1'
                    }
                };

                const chart = new ApexCharts(document.querySelector("#customer_impression_charts"), options);
                chart.render();

                // Hiệu ứng counter cho các giá trị
                document.querySelectorAll('.counter-value').forEach(el => {
                    const target = +el.getAttribute('data-target');
                    let count = 0,
                        step = target / 200;
                    (function update() {
                        count += step;
                        if (count < target) {
                            el.textContent = Math.floor(count).toLocaleString('vi-VN');
                            requestAnimationFrame(update);
                        } else {
                            el.textContent = target.toLocaleString('vi-VN');
                        }
                    })();
                });

                // Xử lý filter buttons (cập nhật dữ liệu khi chọn filter)
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        document.querySelectorAll('.filter-btn').forEach(b => {
                            b.classList.replace('btn-soft-primary', 'btn-soft-secondary');
                        });
                        this.classList.replace('btn-soft-secondary', 'btn-soft-primary');

                        // Lấy giá trị range (hôm nay, tuần, tháng, năm, v.v.)
                        const range = this.getAttribute('data-range');
                        console.log('Range selected:', range);

                        // TODO: Tải lại dữ liệu từ server hoặc cập nhật biểu đồ theo khoảng thời gian đã chọn
                        // Gọi Ajax hoặc xử lý trực tiếp ở đây

                        switch (range) {
                            case 'today':
                                // Lọc dữ liệu theo hôm nay
                                break;
                            case 'yesterday':
                                // Lọc dữ liệu theo hôm qua
                                break;
                            case 'week':
                                // Lọc dữ liệu theo tuần
                                break;
                            case 'month':
                                // Lọc dữ liệu theo tháng
                                break;
                            case 'year':
                                // Lọc dữ liệu theo năm
                                break;
                            default:
                                break;
                        }
                    });
                });
            });
        </script>



        <!-- danh muc -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Dữ liệu được truyền từ Controller
                const labels = {
                    !!json_encode($categoryLabels)!!
            };
            const data = {
                    !!json_encode($categoryValues)!!
                };

            // Lấy màu từ CSS variables
            const colors = JSON.parse(
                document
                    .querySelector("#sales-by-categories")
                    .getAttribute("data-colors")
            ).map(varName =>
                getComputedStyle(document.documentElement)
                    .getPropertyValue(varName)
                    .trim()
            );

            // Cấu hình chart dạng donut
            const options = {
                series: data,
                chart: {
                    type: 'donut',
                    height: 269
                },
                labels: labels,
                colors: colors,
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: false
                },
                responsive: [{
                    breakpoint: 576,
                    options: {
                        chart: {
                            height: 200
                        }
                    }
                }]
            };

            // Render chart
            const chart = new ApexCharts(
                document.querySelector("#sales-by-categories"),
                options
            );
            chart.render();
            });
        </script>