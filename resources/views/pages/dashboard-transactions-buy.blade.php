@extends('layouts.dashboard')

@section('title')
Store Dashboard Transaction Detail
@endsection

@section('content')
<!-- Section Content -->
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">#{{ $transaction->code }}</h2>
            <p class="dashboard-subtitle">Transactions / Details</p>
        </div>
        <div class="dashboard-content" id="transactionDetails">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <img src="{{ Storage::url($transaction->product->galleries->first()->photos ?? '') }}" class="w-100 mb-3" alt="" />
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Customer Name</div>
                                            <div class="product-subtitle">
                                                {{ $transaction->transaction->user->name }}
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Product Name</div>
                                            <div class="product-subtitle">
                                                {{ $transaction->product->name }}
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">
                                                Date of Transaction
                                            </div>
                                            <div class="product-subtitle">
                                                {{ $transaction->created_at }}
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Payment Status</div>
                                            <div class="product-subtitle text-danger">
                                                {{ $transaction->transaction->transaction_status }}
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Total Amount</div>
                                            <div class="product-subtitle">IDR{{ number_format($transaction->transaction->total_price) }}</div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Mobile</div>
                                            <div class="product-subtitle">
                                                {{ $transaction->transaction->user->phone_number }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($transaction->product_status === 1)
                            @php
                            $noReview = $transaction->review == null
                            @endphp
                            <form action="{{ route('dashboard-transaction-buy-review', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="rate">Rate</label>
                                            <br />
                                            <!-- <input type="number" class="form-control" name="rate" value="{{ $transaction->review == null ? 0 : $transaction->review->rate }}" required {{ $noReview ? "" : "disabled" }} /> -->
                                            <div class="rate">
                                                <input type="radio" id="star5" name="rate" value="5" required {{ ($transaction->review == null) ? 0 : ($transaction->review->rate == '5' ? 'checked' : '') }} {{ $noReview ? "" : "disabled" }} />
                                                <label for="star5" title="text">5 stars</label>
                                                <input type="radio" id="star4" name="rate" value="4" {{ ($transaction->review == null) ? 0 : ($transaction->review->rate == '4' ? 'checked' : '') }} {{ $noReview ? "" : "disabled" }} />
                                                <label for="star4" title="text">4 stars</label>
                                                <input type="radio" id="star3" name="rate" value="3" {{ ($transaction->review == null) ? 0 : ($transaction->review->rate == '3' ? 'checked' : '') }} {{ $noReview ? "" : "disabled" }} />
                                                <label for="star3" title="text">3 stars</label>
                                                <input type="radio" id="star2" name="rate" value="2" {{ ($transaction->review == null) ? 0 : ($transaction->review->rate == '2' ? 'checked' : '') }} {{ $noReview ? "" : "disabled" }} />
                                                <label for="star2" title="text">2 stars</label>
                                                <input type="radio" id="star1" name="rate" value="1" {{ ($transaction->review == null) ? 0 : ($transaction->review->rate == '1' ? 'checked' : '') }} {{ $noReview ? "" : "disabled" }} />
                                                <label for="star1" title="text">1 star</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="review">Review</label>
                                            <input type="text" class="form-control" name="review" value="{{ $transaction->review == null ? '' : $transaction->review->review }}" required {{ $noReview ? "" : "disabled" }} />
                                        </div>
                                    </div>
                                </div>
                                @if($noReview)
                                <div class="row">
                                    <div class="col text-right">
                                        <button type="submit" class="btn btn-default px-5 text-white" style="background-color: #FF7878" {{ $noReview }}>
                                            Save
                                        </button>
                                    </div>
                                </div>
                                @endif
                            </form>
                            @endif
                            <form action="{{ route('dashboard-transaction-update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mt-4">
                                        <h5>Shipping Information</h5>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Address</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->transaction->user->address_one }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Province</div>
                                                <div class="product-subtitle">{{ App\Models\Province::find($transaction->transaction->user->provinces_id)->name }}</div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">City</div>
                                                <div class="product-subtitle">{{ App\Models\Regency::find($transaction->transaction->user->regencies_id)->name ?? '' }}</div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Postal Code</div>
                                                <div class="product-subtitle">{{ $transaction->transaction->user->zip_code }}</div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Country</div>
                                                <div class="product-subtitle">{{ $transaction->transaction->user->country }}</div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Resi</div>
                                                <div class="product-subtitle">{{ $transaction->resi }}</div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="is_store_open">Product Status</label>
                                                    <p class="text-muted">
                                                        Apakah Barang sudah diterima?
                                                    </p>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" class="custom-control-input" name="product_status" id="openStoreTrue" value="1" {{ $transaction->product_status == 1  ? 'checked' : '' }} />
                                                        <label for="openStoreTrue" class="custom-control-label">
                                                            Barang Diterima
                                                        </label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" class="custom-control-input" name="product_status" id="openStoreFalse" value="0" {{ $transaction->product_status == 0 || $transaction->product_status == NULL ? 'checked' : '' }} />
                                                        <label for="openStoreFalse" class="custom-control-label">
                                                            Belum Diterima
                                                        </label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 mt-3">
                                                            @if ($transaction->product_status == 0)
                                                            @if ($transaction->shipping_status == 'PENDING')
                                                            <button type="submit" class="btn btn-default px-5 text-white" style="background-color: #FF7878" onclick="msg()" disabled>
                                                                Update Status
                                                            </button>
                                                            @else
                                                            <button type="submit" class="btn btn-default px-5 text-white" style="background-color: #FF7878" onclick="msg()">
                                                                Update Status
                                                            </button>
                                                            @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('addon-script')
<script src="/vendor/vue/vue.js"></script>
<script>
    var transactionDetails = new Vue({
        el: "#transactionDetails",
        data: {
            status: "{{ $transaction->shipping_status }}",
            resi: "{{ $transaction->resi }}",
        },
    });
</script>
<script>
    function msg() {
        alert("Terima Kasih Telah Melakukan Konfirmasi!");
    }
</script>
@endpush