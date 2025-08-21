@extends('user_type.auth', ['parentFolder' => 'offerwall', 'childFolder' => 'none'])

@section('content')
<main class="main-content mt-1 border-radius-lg">
    <div class="container my-3 py-3 d-flex flex-column">
        <div class="row mb-5 justify-content-center align-items-center">
            <div class="col-lg-9 col-12 mx-auto">
                
                <!-- Card Basic Info -->
                <div class="card mt-4" id="basic-info">
                    <div class="card-header">
                        <h5>Web Offerwall Configuration</h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="/offerwall/web/create" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="form-label mt-4">Offerwall Name</label>
                                    <div class="input-group">
                                        <input class="form-control" name="title" type="text"  placeholder="Cpalead" required>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <label class="form-label mt-4">Offerwall Slug ( Fill Offerwall Original Name like tapjoy,cpalead)</label>
                                    <div class="input-group">
                                        <input class="form-control"  name="offer_slug" type="text" placeholder="Cpalead,Offerwall" required>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <label class="form-label mt-4">Offerwall Icon</label>
                                    <div class="input-group">
                                        <input class="form-control" name="icon" type="file" required>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <label class="form-label mt-4">Offerwall Description</label>
                                    <div class="input-group">
                                        <input class="form-control"  name="description"  type="text" placeholder="Best Offers etc" required>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <label class="form-label mt-4">Offerwall URL </label>
                                    <div class="input-group">
                                        <input class="form-control"  name="offerwall_url" type="text"  placeholder="https://fastrsrvr.com/list/452511" required>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <label class="form-label mt-4">Header (if any)</label>
                                    <div class="input-group">
                                        <input class="form-control"  name="header" type="text" placeholder="Authorization: Bearer">
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-4">
                                    <label for="categoryName" class="form-label">Exchange Rate Managed By ?</label>
                                    <select class="form-control" name="tag" id="choices-tag" placeholder="Select Tag" required>
                                        <option value="0">AD NETWORK</option>
                                        <option value="1">BACKEND</option>
                                    </select>
                                </div>
                    </div>
                    </div>
                </div>

                <div class="card mt-4" id="basic-info">
                    <div class="card-header">
                        <h5>Postback Configuration</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-4 col-lg-4">
                                <label class="form-label mt-4">Paramater for <label class="text-info text-sm">USER ID</label></label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="userid"  required>
                                </div>
                            </div>

                            <div class="col-sm-4 col-lg-4">
                                <label class="form-label mt-4">Paramater for <label class="text-info text-sm">OFFER ID</label></label>
                                <div class="input-group">
                                    <input class="form-control" type="text"  name="offerid"  >
                                </div>
                            </div>
                            
                            <div class="col-sm-4 col-lg-4">
                                <label class="form-label mt-4">Paramater for <label class="text-info text-sm">OFFER NAME</label></label>
                                <div class="input-group">
                                    <input class="form-control" type="text"  name="p_offername"  >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                             <div class="col-sm-4 col-lg-4">
                                <label class="form-label mt-4">Paramater for <label class="text-info text-sm">Reward Amount</label></label>
                                <div class="input-group">
                                    <input class="form-control"  type="text" name="amount"  required>
                                </div>
                            </div>
                            
                            <div class="col-sm-4 col-lg-4">
                                <label class="form-label mt-4">Paramater for <label class="text-info text-sm">IP ADDRESS</label></label>
                                <div class="input-group">
                                    <input class="form-control" type="text"  name="ip" >
                                </div>
                            </div>
                            
                             <div class="col-sm-4 col-lg-4">
                                <label class="form-label mt-4">PostBack Return <label class="text-info text-sm">RESPONSE CODE</label></label>
                                <div class="input-group">
                                    <input class="form-control" type="text"  name="response_code" value="201">
                                </div>
                            </div>

                        </div>

                        <div class="">
                            <button type="submit" class="btn bg-gradient-dark btn-sm float-end mt-6 mb-0">ADD</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('js')
<script src="{{ URL::asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    // $("#file-input").change(function(){
    //     readURL(this);
    // });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#alert-success").delay(3000).slideUp(300);
        $("#conv").hide();

    });

    if (document.getElementById('choices-tag')) {
        var tag = document.getElementById('choices-tag');
        const example = new Choices(tag);
    }

    $('#choices-tag').change(function() {
        var optVal = $("#choices-tag option:selected").val();
        if (optVal == 1) {
            $('#conv').show();
        } else {
            $('#conv').hide();
        }
    });
</script>
@endpush