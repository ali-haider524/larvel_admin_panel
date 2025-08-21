@extends('user_type.auth', ['parentFolder' => 'pages', 'childFolder' => ''])

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Coin Store Purchase Transaction</h5>
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
          <table class="table table-flush" id="category-list">
            <thead class="thead-light">
              <tr>
                <th>TRANS ID</th>
                <th>USER</th>
                <th>PAYMENT METHOD</th>
                <th>TRANSACTION ID</th>
                <th>COIN</th>
                <th>AMOUNT</th>
                <th>STATUS</th>
                <th>DATE</th>
              </tr>
            </thead>
            <tbody>
              @if(count($data) > 0)
              @foreach($data as $item)
                <tr id="{{$item->id}}">
                <td class="text-sm "><a href="{{ url('/user-track/' . $item->userid) }}" class="text-info">{{$item->name}}</a></td>
                <td class="text-sm">{{$item->method}}</td>
                <td class="text-sm">{{$item->trans_id}}</td>
                <td class="text-sm">{{$item->coin}}</td>
                <td class="text-sm"><span class="badge bg-gradient-info">{{$item->amount}}</span></td>
                <td class="text-sm">
                  @if($item->status=='success')
                  <span class="badge bg-gradient-success">Success</span>
                  @else
                  <span class="badge bg-gradient-danger">{{$item->status}}</span>
                  @endif
                </td> 
                <td class="text-sm">{!!date('d-M-y H:i:s',strtotime($item->created_at))!!}</td>
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

@endsection
@push('js')
<script src="{{ URL::asset('assets/js/plugins/datatables.js') }}"></script>
<script src="../../assets/js/plugins/sweetalert.min.js"></script>
<script src="../../assets/js/plugins/action.js"></script>
<script>
  if (document.getElementById('category-list')) {
    const dataTableSearch = new simpleDatatables.DataTable("#category-list", {
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