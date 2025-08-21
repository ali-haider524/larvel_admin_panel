@extends('user_type.auth', ['parentFolder' => 'withdrawal', 'childFolder' => ''])

@section('content')
<div class="row">
    <div class="col-lg-9 col-12 mx-auto">
        <div class="card card-body mt-4">
            <h6 class="mb-0">Update Withdraw Method</h6>
            <p class="text-sm mb-0">Fill Data</p>

            <form action="/withdrawal/method/update" method="POST">
            @csrf
            <input type="hidden" name="category" value="{{$data[0]->category}}">
            <input type="hidden" name="id" value="{{$data[0]->id}}">
            
            <hr class="horizontal dark my-3">
            <label for="projectName" class="form-label">Redeem Title</label> 
            <input type="text" class="form-control" name="title"  value="{{$data[0]->title}}" placeholder="Gift Card $5" required>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Coin Required for Redeem</label>
            <input type="number" class="form-control" name="points" value="{{$data[0]->points}}" placeholder="1000" required>
            
            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Input Type</label>
            <select class="form-control" name="input_type" id="choices-tag" placeholder="Input Type" required>
                <option value="text" {{ ($data[0]->input_type=='text') ? 'selected' : ''  }} >TEXT</option>
                <option value="number" {{ ($data[0]->input_type=='number') ? 'selected' : ''  }}>NUMBER</option>
                <option value="email" {{ ($data[0]->input_type=='email') ? 'selected' : ''  }}>EMAIL</option>
            </select>     
             
            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Text Placeholder</label>
            <input type="text" class="form-control" name="placeholder"  value="{{$data[0]->placeholder}}" placeholder="Enter Email" required>

            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Referral Required for Redeem (0= not Required)</label>
            <input type="number" class="form-control" name="refer" value="{{$data[0]->refer}}"  required>
            
            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Redeem Quantity</label>
            <input type="number" class="form-control" name="quantity" value="{{$data[0]->quantity}}"  placeholder="20" required>

           
            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Task Complete Required (Note: Before Redeem user need to complete selected All Task)</label>
            <select class="form-control" name="task" id="choices-tag2" placeholder="Task Complete Required" REQUIRED>
                <option value="0" {{ ($data[0]->task==0) ? 'selected' : ''  }} >NO TASK REQUIRED</option>
                <option value="1" {{ ($data[0]->task==1) ? 'selected' : ''  }}>COMPLETE SPIN, SCRATCH TO UNLOCK</option>
                <option value="2" {{ ($data[0]->task==2) ? 'selected' : ''  }}>COMPLETE SPIN, SCRATCH, MATH QUIZ TO UNLOCK</option>
                <option value="3" {{ ($data[0]->task==3) ? 'selected' : ''  }}>COMPLETE SPIN, SCRATCH, READ ARTICLE TO UNLOCK</option>
                <option value="4" {{ ($data[0]->task==4) ? 'selected' : ''  }}>COMPLETE SPIN, SCRATCH, READ ARTICLE, VIDEOZONE TO UNLOCK</option>
            </select> 
                  
            
            <hr class="horizontal dark my-2">
            <label for="projectName" class="form-label">Available in Country (Note: all = Available in Country)</label>
            <input type="text" class="form-control" name="country"  value="{{$data[0]->country}}" placeholder="all or IN,CS">
            

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ url('/withdrawal') }}" type="button" name="button" class="btn btn-light m-0">BACK TO LIST</a>
                <button type="submit" name="button" class="btn bg-gradient-info m-0 ms-2">Save Changes </button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ URL::asset('assets/js/plugins/choices.min.js') }}"></script>
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
    
    if (document.getElementById('choices-tag2')) {
        var tag = document.getElementById('choices-tag2');
        const example = new Choices(tag);
    }
</script>
@endpush