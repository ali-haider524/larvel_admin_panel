@extends('user_type.auth', ['parentFolder' => 'admin-setting', 'childFolder' => 'alias'])

@section('content')
<main class="main-content mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-9 mx-auto">
                <div class="card card-body mt-4">
                    <h6 class="mb-0">Update Alias</h6>
                    <p class="text-sm mb-0">Fill Detail</p>
                    <hr class="horizontal dark my-3">
                    <form action="/alias/update" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$data->id}}"/>
                        <div>
                            <label for="categoryName" class="form-label">Alias Tag</label>
                            <select class="form-control" name="tag" id="choices-tag" placeholder="Select Tag" disabled>
                                <option value="" selected="">Select Tag</option>
                                <option value="account_ban" {{ ($data->tag == 'account_ban' ) ? 'selected' : '' }}>BAN ACCOUNT</option>
                                <option value="account_unban" {{ ($data->tag == 'account_unban' ) ? 'selected' : '' }}>UNBAN ACCOUNT</option>
                                <option value="auto_ban_vpn" {{ ($data->tag == 'auto_ban_vpn' ) ? 'selected' : '' }}>ACCOUNT AUTO BAN VPN</option>
                                <option value="auto_ban_adblock" {{ ($data->tag == 'auto_ban_adblock' ) ? 'selected' : '' }}>ACCOUNT AUTO BAN ADBLOCK</option>
                                <option value="withdrawal_approve_default" {{ ($data->tag == 'withdrawal_approve_default' ) ? 'selected' : '' }}>WITHDRAWAL APPROVE (DEFAULT)</option>
                                <option value="withdrawal_approve" {{ ($data->tag == 'withdrawal_approve' ) ? 'selected' : '' }}>WITHDRAWAL APPROVE</option>
                                <option value="withdrawal_reject_default" {{ ($data->tag == 'withdrawal_reject_default' ) ? 'selected' : '' }}>WITHDRAWAL REJECT (DEFAULT)</option>
                                <option value="withdrawal_reject" {{ ($data->tag == 'withdrawal_reject' ) ? 'selected' : '' }}>WITHDRAWAL REJECT</option>
                                <option value="add_bonus" {{ ($data->tag == 'add_bonus' ) ? 'selected' : '' }} >ADD COIN</option>
                              
                            </select>
                        </div>
                        <div>
                            <label class="mt-4">Alias Description</label>
                            <div class="">
                                <textarea type="text" class="form-control" name="description" id="categoryDescription">{{$data->description}}</textarea>
                                @error('description')
                                    <p class="text-danger text-xs mt-2 mb-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ url('alias-management') }}" type="button" name="button" class="btn btn-light m-0">BACK TO LIST</a>
                            <button type="submit" name="button" class="btn bg-gradient-dark m-0 ms-2">SUBMIT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection