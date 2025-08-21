@extends('user_type.auth', ['parentFolder' => 'admin-setting', 'childFolder' => 'alias'])

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">All Alias</h5>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <!--<a href="{{ url('/alias/add') }}" class="btn bg-gradient-dark btn-sm mb-0">+&nbsp; New Alias</a>-->
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
          <table class="table table-flush" id="category-list">
            <thead class="thead-light">
              <tr>
                <th>SELECT</th>
                <th>ALIAS TAG</th>
                <th>DESCRIPTION</th>
                <th>CREATION DATE</th>
                <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
              @if(count($data) > 0)
              @foreach($data as $item)
                <tr id="{{$item->id}}">
                <td class="text-sm">
                  <div class="form-check my-auto">
                        <input class="form-check-input" type="checkbox" id="customCheck1">
                      </div>
                 </td>
                <td class="text-sm">{{str_replace('_',' ',$item->tag)}}</td>
                <td class="text-sm">{{$item->description}}</td>
                <td class="text-sm">{{$item->created_at}}</td>
                <td class="text-sm">
                  <a href="{{ url('edit-alias/' . $item->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Alias">
                    <i class="fas fa-user-edit text-secondary"></i>
                  </a>
                  <a href="#" class="delete" data-id="alias"  id="{{$item->id}}"  data-bs-toggle="tooltip" data-bs-original-title="Delete Alias">
                    <i class="fas fa-trash text-secondary"></i>
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


  // $("#category-list").on("click",".delete",function(){
    // Swal.fire({
    //         title: 'Are you sure?',
    //         text: "You won't be able to revert this!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes, delete it!'
    //       }).then((result) => {
    //         if (result.isConfirmed) {
    //           $(this).parent().parent().remove();

              // Swal.fire(
              //   'Deleted!',
              //   'Your file has been deleted.',
              //   'success'
              // )
    //         }
    //       })
    // });


</script>
@endpush