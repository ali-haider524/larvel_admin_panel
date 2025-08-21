@extends('user_type.auth', ['parentFolder' => 'web', 'childFolder' => ''])

@section('content')
<main class="main-content mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-9 mx-auto">
                <div class="card card-body mt-4">
                    <h6 class="mb-0">New Campaign</h6>
                    <p class="text-sm mb-0">Create New Article Task</p>
                    <hr class="horizontal dark my-3">
                    <form action="/article/store" method="POST">
                        @csrf
                        <div>
                            <label for="categoryName" class="form-label">Title</label>
                            <div class="">
                                <input type="text" class="form-control " value="{{ old('title') }}"  placeholder="How to" name="title" onfocus="focused(this)" onfocusout="defocused(this)" required>
                                @error('name')
                                    <p class="text-danger text-xs mt-2 mb-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="categoryName" class="form-label">Article Link</label>
                            <div class="">
                                <input type="text" class="form-control "  placeholder="http" name="url" onfocus="focused(this)" onfocusout="defocused(this)" required>
                                @error('name')
                                    <p class="text-danger text-xs mt-2 mb-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="categoryName" class="form-label">Time in Second</label>
                            <div class="">
                                <input type="number" class="form-control " value="{{ old('timer') }}" placeholder="1" name="timer" onfocus="focused(this)" onfocusout="defocused(this)" required>
                                @error('name')
                                    <p class="text-danger text-xs mt-2 mb-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="categoryName" class="form-label">Coin</label>
                            <div class="">
                                <input type="number" class="form-control " placeholder="5" name="point" onfocus="focused(this)" onfocusout="defocused(this)" required>
                                @error('name')
                                    <p class="text-danger text-xs mt-2 mb-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="categoryName" class="form-label">Count of Users, who will Visit Website (Note: 0 = unlimited)</label>
                            <div class="">
                                <input type="number" class="form-control " value="0" placeholder="0" name="task_limit" onfocus="focused(this)" onfocusout="defocused(this)" required>
                                @error('name')
                                    <p class="text-danger text-xs mt-2 mb-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="categoryName" class="form-label">Article Available in Country (For All Country just use = all)</label>
                            <div class="">
                                <input type="text" class="form-control " value="all" placeholder="IN,US" name="country" onfocus="focused(this)" onfocusout="defocused(this)" required>
                                @error('name')
                                    <p class="text-danger text-xs mt-2 mb-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ url('/article/active') }}" type="button" name="button" class="btn btn-light m-0">BACK TO LIST</a>
                            <button type="submit" name="button" class="btn bg-gradient-primary m-0 ms-2">Create  Article</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection