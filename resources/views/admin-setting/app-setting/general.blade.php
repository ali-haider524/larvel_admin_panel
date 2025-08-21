@extends('user_type.auth', ['parentFolder' => 'pages', 'childFolder' => 'app-setting'])

@section('content')
@if($errors->get('msgError'))
          <div class="m-3  alert alert-warning alert-dismissible fade show" role="alert">
            <span class="alert-text text-white">
              {{$errors->first()}}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
              <i class="fa fa-close" aria-hidden="true"></i>
            </button>
          </div>
          @endif
          @if(session('success'))
          <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
            <span class="alert-text text-white">
              {{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
              <i class="fa fa-close" aria-hidden="true"></i>
            </button>
          </div>
          @endif
  <div class="row">
    <div class="col-lg-9 col-12 mx-auto">
      <div class="card card-body mt-4">
          <form action="/setting/update" method="POST"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="general">
        <h6 class="mb-0">General Setting</h6>
        <p class="text-sm mb-0">Setup Your Company Details</p>

        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">Company or Brand</label>
        <input type="text" class="form-control" name="app_author" value="{{$data[0]->app_author}}">

        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">Support Email</label>
        <input type="text" class="form-control" name="app_email" placeholder="example@gmail.com"  value="{{$data[0]->app_email}}">

        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">Website </label>
        <input type="text" class="form-control" name="app_website" placeholder="http"  value="{{$data[0]->app_website}}">

        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">Privacy Policy </label>
        <input type="text" class="form-control" name="privacy_policy" placeholder="http" value="{{$data[0]->privacy_policy}}">

        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">Insta Page</label>
        <input type="text" class="form-control" name="insta" placeholder="http"  value="{{$data[0]->insta}}">

        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">Youtube Channel</label>
        <input type="text" class="form-control" name="youtube" placeholder="http" value="{{$data[0]->youtube}}"> 

        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">Telegram Channel</label>
        <input type="text" class="form-control" name="telegram" placeholder="http" value="{{$data[0]->telegram}}">

        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">App Icon</label>
        <input type="file" class="form-control" name="icon" >
        

        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">About App</label>
         <textarea name="app_description" class="ckeditor form-control">{{$data[0]->app_description}}</textarea>
         
         <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">App Share Message</label>
         <textarea name="refer_msg" class="ckeditor form-control">{{$data[0]->refer_msg}}</textarea>


        <div class="d-flex justify-content-end mt-4">
          <button type="submit" name="button" class="btn bg-gradient-primary m-0 ms-2">Save Changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('js')  
  <script src="{{ URL::asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
  <script src="{{ URL::asset('assets/js/plugins/flatpickr.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/plugins/dropzone.min.js') }}"></script>
  <script>
   
  </script>
@endpush