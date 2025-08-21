@extends('user_type.auth', ['parentFolder' => 'admin-setting', 'childFolder' => 'app-setting'])

@section('content')
<link href="/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
<div class="container-fluid my-3 py-3">
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
    <div class="row mb-5">
        <div class="col-lg-3">
            <div class="card position-sticky top-1">
                <ul class="nav flex-column bg-white border-radius-lg p-3">
                    <li class="nav-item">
                        <a class="nav-link text-body" data-scroll="" href="#home">
                            <div class="icon me-2">
                                <svg class="text-dark mb-1" width="16px" height="16px" viewBox="0 0 40 40" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>spaceship</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1720.000000, -592.000000)" fill="#FFFFFF"
                                            fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(4.000000, 301.000000)">
                                                    <path class="color-background"
                                                        d="M39.3,0.706666667 C38.9660984,0.370464027 38.5048767,0.192278529 38.0316667,0.216666667 C14.6516667,1.43666667 6.015,22.2633333 5.93166667,22.4733333 C5.68236407,23.0926189 5.82664679,23.8009159 6.29833333,24.2733333 L15.7266667,33.7016667 C16.2013871,34.1756798 16.9140329,34.3188658 17.535,34.065 C17.7433333,33.98 38.4583333,25.2466667 39.7816667,1.97666667 C39.8087196,1.50414529 39.6335979,1.04240574 39.3,0.706666667 Z M25.69,19.0233333 C24.7367525,19.9768687 23.3029475,20.2622391 22.0572426,19.7463614 C20.8115377,19.2304837 19.9992882,18.0149658 19.9992882,16.6666667 C19.9992882,15.3183676 20.8115377,14.1028496 22.0572426,13.5869719 C23.3029475,13.0710943 24.7367525,13.3564646 25.69,14.31 C26.9912731,15.6116662 26.9912731,17.7216672 25.69,19.0233333 L25.69,19.0233333 Z">
                                                    </path>
                                                    <path class="color-background"
                                                        d="M1.855,31.4066667 C3.05106558,30.2024182 4.79973884,29.7296005 6.43969145,30.1670277 C8.07964407,30.6044549 9.36054508,31.8853559 9.7979723,33.5253085 C10.2353995,35.1652612 9.76258177,36.9139344 8.55833333,38.11 C6.70666667,39.9616667 0,40 0,40 C0,40 0,33.2566667 1.855,31.4066667 Z">
                                                    </path>
                                                    <path class="color-background"
                                                        d="M17.2616667,3.90166667 C12.4943643,3.07192755 7.62174065,4.61673894 4.20333333,8.04166667 C3.31200265,8.94126033 2.53706177,9.94913142 1.89666667,11.0416667 C1.5109569,11.6966059 1.61721591,12.5295394 2.155,13.0666667 L5.47,16.3833333 C8.55036617,11.4946947 12.5559074,7.25476565 17.2616667,3.90166667 L17.2616667,3.90166667 Z"
                                                        opacity="0.598539807"></path>
                                                    <path class="color-background"
                                                        d="M36.0983333,22.7383333 C36.9280725,27.5056357 35.3832611,32.3782594 31.9583333,35.7966667 C31.0587397,36.6879974 30.0508686,37.4629382 28.9583333,38.1033333 C28.3033941,38.4890431 27.4704606,38.3827841 26.9333333,37.845 L23.6166667,34.53 C28.5053053,31.4496338 32.7452344,27.4440926 36.0983333,22.7383333 L36.0983333,22.7383333 Z"
                                                        opacity="0.598539807"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="text-sm">Home Screen</span>
                        </a>
                    </li>
                    <li class="nav-item pt-2">
                        <a class="nav-link text-body" data-scroll="" href="#task">
                            <div class="icon me-2">
                                <svg class="text-dark mb-1" width="16px" height="16px" viewBox="0 0 40 44" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>Task Setting</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF"
                                            fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(154.000000, 300.000000)">
                                                    <path class="color-background"
                                                        d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z"
                                                        opacity="0.603585379"></path>
                                                    <path class="color-background"
                                                        d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="text-sm">Task Setting</span>
                        </a>
                    </li>
                    <li class="nav-item pt-2">
                        <a class="nav-link text-body" data-scroll="" href="#referral">
                            <div class="icon me-2">
                                <svg class="text-dark mb-1" width="16px" height="16px" viewBox="0 0 42 42" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>box-3d-50</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-2319.000000, -291.000000)" fill="#FFFFFF"
                                            fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(603.000000, 0.000000)">
                                                    <path class="color-background"
                                                        d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474453 38.8987261,9.45068056 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z">
                                                    </path>
                                                    <path class="color-background"
                                                        d="M23.625,22.429159 L23.625,39.8805372 C23.625,40.4328219 24.0727153,40.8805372 24.625,40.8805372 C24.7802551,40.8805372 24.9333778,40.8443874 25.0722402,40.7749511 L41.2741875,32.673375 L41.2741875,32.673375 C41.719125,32.4515625 42,31.9974375 42,31.5 L42,14.241659 C42,13.6893742 41.5522847,13.241659 41,13.241659 C40.8447549,13.241659 40.6916418,13.2778041 40.5527864,13.3472318 L24.1777864,21.5347318 C23.8390024,21.7041238 23.625,22.0503869 23.625,22.429159 Z"
                                                        opacity="0.7"></path>
                                                    <path class="color-background"
                                                        d="M20.4472136,21.5347318 L1.4472136,12.0347318 C0.953235098,11.7877425 0.352562058,11.9879669 0.105572809,12.4819454 C0.0361450918,12.6208008 6.47121774e-16,12.7739139 0,12.929159 L0,30.1875 L0,30.1875 C0,30.6849375 0.280875,31.1390625 0.7258125,31.3621875 L19.5528096,40.7750766 C20.0467945,41.0220531 20.6474623,40.8218132 20.8944388,40.3278283 C20.963859,40.1889789 21,40.0358742 21,39.8806379 L21,22.429159 C21,22.0503869 20.7859976,21.7041238 20.4472136,21.5347318 Z"
                                                        opacity="0.7"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="text-sm">Referral & Withdraw </span>
                        </a>
                    </li>
                    <li class="nav-item pt-2">
                        <a class="nav-link text-body" data-scroll="" href="#daily">
                            <div class="icon me-2">
                                <svg class="text-dark mb-1" width="16px" height="16px" viewBox="0 0 40 44" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>switches</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1870.000000, -440.000000)" fill="#FFFFFF"
                                            fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(154.000000, 149.000000)">
                                                    <path class="color-background"
                                                        d="M10,20 L30,20 C35.4545455,20 40,15.4545455 40,10 C40,4.54545455 35.4545455,0 30,0 L10,0 C4.54545455,0 0,4.54545455 0,10 C0,15.4545455 4.54545455,20 10,20 Z M10,3.63636364 C13.4545455,3.63636364 16.3636364,6.54545455 16.3636364,10 C16.3636364,13.4545455 13.4545455,16.3636364 10,16.3636364 C6.54545455,16.3636364 3.63636364,13.4545455 3.63636364,10 C3.63636364,6.54545455 6.54545455,3.63636364 10,3.63636364 Z"
                                                        opacity="0.6"></path>
                                                    <path class="color-background"
                                                        d="M30,23.6363636 L10,23.6363636 C4.54545455,23.6363636 0,28.1818182 0,33.6363636 C0,39.0909091 4.54545455,43.6363636 10,43.6363636 L30,43.6363636 C35.4545455,43.6363636 40,39.0909091 40,33.6363636 C40,28.1818182 35.4545455,23.6363636 30,23.6363636 Z M30,40 C26.5454545,40 23.6363636,37.0909091 23.6363636,33.6363636 C23.6363636,30.1818182 26.5454545,27.2727273 30,27.2727273 C33.4545455,27.2727273 36.3636364,30.1818182 36.3636364,33.6363636 C36.3636364,37.0909091 33.4545455,40 30,40 Z">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="text-sm">Daily Bonus</span>
                        </a>
                    </li>
                    <li class="nav-item pt-2">
                        <a class="nav-link text-body" data-scroll="" href="#promote">
                            <div class="icon me-2">
                                <svg class="text-dark mb-1" width="16px" height="16px" viewBox="0 0 40 44" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>switches</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1870.000000, -440.000000)" fill="#FFFFFF"
                                            fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(154.000000, 149.000000)">
                                                    <path class="color-background"
                                                        d="M10,20 L30,20 C35.4545455,20 40,15.4545455 40,10 C40,4.54545455 35.4545455,0 30,0 L10,0 C4.54545455,0 0,4.54545455 0,10 C0,15.4545455 4.54545455,20 10,20 Z M10,3.63636364 C13.4545455,3.63636364 16.3636364,6.54545455 16.3636364,10 C16.3636364,13.4545455 13.4545455,16.3636364 10,16.3636364 C6.54545455,16.3636364 3.63636364,13.4545455 3.63636364,10 C3.63636364,6.54545455 6.54545455,3.63636364 10,3.63636364 Z"
                                                        opacity="0.6"></path>
                                                    <path class="color-background"
                                                        d="M30,23.6363636 L10,23.6363636 C4.54545455,23.6363636 0,28.1818182 0,33.6363636 C0,39.0909091 4.54545455,43.6363636 10,43.6363636 L30,43.6363636 C35.4545455,43.6363636 40,39.0909091 40,33.6363636 C40,28.1818182 35.4545455,23.6363636 30,23.6363636 Z M30,40 C26.5454545,40 23.6363636,37.0909091 23.6363636,33.6363636 C23.6363636,30.1818182 26.5454545,27.2727273 30,27.2727273 C33.4545455,27.2727273 36.3636364,30.1818182 36.3636364,33.6363636 C36.3636364,37.0909091 33.4545455,40 30,40 Z">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="text-sm">User Promotion Setting</span>
                        </a>
                    </li>

                    <li class="nav-item pt-2">
                        <a class="nav-link text-body" data-scroll="" href="#coinstore">
                            <div class="icon me-2">
                                <svg class="text-dark mb-1" width="16px" height="16px" viewBox="0 0 42 44" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>time-alarm</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-2319.000000, -440.000000)" fill="#923DFA"
                                            fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(603.000000, 149.000000)">
                                                    <path class="color-background"
                                                        d="M18.8086957,4.70034783 C15.3814926,0.343541521 9.0713063,-0.410050841 4.7145,3.01715217 C0.357693695,6.44435519 -0.395898667,12.7545415 3.03130435,17.1113478 C5.53738466,10.3360568 11.6337901,5.54042955 18.8086957,4.70034783 L18.8086957,4.70034783 Z"
                                                        opacity="0.6"></path>
                                                    <path class="color-background"
                                                        d="M38.9686957,17.1113478 C42.3958987,12.7545415 41.6423063,6.44435519 37.2855,3.01715217 C32.9286937,-0.410050841 26.6185074,0.343541521 23.1913043,4.70034783 C30.3662099,5.54042955 36.4626153,10.3360568 38.9686957,17.1113478 Z"
                                                        opacity="0.6"></path>
                                                    <path class="color-background"
                                                        d="M34.3815652,34.7668696 C40.2057958,27.7073059 39.5440671,17.3375603 32.869743,11.0755718 C26.1954189,4.81358341 15.8045811,4.81358341 9.13025701,11.0755718 C2.45593289,17.3375603 1.79420418,27.7073059 7.61843478,34.7668696 L3.9753913,40.0506522 C3.58549114,40.5871271 3.51710058,41.2928217 3.79673036,41.8941824 C4.07636014,42.4955431 4.66004722,42.8980248 5.32153275,42.9456105 C5.98301828,42.9931963 6.61830436,42.6784048 6.98113043,42.1232609 L10.2744783,37.3434783 C16.5555112,42.3298213 25.4444888,42.3298213 31.7255217,37.3434783 L35.0188696,42.1196087 C35.6014207,42.9211577 36.7169135,43.1118605 37.53266,42.5493622 C38.3484064,41.9868639 38.5667083,40.8764423 38.0246087,40.047 L34.3815652,34.7668696 Z M30.1304348,25.5652174 L21,25.5652174 C20.49574,25.5652174 20.0869565,25.1564339 20.0869565,24.6521739 L20.0869565,15.5217391 C20.0869565,15.0174791 20.49574,14.6086957 21,14.6086957 C21.50426,14.6086957 21.9130435,15.0174791 21.9130435,15.5217391 L21.9130435,23.7391304 L30.1304348,23.7391304 C30.6346948,23.7391304 31.0434783,24.1479139 31.0434783,24.6521739 C31.0434783,25.1564339 30.6346948,25.5652174 30.1304348,25.5652174 Z">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="text-sm">Payment Gateway, CoinStore</span>
                        </a>
                    </li>
                    <li class="nav-item pt-2">
                        <a class="nav-link text-body" data-scroll="" href="#security">
                            <div class="icon me-2">
                                <svg class="text-dark mb-1" width="16px" height="16px" viewBox="0 0 42 44" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>time-alarm</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-2319.000000, -440.000000)" fill="#923DFA"
                                            fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(603.000000, 149.000000)">
                                                    <path class="color-background"
                                                        d="M18.8086957,4.70034783 C15.3814926,0.343541521 9.0713063,-0.410050841 4.7145,3.01715217 C0.357693695,6.44435519 -0.395898667,12.7545415 3.03130435,17.1113478 C5.53738466,10.3360568 11.6337901,5.54042955 18.8086957,4.70034783 L18.8086957,4.70034783 Z"
                                                        opacity="0.6"></path>
                                                    <path class="color-background"
                                                        d="M38.9686957,17.1113478 C42.3958987,12.7545415 41.6423063,6.44435519 37.2855,3.01715217 C32.9286937,-0.410050841 26.6185074,0.343541521 23.1913043,4.70034783 C30.3662099,5.54042955 36.4626153,10.3360568 38.9686957,17.1113478 Z"
                                                        opacity="0.6"></path>
                                                    <path class="color-background"
                                                        d="M34.3815652,34.7668696 C40.2057958,27.7073059 39.5440671,17.3375603 32.869743,11.0755718 C26.1954189,4.81358341 15.8045811,4.81358341 9.13025701,11.0755718 C2.45593289,17.3375603 1.79420418,27.7073059 7.61843478,34.7668696 L3.9753913,40.0506522 C3.58549114,40.5871271 3.51710058,41.2928217 3.79673036,41.8941824 C4.07636014,42.4955431 4.66004722,42.8980248 5.32153275,42.9456105 C5.98301828,42.9931963 6.61830436,42.6784048 6.98113043,42.1232609 L10.2744783,37.3434783 C16.5555112,42.3298213 25.4444888,42.3298213 31.7255217,37.3434783 L35.0188696,42.1196087 C35.6014207,42.9211577 36.7169135,43.1118605 37.53266,42.5493622 C38.3484064,41.9868639 38.5667083,40.8764423 38.0246087,40.047 L34.3815652,34.7668696 Z M30.1304348,25.5652174 L21,25.5652174 C20.49574,25.5652174 20.0869565,25.1564339 20.0869565,24.6521739 L20.0869565,15.5217391 C20.0869565,15.0174791 20.49574,14.6086957 21,14.6086957 C21.50426,14.6086957 21.9130435,15.0174791 21.9130435,15.5217391 L21.9130435,23.7391304 L30.1304348,23.7391304 C30.6346948,23.7391304 31.0434783,24.1479139 31.0434783,24.6521739 C31.0434783,25.1564339 30.6346948,25.5652174 30.1304348,25.5652174 Z">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="text-sm">App Security Setting</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <div class="col-lg-9 mt-lg-0 mt-4">
            <!-- Card Profile -->
            <div class="card card-body" id="home">
                <div class="row justify-content-center align-items-center">
                    <div class="col-sm-auto col-sm-12 col-lg-4">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{'https://worklab.technicalsumer.website/images/user/userpro.png'}}" alt="bruce"
                                class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-sm-auto col-8 my-auto">
                        <div class="h-100">
                            <h5 class="mb-1 font-weight-bolder">
                                App Setting
                            </h5>
                            <p class="mb-0 font-weight-bold text-sm">
                                Home Screen, Task Setting
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">

                    </div>
                </div>

            </div>
            <!-- Card Basic Info -->

            <div class="card mt-4">
                <div class="card-header">
                    <h5>Home Screen</h5>
                </div>
                <div class="card-body p-4 mt-0">
                    <form action="/setting/update" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="hometask">
                    <h6 class="text-uppercase text-body text-xs font-weight-bolder">Home Screen Offers</h6>
                    <ul class="list-group">
                        <li class="list-group-item border-0 px-0">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox"  name="math" id="flexSwitchCheckDefault"
                                    {{($task[0]->math=='on') ? 'checked' : ''}} >
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                    for="flexSwitchCheckDefault" >Math Quiz</label>
                            </div>
                        </li>
                        <li class="list-group-item border-0 px-0">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox"  name="spin" id="flexSwitchCheckDefault1" {{($task[0]->spin=='on') ? 'checked' : ''}}>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                    for="flexSwitchCheckDefault1" >Lucky Wheel</label>
                            </div>
                        </li>
                        <li class="list-group-item border-0 px-0">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox"  name="scratch" id="flexSwitchCheckDefault2"
                                    {{($task[0]->scratch=='on') ? 'checked' : ''}}>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                    for="flexSwitchCheckDefault2">Lucky Scratch</label>
                            </div>
                        </li>

                        <li class="list-group-item border-0 px-0">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox" name="web"  id="flexSwitchCheckDefault2"
                                    {{($task[0]->web=='on') ? 'checked' : ''}}>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                    for="flexSwitchCheckDefault2" >Read Article</label>
                            </div>
                        </li>

                        <li class="list-group-item border-0 px-0">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto"  name="video" type="checkbox" id="flexSwitchCheckDefault2"
                                     {{($task[0]->video=='on') ? 'checked' : ''}}>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                    for="flexSwitchCheckDefault2">Videozone</label>
                            </div>
                        </li>

                        <li class="list-group-item border-0 px-0">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto"  name="game" type="checkbox" id="flexSwitchCheckDefault2"
                                    {{($task[0]->game=='on') ? 'checked' : ''}}>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                    for="flexSwitchCheckDefault2">Playzone</label>
                            </div>
                        </li>

                        <li class="list-group-item border-0 px-0">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto"  name="cpi" type="checkbox" id="flexSwitchCheckDefault2"
                                    {{($task[0]->cpi=='on') ? 'checked' : ''}}>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                    for="flexSwitchCheckDefault2">Cpi offer</label>
                            </div>
                        </li>

                        <li class="list-group-item border-0 px-0">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" name="promo"  type="checkbox" id="flexSwitchCheckDefault2"
                                    {{($task[0]->promo=='on') ? 'checked' : ''}}>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                    for="flexSwitchCheckDefault2">Promote</label>
                            </div>
                        </li>

                        <li class="list-group-item border-0 px-0">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" name="store"  type="checkbox" id="flexSwitchCheckDefault2"
                                    {{($task[0]->store=='on') ? 'checked' : ''}}>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                    for="flexSwitchCheckDefault2">Coin Store</label>
                            </div>
                        </li>

                        <li class="list-group-item border-0 px-0">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" name="offerwall"  type="checkbox" id="flexSwitchCheckDefault2"
                                    {{($task[0]->offerwall=='on') ? 'checked' : ''}}>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                    for="flexSwitchCheckDefault2">OfferWalls</label>
                            </div>
                        </li>
                        
                        <li class="list-group-item border-0 px-0">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" name="db"  type="checkbox" id="flexSwitchCheckDefault2"
                                    {{($task[0]->db=='on') ? 'checked' : ''}}>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                    for="flexSwitchCheckDefault2">Daily Bonus</label>
                            </div>
                        </li>
                        
                        <li class="list-group-item border-0 px-0">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" name="do"  type="checkbox" id="flexSwitchCheckDefault2"
                                    {{($task[0]->do=='on') ? 'checked' : ''}}>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                    for="flexSwitchCheckDefault2">Daily Offers</label>
                            </div>
                        </li>
                    </ul>
                    
                     <div>
                            <label class="mt-4">Home Screen Message</label>
                            <div class="">
                                <textarea type="text" class="form-control" name="homeMsg">{{ $homeMsg }}</textarea>
                            </div>
                        </div>
                        
                    <button type="submit" class="btn bg-gradient-info mt-3">Save Changes</button>
                </div>
                </form>
            </div>


            <div class="card mt-4" id="task">
                <div class="card-header">
                    <h5>Task Setting</h5>
                </div>
                <div class="card-body pt-0">
                    <form action="/setting/update" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="appsetting">
                        <!--spin-->
                        <figure>
                            <blockquote class="blockquote">
                                <h6>
                                    <p class="ps-2"> Lucky Wheel</p>
                                </h6>
                            </blockquote>
                            <figcaption class="blockquote-footer ps-3">
                                Set Daily Limit of Lucky Wheel
                            </figcaption>
                        </figure>
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">
                                <label class="form-label">Daily Lucky Wheel Limit</label>
                                <div class="input-group">
                                    <input class="form-control" type="number" name="TASK_SPIN"
                                        value="{{env('TASK_SPIN')}}" placeholder="10" required>
                                </div>
                            </div>
                        </div>

                        <!--scratch-->
                        <br>
                        <figure>
                            <blockquote class="blockquote">
                                <h6>
                                    <p class="ps-2"> Scratch Card</p>
                                </h6>
                            </blockquote>
                            <figcaption class="blockquote-footer ps-3">
                                Set Daily Limit of Scratch Card, Scratch Card Minimum & Maximum Coin Reward.
                            </figcaption>
                        </figure>
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">
                                <label class="form-label">Daily Scratch Limit</label>
                                <div class="input-group">
                                    <input class="form-control" type="number" name="TASK_SCRATCH"
                                        value="{{env('TASK_SCRATCH')}}" placeholder="10" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4">
                                <label class="form-label">Scratch Reward Range ( Minimum, Maximum)</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="SCRATCH_COIN"
                                        value="{{env('SCRATCH_COIN')}}" placeholder="5,10" required>
                                </div>
                            </div>
                        </div>

                        <!--math quiz-->
                        <br>
                        <figure>
                            <blockquote class="blockquote">
                                <h6>
                                    <p class="ps-2"> Math Quiz</p>
                                </h6>
                            </blockquote>
                            <figcaption class="blockquote-footer ps-3">
                                Set Daily Limit of Math Quiz, Math Quiz Minimum & Maximum Coin Reward.
                            </figcaption>
                        </figure>
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">
                                <label class="form-label">Daily Math Quiz Limit</label>
                                <div class="input-group">
                                    <input class="form-control" type="number" name="TASK_MATH"
                                        value="{{env('TASK_MATH')}}" placeholder="10" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4">
                                <label class="form-label">Math Quiz Reward Range ( Minimum, Maximum)</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="MATH_COIN"
                                        value="{{env('MATH_COIN')}}" placeholder="5,10" required>
                                </div>
                            </div>
                        </div>

                        <!--Video-->
                        <br>
                        <figure>
                            <blockquote class="blockquote">
                                <h6>
                                    <p class="ps-2">Video Zone</p>
                                </h6>
                            </blockquote>
                            <figcaption class="blockquote-footer ps-3">
                                Set Daily Limit of Video Zone Task.
                            </figcaption>
                        </figure>
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">
                                <label class="form-label">Daily VideoZone Limit</label>
                                <div class="input-group">
                                    <input class="form-control" type="number" name="TASK_VIDEO"
                                        value="{{env('TASK_VIDEO')}}" placeholder="10" required>
                                </div>
                            </div>
                        </div>

                        <!--Article-->
                        <br>
                        <figure>
                            <blockquote class="blockquote">
                                <h6>
                                    <p class="ps-2">Read Article</p>
                                </h6>
                            </blockquote>
                            <figcaption class="blockquote-footer ps-3">
                                Set Daily Limit of Read Article Task.
                            </figcaption>
                        </figure>
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">
                                <label class="form-label">Daily Read Article Limit</label>
                                <div class="input-group">
                                    <input class="form-control" type="number" name="TASK_WEB"
                                        value="{{env('TASK_WEB')}}" placeholder="10" required>
                                </div>
                            </div>
                        </div>

                        <!--Playzone-->
                        <br>
                        <figure>
                            <blockquote class="blockquote">
                                <h6>
                                    <p class="ps-2">PlayZone HTML 5 Game</p>
                                </h6>
                            </blockquote>
                            <figcaption class="blockquote-footer ps-3">
                                Set Playzone Game Time, Game Reward , Game Popup Message.
                            </figcaption>
                        </figure>
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">
                                <label class="form-label">Game Time (User Need to Spend x Second Time to get Reward)</label>
                                <div class="input-group">
                                    <input class="form-control" type="number" name="GAME_MIN"
                                        value="{{env('GAME_MIN')}}" placeholder="10" required>
                                </div>
                            </div>

                            <div class="col-sm-12 col-lg-4">
                                <label class="form-label">Game Reward Range (Min.Max)</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="GAME_COIN"
                                        value="{{env('GAME_COIN')}}" placeholder="5,10" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn bg-gradient-info mt-3">Save Changes</button>


                </div>
            </div>

            <!--Referral-->
            <div class="card mt-4" id="referral">
                <div class="card-header">
                    <h5>Referral Setting</h5>
                </div>
                <div class="card-body pt-0">
                    <figure>
                        <blockquote class="blockquote">
                            <h6>
                                <p class="ps-2"> Referral</p>
                            </h6>
                        </blockquote>
                        <figcaption class="blockquote-footer ps-3">
                            Welcome Bonus,Referral Coin
                        </figcaption>
                    </figure>
                    <div class="row">
                        <div class="col-sm-12 col-lg-4">
                            <label class="form-label">Welcome Bonus</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="WL_COIN" value="{{env('WL_COIN')}}"
                                    placeholder="10" required>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-4">
                            <label class="form-label">Referral Bonus</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="REF_COIN" value="{{env('REF_COIN')}}"
                                    placeholder="10" required>
                            </div>
                        </div>

                        <div>
                            <br>
                            <label for="categoryName" class="form-label">Referral Coin & Welcome Bonus Credit When</label>
                            <select class="form-control" name="REF_MODE" id="choices-tag"
                                placeholder="Referral Coin Credit When">
                                <option value="0" {{ (env('REF_MODE')=='0' ) ? 'selected' : '' }}>Direct (When Invited
                                    person Enter refer code Upline User get Bonus)</option>
                                <option value="1" {{ (env('REF_MODE')=='1' ) ? 'selected' : '' }}>Complete Task (User Need to Complete Lucky Wheel  & Scratch Card Task to get Welcome Bonus and get Upline Bonus)</option>
                            </select>
                        </div>


                        <div class="col-sm-12 col-lg-4">
                            <br>
                            <label class="form-label">Daily Withdraw Limit</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="RDM_LIM" value="{{env('RDM_LIM')}}"
                                    placeholder="10" required>
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn bg-gradient-info mt-3">Save Changes</button>
                </div>

                <div class="card-body pt-0">
                </div>
            </div>

            <!--daily bonus-->
            <div class="card mt-4" id="daily">
                <div class="card-header">
                    <h5>Daily Bonus</h5>
                </div>
                <div class="card-body pt-0">
                    <figure>
                        <blockquote class="blockquote">
                            <h6>
                                <p class="ps-2">Daily Bonus</p>
                            </h6>
                        </blockquote>
                        <figcaption class="blockquote-footer ps-3">
                            User get Daily Bonus on Each Day
                        </figcaption>
                    </figure>
                    <div class="row">
                        <div class="col-sm-12 col-lg-3">
                            <label class="form-label">Monday</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="day1" value="{{$daily[0]->d1}}"
                                    placeholder="10" required>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-3">
                            <label class="form-label">Tuesday</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="day2" value="{{$daily[0]->d2}}"
                                    placeholder="10" required>
                            </div>
                        </div>


                        <div class="col-sm-12 col-lg-3">
                            <label class="form-label">Wednesday</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="day3" value="{{$daily[0]->d3}}"
                                    placeholder="10" required>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-3">
                            <label class="form-label">Thursday</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="day4" value="{{$daily[0]->d4}}"
                                    placeholder="10" required>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 col-lg-3">
                            <label class="form-label">Friday</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="day5" value="{{$daily[0]->d5}}"
                                    placeholder="10" required>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-3">
                            <label class="form-label">Saturday</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="day6" value="{{$daily[0]->d6}}"
                                    placeholder="10" required>
                            </div>
                        </div>


                        <div class="col-sm-12 col-lg-3">
                            <label class="form-label">Sunday</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="day7" value="{{$daily[0]->d7}}"
                                    placeholder="10" required>
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn bg-gradient-info mt-3">Save Changes</button>

                </div>
                <div class="card-body pt-0">
                </div>
            </div>

            <!--promote-->
            <div class="card mt-4" id="promote">
                <div class="card-header">
                    <h5>Promotion Setting</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <label class="form-label">Required Coin For Promote 1 Website & Video :-</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="video_promotecoin"
                                    value="{{$data[0]->video_promotecoin}}" placeholder="10" required>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-6">
                            <label class="form-label">Max Promotion Limit :-</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="max_promote"
                                    value="{{$data[0]->max_promote}}" placeholder="10" required>
                            </div>
                        </div>


                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 col-lg-6">
                            <label class="form-label">Video & Website Timer in Promotion :- ( Value in Second)</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="promote_time"
                                    value="{{$data[0]->promote_time}}" placeholder="1" required>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-6">
                            <label class="form-label">Video Watch Coin get User( from promoted video ) :-</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="promo_videocoin"
                                    value="{{$data[0]->promo_videocoin}}" placeholder="10" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">


                        <div class="col-sm-12 col-lg-6">
                            <label class="form-label">Web Visit Coin get User( from promoted website ) :-</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="promo_webcoin"
                                    value="{{$data[0]->promo_webcoin}}" placeholder="10" required>
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn bg-gradient-info mt-3">Save Changes</button>

                </div>
                <div class="card-body pt-0">
                </div>
            </div>


            
                        <div class="card mt-4" id="coinstore">
                <div class="card-header">
                    <h5>CoinStore & Payment Setting</h5>
                </div>
                <div class="card-body pt-0">
                    
                    <h6 class="text-uppercase text-body text-xs font-weight-bolder">Payment Mode Enable Disable</h6>
                    <ul class="list-group">
                
                        <li class="list-group-item border-0 px-0">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox" name="upi"   {{($pay[0]->upi=='on') ? 'checked' : ''}}>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                    for="flexSwitchCheckDefault1">UPI</label>
                            </div>
                        </li>
                        <li class="list-group-item border-0 px-0">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox" name="inapp"  {{($pay[0]->inapp=='on') ? 'checked' : ''}}>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                    for="flexSwitchCheckDefault1" >Google Play IN-App Purchase</label>
                            </div>
                        </li>
                        <li class="list-group-item border-0 px-0">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox" name="manual"
                                    checked>
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                    for="flexSwitchCheckDefault2" {{($pay[0]->manual=='on') ? 'checked' : ''}}>Manual Mode</label>
                            </div>
                        </li>
                    </ul>
                    <br>
                    <figure>
                        <blockquote class="blockquote">
                            <h6>
                                <p class="ps-2">Coin Store Name</p>
                            </h6>
                        </blockquote>
                        <figcaption class="blockquote-footer ps-3">
                            Set your Store Name eg: CoinStore
                        </figcaption>
                    </figure>
                    
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <label class="form-label">Store Name :-</label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="storeName"
                                    value="{{$pay[0]->storeName}}" placeholder="Coin Store" required>
                            </div>
                        </div>
                    </div>

                    <br>
                    <figure>
                        <blockquote class="blockquote">
                            <h6>
                                <p class="ps-2">UPI ( Only For India )</p>
                            </h6>
                        </blockquote>
                        <figcaption class="blockquote-footer ps-3">
                            Setup UPI Business Name , ID , Merchant Code Details
                        </figcaption>
                    </figure>
                    <div class="row mt-2">
                        <div class="col-sm-12 col-lg-4">
                            <label class="form-label">UPI ID :-</label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="upiID" value="{{$pay[0]->upiID}}"
                                    placeholder="">
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-4">
                            <label class="form-label">UPI Name :-</label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="upiName" value="{{$pay[0]->upiName}}"
                                    placeholder="">
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-4">
                            <label class="form-label">UPI Merchant Code :-</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="upiMerchant" value="{{$pay[0]->upiMerchant}}"
                                    placeholder="">
                            </div>
                        </div>
                    </div>
                    
                    <br>
                    <figure>
                        <blockquote class="blockquote">
                            <h6>
                                <p class="ps-2">Google Play In App Purchase</p>
                            </h6>
                        </blockquote>
                        <figcaption class="blockquote-footer ps-3">
                            Setup Google in app key
                        </figcaption>
                    </figure>
                    <div class="row mt-2">
                        <div class="col-sm-12 col-lg-4">
                            <label class="form-label">Google PLay KEY :-</label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="google_key" value="{{$pay[0]->google_key}}"
                                    placeholder="">
                            </div>
                        </div>
                    </div>

                    <br>
                    <figure>
                        <blockquote class="blockquote">
                            <h6>
                                <p class="ps-2">Manual Payment Option</p>
                            </h6>
                        </blockquote>
                        <figcaption class="blockquote-footer ps-3">
                            Add Your Paymnet Info For Manual Option User Pay and Contact via Whatsapp
                        </figcaption>
                    </figure>
                    <div class="row mt-2">

                        <div class="col-sm-12 col-lg-6">
                            <label class="form-label">Whatsapp No. or Email For Contact:-</label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="manualContact" value="{{$pay[0]->contact}}"
                                    placeholder="Whatsapp No. or Email">
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <label class="form-label">Payment Detail :-</label>
                            <div class="input-group">
                                <textarea class="ckeditor form-control" name="manualDetail" placeholder="ADD"
                                    textarea>{{$pay[0]->m_payinfo}}</textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn bg-gradient-info mt-3">Save Changes</button>
                </div>
                <div class="card-body pt-0">
                </div>
            </div>
            </form>
        </div>
    </div>
    @include('layouts/footers/auth/footer')
</div>
@endsection
@include('modal')

@push('js')
<script src="{{ URL::asset('assets/js/plugins/modal.js') }}"></script>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

<script>


</script>
@endpush