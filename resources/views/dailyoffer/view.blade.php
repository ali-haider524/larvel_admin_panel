@extends('user_type.auth', ['parentFolder' => 'dailyoffer', 'childFolder' => ''])

@section('content')
<div class="row">
    <div class="col-lg-9 col-12 mx-auto">
        <div class="card card-body mt-4">
            <h6 class="mb-0">View Daily Offer</h6>
            <p class="text-sm mb-0">Fill Data</p>

        
            <hr class="horizontal dark my-3">
            <label for="projectName" class="form-label">Offer Name</label>
            <input type="text" class="form-control" name="title" value="{{$data[0]->title}}" placeholder="Complete this offer" readonly>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Offer Image URL (Optional)</label>
            <input type="text" class="form-control" name="image"  value="{{$data[0]->image}}" placeholder="Http://" readonly>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Offer URL</label>
            <input type="text" class="form-control" name="link" value="{{$data[0]->link}}" placeholder="Http://" readonly>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Install Coin (User Get After Complete task)</label>
            <input type="number" class="form-control" name="coin" value="{{$data[0]->coin}}" placeholder="5" readonly>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Count of Users, who will Complete Offer (Note: 0 = unlimited)</label>
            <input type="text" class="form-control" name="task_limit" value="{{$data[0]->task_limit}}" placeholder="0" readonly>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Available in Country (Note: all = Available in Country)</label>
            <input type="text" class="form-control" name="country" value="{{$data[0]->country}}" placeholder="all or IN,CS" readonly>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Offers Instruction</label>
            <textarea class="ckeditor form-control" name="details" required readonly>{{$data[0]->description}}</textarea>

        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ URL::asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
    if (document.getElementById('editor')) {
        var quill = new Quill('#editor', {
            theme: 'snow' // Specify theme in configuration
        });
    }

    if (document.getElementById('choices-tag')) {
        var tag = document.getElementById('choices-tag');
        const example = new Choices(tag);
    }
</script>
@endpush