@extends('layouts.app')

@section('title')
    Store Comment Page
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
                  <li class="breadcrumb-item active">Comment</li>
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
                  <div class="row mt-3">
                    <div class="col-12 mt-2">
                      <h5 class="mb-3">Comments Product</h5>
                      @foreach ($comments as $com)
                        <a 
                          href="{{ route('comments-reply', $com->product->slug) }}"
                          class="card card-list d-block"
                          >
                          <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">{{ $com->user->name }}</div>
                                <div class="col-md-3">{{ $com->product->name }}</div>
                                <div class="col-md-3">{{ $com->comment }}</div>
                                <div class="col-md-2">{{ $com->created_at }}</div>
                                <div class="col-md-1 d-none d-md-block">
                                  <img 
                                    src="/images/dashboard-arrow-right.svg"
                                    alt=""
                                  >
                              </div>
                            </div>
                          </div>
                        </a>
                      @endforeach
                    </div>
                  </div>
              </table>
            </div>
          </div>
          <div class="row" data-aos="fade-up" data-aos-delay="150">
            <div class="col-12">
              <hr />
            </div>
        </div>
      </section>
    </div>
@endsection