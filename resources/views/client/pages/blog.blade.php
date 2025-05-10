@extends('client.layouts.app')



@section('title', 'Blog')

@section('content')
<div class="breadcrumb-area">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-wrap">
          <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">blog</li>
            </ul>
          </nav>

        </div>
      </div>
    </div>
  </div>

</div>

<div class="blog-main-wrapper section-padding">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="blog-item-wrapper">
          <!-- blog item wrapper end -->
          <div class="row mbn-30">
            @foreach($blogs as $blog)
            <div class="col-md-6">
              <!-- blog post item start -->
              <div class="blog-post-item mb-30">
                <figure class="blog-thumb">
                  <!-- Kiểm tra nếu có hình ảnh -->
                  @if($blog->image_url)
                  <a href="{{ route('client.blog.show', $blog->id) }}">
                    <img src="{{ Storage::url($blog->image_url) }}" alt="blog image">
                  </a>
                  @else
                  <!-- Nếu không có hình ảnh, có thể thêm một hình ảnh mặc định hoặc để trống -->
                  <a href="{{ route('client.blog.show', $blog->id) }}">
                    <img src="{{ asset('assetsClient/img/blog/default-image.jpg') }}" alt="blog image" style="width: 300px; height: 200px; object-fit: cover;">
                  </a>
                  @endif
                </figure>
                <div class="blog-content">
                  <div class="blog-meta">
                    @if($blog->status != 'draft')
                    <!-- Hiển thị ngày tháng và tác giả nếu bài viết không phải là nháp -->
                    <p>
                      {{ optional($blog->created_at)->format('d/m/Y') }} |
                      <a href="#">{{ $blog->user->name ?? 'Unknown' }}</a>
                    </p>
                    @else
                    <!-- Nếu là nháp, không hiển thị gì hoặc có thể hiển thị thông báo -->

                    @endif
                  </div>


                  <h4 class="blog-title">
                    <!-- Tiêu đề bài viết -->
                    <a href="{{ route('client.blog.show', $blog->id) }}">{{ $blog->title }}</a>
                  </h4>
                </div>
              </div>
              <!-- blog post item end -->
            </div>
            @endforeach
          </div>
          <!-- blog item wrapper end -->

          <!-- start pagination area -->
          <div class="paginatoin-area text-center">
            <ul class="pagination-box">
              <!-- Previous Page Link -->
              <li class="{{ $blogs->onFirstPage() ? 'disabled' : '' }}">
                <a class="previous" href="{{ $blogs->previousPageUrl() }}">
                  <i class="pe-7s-angle-left"></i>
                </a>
              </li>

              <!-- Pagination Links -->
              @foreach ($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
              <li class="{{ $page == $blogs->currentPage() ? 'active' : '' }}">
                <a href="{{ $url }}">{{ $page }}</a>
              </li>
              @endforeach

              <!-- Next Page Link -->
              <li class="{{ $blogs->hasMorePages() ? '' : 'disabled' }}">
                <a class="next" href="{{ $blogs->nextPageUrl() }}">
                  <i class="pe-7s-angle-right"></i>
                </a>
              </li>
            </ul>
          </div>

                            <h4>{{ $blog->title }}</h4>
                        </a>


          <!-- end pagination area -->
        </div>
      </div>
    </div>
  </div>
</div>




@endsection