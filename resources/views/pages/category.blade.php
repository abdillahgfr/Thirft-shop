@extends('layouts.app')

@section('title')
    Store Category Page
@endsection

@section('content')
    <!-- Page Content -->
    <div class="page-content page-home">
      <section class="store-trend-categories">
        <div class="container">
          <div class="row">
            <div class="col" data-aos="fade-up">
              <h5>All Categories</h5>
            </div>
            <div class="col-4 text-left">
               <form action="{{ url('cari') }}" method="GET">
                {{ @csrf_field() }}
                <input type="text" name="name" placeholder="Search Product" class="form-control form-control-sm mb-3">
              </form>
             </div>
          </div>
            <div class="row">
              <div class="col-12">
                <div class="owl-carousel owl-theme">
                    @php $incrementCategory = 0 @endphp
                      @forelse ($categories as $category)
                          <div
                              class="col-md-12"
                              data-aos="fade-up"
                              data-aos-delay="{{ $incrementCategory+= 100 }}"
                          >
                              <a href="{{ route('categories-detail', $category->slug) }}" class="component-categories d-block">
                                  <div class="categories-image">
                                      <img
                                      src="{{ Storage::url($category->photo) }}"
                                      alt=""
                                      class="w-100"
                                      />
                                  </div>
                                  <p class="categories-text">{{ $category->name }}</p>
                              </a>
                          </div>
                      @empty
                      <div class="col-12 text-center py-5" 
                          data-aos="fade-up" 
                          data-aos-delay="100">
                          No Categories Found
                      </div>
                    @endforelse
                    
                </div>  
              </div> 
            </div>
        </div>
      </section>

      <section class="store-new-products">
        <div class="container">
          <div class="row">
            <div class="col-12" data-aos="fade-up">
              <h5>All Products</h5>
            </div>
          </div>
          <div class="row">
          @php $incrementProduct = 0 @endphp
            @forelse ($products as $product)
                <div
                class="col-6 col-md-4 col-lg-3"
                data-aos="fade-up"
                data-aos-delay="{{ $incrementProduct+= 100 }}"
            >
                    <a href="{{ route('details', $product->slug) }}" class="component-products d-block">
                        <div class="product-thumbnail">
                            <div
                            class="products-image"
                            style="
                                @if($product->galleries->count())
                                    background-image: url('{{ Storage::url($product->galleries->first()->photos) }}')
                                @else
                                    background-color: #eee
                                @endif 
                            "
                        ></div>
                    </div>
                        <div class="product-text mb-1 mt-2 text-dark">{{ $product->name }}</div>
                        <div class="product-price mb-1" style="color: #F0B76E">Rp.{{ $product->price }}</div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5" 
                        data-aos="fade-up" 
                        data-aos-delay="100">
                        No Products Found
                </div>
            @endforelse
          </div>
          <div class="row">
            <div class="col-12 mt-4">
               {{ $products->links() }}
            </div>
          </div>
        </div>
      </section>
    </div>
@endsection

@push('addon-script')
<script>
  $(document).ready(function(){
    var owl = $(".owl-carousel");
  owl.owlCarousel({
    margin: 10,
    loop: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 5,
      },
    },
  });
});
</script>
<link rel="stylesheet" href="{{ asset('vendor/dist/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/dist/assets/owl.theme.default.min.css') }}">
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/dist/owl.carousel.js') }}"></script>
<script src="{{ asset('vendor/dist/owl.carousel.min.js') }}"></script>

@endpush