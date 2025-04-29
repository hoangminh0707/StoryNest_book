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
              <li class="breadcrumb-item"><a href="{{ url('/blog') }}">blog</a></li>
              <li class="breadcrumb-item active" aria-current="page">Bài viết chi tiết</li>
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
      <div class="col-lg-3 order-2">
        <aside class="blog-sidebar-wrapper">
          <!-- Search Sidebar -->
          <div class="blog-sidebar">
            <h5 class="title">search</h5>
            <div class="sidebar-serch-form">
              <form action="#">
                <input type="text" class="search-field" placeholder="search here">
                <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
              </form>
            </div>
          </div>

          <!-- Categories Sidebar (Only show if categories exist) -->


          <!-- Blog Archives Sidebar (Only show if archives exist) -->


          <!-- Recent Posts Sidebar (Only show if recent posts exist) -->


          <!-- Tags Sidebar -->

        </aside>
      </div>

      <div class="col-lg-9 order-1">
        <div class="blog-item-wrapper">
          <!-- Blog Post -->
          <div class="blog-post-item blog-details-post">
            <figure class="blog-thumb">
              <div class="blog-carousel-2 slick-row-15 slick-arrow-style slick-dot-style">
                @if($blog->image_url )
                <div class="blog-single-slide">
                  <img src="{{ Storage::url($blog->image_url) }}" alt="blog image">
                </div>
                @endif
              </div>
            </figure>
            <div class="blog-content">
              <h3 class="blog-title">{{ $blog->title }}</h3>
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
              <div class="entry-summary">
                <p>{{ $blog->content }}</p>
                <blockquote>
                  <p>{{ $blog->quote }}</p>
                </blockquote>
              </div>
            </div>
          </div>

          <!-- Comment Section (Only show if comments exist) -->
          @if($comments && $comments->count() > 0)
          <div class="comment-section section-padding">
            <h5>{{ $comments->count() }} Comment</h5>
            <ul>
              @foreach($comments as $comment)
              <li>
                <div class="author-avatar">
                  <img src="{{ $comment->author->avatar_url }}" alt="">
                </div>
                <div class="comment-body">
                  <span class="reply-btn"><a href="#">Reply</a></span>
                  <h5 class="comment-author">{{ $comment->author->name }}</h5>
                  <div class="comment-post-date">
                    {{ $comment->created_at->format('d M, Y') }} at {{ $comment->created_at->format('h:i a') }}
                  </div>
                  <p>{{ $comment->content }}</p>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
          @endif

          <!-- Comment Box (Always show) -->
          <div class="blog-comment-wrapper">
            <h5>Leave a reply</h5>
            <p>Your email address will not be published. Required fields are marked *</p>
            <form action="#">
              <div class="comment-post-box">
                <div class="row">
                  <div class="col-12">
                    <label>Comment</label>
                    <textarea name="commnet" placeholder="Write a comment"></textarea>
                  </div>
                  <div class="col-lg-4 col-md-4">
                    <label>Name</label>
                    <input type="text" class="coment-field" placeholder="Name">
                  </div>
                  <div class="col-lg-4 col-md-4">
                    <label>Email</label>
                    <input type="text" class="coment-field" placeholder="Email">
                  </div>
                  <div class="col-lg-4 col-md-4">
                    <label>Website</label>
                    <input type="text" class="coment-field" placeholder="Website">
                  </div>
                  <div class="col-12">
                    <div class="coment-btn">
                      <input class="btn btn-sqr" type="submit" name="submit" value="Post Comment">
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection