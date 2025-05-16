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


                            </form>
                        </div>
                    </div>

                </div>


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
                                            </span> ₫
                                        </h4>

                                        <a href="#" class="text-decoration">Thu nhập ròng</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                            <i class="bx bx-dollar-circle text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->

                    </div>

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
                                                <!-- {{ number_format($ordersToday) }} -->
                                            </span>
                                        </h4>

                                        <a href="{{ route('admin.orders.index') }}" class="text-decoration">Xem tất cả đơn hàng</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                                            <i class="bx bx-cart text-warning"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

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
                                                <!-- {{ number_format($productsCount) }} -->
                                            </span>
                                        </h4>

                                        <a href="{{ route('admin.products.index') }}" class="text-decoration">Xem danh sách sản phẩm</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                            <i class="bx bx-box text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->

                    </div>

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
                                                <!-- {{ number_format($usersToday) }} -->
                                            </span>
                                        </h4>

                                        <a href="{{ route('admin.userIndex') }}" class="text-decoration">Xem
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

                    </div>
                </div>

                <!-- Biểu đồ Doanh thu -->
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header border-0 align-items-center d-flex justify-content-between">
                                <h4 class="card-title mb-0">Biểu đồ doanh thu và đơn hàng</h4>
                            </div>

                            <div class="card"></div>

                            <div class="card-body p-0 pb-2">
                                <div class="w-100">
                                    <div id="customer_impression_charts" class="apex-charts" style="min-height: 350px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Biểu đồ trạng thái đơn hàng</h5>
                            </div>
                            <div class="card-body">
                                <div id="order_status_chart" class="apex-charts" style="height: 350px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- sản phẩm bán chạy  -->
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header align-items-center d-flex justify-content-between">
                                    <h4 class="card-title mb-0">🔥 Sản phẩm bán chạy nhất</h4>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-hover align-middle mb-0">
                                            <tbody>
                                                @foreach($topProducts as $prod)
                                                <tr>
                                                    <td style="min-width: 100px;">
                                                        <div class="d-flex align-items-center gap-3">

                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-1">
                                                                    <a href="{{ route('admin.products.edit', $prod->id) }}" class="text-dark">
                                                                        {{ $prod->name }}
                                                                    </a>
                                                                </h6>
                                                                <small class="text-muted">{{ \Carbon\Carbon::parse($prod->created_at)->format('d/m/Y') }}</small>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <!-- Giá bán -->
                                                    <td style="min-width: 80px;">
                                                        <div class="text-end">
                                                            <div class="fw-semibold text-primary">
                                                                {{ number_format($prod->price, 0, ',', '.') }} ₫
                                                            </div>
                                                            <small class="text-muted">Giá bán</small>
                                                        </div>
                                                    </td>

                                                    <!-- Số lượng bán -->
                                                    <td style="min-width: 80px;">
                                                        <div class="text-center">
                                                            <span class="fw-semibold">{{ $prod->total_orders }}</span><br>
                                                            <small class="text-muted">Đã bán</small>
                                                        </div>
                                                    </td>

                                                    <!-- Tổng doanh thu -->
                                                    <td style="min-width: 120px;">
                                                        <div class="text-end">
                                                            <div class="fw-semibold text-success">
                                                                {{ number_format($prod->total_amount, 0, ',', '.') }} ₫
                                                            </div>
                                                            <small class="text-muted">Doanh thu</small>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> <!-- .table-responsive -->
                                </div> <!-- .card-body -->
                            </div> <!-- .card -->
                        </div>

                        <!-- đơn hàng mới -->
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header align-items-center d-flex justify-content-between">
                                    <h4 class="card-title mb-0"> 🛒 Đơn hàng mới nhất</h4>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-centered table-nowrap table-hover mb-0 align-middle">
                                            <thead class="table-light">
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
                                                    <!-- Khách hàng -->
                                                    <td style="min-width: 120px;">
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $order->user->avatar ? Storage::url($order->user->avatar) : 'https://i.ibb.co/R4Hqy0Lm/download.jpg' }}"
                                                                alt="Avatar" class="rounded-circle avatar-xs me-2" />
                                                            <span>{{ $order->user->name }}</span>
                                                        </div>
                                                    </td>

                                                    <!-- Ngày -->
                                                    <td style="min-width: 100px;">
                                                        {{ $order->created_at->format('d-m-Y') }}
                                                    </td>

                                                    <!-- Sản phẩm -->
                                                    <td style="min-width: 150px;">
                                                        @foreach ($order->orderItems as $item)
                                                        <div class="mb-1">
                                                            <span class="fw-medium product-name" title="{{ $item->product->name }}">
                                                                {{ Str::limit($item->product->name, 20) }}
                                                            </span>
                                                            <small class="text-muted">x{{ $item->quantity }}</small>
                                                        </div>
                                                        @endforeach
                                                    </td>
                                                    <!-- Tổng tiền -->
                                                    <td style="min-width: 120px;">
                                                        <span class="text-success fw-medium">
                                                            {{ number_format($order->final_amount, 0, ',', '.') }}đ
                                                        </span>
                                                    </td>

                                                    <!-- Trạng thái -->
                                                    <td style="min-width: 110px;">
                                                        @php
                                                        $statusLabels = [
                                                        'pending' => 'Chờ xử lý',
                                                        'confirmed' => 'Đã xác nhận',
                                                        'shipped' => 'Đang giao',
                                                        'delivered' => 'Đã giao',
                                                        'completed' => 'Hoàn tất',
                                                        'cancelled' => 'Đã hủy',
                                                        ];
                                                        $statusColors = [
                                                        'pending' => 'warning',
                                                        'confirmed' => 'primary',
                                                        'shipped' => 'info',
                                                        'delivered' => 'success',
                                                        'completed' => 'success',
                                                        'cancelled' => 'danger',
                                                        ];
                                                        $status = $order->status;
                                                        @endphp
                                                        <span class="badge bg-{{ $statusColors[$status] ?? 'secondary' }}-subtle text-{{ $statusColors[$status] ?? 'secondary' }}">
                                                            {{ $statusLabels[$status] ?? ucfirst($status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div><!-- end table-responsive -->
                                </div>
                            </div> <!-- end card -->
                        </div>



                    </div>
                </div>
            </div>

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
                document.addEventListener("DOMContentLoaded", function() {
                    const revenueChartEl = document.querySelector("#customer_impression_charts");
                    if (revenueChartEl) {
                        const options = {
                            chart: {
                                height: 350,
                                type: 'line', // Biểu đồ line cho Đơn hàng
                                toolbar: {
                                    show: false
                                },
                            },
                            series: [{
                                    name: "Doanh thu ",
                                    type: 'bar', // Biểu đồ cột cho Doanh thu
                                    data: @json($revenueValues),
                                    color: '#0ab39c', // Màu xanh cho doanh thu
                                    borderRadius: 5
                                },
                                {
                                    name: "Đơn hàng",
                                    type: 'line', // Biểu đồ đường cho Đơn hàng
                                    data: @json($orderCounts),
                                    color: '#6c757d', // Màu xám cho đơn hàng
                                    stroke: {
                                        width: 3, // Độ dày của đường đơn hàng
                                        curve: 'smooth' // Đường cong mượt mà
                                    },
                                    markers: {
                                        size: 6, // Kích thước marker trên đường
                                        colors: '#6c757d', // Màu marker giống màu đường
                                        strokeColor: '#fff', // Màu viền marker
                                        strokeWidth: 2
                                    }
                                }
                            ],

                            yaxis: [{

                                    labels: {
                                        formatter: function(val) {
                                            return val.toLocaleString('vi-VN'); // Định dạng doanh thu
                                        }
                                    },
                                },
                                {
                                    opposite: true,

                                    labels: {
                                        formatter: function(val) {
                                            return val + ' đơn'; // Định dạng đơn hàng
                                        }
                                    },
                                }
                            ],
                            tooltip: {
                                shared: true,
                                intersect: false,
                                y: {
                                    formatter: function(val, {
                                        seriesIndex
                                    }) {
                                        return seriesIndex === 0 ?
                                            val.toLocaleString('vi-VN') + ' ₫' // Doanh thu
                                            :
                                            val + ' đơn'; // Đơn hàng
                                    }
                                }
                            },
                            dataLabels: {
                                enabled: true,
                                enabledOnSeries: [0, 1],
                                formatter: function(val, opts) {
                                    return opts.seriesIndex === 0 ?
                                        val.toLocaleString('vi-VN') + ' ₫' // Doanh thu
                                        :
                                        val + ' đơn'; // Đơn hàng
                                }
                            },
                            plotOptions: {
                                bar: {
                                    columnWidth: '40%', // Chiều rộng cột Doanh thu
                                    borderRadius: 5,
                                    dataLabels: {
                                        position: 'top' // Đặt nhãn trên cột
                                    }
                                }
                            },
                            stroke: {
                                show: true,
                                width: 1,
                                colors: ['transparent']
                            },
                            colors: ['#0ab39c', '#6c757d'], // Màu cho các loại dữ liệu
                        };

                        // Tạo biểu đồ
                        new ApexCharts(revenueChartEl, options).render();
                    }

                    // Biểu đồ trạng thái đơn hàng (pie chart)
                    const statusChartEl = document.querySelector("#order_status_chart");

                    if (statusChartEl) {
                        // Dữ liệu nhãn trạng thái và giá trị từ backend (Laravel)
                        const rawLabels = @json($statusChartLabels); // Các nhãn trạng thái
                        const rawValues = @json($statusChartValues); // Số lượng đơn hàng theo trạng thái

                        // Bản đồ ánh xạ trạng thái sang nhãn tiếng Việt và màu Bootstrap chuyên nghiệp
                        const statusMap = {
                            'pending': {
                                label: 'Chờ xử lý',
                                color: '#ffc107'
                            }, // Warning
                            'confirmed': {
                                label: 'Đã xác nhận',
                                color: '#007bff'
                            }, // Primary
                            'shipped': {
                                label: 'Đang giao',
                                color: '#17a2b8'
                            }, // Info
                            'delivered': {
                                label: 'Đã giao',
                                color: '#28a745'
                            }, // Success
                            'completed': {
                                label: 'Hoàn tất',
                                color: '#343a40'
                            }, // Dark
                            'cancelled': {
                                label: 'Đã hủy',
                                color: '#dc3545'
                            } // Danger
                        };

                        // Dịch nhãn và màu tương ứng với trạng thái
                        const translatedLabels = rawLabels.map(status => statusMap[status]?.label || status);
                        const translatedColors = rawLabels.map(status => statusMap[status]?.color || '#6c757d'); // fallback: Secondary

                        // Cấu hình biểu đồ trạng thái đơn hàng
                        const statusOptions = {
                            chart: {
                                type: 'pie',
                                height: 350
                            },
                            series: rawValues,
                            labels: translatedLabels,
                            colors: translatedColors,
                            responsive: [{
                                breakpoint: 480,
                                options: {
                                    chart: {
                                        width: 200
                                    },
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }],
                            dataLabels: {
                                enabled: true,
                                formatter: (val) => `${val.toFixed(1)}%`
                            },
                            tooltip: {
                                y: {
                                    formatter: val => `${val.toLocaleString('vi-VN')} đơn`
                                }
                            },
                            legend: {
                                position: 'bottom'
                            }
                        };

                        // Khởi tạo biểu đồ
                        new ApexCharts(statusChartEl, statusOptions).render();
                    }

                });
            </script>














            @endsection