@extends('client.layouts.app')
@section('title', 'Blog')

@section('content')

<!-- Hero Section -->
<section class="hero-section position-relative padding-large" style="background-image: url('{{ asset('assetClient/images/banner-image-bg-1.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
  <div class="hero-content">
    <div class="container">
      <div class="row">
        <div class="text-center">
          <h1>Bài viết</h1>
          <div class="breadcrumbs">
            <span class="item">
              <a href="/">Home &gt;</a>
            </span>
            <span class="item text-decoration-underline">Bài viết</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="breadcrumb-section">
    {{-- <h2 class="sr-only">Site Breadcrumb</h2> --}}
    <div class="container">
      <div class="breadcrumb-contents">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Blog</li>
          </ol>
        </nav>
      </div>
    </div>
  </section>
<!-- Blog Section -->
<section class="inner-page-sec-padding-bottom space-db--30">
    <div class="container">
      <div class="row space-db-lg--60 space-db--30">
        <div class="col-lg-12">
          <div class="row">
            @foreach ($blogs as $blog)
                <div class="col-md-4 mb-4">
                    <div class="blog-card card-style-grid">
                        <a href="{{ route('blogs.show', $blog->id) }}">
                            @if ($blog->image)
                            <img src="{{ Storage::url($blog->image) }}" alt="Blog image" class="img-fluid" style="max-width: 100%; height: auto;">
                        @else
                            <img src="https://via.placeholder.com/400x250.png?text=No+Image" alt="No Image" class="img-fluid" style="max-width: 100%; height: auto;">
                        @endif

                            <h4>{{ $blog->title }}</h4>
                        </a>

                        {{-- Hiển thị ảnh --}}
                        <p>{{ Str::limit($blog->content, 100) }}...</p>  <!-- Trích đoạn nội dung -->
                        <p><strong>Status:</strong> {{ $blog->status }}</p>
                        <hr>
                    </div>
                </div>
            @endforeach
          </div>

          {{-- Pagination --}}
          <div class="pagination justify-content-center">
            {{ $blogs->links() }}
          </div>

        </div>
      </div>
    </div>
</section>

@endsection
