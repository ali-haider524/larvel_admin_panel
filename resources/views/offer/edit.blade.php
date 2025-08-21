@extends('user_type.auth', ['parentFolder' => 'offer', 'childFolder' => ''])

@section('content')
<div class="row">
    <div class="col-lg-9 col-12 mx-auto">
        <div class="card card-body mt-4">
            <h6 class="mb-0">Update App Offer</h6>
            <p class="text-sm mb-0">Fill Data</p>
            <hr class="horizontal dark my-3">

            <form action="/offers/update" method="POST">
            @csrf    
            <input type="hidden" name="id" value="{{$data->id}}">

            <label for="projectName" class="form-label">App Name</label>
            <input type="text" class="form-control" name="app_name" value="{{$data->app_name}}" id="projectName" placeholder="My App" required>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">App Icon URL</label>
            <input type="text" class="form-control" name="image" value="{{$data->image}}" id="projectName" placeholder="Http://" required>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">App URL</label>
            <input type="text" class="form-control" name="appurl" value="{{$data->appurl}}"  placeholder="Http://" required>

            <div class="row">
                <div class="col-sm-12 col-lg-4">
                    <hr class="horizontal dark my-2">
                    <label for="projectName" class="form-label">Paramater for <small class="text-info text-sm">USER ID</small></label>
                    <input type="text" class="form-control" name="p_userid" placeholder="subid=" value="{{$data->p_userid}}" required>
                </div>
                
                <div class="col-sm-12 col-lg-4">
                    <hr class="horizontal dark my-2">
                    <label for="projectName" class="form-label">Postback Parameter <small class="text-info text-sm">App ID </small></label>
                    <select class="form-control" name="appID" required>
                        <option value="0" {{($data->appID =="0") ? 'selected' : ''}}>subid2={subid2}</option>
                        <option value="1" {{($data->appID =="1") ? 'selected' : ''}}>offerid={offerid}</option>
                        <option value="2" {{($data->appID =="2") ? 'selected' : ''}}>appid={appid}</option>
                    </select>
                </div>
                
                <div class="col-sm-12 col-lg-4">
                    <hr class="horizontal dark my-2">
                    <label for="projectName" class="form-label">Postback <small class="text-info text-sm">Response Code</small></label>
                    <input type="text" class="form-control" name="response_code" placeholder="201" value="{{$data->response_code}}" required>
                </div>
            
            </div>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Install Coin (User Get After Complete task)</label>
            <input type="number" class="form-control" name="points" value="{{$data->points}}" placeholder="5" required>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Count of Users, who will Install Apps (Note: 0 = unlimited)</label>
            <input type="text" class="form-control" name="task_limit" value="{{$data->task_limit}}" value="0" placeholder="0">

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Available in Country (Note: all = Available in Country)</label>
            <input type="text" class="form-control" name="country" value="{{$data->country}}" placeholder="all or IN,CS" required>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">App Instruction</label>
            <textarea class="ckeditor form-control" name="details" required>{{$data->details}}</textarea>


            <div class="d-flex justify-content-end mt-4">
                <a href="{{ url('/offers/active') }}" type="button" name="button" class="btn btn-light m-0">BACK TO LIST</a>
                <button type="submit" name="button" class="btn bg-gradient-info m-0 ms-2">Update Offer</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ URL::asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>


    if (document.getElementById('choices-tag')) {
      var tag = document.getElementById('choices-tag');
      const example = new Choices(tag);
    }

    quill.on('text-change', function(delta, oldDelta, source) {
        document.getElementById("quill_html").value = quill.root.innerHTML;
    });
</script>
@endpush