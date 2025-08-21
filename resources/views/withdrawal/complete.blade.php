@extends('user_type.auth', ['parentFolder' => 'withdrawal', 'childFolder' => ''])

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Completed Withdrawal</h5>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">

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
                <th><div class="form-check my-auto"> <input class="form-check-input sub_chk_all" type="checkbox" id=""/></div></th>
                <th>USER NAME</th>
                <th>REQUEST TO</th>
                <th>COIN DEBIT</th>
                <th>PAYMENT METHOD</th>
                <th>SUBMIT DATE</th>
                <th>UPDATE DATE</th>
                <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
              @if(count($data) > 0)
              @foreach($data as $item)
              <tr id="{{$item->request_id}}">
                <td class="text-sm">
                  <div class="form-check my-auto">
                  <input class="form-check-input sub_chk" type="checkbox" id="customCheck1" data-id="{{$item->request_id}}" value="{{$item->request_id}}">
                  </div>
                </td>
                <td class="text-sm">
                  @if($item->name==null)
                  {{ $name= App\Models\Users::UserName($item->user_id)}}
                  @if($name==null)
                  <span class="badge bg-gradient-danger">User Account Deleted</span>
                  @endif
                  @else
                  {{$item->name}}
                  @endif
                </td>
                <td class="text-sm">{{$item->mobile_no}}</td>
                <td class="text-sm">{{$item->amount}}</td>
                <td class="text-sm"><span class="badge bg-dark">{{$item->type}}</span></td>
                <td class="text-sm">{!!date('d-M-y H:i:s',strtotime($item->date))!!}</td>
                <td class="text-sm">{!!date('d-M-y H:i:s',strtotime($item->updated_at))!!}</td>
                <td class="text-sm">
                  <a href="{{ url('user-track/' . $item->user_id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Track User">
                    <i class="fas fa-chart-line text-info"></i>
                  </a>
                  <a href="#"  data-id="payreq_"  id="{{$item->request_id}}"  class="mx-3 delete" data-bs-toggle="tooltip" data-bs-original-title="Delete">
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
                <li><a class="dropdown-item border-radius-md text-danger" href="javascript:;" id="delete" data-id="payreq">Delete</a></li>
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
</script>
@endpush