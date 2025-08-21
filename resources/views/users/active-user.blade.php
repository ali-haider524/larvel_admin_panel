@extends('user_type.auth', ['parentFolder' => 'users', 'childFolder' => ''])

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">All Users</h5>
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
          <table class="table table-flush" id="users-list">
            <thead class="thead-light">
              <tr>
                <th>User ID</th>
                <th>PHOTO</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>COIN</th>
                <th>COUNTRY</th>
                <th>IP ADDRESS</th>
                <th>ACCOUNT STATUS</th>
                <th>CREATION DATE</th>
                <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
              @if(count($users) > 0)
              @foreach($users as $user)
              <tr id="{{$user->cust_id}}">
                <td class="text-sm">{{$user->cust_id}}</td>
                <td class="text-sm">
                  <span class="my-2 text-xs">
                    @if($user->type=="null")
                    <a href="{{url('/images/user/userpro.png')}}" target="_blank"><img src="{{url('/images/user/userpro.png')}}" class="avatar avatar-xl shadow"></a>
                    @elseif($user->type=="google")
                    @if($user->profile=='null')
                    <a href="{{url('/images/user/userpro.png')}}" target="_blank"><img src="{{url('/images/user/userpro.png' )}}" class="avatar avatar-xl shadow"></a>
                    @else
                    <a href="{{$user->profile}}" target="_blank"><img src="{{$user->profile}}" class="avatar avatar-xl shadow"></a>
                    @endif
                    @else
                    <a href="{{url('/images/user/userpro.png'.$user->profile)}}" target="_blank"><img src="{{url('/images/user/userpro.png'.$user->profile)}}" class="avatar avatar-xl shadow"></a>
                    @endif
                  </span>
                </td>
                <td class="text-sm "><a href="{{ url('/user-track/' . $user->cust_id) }}" target="_blank" class="text-info text-bold">{{$user->name}}</a></td>
                <td class="text-sm">{{$user->email}}</td>
                <td class="text-sm">{{number_format($user->balance)}}</td>
                <td class="text-sm"><img src="{{'https://ipdata.co/flags/'.strtolower($user->country).'.png'}}"/></td>
                <td class="text-sm">{{$user->ip}}</td>
                <td class="text-sm" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                  @if($user->status==0)
                  <span class="badge bg-success">Active</span>
                  @else
                  <span class="badge bg-danger">Banned</span>
                  @endif
                </td>
                <td class="text-sm">{!!date('d-M-y H:i:s',strtotime($user->inserted_at))!!}</td>
                <td class="text-sm">
                    <a href="#" class="mx-3 updateUserStatus" data-bs-toggle="tooltip" data-bs-original-title="UN BAN" id="{{$user->cust_id}}" data-id="{{$user->status}}">
                    <i class="fas fa-ban text-danger"> BAN</i>
                  </a>
                  
                  <a href="{{ url('/user-track/' . $user->cust_id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="User Info">
                    <i class="fas fa-user-edit text-info"></i>
                  </a>
                  <a href="#" class="delete" data-id="user"  id="{{$user->cust_id}}"  data-bs-toggle="tooltip" data-bs-original-title="Delete User">
                    <i class="fas fa-trash text-danger"></i>
                  </a>

                  {{$user->page}}

                </td>
              </tr>
              @endforeach
              @else
              <tr> no content </tr>
              @endif
            </tbody>
          </table>
          {{$users->links('components.paginate')}}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@include('modal')

@push('js')
<script src="{{ URL::asset('assets/js/plugins/datatables.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/modal.js') }}"></script>


<script>
  if (document.getElementById('users-list')) {
    const dataTableSearch = new simpleDatatables.DataTable("#users-list", {
      searchable: false,
      fixedHeight: true,
      paginate: false,
      perPage: 15,
      sortable: 2,
      labels: {
        placeholder: "Search...",
        noRows: "No entries found",
        info: "Showing {{ $users->firstItem() }} to {{$users->lastItem()}} of {{$users->total()}} entries"
      },
    });

    document.querySelectorAll(".export").forEach(function(el) {
      el.addEventListener("click", function(e) {
        var type = el.dataset.type;

        var data = {
          type: type,
          filename: "-" + type,
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
<script src="{{ URL::asset('assets/js/plugins/modal.js') }}"></script><script>
  $(document).ready(function() {
    $("#alert-success").delay(3000).slideUp(300);
  });
  
      $("body").on("click", ".updateUserStatus", function () {
        var current_object = $(this);
        var id = current_object.attr('id');
        var status = current_object.attr('data-id');
        console.log('status=>'+status+'  userid=?'+id);
        $("#AcStatusModal").modal('show');
        $("#banid").val(id);
        $("#banstatus").val(status);
        if(status==0){
            $("#exampleModalLabel").val('Ban Account');
        }else{
           $("#exampleModalLabel").val('Unban Account');
        }
       
    });

</script>
@endpush