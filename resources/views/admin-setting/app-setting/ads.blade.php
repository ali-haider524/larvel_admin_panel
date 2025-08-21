@extends('user_type.auth', ['parentFolder' => 'admin-setting', 'childFolder' => 'app-setting'])

@section('content')
  <div class="row">
    <div class="col-lg-6">
      <h4>Manage Ads Setting</h4>
      <p></p>
    </div>
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
  </div>
    
    <div class="row">
        <div class="col-2"></div>
        <div class="col-sm-12 col-lg-6">
            <div class="card mt-4" id="daily">
                <form action="/setting/update" method="POST">
                @csrf
                <input type="hidden" name="type" value="ads">
                <div class="card-header">
                 <figure>
                        <blockquote class="blockquote">
                            <h6>
                                <p class="ps-2">For Every Task Complete Interstital Ads will be show</p>
                            </h6>
                            </blockquote>
                            <figcaption class="blockquote-footer ps-3">
                            Fill All Ads details, Enable Disable ads.
                            </figcaption>
                        </figure>   
                </div>
                <div class="card-body pt-0">
                      <label class="mt-3">STARTAPP APP ID :-</label>
                      <input class="form-control" type="text" name="startapp_appid" value="{{$data[0]->startapp_appid}}"/>
                      
                      <label class="mt-34">UNITY GAME ID :-</label>
                      <input class="form-control" type="text" name="unity_game" value="{{$data[0]->unity_game}}"/>
                      
                      <label class="mt-3">ADCLONY APP ID :-</label>
                      <input class="form-control" type="text" name="adcolonyApp"  value="{{$data[0]->adcolonyApp}}"/>
                      
                      <label class="mt-3">ADCLONY ZONE ID :-</label>
                      <input class="form-control" type="text" name="adcolony_zone"  value="{{$data[0]->adcolony_zone}}"/>
            </div>
            </div>
        </div>
        <div class="col-4"></div>
    </div>
              
  
  <div class="row mt-4">
    <div class="col-sm-4 row">  
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <h5 class="font-weight-bolder">Banner Ad</h5>
          <div>
            <label for="categoryName" class="form-label">Select Banner Ad Network Type</label>
            <select class="form-control" name="banner_type"  placeholder="SELECT ADNETWORK TYPE" Required>
                <option value="admob" {{($data[0]->banner_type=='admob') ? 'selected' : '' }}>ADMOB</option>
                <option value="fb" {{($data[0]->banner_type=='fb') ? 'selected' : '' }}>FACEBOOK AUDIENCE NETWORK</option>
                <option value="applovin" {{($data[0]->banner_type=='applovin') ? 'selected' : '' }}>APPLOVINN</option>
                <option value="startapp" {{($data[0]->banner_type=='startapp') ? 'selected' : '' }}>STARTAPP</option>
                <option value="off" {{($data[0]->banner_type=='off') ? 'selected' : '' }}>OFF</option>
            </select>
        </div>

          <label class="mt-4">Banner Adunit</label>
          <input class="form-control" type="text" name="bannerID" value="{{$data[0]->bannerID}}"/>
        
        </div>
      </div>
    </div>
     <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <h5 class="font-weight-bolder">On Back Press Interstital Ad</h5>
          <div>
            <label for="categoryName" class="form-label">Select Interstital Ad Network Type</label>
            <select class="form-control" name="interstital_type" placeholder="SELECT ADNETWORK TYPE" Required>
               <option value="admob" {{($data[0]->interstital_type=='admob') ? 'selected' : '' }}>ADMOB</option>
                <option value="fb" {{($data[0]->interstital_type=='fb') ? 'selected' : '' }}>FACEBOOK AUDIENCE NETWORK</option>
                <option value="applovin" {{($data[0]->interstital_type=='applovin') ? 'selected' : '' }}>APPLOVINN (Mediation with : Applovin Max,FB,Admob,Unity)</option>
                <option value="unity" {{($data[0]->interstital_type=='unity') ? 'selected' : '' }}>UNITY (Mediation with : Unity,FB)</option>
                <option value="startapp" {{($data[0]->interstital_type=='startapp') ? 'selected' : '' }}>STARTAPP</option>
                <option value="off" {{($data[0]->interstital_type=='off') ? 'selected' : '' }}>OFF</option>
            </select>
        </div>

          <label class="mt-4">ADS FREQUENCY</label>
          <input class="form-control" type="number"  name="interstitalCount" value="{{$data[0]->interstital_count}}"/>
        </div>
      </div>
    </div>
    </div>
    <!--Interstital Ads  -->
    <div class="col-sm-4">
      <div class="card">
        <div class="card-body">
          <h5 class="font-weight-bolder">Interstital Ad</h5>
          
          <div class="form-check">
          <input class="form-check-input" type="checkbox" id="fcustomCheck1" name="isAdmob" {{($inter[0]->isAdmob=='true') ? 'checked' : '' }}>
          <label class="custom-control-label" for="customCheck1">ADMOB ADUNIT</label>
          </div>
          <input class="form-control" type="text" name="au_admob" placeholder="ADMOB ADUNIT"  value="{{$inter[0]->au_admob}}" /> 
          
          <div class="form-check mt-3">
          <input class="form-check-input" type="checkbox" name="isApplovin"  {{($inter[0]->isApplovin=='true') ? 'checked' : '' }}>
          <label class="custom-control-label" for="customCheck1">APPLOVIN ADUNIT (Mediation with : Applovin Max,FB,Admob,Unity)</label>
          </div>          
          <input class="form-control" type="text" name="au_applovin" placeholder="Applovin Adunit "  value="{{$inter[0]->au_applovin}}" /> 
          
          <div class="form-check mt-3">
          <input class="form-check-input" type="checkbox"  name="isUnity" {{($inter[0]->isUnity=='true') ? 'checked' : '' }}>
          <label class="custom-control-label" for="customCheck1">UNITY ADUNIT (Mediation with : Unity,FB)</label>
          </div>
          <input class="form-control" type="text" name="au_unity" placeholder="Unity Adunit"  value="{{$inter[0]->au_unity}}"/> 
          
          <div class="form-check mt-3">
          <input class="form-check-input" type="checkbox"  name="isFb" {{($inter[0]->isFb=='true') ? 'checked' : '' }}>
          <label class="custom-control-label" for="customCheck1">AUDIENCE NETWORK ADUNIT</label>
          </div>
          <input class="form-control" type="text" name="au_fb" placeholder="AUDIENCE NETWORK ADUNIT"  value="{{$inter[0]->au_fb}}"/> 
          
          <div class="form-check mt-3">
          <input class="form-check-input" type="checkbox"  name="isStart" {{($inter[0]->isStart=='true') ? 'checked' : '' }}>
          <label class="custom-control-label" for="customCheck1">STARTAPP INTERSTITAL</label>
          </div>
          
          <div class="form-check mt-3">
          <input class="form-check-input" type="checkbox" id="fcustomCheck1" name="isAdcolony" {{($inter[0]->isAdcolony=='true') ? 'checked' : '' }}>
          <label class="custom-control-label" for="customCheck1">ADCOLONY INTERSTITAL</label>
          </div>
          <button type="submit" class="btn bg-gradient-info mt-3">Save Changes</button>

        </div>
      </div>
    </div>

       <!--Native Ads  -->
    <div class="col-sm-4">
      <div class="card">
        <div class="card-body">
          <h5 class="font-weight-bolder">Native Ad</h5>
          <div>
            <label for="categoryName" class="form-label">Select Native Ad Network Type</label>
            <select class="form-control" name="native_type" placeholder="SELECT ADNETWORK TYPE" >
                <option value="admob" {{($data[0]->nativeType=='admob') ? 'selected' : '' }}>ADMOB</option>
                <option value="fb" {{($data[0]->nativeType=='fb') ? 'selected' : '' }}>FACEBOOK AUDIENCE NETWORK</option>
                <option value="applovin" {{($data[0]->nativeType=='applovin') ? 'selected' : '' }}>APPLOVINN</option>
                <option value="off" {{($data[0]->nativeType=='off') ? 'selected' : '' }}>OFF</option>
            </select>
        </div>

          <label class="mt-4 text-dark">Native Adunit ( Not Required for Startapp ):- </label>
          <input class="form-control" type="text" name="nativeID" value="{{$data[0]->nativeID}}"/>

          <label class="mt-4">Native Ads After How Many Item :-</label>
          <input class="form-control" type="number" name="nativeCount" value="{{$data[0]->native_count}}" />
          
</form>
        </div>
      </div>
    </div>
    
  </div>
  </div>
@endsection
  
@push('js')
  <script src="{{ URL::asset('assets/js/plugins/choices.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/plugins/quill.min.js') }}"></script>
  <script>

    if (document.getElementById('choices-tag1')) {
      var tag = document.getElementById('choices-tag1');
      const example = new Choices(tag);
    }
    
     if (document.getElementById('choices-tag2')) {
      var tag = document.getElementById('choices-tag2');
      const example = new Choices(tag);
    }

  
   if (document.getElementById('choices-tag3')) {
      var tag = document.getElementById('choices-tag3');
      const example = new Choices(tag);
    }
  </script>
@endpush