@extends('layouts.dashboard')

@section('title')
Store Dashboard Product
@endsection

@section('content')
<!-- Section Content -->
    <div
        class="section-content section-dashboard-home"
        data-aos="fade-up"
        >
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">My Products</h2>
                <p class="dashboard-subtitle">Manage it well and get money</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                    <a
                        href="{{ route('dashboard-product-create') }}"
                        class="btn btn-default px-5 text-white"
                        style="background-color: #FF7878"
                        >Add New Product</a
                    >
                    </div>
                </div>
                <div class="row mt-4">
                    @foreach ($products as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <a
                                href="{{ route('dashboard-product-details', $product->id) }}"
                                class="card card-dahsboard-product d-block"
                            >
                                <div class="card-body">
                                    <img
                                        src="{{ Storage::url($product->galleries->first()->photos ?? '') }}"
                                        alt=""
                                        class="w-100 mb-2"
                                        height="200"
                                    />
                                    <div class="product-title mb-1 mt-2" style="color: #020202">{{ $product->name }}</div>
                                    <div class="product-category mb-2" style="color: #C5C5C5">{{ $product->category->name }}</div>
                                     <form action="{{ route('dashboard-product-delete', $product->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger" style="background-color: F32323">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection