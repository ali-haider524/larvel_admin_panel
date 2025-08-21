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
        <h6 class="mb-0">Server Configuration</h6>
        <p class="text-sm mb-0">App Configuration</p>
        <form action="/setting/update" method="POST">
        @csrf
        <input  type="hidden" name="type" value="server">
        <hr class="horizontal dark my-2"> 
        <label for="projectName" class="form-label">API URL <a href="https://create-api.techappinnovation.com/" class="text-info" target="_blank">[ Click here to Generate Your API URL ]</a></label>

        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">ADMIN PANEL DEBUG MODE</label>
        <select name="APP_DEBUG"  class="form-control" >
            <option value="local" {{(env('APP_ENV') == 'local') ? 'selected' : '' }}>DEBUG</option>
            <option value="production" {{(env('APP_ENV') == 'production') ? 'selected' : '' }}>PRODUCTION</option>
        </select>
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">API KEY</label>
        <input type="text" class="form-control" name="API_KEY" value="{{env('API_KEY')}}">
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">APP URL</label>
        <input type="text" class="form-control" name="APP_URL" value="{{env('APP_URL')}}">
        
         <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">CUSTOM OFFER SECRET</label>
        <input type="text" class="form-control" name="CUSTOM_OFFER_SECRET" value="{{ env('CUSTOM_OFFER_SECRET')}}">
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">CRON JOB SECRET</label>
        <input type="text" class="form-control" name="CRON_SECRET" value="{{ env('CRON_SECRET')}}">

        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">HOW MUCH COIN IS 1 USD ? ( this is only for offerwall if offerwall managed by backend then conversation will be this)</label>
        <input type="number" class="form-control" name="COIN_TO_USD" value="{{ env('COIN_TO_USD')}}">
        
        <div class="d-flex justify-content-end mt-4">
          <button type="submit" name="button" class="btn bg-gradient-info m-0 ms-2">Save Changes</button>
          </form>
        </div>
      </div>
    </div>

    
    <div class="col-lg-9 col-12 mx-auto">
      <div class="card card-body mt-4">
        <h6 class="mb-0">One Signal Configuration</h6>
        <p class="text-sm mb-0"></p>
        <form action="/setting/update" method="POST">
        @csrf
        <input type="hidden" name="type" value="notification">
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">ONESIGNAL APP ID</label>
        <input type="text" class="form-control" name="ONESIGNAL_APP_ID" value="{{ env('ONESIGNAL_APP_ID')}}">
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">ONESIGNAL REST API KEY</label>
        <input type="text" class="form-control" name="ONESIGNAL_REST_API_KEY" value="{{ env('ONESIGNAL_REST_API_KEY')}}">
    
         <div class="d-flex justify-content-end mt-4">
          <button type="submit" name="button" class="btn bg-gradient-info m-0 ms-2">Save Changes</button>
          </form>
        </div>
      </div>
    </div>
    
    <div class="col-lg-9 col-12 mx-auto">
      <div class="card card-body mt-4">
        <h6 class="mb-0">SMTP Configuration</h6>
        <p class="text-sm mb-0"></p>
        <form action="/setting/update" method="POST">
        @csrf
        <input type="hidden" name="type" value="smtp">
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">MAIL MAILER </label>
        <input type="text" class="form-control" name="MAIL_MAILER" placeholder="smtp" value="{{ env('MAIL_MAILER')}}">
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">MAIL HOST </label>
        <input type="text" class="form-control" name="MAIL_HOST" placeholder="smtp.gmail.com" value="{{ env('MAIL_HOST')}}">
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">MAIL PORT </label>
        <input type="number" class="form-control" name="MAIL_PORT" placeholder="465"  value="{{ env('MAIL_PORT')}}">
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">MAIL USERNAME </label>
        <input type="text" class="form-control" name="MAIL_USERNAME" placeholder="****"  value="{{ env('MAIL_USERNAME')}}">
        
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">MAIL PASSWORD </label>
        <input type="password" class="form-control" name="MAIL_PASSWORD" placeholder="" value="{{ env('MAIL_PASSWORD')}}">
        
        <hr class="horizontal dark my-2">
        <label for="projectName" class="form-label">Encryption Mode</label>
        <select name="MAIL_ENCRYPTION"  class="form-control" >
            <option name="ssl" {{(env('MAIL_ENCRYPTION')=='ssl') ? 'selected' : '' }}>SSL</option>
            <option name="tls" {{(env('MAIL_ENCRYPTION')=='tls') ? 'selected' : '' }}>TLS</option>
        </select>

        <div class="d-flex justify-content-end mt-4">
          <button type="submit" name="submit" class="btn bg-gradient-info m-0 ms-2">Save Changes</button>
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