@extends('layouts.app-verify')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-lg-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                   <div>
                        {{ __('Verify Your Email Address') }}       
                    </div> 
                    <div>
                        {{ Auth::user()->email }}
                    </div> 
                </div>
                <div class="card-body">
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
