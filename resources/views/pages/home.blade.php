@extends('layouts.app')

@section('title')
    JOKIDAYS.CO
@endsection

@section('content')
    <div class="row mt-4" style="margin:0px">
        <div id="slider-img" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#slider-img" data-slide-to="0" class="active"></li>
            </ol>
            <div class="carousel-inner" style="border-radius: 5px;">
                <div class="carousel-item active">
                    <img src="{{ asset('storage/banner/banner-1.png')}}" class="d-block w-100">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#slider-img" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#slider-img" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="row mb-4" style="margin:0px">
        <div class="col-12 mt-4">
            <h5>Daftar Layanan</h5>
            <span class="strip-primary"></span>
        </div>
        @foreach ($products as $product)
        <div class="col-lg-3 col-md-4 col-12 mt-3">
            <div class="card rounded-3">
                <img src="https://xcashshop.com/assets/images/1638285309112.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{$product->name}}</h5>
                    <p class="card-text">{{$product->description}}</p>
                    <a href="product/{{$product->slug}}" class="btn btn-outline-primary">
                        <i class="fas fa-shopping-cart"></i>
                        Buy
                    </a>
                </div>
            </div>
        </div>
        @endforeach
            {{-- <div class="card">
                <div class="card-body d-flex">
                    <img src="https://xcashshop.com/assets/images/1638285309112.png" class="rounded float-left me-3"
                        style="border-radius: 10px;" width="80px" height="80px">
                    <div>
                        <h5 class="card-title">Mobile Legends</h5>
                        <p class="card-text">Diamond Fast</p>
                        <a href="id/mobile-legends" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart"></i>
                            Buy
                        </a>
                    </div>
                </div>
            </div> --}}
    </div>
@endsection
