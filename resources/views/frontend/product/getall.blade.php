@extends('frontend.product_layout')
@section('title','Quarmenü Ürünler')
@section('content')
    @foreach($data as $product)
        <div class="card-box">
            <div class="image-container">
                <img src="/{{$product->image}}" alt="İçecek Resmi">
            </div>
            <div class="content">
                <h4>{{$product->productName}}</h4>
                <span>{{$product->price}} TL</span>
            </div>
        </div>
    @endforeach
@endsection

