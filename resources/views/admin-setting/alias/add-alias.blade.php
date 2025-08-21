@extends('user_type.auth', ['parentFolder' => 'admin-setting', 'childFolder' => 'alias'])

@section('content')
<main class="main-content mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-9 mx-auto">
                <div class="card card-body mt-4">
                    <h6 class="mb-0">Alias</h6>
                    <p class="text-sm mb-0">Create new Alias</p>
                    <hr class="horizontal dark my-3">
                    <form action="/alias/store" method="POST">
                        @csrf
                        <div>
                            <label for="categoryName" class="form-label">Alias Tag</label>
                            <select class="form-control" name="tag" id="choices-tag" placeholder="Select Tag">
                                <option value="" selected="">Select Tag</option>
                                <option value="account_ban">BAN ACCOUNT</option>
                                <option value="account_unban">UNBAN ACCOUNT</option>
                                <option value="withdrawal_approve">WITHDRAWAL APPROVE</option>
                                <option value="withdrawal_reject">WITHDRAWAL REJECT</option>
                                <!--<option value="add_bonus">ADD COIN</option>-->
                            </select>
                        </div>
                        <div>
                            <label class="mt-4">Alias Description</label>
                            <div class="">
                                <textarea type="text" class="form-control  " name="description" id="categoryDescription">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-danger text-xs mt-2 mb-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ url('/alias-management') }}" type="button" name="button" class="btn btn-light m-0">BACK TO LIST</a>
                            <button type="submit" name="button" class="btn bg-gradient-dark m-0 ms-2">CREATE ALIAS</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
@push('js')
<script src="{{ URL::asset('assets/js/plugins/choices.min.js') }}"></script>
<script>
    if (document.getElementById('choices-tag')) {
      var tag = document.getElementById('choices-tag');
      const example = new Choices(tag);
    }

</script>
@endPush