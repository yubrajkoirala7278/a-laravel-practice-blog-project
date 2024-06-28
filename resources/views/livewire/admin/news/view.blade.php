@extends('blogs::admin.layouts.master')
@section('content')
<div class="p-4 bg-white">
    <h1>{{ $newsItem->title }}</h1>
    <p>{{ $newsItem->slug }}</p>
    @foreach ($newsItem->images as $image)
        <img src="{{ asset('storage/images/news/' . $image->images) }}" loading="lazy" alt="{{ $image->images }}">
    @endforeach
</div>
@endsection
