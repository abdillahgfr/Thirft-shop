@extends('layouts.success')

@section('title')
    Store Success Page
@endsection

@section('content')
    <div class="page-content page-success">
      <div class="section-success" data-aos="zoom-in">
        <div class="container">
          <div class="row align-items-center row-login justify-content-center">
            <div class="col-lg-6 text-center">
              <img src="/images/bagshop.svg" alt="" class="w-25 mb-4" />
              <h2>Transaction Processed !</h2>
              <p>
                Please wait for an email confirmation from us and 
                we will inform you of the receipt as soon as possible!
              </p>
              <div>
                <a href="{{ route('dashboard') }}" class="btn btn-default w-50 mt-4 text-white" style="background-color: #ff7878">
                  My Dashboard</a
                >
                <a href="{{ route('home') }}" class="btn btn-signup w-50 mt-2">
                  Go To Shopping</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection