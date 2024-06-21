@extends('blogs::admin.layouts.master')

@section('page-name')
    Blog
@endsection

@section('content')
    <div class="p-4 bg-white">
        <p>Title: {{ $blog->title }}</p>
        <p>Slug: {{ $blog->slug }}</p>
        <p>Description: {!! $blog->description !!}</p>
        <p>Status : {{$blog->is_published==1?'Published':'Unpublished'}}</p>
        <img src="{{ asset('storage/images/blogs/'.$blog->image) }}" alt="Image" style="height:200px">
    </div>
@endsection
