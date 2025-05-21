<section class="bg-danger bg-gradient py-3">
    <div class="container">
        {{-- Header Flash Sale --}}
        <div class="d-flex justify-content-between align-items-center bg-white rounded px-3 py-2 mb-4 shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <h4 class="mb-0 fw-bold text-danger">
                    FLA<span class="text-warning">⚡</span>H SALE
                </h4>
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-semibold">Kết thúc trong</span>
                    <div class="d-flex bg-dark text-white fw-bold rounded px-2 py-1 font-monospace">
                        <span id="hours">00</span><span> : </span>
                        <span id="minutes">00</span><span> : </span>
                        <span id="seconds">00</span>
                    </div>
                </div>
            </div>
            <a href="" class="text-primary text-decoration-none fw-semibold">Xem tất cả</a>
        </div>

        {{-- Grid sản phẩm --}}
        <div class="row g-3">
            @forelse ($flashSaleProducts as $product)
                @php
                    $variant = $product->flashSaleVariant ?? null;
                    $price = $product->price ?? 0;
                    $discounted = $variant->discount_price ?? $price;
                    $discount = $variant->discount_percent ?? 0;
                    $sold = $product->sold ?? 0;
                    $stock = $product->stock ?? 0;
                    $total = max($sold + $stock, 1);
                    $progress = round($sold / $total * 100);

                    $thumbnail = $product->images->first();
                    $secondary = $product->images->skip(1)->first();
                @endphp

                <div class="col-6 col-md-4 col-lg-2 mb-3">
                    <div class="card h-100 rounded shadow-sm border-0 position-relative">
                        <div class="product-img-container position-relative overflow-hidden">
                            <a href="{{ route('product.show', $product->slug) }}" title="{{ $product->name }}">
                                @if ($thumbnail)
                                    <img class="img-fluid pri-img" src="{{ Storage::url($thumbnail->image_path) }}" alt="{{ $product->name }}">
                                @else
                                    <img class="img-fluid pri-img" src="{{ asset('images/no-image.png') }}" alt="No image">
                                @endif
                                @if ($secondary)
                                    <img class="img-fluid sec-img position-absolute top-0 start-0" src="{{ Storage::url($secondary->image_path) }}" alt="{{ $product->name }}">
                                @endif
                            </a>
                        </div>

                        <div class="card-body p-2 text-center small">
                            <div class="fw-semibold text-dark mb-1 text-truncate" style="height: 3em; line-height: 1.5em;">
                                {{ $product->name }}
                            </div>

                            <div class="fw-bold text-danger fs-6">
                                {{ number_format($discounted, 0, ',', '.') }} đ
                                @if ($discount > 0)
                                    <span class="badge bg-danger ms-1">-{{ $discount }}%</span>
                                @endif
                            </div>

                            @if ($discount > 0)
                                <div class="text-muted text-decoration-line-through small">
                                    {{ number_format($price, 0, ',', '.') }} đ
                                </div>
                            @endif
                        </div>

                        {{-- Thanh tiến trình đã bán --}}
                        <div class="px-2 pb-2">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="text-center small text-muted mt-1">Đã bán {{ $sold }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-white">
                    Không có sản phẩm Flash Sale nào.
                </div>
            @endforelse
        </div>
    </div>
</section>

<script>
    const endTime = new Date("{{ $flashSale->end_time ?? now() }}");

    function updateCountdown() {
        const now = new Date();
        const diff = endTime - now;

        if (diff <= 0) {
            document.getElementById('hours').textContent = '00';
            document.getElementById('minutes').textContent = '00';
            document.getElementById('seconds').textContent = '00';
            return;
        }

        const h = String(Math.floor(diff / (1000 * 60 * 60))).padStart(2, '0');
        const m = String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
        const s = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0');

        document.getElementById('hours').textContent = h;
        document.getElementById('minutes').textContent = m;
        document.getElementById('seconds').textContent = s;
    }

    setInterval(updateCountdown, 1000);
    updateCountdown();
</script>

<style>
    .text-truncate {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-img-container {
        width: 100%;
        aspect-ratio: 3 / 4;
        background-color: #fff;
        position: relative;
        overflow: hidden;
    }

    .product-img-container .pri-img,
    .product-img-container .sec-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: opacity 0.3s ease;
    }

    .product-img-container .sec-img {
        opacity: 0;
        z-index: 1;
        position: absolute;
        top: 0;
        left: 0;
    }

    .product-img-container:hover .sec-img {
        opacity: 1;
    }

    .product-img-container:hover .pri-img {
        opacity: 0;
    }
</style>
