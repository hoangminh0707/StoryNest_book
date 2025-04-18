<?php
?>


@extends('client.layouts.app')
@section('title', 'Blog')

@section('content')

  <!-- Hero Section -->
  <section class="hero-section position-relative padding-large"
    style="background-image: url('{{ asset('assetClient/images/banner-image-bg-1.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
    <div class="hero-content d-flex align-items-center justify-content-center h-100">
    <div class="container text-center text-white">
      <h1 class="mb-2">Chi tiết bài viết</h1>
      <div class="breadcrumbs">
      <a href="/" class="text-white">Home</a>
      <span class="mx-1 text-white">/</span>
      <span class="text-decoration-underline text-white">Post</span>
      </div>
    </div>
    </div>
  </section>

  <!-- Blog Detail Section -->
  <section class="inner-page-sec-padding-bottom py-5">
    <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">

      <!-- Blog Post -->
      <div class="blog-post post-details mb-5">
        <div class="blog-image mb-4">
        @if ($blog->image)
      <img src="{{ Storage::url($blog->image) }}" alt="Blog image" class="img-fluid w-100 rounded">
    @else
    <img src="https://via.placeholder.com/800x400?text=No+Image" class="img-fluid w-100 rounded" alt="No Image">
  @endif
        </div>

        <div class="blog-content">
        <h3 class="mb-3">{{ $blog->title }}</h3>
        <div class="post-meta mb-4 ">
          <i class="far fa-calendar-alt"></i> {{ $blog->created_at->format('F d, Y') }}
        </div>

        <article>
          <p>{{ $blog->content }}</p>
        </article>
        </div>
      </div>

      <!-- Comment Form -->
      <section>

        <!-- Hiển thị các bình luận -->
        <div class="comments-section mt-4">
        <h4>{{ $blog->comments->count() }} Bình luận</h4>

        @foreach($blog->comments as $comment)
      <div class="comment">
        <h5>{{ $comment->name }}</h5>
        <p>{{ $comment->content }}</p>
        <small>{{ $comment->created_at->diffForHumans() }}</small>
      </div>
    @endforeach
        </div>

        <!-- Form Bình luận -->
        <div class="comment-form mt-5">
        <h4>Để lại bình luận của bạn</h4>

        @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

        <form action="{{ route('comments.store', $blog->id) }}" method="POST">
          @csrf
          <div class="form-group">
          <label for="name">Tên của bạn</label>
          <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
          @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
      @enderror
          </div>

          <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
          @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
      @enderror
          </div>

          <div class="form-group">
          <label for="content">Nội dung bình luận</label>
          <textarea id="content" name="content" class="form-control" rows="5">{{ old('content') }}</textarea>
          @error('content')
        <div class="alert alert-danger">{{ $message }}</div>
      @enderror
          </div>

          <button type="submit" class="btn btn-primary">Gửi Bình luận</button>
        </form>
        </div>
      </div>
    </div>
    </div>
  </section>


  </div>
  </div>
  </div>
  </section>

@endsection