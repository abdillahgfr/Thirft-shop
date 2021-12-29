@extends('layouts.app')

@section('title')
    Store Detail Page
@endsection

@section('content')
    <!--Page Content-->
    <div class="page-content page-details">
      <section class="store-breadcrumbs" data-aos="fade-down" data-aous-delay="100">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <nav>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                  </li>
                  <li class="breadcrumb-item active">
                    Product Details
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>

      <section class="store-gallery mb-3" id="gallery">
        <div class="container">
          <div class="row">
           <div class="col-lg-6" data-aos="zoom-in">
            <transition name="slide-fade" mode="out-in">
              <img :src="photos[activePhoto].url" :key="photos[activePhoto].id" class="w-100 main-image" alt="">
            </transition>
           </div>
            <div class="col-lg-2">
              <div class="row">
                <div class="col-3 col-lg-12 mt-2 mt-lg-0" v-for="(photo, index) in photos" :key="photo.id" data-aos="zoom-in" data-aos-delay="100">
                  <a href="#" @click="changeActive(index)">
                    <img :src="photo.url" class="w-100 thumbnail-image" class="{active: index == activePhoto}" alt="">
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="store-details-container" data-aos="fade-up">
        <section class="store-heading">
          <div class="container">
            <div class="row">
            <div class="col-lg-6">
              <h1>{{$product->name}}</h1>
            <div class="owner">By {{  $product->user->store_name }}<br />{{ number_format((float)$product->user->average_rate, 2, '.', '') }} 
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" style="color:#ffc700">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
              </svg>
            </div>
                  @if ($product->user->store_status == 0)
                      <div class="div text-danger w-50 mb-2">Store Temporarily Closed</div>
                  @endif
              <div class="price" style="color: #F0B76E">Rp.{{ number_format($product->price) }}</div>
            </div>
            <div class="col-lg-2" data-aos="zoom-in">
              @auth
                <form action="{{ route('detail-add', $product->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <button
                     class="btn btn-default px-4 text-white btn-block mb-3"
                      type="submit"
                      style="background-color: #FF7878"
                      > 
                    Add to Cart
                  </button>
                </form>
              @else
                <a
                  href="{{ route('login') }}" 
                  class="btn btn-default text-white btn-block mb-3"
                  style="background-color: #FF7878"
                  >
                  Sign In to Add
                </a>
              @endauth
            </div>
          </div></div>
        </section>
        <section class="store-description">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-8">
                {!! $product->description !!}
              </div>
            </div>
          </div>
        </section>
        <section class="store-review">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-8 mt-3 mb-3">
                <h5>Product Review</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-lg-8">
                @foreach($product->reviews as $review)
                <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="rate">
                            <input type="radio" id="star5" value="5" required {{ ($review->rate == '5' ? 'checked' : '') }} disabled />
                            <label for="star5" title="text">5 stars</label>
                            <input type="radio" id="star4" value="4" {{ ($review->rate == '4' ? 'checked' : '') }} disabled />
                            <label for="star4" title="text">4 stars</label>
                            <input type="radio" id="star3" value="3" {{ ($review->rate == '3' ? 'checked' : '') }} disabled />
                            <label for="star3" title="text">3 stars</label>
                            <input type="radio" id="star2" value="2" {{ ($review->rate == '2' ? 'checked' : '') }} disabled />
                            <label for="star2" title="text">2 stars</label>
                            <input type="radio" id="star1" value="1" {{ ($review->rate == '1' ? 'checked' : '') }} disabled />
                            <label for="star1" title="text">1 star</label>
                        </div>
                      </div>
                      <div class="row">
                        <p style="margin-left: 10px;">
                        {{$review->review}}
                        </p>
                      </div>
                      <div class="row">
                        <p style="margin-left: 10px;">
                        <div class="owner" style="    font-weight: normal;font-size: 14px;line-height: 21px;color: #979797;margin-bottom: 8px;">By {{ $review->user->email }}</div>
                        </p>
                      </div>
                    </div>
                </div>
                @endforeach
                @if($product->reviews->count() == 0)
                <div class="alert alert-warning">There are no reviews yet.</div>
                @endif
              </div>
            </div>
          </div>
        </section>
        <section class="store-review">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-8 mt-3 mb-3">
                <h5>Customer Comments</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-lg-8">
                <ul class="list-unstyled">
                 {{-- <div class="card my-4">
                    <h5 class="card-header">Leave a Comment: </h5>
                       <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                          @csrf
                            <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                            <div class="form-group">
                              <p>Name : </p>
                              <input class="form-control" type="text" name="nama"> </input>
                            </div>
                            <div class="form-group">
                              <p>Comment : </p>
                              <input class="form-control" type="text" name="komentar"> </input>
                            </div>
                            <input 
                              type="submit"  
                              class="btn btn-default nav-link px-4 text-white"
                              style="background-color: #0cbdc4"></button>
                        </form>
                      </div> --}}
                  </div>
                </ul>
              </div>
            </div>
          </div>
          <div class="container">
            @comments(['model' => $product])
          </div>
        </section>
      </div>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script>
      var gallery = new Vue({
        el: "#gallery",
        mounted() {
          AOS.init();
        },
        data: {
          activePhoto: 0,
          photos: [
            @foreach($product->galleries as $gallery)
              {
                id: {{ $gallery->id }},
                url: "{{ Storage::url($gallery->photos) }}",
              },
            @endforeach
          ],
        },
        methods: {
          changeActive(id){
            this.activePhoto = id;
          },
        },
      });
    </script> 
@endpush