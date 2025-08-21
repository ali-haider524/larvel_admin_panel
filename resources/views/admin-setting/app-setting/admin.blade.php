@extends('user_type.auth', ['parentFolder' => 'admin-setting', 'childFolder' => 'app-setting'])

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
        <h6 class="mb-0">Admin Profile</h6>
        <p class="text-sm mb-0">Update Password</p>
        <form action="/setting/update" method="POST">
        @csrf
        <input  type="hidden" name="type" value="admin">
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">Admin Email</label>
        <input type="text" class="form-control" name="email" value="{{$data[0]->email}}" placeholder="admin@gmail.com">
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">Old Password</label>
        <input type="password" class="form-control" name="oldpass" >
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">New Password</label>
        <input type="password" class="form-control" name="newpass" >
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" name="cnpass" >

        <div class="d-flex justify-content-end mt-4">
          <button type="submit" name="button" class="btn bg-gradient-info m-0 ms-2">Save Changes</button>
          </form>
        </div>
      </div>
    </div>
    
    
    <div class="col-lg-9 col-12 mx-auto">
      <div class="card card-body mt-4">
        <h6 class="mb-0">License Verification</h6>
        <p class="text-sm mb-0"></p>
        <form action="/setting/update" method="POST">
        @csrf
        <input type="hidden" name="type" value="package">
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">Purchase Code </label>
        <input type="text" class="form-control" name="licence" value="{{$data[0]->purchase_code}}" placeholder="">
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">Android App Package Name </label>
        <input type="text" class="form-control" name="package" value="{{$data[0]->license}}" placeholder="com.app.rewardapp">
       
        <div class="d-flex justify-content-end mt-4">
          <button type="submit" name="submit" class="btn bg-gradient-info m-0 ms-2">Verify</button>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('js')  
  <script src="{{ URL::asset('assets/js/plugins/choices.min.js') }}"></script>
  <script>

    if (document.getElementById('choices-tag')) {
      var tag = document.getElementById('choices-tag');
      const example = new Choices(tag);
    }

    if (document.getElementById('choices-tag1')) {
      var tag = document.getElementById('choices-tag1');
      const example = new Choices(tag);
    }
  
    if (document.getElementById('choices-tag2')) {
      var tag = document.getElementById('choices-tag2');
      const example = new Choices(tag);
    }
  
  </script>


@endpush