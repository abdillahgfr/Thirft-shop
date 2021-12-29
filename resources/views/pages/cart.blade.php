@extends('layouts.app')

@section('title')
    Store Cart Page
@endsection

@section('content')
    <!--Page Content-->
    <div class="page-content page-cart">
      <section
        class="store-breadcrumbs"
        data-aos="fade-down"
        data-aous-delay="100"
      >
        <div class="container">
          <div class="row">
            <div class="col-12">
              <nav>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                  </li>
                  <li class="breadcrumb-item active">Cart</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>

      <section class="store-cart">
        <div class="container">
          <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-12 table-responsive">
              <table class="table table-borderless table-cart">
                <thead>
                  <tr>
                    <td>Image</td>
                    <td>Name &amp; Seller</td>
                    <td>Price</td>
                    <td>Menu</td>
                  </tr>
                </thead>
                <tbody>
                  @php $totalPrice = 0 @endphp
                  @foreach ($carts as $cart)
                  <tr>
                    <td style="width: 20%">
                      @if ($cart->product->galleries)
                        <img
                          src="{{Storage::url($cart->product->galleries->first()->photos)}}"
                          alt=""
                          class="cart-image"/>
                      @endif
                    </td>
                    <td style="width: 35%">
                      <div class="product-title">{{ $cart->product->name }}</div>
                      <div class="product-subtitle">By {{ $cart->product->user->store_name }}</div>
                    </td>
                    <td style="width: 35%">
                      <div class="product-title">Rp. {{ number_format($cart->product->price) }}</div>
                      <div class="product-subtitle">IDR</div>
                    </td>
                    <td style="width: 20%">
                      <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-remove-cart" style="background-color: #F32323"> 
                          Remove 
                        </button>
                      </form>
                    </td>
                  </tr>
                    @php $totalPrice += $cart->product->price @endphp
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="row" data-aos="fade-up" data-aos-delay="150">
            <div class="col-12">
              <hr />
            </div>
            <div class="col-12">
              <h2 class="mb-4">Shippng Details</h2>
            </div>
          </div>
         <form action="{{ route('checkout') }}" id="locations" enctype="multipart/form-data" method="POST">
          @csrf
          <input type="hidden" name="total_price" value="{{ $totalPrice }}">
          <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
            <div class="col-md-12">
              <div class="form-group">
                <label for="address_one">Adress</label>
                <input
                  type="text"
                  class="form-control"
                  id="address_one"
                  name="address_one"
                  value="{{ $user->address_one }}"
                  required
                />
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="provinces_id">Province</label>
                <select name="provinces_id" id="provinces_id" class="form-control" v-if="provinces" v-model="provinces_id" required>
                  <option v-for="province in provinces" :value="province.id">@{{ province.name }}</option>
                </select>
                <select v-else="form-control"></select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="regencies_id">City</label>
                  <select name="regencies_id"  id="regencies_id" v-if="regencies" v-model="regencies_id" class="form-control" required>
                    <option v-for="regency in regencies" :value="regency.id">@{{ regency.name }}</option>
                  </select>
                  <select v-else class="form-control"></select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="zip_code">Zip Code</label>
                <input
                  type="text"
                  class="form-control"
                  id="zip_code"
                  name="zip_code"
                  value="{{ $user->zip_code }}"
                  required
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="country">Country</label>
                <input
                  type="text"
                  class="form-control"
                  id="country"
                  name="country"
                  value="{{ $user->country }}"
                  required
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="phone_number">Mobile</label>
                <input
                  type="text"
                  class="form-control"
                  id="phone_number"
                  name="phone_number"
                  value="{{ $user->phone_number }}"
                  required
                />
              </div>
            </div>
          </div>
          <div class="row" data-aos="fade-up" data-aos-delay="150">
            <div class="col-12">
              <hr />
            </div>
            <div class="col-12">
              <h2 class="mb-1">Payment Information</h2>
            </div>
          </div>
          <div class="row" data-aos="fade-up" data-aos-delay="200">
            <div class="col-4 col-md-2">
              <div class="product-title" style="color: #eeb05f">IDR {{ number_format($totalPrice ?? 0) }}</div>
              <div class="product-subtitle">Total</div>
            </div>
            <div class="col text-right">
             @php
               if($totalPrice != 0){
                 echo "
                  <button
                type='submit'
                class='btn btn-default px-5 text-white'
                style='background-color: #eeb05f'
                >Check Now</
              >
              </button>
                 ";
               }else{
                 echo"
                 <button
                type='submit'
                class='btn btn-default px-5 text-white' disabled
                style='background-color: #eeb05f'
                >Check Now</
              >
              </button>
                 ";
               }
             @endphp
            </div>
          </div>
         </form>
        </div>
      </section>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
      var locations = new Vue({
        el: "#locations",
        mounted() {
          AOS.init();
          this.getProvincesData();
        },
        data: {
          provinces: null,
          regencies: null,
          provinces_id: null,
          regencies_id: null
        },
        methods: {
          getProvincesData() {
            var self = this;
            axios.get('{{ route('api-provinces') }}')
            .then(function(response){
              self.provinces = response.data;
            });
          },
          getRegenciesData() {
            var self = this;
            axios.get('{{ url('api/regencies') }}/' + self.provinces_id)
            .then(function(response){
              self.regencies = response.data;
            });
          },
        },
        watch: {
          provinces_id: function(val, oldVal) {
            this.regencies_id = null;
            this.getRegenciesData();
          }
        }
      });
    </script> 
@endpush