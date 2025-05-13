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
          @if($blog->image_url)
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
        @if($blog->comments->count() > 0)
      <div class="comment-section section-padding">
      <h5>{{ $blog->comments->count() }} Bình luận</h5>
      <ul>
        @foreach ($blog->comments as $comment)
      <li>
      <div class="author-avatar">
        <img
        src="{{ $comment->user->avatar ? Storage::url($comment->user->avatar) : 'https://i.ibb.co/WpKLtySw/Logo-Story-Nest-Book.jpg' }}"
        alt="">
      </div>
      <div class="comment-body">
        <span class="reply-btn">
        <a href="javascript:void(0);"
        onclick="setReply({{ $comment->id }}, '{{ $comment->user->name ?? 'Guest' }}')">Reply</a>
        </span>
        <h5 class="comment-author">{{ $comment->user->name ?? 'Guest' }}</h5>
        <div class="comment-post-date">
        {{ $comment->created_at->format('d M, Y \a\t h:i A') }}
        </div>
        <p>{{ $comment->content }}</p>
      </div>

      </li>
      @if ($comment->children)
      <ul class="children">
      @foreach ($comment->children as $child)
      <li class="comment-children">
      <div class="author-avatar">
      <img
      src="{{ $comment->user->avatar ? Storage::url($comment->user->avatar) : 'https://i.ibb.co/WpKLtySw/Logo-Story-Nest-Book.jpg' }}"
      alt="">
      </div>
      <div class="comment-body">
      <span class="reply-btn">
      <a href="javascript:void(0);"
      onclick="setReply({{ $child->id }}, '{{ $child->user->name ?? 'Guest' }}')">Reply</a>
      </span>
      <h5 class="comment-author">
      {{ $child->user->name ?? 'Guest' }}
      @if ($child->parent && $child->parent->user)
      đã trả lời <span style="color: #007bff;">{{ $child->parent->user->name ?? 'Guest' }}</span>
      @endif
      </h5>
      <div class="comment-post-date">
      {{ $child->created_at->format('d M, Y \a\t h:i A') }}
      </div>
      <p>{{ $child->content }}</p>
      </div>
      </li>
      @endforeach
      </ul>
      @endif
      </li>
      @endforeach

      </ul>
      </div>
      @endif

        <!-- Comment Box (Always show) -->
        <div class="blog-comment-wrapper">
        <h5>Bình Luận bài biết</h5>
        <form action="{{ route('comments.store') }}" method="POST">
          @csrf
          <input type="hidden" name="commentable_id" value="{{ $blog->id }}">
          <input type="hidden" name="commentable_type" value="App\Models\Blog">
          <input type="hidden" id="parent_id_input" name="parent_id" value="">
          <div class="comment-post-box">
          <div class="row">
            <div class="col-12">
            <label>Nhập bình luận về bài viết này của bạn</label>
            <div id="replying-to" style="display: none; margin-bottom: 10px;">
              <strong>Đang trả lời: <span id="replying-name"></span></strong>
              <a href="javascript:void(0);" onclick="cancelReply()"
              style="margin-left: 10px; color: red;">Hủy</a>
            </div>

            <textarea name="content" placeholder="Nhập bình luận vào đây" required></textarea>
            </div>
            <div class="col-12">
            <div class="coment-btn">
              <input class="btn btn-sqr" type="submit" value="Post Comment">
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


  <script>
    function setReply(commentId, userName) {
    document.getElementById('parent_id_input').value = commentId;
    document.getElementById('replying-to').style.display = 'block';
    document.getElementById('replying-name').innerText = userName;

    // Cuộn đến phần form
    document.querySelector('.blog-comment-wrapper').scrollIntoView({ behavior: 'smooth' });
    }

    function cancelReply() {
    document.getElementById('parent_id_input').value = '';
    document.getElementById('replying-to').style.display = 'none';
    document.getElementById('replying-name').innerText = '';
    }
  </script>


@endsection
