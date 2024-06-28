@extends('blogs::public.layouts.master')
@section('content')
<div class="container mt-4">
<div class="row">
    @foreach($news as $item)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('storage/images/news/' . $item->images[0]->images) }}" class="card-img-top img-fluid" alt="..." style="height: 250px;">
                <div class="card-body">
                  <h5 class="card-title">{{$item->title}}</h5>
                  <p class="card-text">{!!$item->description!!}</p>
                  <a href="" class="btn btn-primary">Read more</a>
                </div>
              </div>
        </div>
    @endforeach
    {{ $news->links('livewire.pagination') }}
</div>
</div>


@endsection