@extends('user_type.auth', ['parentFolder' => 'users', 'childFolder' => ''])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- Card header -->
            <div class="card-header pb-0">
                <div class="d-lg-flex">
                    <div>
                        <h5 class="mb-0">Search User</h5>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-0 ">
                <div class="row">
                    <div class="col-sm-3">
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group mb-3 text-center" style="padding: 30px; ">
                            <input type="text" class="form-control" name="query" id="query" value="{{$query}}" placeholder="Search User by email , User ID ,name , Ip , Refer Code , Country Iso Code" aria-label="Search User by email , User ID ,name , Ip , Refer Code , Country Iso Code" aria-describedby="button-addon2">
                            <button class="btn btn-outline-info mb-0" type="submit" id="search-user">Search </button>
                        </div>
                    </div>
                    <div class="col-sm-3">
                    </div>
                </div>

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
                                <th>ACCOUNT TYPE</th>
                                <th>EMAIL</th>
                                <th>Balance</th>
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
                                <td class="text-sm "><a href="{{ url('/user-track/' . $user->cust_id) }}" class="text-info text-bold">{{$user->name}}</a></td>
                                <td class="text-sm">{{$user->type}}</td>
                                <td class="text-sm">{{$user->email}}</td>
                                <td class="text-sm">{{number_format($user->balance)}}</td>
                                <td class="text-sm">{{$user->inserted_at}}</td>
                                <td class="text-sm">
                                    <a href="{{ url('/user-track/' . $user->cust_id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="User Info">
                                        <i class="fas fa-user-edit text-info"></i>
                                    </a>
                                    <a href="#" class="delete" data-id="user" id="{{$user->cust_id}}" data-bs-toggle="tooltip" data-bs-original-title="Delete User">
                                        <i class="fas fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>

                    </table>
                    @if(count($users) > 1)
                    {{$users->links('components.paginate')}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ URL::asset('assets/js/plugins/datatables.js') }}"></script>
<script>
    if (document.getElementById('users-list')) {
        const dataTableSearch = new simpleDatatables.DataTable("#users-list", {
            searchable: false,
            fixedHeight: true,
            paginate: false,
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
<script>
    $(document).ready(function() {
        $("#alert-success").delay(3000).slideUp(300);

        
    });

    $("#search-user").click(function() {
        window.location = '/users/search/'+$("#query").val();

    });

    
</script>
@endpush