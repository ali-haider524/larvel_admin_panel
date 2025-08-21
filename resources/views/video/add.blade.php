@extends('user_type.auth', ['parentFolder' => 'video', 'childFolder' => ''])

@section('content')
<div class="row">
    <div class="col-lg-9 col-12 mx-auto">
        <div class="card card-body mt-4">
            <h6 class="mb-0">Add Video</h6>
            <p class="text-sm mb-0">Fill Data</p>
            <form action="/videozone/create" method="POST">
            @csrf
            <hr class="horizontal dark my-3">
            <label for="projectName" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="projectName" placeholder="My Video" required>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Video URL</label>
            <input type="text" class="form-control" name="url" id="projectName" placeholder="https://www.youtube.com/watch?v=60ItHLz5WEA" required>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Video Timer in Second (User need to must watch video for this time to get Reward)</label>
            <input type="number" class="form-control" name="timer" id="projectName" placeholder="30" required>    

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Video Watch Coin (User Get After Complete task)</label>
            <input type="number" class="form-control" name="point" placeholder="5" required>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Count of Users, who will Watch Video (Note: 0 = unlimited)</label>
            <input type="number" class="form-control" name="task_limit" value="0" placeholder="0" required>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Video Available Country (For All Country just use = all)</label>
            <input type="text" class="form-control" name="country" placeholder="IN,US,all">

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ url('/videozone/active') }}" type="button" name="button" class="btn btn-light m-0">BACK TO LIST</a>
                <button type="submit" name="button" class="btn bg-gradient-info m-0 ms-2">Add Video</button>
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
</script>
@endpush