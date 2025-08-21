@extends('user_type.auth', ['parentFolder' => 'pages', 'childFolder' => ''])

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Faq</h5>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
          <div class="ms-auto my-auto">
                <a href="#" class="btn bg-gradient-info btn-sm mb-0 addFaq">+&nbsp; ADD NEW</a>
              </div>
          </div>
        </div>
      </div>
      <div class="card-body px-0 pb-0">
        <div class="table-responsive">
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
          <table class="table table-flush" id="data-list">
            <thead class="thead-light">
              <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Question</th>
                <th>Answer</th>
                <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
              @if(count($data) > 0)
              @foreach($data as $item)
              <tr id="{{$item->id}}">
                <td class="text-sm">
                  <div class="form-check my-auto">
                  {{$item->id}}
                  </div>
                </td>
                <td class="text-sm">{{$item->type}}</td>
                <td class="text-sm">{{ \Illuminate\Support\Str::limit(strip_tags($item->question), 30, $end='...')}}</td>
                <td class="text-sm">{{ \Illuminate\Support\Str::limit(strip_tags($item->answer), 30, $end='...')}}</td>
                <td class="text-sm">{!!date('d-M-y H:i:s',strtotime($item->created_at))!!}</td>
                <td class="text-sm">
                  <a href="#" class="mx-3 editFaq" id="{{$item->id}}" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                    <i class="fas fa-edit text-success"></i>
                  </a>
                  <a href="#"  data-id="faq"  id="{{$item->id}}"  class="mx-3 delete" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                    <i class="fas fa-trash text-danger"></i>
                  </a>
                </td>
              </tr>
              @endforeach
              @else
              <tr>no content </tr>
              @endif
            </tbody>
          </table>

          {{$data->links('components.paginate')}}
        </div>
      </div>
    </div>
  </div>
</div>

@include('modal')
@endsection
@push('js')
<script src="{{ URL::asset('assets/js/plugins/datatables.js') }}"></script>
<script src="../../assets/js/plugins/sweetalert.min.js"></script>
<script src="../../assets/js/plugins/action.js"></script>
<script>
  if (document.getElementById('data-list')) {
    const dataTableSearch = new simpleDatatables.DataTable("#data-list", {
      searchable: true,
      fixedHeight: true,
      perPage: 15,
      labels: {
        placeholder: "Search...",
        perPage: "Show {select} entries",
        noRows: "No entries found",
        info: "Showing {{ $data->firstItem() }} to {{$data->lastItem()}} of {{$data->total()}} entries"
      },
    });

    document.querySelectorAll(".export").forEach(function(el) {
      el.addEventListener("click", function(e) {
        var type = el.dataset.type;

        var data = {
          type: type,
          filename: "alias-" + type,
        };

        if (type === "csv") {
          data.columnDelimiter = "|";
        }

        dataTableSearch.export(data);
      });
    });
  };
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $("#alert-success").delay(3000).slideUp(300);
  });
  
    $("body").on("click",".addFaq", function () {
        $("#faqModal").modal('show');
    });
    
    
    
    $("body").on("click", ".editFaq", function () {
        var current_object = $(this);
        var link = window.location.origin;
        id=current_object.attr('id');
         $.ajax({
            url: 'faq/edit/'+id,
            type: "GET",

            success: function (data) {
                 $("#faqupdateModal").modal('show');
                 $("#faqid").val(data[0]['id']);
                 $("#question").val(data[0]['question']);
                 $("#answer").val(data[0]['answer']);
                  $('#type option[value="'+ data['type'] +'"]').attr("selected", "selected");
      
                console.log(data[0]['id']);
                },
            });

    });
  
</script>
@endpush