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
        <h6 class="mb-0">Update & Maintenance</h6>
        <p class="text-sm mb-0">Enable Update or Maintenance Mode</p>
        <hr class="horizontal dark my-3">
        <form action="/setting/update" method="POST">
            @csrf
            <input type="hidden" name="type" value="update">
        <div>
            <label for="categoryName" class="form-label">App Update & Maintenance Popup Show/Hide:-</label>
            <select class="form-control" name="up_status" id="choices-tag" placeholder="Select Status" required>
                <option value="" selected="">SELECT STATUS</option>
                <option value="true" {{($data[0]->up_status == 'true') ? 'selected' : ''}} >ON</option>
                <option value="false" {{($data[0]->up_status == 'false') ? 'selected' : ''}} >OFF</option>
            </select>
        </div>

        <hr class="horizontal dark my-2">
        <div>
            <label for="categoryName" class="form-label">Select Mode</label>
            <select class="form-control" name="up_mode" id="choices-tag1" placeholder="Select Mode" required>
                <option value="" selected="">SELECT Mode</option>
                <option value="0" {{($data[0]->up_mode == '0') ? 'selected' : ''}}>UPDATE POPUP</option>
                <option value="1" {{($data[0]->up_mode == '1') ? 'selected' : ''}}>Maintenance</option>
            </select>
        </div>
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">Android App Version Code</label>
        <input type="number" class="form-control" name="up_version" placeholder="1" value="{{$data[0]->up_version}}" required>

        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">App URL</label>
        <input type="text" class="form-control" name="up_link" placeholder="http" value="{{$data[0]->up_link}}">
      
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">Message</label>
        <div id="editor" >
         <textarea name="up_msg" class="form-control">{{$data[0]->up_msg}}</textarea>
        </div>

        <hr class="horizontal dark my-2">
        <div>
            <label for="categoryName" class="form-label">User Can Skip Update</label>
            <select class="form-control" name="up_btn" id="choices-tag2" placeholder="Select User Can Skip Update">
                <option value="" selected="">User Can Skip Update?</option>
                <option value="true"  {{($data[0]->up_btn == 'true') ? 'selected' : ''}}>YES</option>
                <option value="false"  {{($data[0]->up_btn == 'false') ? 'selected' : ''}}>NO</option>
            </select>
        </div>

        <div class="d-flex justify-content-end mt-4">
          <button type="submit" name="button" class="btn bg-gradient-info m-0 ms-2">Save Changes</button>
        </div>
      </div>
      </form>
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