@extends('frontend.category_layout')
@section('title','Quarmenü Anasayfa')
@section('content')
    @foreach($data as $category)
        <div class="card-box">
            <a href="{{ route('product.list', ['link' => $category->link]) }}">
                <img src="/{{ $category->image }}" alt="{{ $category->categoryName }}">
                <h4 class="bottom-left">{{ $category->categoryName }}</h4>
            </a>
        </div>
    @endforeach
@endsection
