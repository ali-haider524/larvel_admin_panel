@extends('user_type.auth', ['parentFolder' => 'laravel', 'childFolder' => 'category'])

@section('content')
<main class="main-content mt-1 border-radius-lg">
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
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-9 mx-auto">
                <div class="card card-body mt-4">
                    <h6 class="mb-0">Push Notification</h6>
                    <p class="text-sm mb-0">Send Push Notification to All User</p>
                    <hr class="horizontal dark my-3">
                    <form action="/push-notification/send" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="categoryName" class="form-label">Title</label>
                            <div class="">
                                <input type="text" class="form-control " value="{{ old('title') }}" id="categoryName" name="title" onfocus="focused(this)" onfocusout="defocused(this)">
                                @error('name')
                                    <p class="text-danger text-xs mt-2 mb-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label class="mt-4">Message</label>
                            <div class="">
                                <textarea type="text" class="form-control  " name="description" id="categoryDescription">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-danger text-xs mt-2 mb-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="categoryName" class="form-label mt-4">URL (Optional)</label>
                            <div class="">
                                <input type="text" class="form-control " value="{{ old('url') }}" placeholder="http" name="url" onfocus="focused(this)" onfocusout="defocused(this)">
                                @error('name')
                                    <p class="text-danger text-xs mt-2 mb-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="categoryName" class="form-label mt-4">IMAGE (Optional)</label>
                            <div class="">
                                <input type="file" class="form-control " value="{{ old('image') }}" name="image" onfocus="focused(this)" onfocusout="defocused(this)">
                                @error('name')
                                    <p class="text-danger text-xs mt-2 mb-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ url('dashboard') }}" type="button" name="button" class="btn btn-light m-0">BACK TO Dashboard</a>
                            <button type="submit" name="button" class="btn bg-gradient-info m-0 ms-2">SEND NOTIFICATION</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection