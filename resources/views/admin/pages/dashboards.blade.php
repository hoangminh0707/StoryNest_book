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
                                        <i class="fas fa-dollar-sign me-1"></i>
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
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn hàng</p>
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

                                        <a href="{{ route('admin.orders.index') }}" class="text-decoration-underline">Xem tất cả đơn hàng</a>
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

                                        <a href="{{ route('admin.products.index') }}" class="text-decoration-underline">Xem danh sách sản phẩm</a>
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
                            {{-- Card header với filter buttons và loại biểu đồ --}}
                            <div class="card-header border-0 d-flex align-items-center justify-content-between">
                                <h4 class="card-title mb-0">Thống kê</h4>
                                <div>
                                    {{-- Loại biểu đồ --}}
                                    <div class="btn-group me-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm chart-type-btn active" data-type="revenue">Doanh thu</button>
                                        <button type="button" class="btn btn-outline-primary btn-sm chart-type-btn" data-type="orders">Đơn hàng</button>
                                    </div>

                                    {{-- Bộ lọc thời gian --}}
                                    @php $ranges = ['today' => 'Hôm nay', 'yesterday' => 'Hôm qua', 'week' => 'Tuần', 'month' => 'Tháng', 'year' => 'Năm']; @endphp
                                    @foreach ($ranges as $key => $label)
                                    <button type="button" class="btn btn-soft-secondary btn-sm filter-btn {{ $key == 'year' ? 'btn-soft-primary' : '' }}" data-range="{{ $key }}">{{ $label }}</button>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Summary row --}}
                            <div class="card-header p-0 border-0 bg-light-subtle">
                                <div class="row g-0 text-center">
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1"><span class="counter-value" data-target="{{ $totalOrdersAll }}">0</span></h5>
                                            <p class="text-muted mb-0">Đơn hàng</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0 border-end-0">
                                            <h5 class="mb-1">₫<span class="counter-value" data-target="{{ round($totalEarningsAll / 1000, 2) }}">0</span>k</h5>
                                            <p class="text-muted mb-0">Doanh thu</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Biểu đồ --}}
                            <div class="card-body p-0 pb-2">
                                <canvas id="revenueChart" style="min-height: 300px;"></canvas>
                            </div>
                        </div>
                    </div>







                    {{-- Top Sellers theo Danh mục --}}
                    <div class="col-xl-4">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Top Danh mục bán chạy</h4>
                                <div class="flex-shrink-0">
                                    <div class="dropdown card-header-dropdown">
                                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted">Tùy chọn<i class="mdi mdi-chevron-down ms-1"></i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Tải báo cáo</a>
                                            <a class="dropdown-item" href="#">Xuất Excel</a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body">
                                {{-- Apex donut chart --}}
                                <div id="category-sales-donut" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]' class="apex-charts" dir="ltr" style="height: 270px;"></div>

                                {{-- Chi tiết danh mục --}}
                                <div class="mt-4">
                                    @php
                                    $totalCategorySales = array_sum($categoryValues);
                                    @endphp

                                    @foreach($topCategories as $index => $category)
                                    @php
                                    $percent = $totalCategorySales ? round($categoryValues[$index] / $totalCategorySales * 100, 2) : 0;
                                    @endphp
                                    <p class="mb-1">
                                        {{ $category->name }}
                                        <span class="float-end">{{ $percent }}%</span>
                                    </p>
                                    <div class="progress mt-2" style="height: 6px;">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div> <!-- .card -->
                    </div>


                </div>
                <!-- end col -->


                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Sản phẩm bán chạy nhất</h4>

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
                                                    <span class="text-muted">Giá</span>
                                                </td>

                                                <!-- Tổng Orders -->
                                                <td>
                                                    <h5 class="fs-14 my-1 fw-normal">
                                                        {{ $prod->total_orders }}
                                                    </h5>
                                                    <span class="text-muted">Đơn hàng</span>
                                                </td>

                                                <!-- Doanh thu Amount -->
                                                <td>
                                                    <h5 class="fs-14 my-1 fw-normal">
                                                        {{ number_format($prod->total_amount, 0, ',', '.') }} ₫
                                                    </h5>
                                                    <span class="text-muted">Tổng doanh thu</span>
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
                                <h4 class="card-title mb-0 flex-grow-1">Đơn hàng mới</h4>
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
                                                <th scope="col">Khách hàng</th>
                                                <th scope="col">Ngày</th>
                                                <th scope="col">Sản phẩm</th>
                                                <th scope="col">Tổng tiền</th>
                                                <th scope="col">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentOrders as $order)
                                            <tr>

                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="{{ $order->user->avatar ? Storage::url($order->user->avatar) : 'https://i.ibb.co/R4Hqy0Lm/download.jpg' }}"
                                                                width="40" height="40" class="rounded-circle" alt="Avatar người dùng">

                                                        </div>
                                                        <div class="flex-grow-1">{{ $order->user->name }}</div>
                                                    </div>
                                                </td>
                                                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                                <td>

                                                    @foreach ($order->orderItems as $item)
                                                    {{ $item->product->name }} x{{ $item->quantity }}
                                                    @endforeach
                                                </td>
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            let revenueChart;
            let chartData = {
                labels: [],
                revenues: [],
                orders: []
            };
            let currentType = 'revenue';

            function renderChart() {
                const ctx = document.getElementById('revenueChart').getContext('2d');
                if (revenueChart) revenueChart.destroy();

                const isRevenue = currentType === 'revenue';
                const dataSet = isRevenue ? chartData.revenues : chartData.orders;
                const label = isRevenue ? 'Doanh thu (VNĐ)' : 'Số lượng đơn hàng';
                const color = isRevenue ? '#0d6efd' : '#198754';

                revenueChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: label,
                            data: dataSet,
                            borderColor: color,
                            backgroundColor: color + '33',
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return isRevenue ?
                                            'Doanh thu: ₫' + parseInt(context.raw).toLocaleString() :
                                            'Đơn hàng: ' + context.raw;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return isRevenue ? '₫' + value.toLocaleString() : value;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            function fetchData(range = 'year') {
                fetch(`/admin/revenue-data?date_range=${range}`)
                    .then(res => res.json())
                    .then(data => {
                        chartData.labels = data.labels;
                        chartData.revenues = data.revenues;
                        chartData.orders = data.orders;
                        renderChart();
                    });
            }

            document.addEventListener('DOMContentLoaded', function() {
                fetchData(); // mặc định là 'year'

                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('btn-soft-primary'));
                        this.classList.add('btn-soft-primary');
                        fetchData(this.dataset.range);
                    });
                });

                document.querySelectorAll('.chart-type-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('.chart-type-btn').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                        currentType = this.dataset.type;
                        renderChart();
                    });
                });
            });
        </script>








        <!-- danh muc -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <!-- <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Dữ liệu được truyền từ Controller
                const labels = {
                    !!json_encode($categoryLabels) !!
                };
                const data = {
                    !!json_encode($categoryValues) !!
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
        </script> -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var options = {
                    chart: {
                        type: 'donut',
                        height: 270
                    },
                    series: @json($categoryValues), // array số liệu
                    labels: @json($categoryLabels), // array nhãn danh mục
                    legend: {
                        position: 'bottom'
                    },
                    colors: getChartColorsArray("category-sales-donut")
                };

                var chart = new ApexCharts(document.querySelector("#category-sales-donut"), options);
                chart.render();
            });

            function getChartColorsArray(id) {
                var colors = document.getElementById(id).getAttribute("data-colors");
                if (colors) {
                    colors = JSON.parse(colors).map(function(value) {
                        var newValue = value.replace(" ", "");
                        if (newValue.indexOf("--") === 0) {
                            return getComputedStyle(document.documentElement).getPropertyValue(newValue) || newValue;
                        }
                        return newValue;
                    });
                }
                return colors;
            }
        </script>