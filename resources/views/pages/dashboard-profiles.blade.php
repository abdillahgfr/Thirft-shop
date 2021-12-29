@extends('layouts.dashboard')

@section('title')
    Account Settings
@endsection

@section('content')
<!-- Section Content -->
    <div
      class="section-content section-dashboard-home"
      data-aos="fade-up"
    >
      <div class="container-fluid">
        <div class="dashboard-heading">
          <h2 class="dashboard-title">Setting Picture</h2>
          <p class="dashboard-subtitle">Update your current Profile Picture</p>
        </div>
        <div class="dashboard-content">
          <div class="row">
            <div class="col-12">
                <form action="{{ route('dashboard-settings-profile-redirect','dashboard-settings-profile') }}" method="POST" enctype="multipart/form-data" id="locations">
                @csrf
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="mobile">Profile Picture</label>
                          <input 
                            type="file" 
                            class="form-control"
                            name="photos" 
                            id="photos"
                            />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col text-right">
                        <button
                          type="submit"
                          class="btn btn-default px-5 text-white"
                          style="background-color: #FF7878"
                        >
                          Save
                        </button>
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
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@endpush