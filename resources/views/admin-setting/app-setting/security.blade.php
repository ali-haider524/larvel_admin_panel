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
            <h6 class="mb-0">Fraud & Prevention</h6>
            <p class="text-sm mb-0">Enable Update or Maintenance Mode</p>
            <hr class="horizontal dark my-3">
            <form action="/setting/update"  method="POST" >
             @csrf
             <input type="hidden" name="type" value="security">

                <br>
                <div class="col-6 card shadow-none border h-100">
                    <div class="row">
                        <div class="col-sm-1 m-2" style="width:60px;">
                            <span class="my-2 text-xs">
                                <img src="{{URL::asset('assets/img/vpn.png')}}" class="avatar avatar-ssl shadow">
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <figure>
                                <blockquote class="blockquote">
                                    <h6>
                                        <p class="ps-2">
                                        <div class="form-check" style="margin-left:5px;"><input class="form-check-input"
                                                type="checkbox" id="fcustomCheck1" checked disabled>
                                            Block Vpn Access </p>
                                        </div>
                                    </h6>
                                </blockquote>
                                <figcaption class="blockquote-footer ps-3">
                                    User Cannot Access App with Vpn.</figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
                
                <div class="col-6 card shadow-none border h-100">
                    <div class="row">
                        <div class="col-sm-1 m-2" style="width:60px;">
                            <span class="my-2 text-xs">
                                <img src="{{URL::asset('assets/img/app_clon.png')}}" class="avatar avatar-ssl shadow">
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <figure>
                                <blockquote class="blockquote">
                                    <h6>
                                        <p class="ps-2">
                                        <div class="form-check" style="margin-left:5px;"><input class="form-check-input"
                                                type="checkbox" id="fcustomCheck1" checked disabled>
                                            App Cloning </p>
                                        </div>
                                    </h6>
                                </blockquote>
                                <figcaption class="blockquote-footer ps-3">
                                    User Cannot Work on Clonning App.</figcaption>
                            </figure>
                        </div>
                    </div>
                </div>


                <div class="col-6 card shadow-none border h-100 mt-2">
                    <div class="row">
                        <div class="col-sm-1 m-2" style="width:60px;">
                            <span class="my-2 text-xs">
                                <img src="{{URL::asset('assets/img/onedevice.png')}}" class="avatar avatar-ssl shadow">
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <figure>
                                <blockquote class="blockquote">
                                    <h6>
                                        <p class="ps-2">
                                        <div class="form-check" style="margin-left:5px;"><input class="form-check-input"
                                                type="checkbox" id="fcustomCheck1" name="SEC_ONE_DEVICE" {{(env('SEC_ONE_DEVICE')==0) ? 'checked' : ''}} >
                                            One Device One Account </p>
                                        </div>
                                    </h6>
                                </blockquote>
                                <figcaption class="blockquote-footer ps-3">
                                    User Can Create Only One Account in one device.</figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="col-6 card shadow-none border h-100 mt-2">
                    <div class="row">
                        <div class="col-sm-1 m-2" style="width:60px;">
                            <span class="my-2 text-xs">
                                <img src="{{URL::asset('assets/img/blockroot.png')}}" class="avatar avatar-ssl shadow">
                            </span>
                        </div>
                        <div class="col-sm-8">
                            <figure>
                                <blockquote class="blockquote">
                                    <h6>
                                        <p class="ps-2">
                                        <div class="form-check" style="margin-left:5px;"><input class="form-check-input"
                                                type="checkbox" id="fcustomCheck1" name="SEC_BLOCK_ROOT" {{(env('SEC_BLOCK_ROOT')==0) ? 'checked' : ''}} >
                                            Block Rooted Devices </p>
                                        </div>
                                    </h6>
                                </blockquote>
                                <figcaption class="blockquote-footer ps-3">
                                    App will not work on Rooted device if this option is activated.</figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
                <!--<div class="col-6 card shadow-none border h-100 mt-2">-->
                <!--    <div class="row">-->
                <!--        <div class="col-sm-1 m-2" style="width:60px;">-->
                <!--            <span class="my-2 text-xs">-->
                <!--                <img src="{{URL::asset('assets/img/ads.png')}}" class="avatar avatar-ssl shadow">-->
                <!--            </span>-->
                <!--        </div>-->
                <!--        <div class="col-sm-6">-->
                <!--            <figure>-->
                <!--                <blockquote class="blockquote">-->
                <!--                    <h6>-->
                <!--                        <p class="ps-2">-->
                <!--                        <div class="form-check" style="margin-left:5px;"><input class="form-check-input"-->
                <!--                                type="checkbox" id="fcustomCheck1" checked >-->
                <!--                            Auto Ban for Adblocker Detection</p>-->
                <!--                        </div>-->
                <!--                    </h6>-->
                <!--                </blockquote>-->
                <!--                <figcaption class="blockquote-footer ps-3">-->
                <!--                   Auto Ban User who attemps to use Adblocker.</figcaption>-->
                <!--            </figure>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <div class="col-6 card shadow-none border h-100 mt-2">
                    <div class="row">
                        <div class="col-sm-1 m-2" style="width:60px;">
                            <span class="my-2 text-xs">
                                <img src="{{URL::asset('assets/img/blockroot.png')}}" class="avatar avatar-ssl shadow">
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <figure>
                                <blockquote class="blockquote">
                                    <h6>
                                        <p class="ps-2">
                                        <div class="form-check" style="margin-left:5px;"><input class="form-check-input"
                                                type="checkbox" id="fcustomCheck1" name="SEC_AUTOBAN_ROOT" {{(env('SEC_AUTOBAN_ROOT')==0) ? 'checked' : ''}} >
                                            Auto Ban Rooted Device </p>
                                        </div>
                                    </h6>
                                </blockquote>
                                <figcaption class="blockquote-footer ps-3">
                                    Auto ban account who used in rooted device..</figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
               
            <p style="margin-top:5px; margin-left:10px">More function will be added on future Update..</p>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" name="submit" class="btn bg-gradient-info float-left">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ URL::asset('assets/js/plugins/choices.min.js') }}"></script>



@endpush