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
            <h5 class="mb-0">Home Screen Banner</h5>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
          <div class="ms-auto my-auto">
                <a href="#" class="btn bg-gradient-info btn-sm mb-0 addBanner">+&nbsp; ADD NEW</a>
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
                <th>SELECT</th>
                <th>BANNER</th>
                <th>LINK</th>
                <th>BANNER TYPE</th>
                <th>BANNER ACTION</th>
                <th>STATUS</th>
                <th>CREATED AT</th>
                <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
              @if(count($data) > 0)
              @foreach($data as $item)
              <tr id="{{$item->id}}">
                <td class="text-sm">
                  <div class="form-check my-auto">
                  <input class="form-check-input sub_chk" type="checkbox" id="customCheck1" data-id="{{$item->id}}" value="{{$item->id}}">
                  </div>
                </td>
                <td class="text-sm">
                    <span class="my-2 text-xs">
                            <img src="{{ url('images/'.$item->banner) }}" class="img border-radius-lg" alt="Responsive image" width="200"  height="150">
                    </span>
                </td>
                <td class="text-sm"><a href="{{$item->link}}" target="_blank" class="text-info">View Link</a></td>
                <td class="text-sm">{{$item->bannertype}}</td>
                <td class="text-sm">{{$item->onclick}}</td>
                <td class="text-sm" >
                  @if($item->status==0)
                  <span class="badge bg-success">Activesss</span>
                  @else
                  <span class="badge bg-danger">Disabled</span>
                  @endif
                </td>
                <td class="text-sm">{!!date('d-M-y H:i:s',strtotime($item->created_at))!!}</td>
                <td class="text-sm">
                  <a href="#" class="mx-3 editBanner" data-bs-toggle="tooltip" id="{{$item->id}}"  data-bs-original-title="Edit">
                    <i class="fas fa-edit text-success"></i>
                  </a>
                  <a href="#"  data-id="banner"  id="{{$item->id}}"  class="mx-3 delete" data-bs-toggle="tooltip" data-bs-original-title="Delete">
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
          <div class="d-flex" style="margin-left: 30px;">
          <button class="btn btn-outline-dark sub_chk_all"> Select All </button>
            <div class="dropdown d-inline " style="margin-left: 10px;">
              <a href="javascript:;" class="btn btn-outline-dark dropdown-toggle " data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
                Action
              </a>
              <ul class="dropdown-menu dropdown-menu-lg-start px-2 py-3" aria-labelledby="navbarDropdownMenuLink2" data-popper-placement="left-start">
                <li><a class="dropdown-item border-radius-md" href="javascript:;" id="enable" data-id="banner">Eanble</a></li>
                <li><a class="dropdown-item border-radius-md" href="javascript:;" id="disable" data-id="banner">Disable</a></li>
              </ul>
            </div>
            <!-- <button class="btn btn-icon btn-outline-dark ms-2 export" data-type="csv" type="button">
              <span class="btn-inner--icon"><i class="ni ni-archive-2"></i></span>
              <span class="btn-inner--text">Export CSV</span>
            </button> -->
          </div>
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
<script src="{{ URL::asset('assets/js/plugins/choices.min.js') }}"></script>
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

    $("body").on("click", ".addBanner", function () {
        $("#bannerModal").modal('show');
    });
    
    $("body").on("click", ".editBanner", function () {
        var current_object = $(this);
        var link = window.location.origin;
        id=current_object.attr('id');
         $.ajax({
            url: 'banner/edit/'+id,
            type: "GET",

            success: function (data) {
                 $("#bannerUpdateModal").modal('show');
                 $("#id").val(data['id']);
                 $("#link").val(data['link']);
                 $("#oldicon").val(data['banner']);
                 $('#choices-tag option[value="'+ data['bannertype'] +'"]').attr("selected", "selected");
                 $('#choices-tag2 option[value="'+ data['onclick'] +'"]').attr("selected", "selected");
                console.log(data);
            },
          });

    });
  
          
    if (document.getElementById('choices-tag')) {
      var tag = document.getElementById('choices-tag');
      const example = new Choices(tag);
    }

</script>
@endpush