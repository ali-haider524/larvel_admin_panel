@extends('user_type.auth', ['parentFolder' => 'dashboards', 'childFolder' => 'none'])

@section('content')
  <div class="row">
    <div class="col-lg-12 position-relative z-index-2">
      <div class="card card-plain mb-4">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-lg-6">
              <div class="d-flex flex-column h-100">
                <h2 class="font-weight-bolder mb-0"></h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-sm-5">
          <div class="card  mb-4">
            <a href="/users">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Users</p>
                    <h5 class="font-weight-bolder mb-0">
                     {{number_format($user)}}
                      <span class="text-success text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="card ">
            <div class="card-body p-3">
              <a href="/offers/active">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Apps</p>
                    <h5 class="font-weight-bolder mb-0">
                      {{$apps}}
                      <span class="text-success text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-app text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </a>
        </div>
        <div class="col-lg-3 col-sm-5 mt-sm-0 mt-4">
          <div class="card  mb-4">
            <a href="/all-transaction">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Transactions</p>
                    <h5 class="font-weight-bolder mb-0">
                      {{number_format($trans)}}
                      <span class="text-danger text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-chart-bar-32 text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="card ">
            <a href="/article/active">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Websites</p>
                    <h5 class="font-weight-bolder mb-0">
                      {{number_format($weblink)}}
                      <span class="text-success text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-planet text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </a>
        </div>
        <div class="col-lg-3 col-sm-5 mt-sm-0 mt-4">
          <div class="card  mb-4">
            <a href="/withdrawal/pending">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Pending Payment</p>
                    <h5 class="font-weight-bolder mb-0">
                       {{number_format($pending)}}
                      <span class="text-danger text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="card ">
            <div class="card-body p-3">
              <a href="/videozone/active">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Video</p>
                    <h5 class="font-weight-bolder mb-0">
                       {{number_format($video)}}
                      <span class="text-success text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-button-play text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-5 mt-sm-0 mt-4">
          <div class="card  mb-4">
            <a href="/withdrawal/completed">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Completed Payment</p>
                    <h5 class="font-weight-bolder mb-0">
                       {{number_format($complete)}}
                      <span class="text-danger text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="card ">
            <div class="card-body p-3">
              <a href="/withdrawal">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Redeem Method</p>
                    <h5 class="font-weight-bolder mb-0">
                       {{number_format($redeem)}}
                      <span class="text-success text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-credit-card text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row mt-4">
        <div class="col-lg-3 col-sm-5">
          <div class="card  mb-4">
            <a href="/games">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Games</p>
                    <h5 class="font-weight-bolder mb-0">
                     {{number_format($game)}}
                      <span class="text-success text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-controller text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="card ">
            <a href="/coinstore">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">CoinStore Package</p>
                    <h5 class="font-weight-bolder mb-0">
                      {{$store}}
                      <span class="text-success text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-sm-5 mt-sm-0 mt-4">
          <div class="card  mb-4">
            <div class="card-body p-3">
             <a href="/offerwall/sdk">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">SDK Offerwall</p>
                    <h5 class="font-weight-bolder mb-0">
                      {{number_format($sdk)}}
                      <span class="text-danger text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-archive-2 text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
              </a>
            </div>
          </div>
          <div class="card ">
            <div class="card-body p-3">
              <a href="/dailyoffer">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Daily Offers</p>
                    <h5 class="font-weight-bolder mb-0">
                      {{number_format($doffer)}}
                      <span class="text-success text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-calendar-grid-58 text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-5 mt-sm-0 mt-4">
          <div class="card  mb-4">
            <a href="/offerwall/web">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">WEB Offerwall</p>
                    <h5 class="font-weight-bolder mb-0">
                       {{number_format($web)}}
                      <span class="text-danger text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-archive-2 text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-sm-5 mt-sm-0 mt-4">
          <div class="card  mb-4">
            <a href="/offerwall/api">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">API Offerwall</p>
                    <h5 class="font-weight-bolder mb-0">
                       {{number_format($api)}}
                      <span class="text-danger text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-archive-2 text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          
        </div>
      </div>

    </div>
  
  

  <div class="row mt-3">
<div class="col-lg-6 ms-auto">
      <div class="card">
        <div class="card-header pb-0 p-3">
          <div class="d-flex align-items-center">
            <h6 class="mb-0">User Analytics</h6>
            <button type="button" class="btn btn-icon-only btn-rounded btn-outline-secondary mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center ms-auto" data-bs-toggle="tooltip" data-bs-placement="bottom" title="User Analytics">
              <i class="fas fa-info"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-3">
          <div class="row">
            <div class="col-5 text-center">
              <div class="chart">
                <canvas id="chart-consumption" class="chart-canvas" height="197"></canvas>
              </div>
              <h4 class="font-weight-bold mt-n8">
                <span>{{$user}}</span>
                <span class="d-block text-body text-sm">Users</span>
              </h4>
            </div>
            <div class="col-7">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-0">
                          <span class="badge bg-gradient-primary me-3"> </span>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Total User</h6>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold">{{ $user}} </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-0">
                          <span class="badge bg-gradient-secondary me-3"> </span>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Today User App Opend</h6>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold"> {{$appopen}}  </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-0">
                          <span class="badge bg-gradient-info me-3"> </span>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Today User Registerd</h6>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold">  {{$today}}  </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-0">
                          <span class="badge bg-gradient-success me-3"> </span>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">this Month User Registerd</h6>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold"> {{$month}} </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-0">
                          <span class="badge bg-gradient-warning me-3"> </span>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Banned User</h6>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold"> {{$ban}} </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<div class="col-lg-6 ms-auto">
      
    </div>
  </div>
@endsection

@push('js')  
  <script src="{{ URL::asset('assets/js/plugins/chartjs.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/plugins/threejs.js') }}"></script>
  <script src="{{ URL::asset('assets/js/plugins/orbit-controls.js') }}"></script>
  <script>
   
     var ctx1 = document.getElementById("chart-consumption").getContext("2d");

      var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

      new Chart(ctx1, {
        type: "doughnut",
        data: {
          labels: ['Total User', 'Today User App Opend', 'Today User Registerd', 'this Month User Registerd', 'Banned User'],
          datasets: [{
            label: "Consumption",
            weight: 9,
            cutout: 90,
            tension: 0.9,
            pointRadius: 2,
            borderWidth: 2,
            backgroundColor: ['#FF0080', '#A8B8D8', '#21d4fd', '#98ec2d', '#ff667c'],
            data: ["{{$user}}", "{{$appopen}}", "{{$today}}", "{{$month}}", "{{$ban}}"],
            fill: false
          }],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
              },
              ticks: {
                display: false
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
              },
              ticks: {
                display: false,
              }
            },
          },
        },
      });

  </script>
@endpush