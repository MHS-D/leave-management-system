@extends('web.backend.layout.app')

@section('title', __('strings.DASHBOARD'))

@section('content')
    <div class="content-header row">
    </div>
    <div class="content-body">
        <!-- Dashboard Analytics Start -->
        <section id="dashboard-analytics">
            <div class="row match-height">
                <!-- Greetings Card starts -->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card card-congratulations">
                        <div class="card-body text-center">
                            <img src="{{ asset('assets/images/elements/decore-left.png') }}" class="congratulations-img-left"
                                alt="card-img-left" />
                            <img src="{{ asset('assets/images/elements/decore-right.png') }}"
                                class="congratulations-img-right" alt="card-img-right" />
                            <div class="avatar avatar-xl bg-primary shadow">
                                <div class="avatar-content">
                                    <i data-feather="award" class="font-large-1"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <h1 class="mb-1 text-white"> {{ __('strings.WELCOME_BACK').' '.auth()->user()->first_name }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Greetings Card ends -->

                @if(auth()->user()->hasRole(config('settings.roles.names.adminRole')))

                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-warning p-50 m-0">
                                <div class="avatar-content">
                                    <a href="#"><i data-feather="user" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $total_users ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.USERS_TOTAL') }}</p>
                        </div>
                        <div id="order-chart"></div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="#"><i data-feather="user" class="font-medium-5"></i></a>

                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $employees_count ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.EMPLOYEES_COUNT') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>

                 <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="#"><i data-feather="user" class="font-medium-5"></i></a>

                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $active_users ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.ACTIVE_USERS') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>


                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="#"><i data-feather="clock" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $inactive_users ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.UNACTIVE_USERS') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                @endif


                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="#"><i data-feather="clock" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $total_requests ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.TOTAL_REQUESTS') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>


                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="#"><i data-feather="clock" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $pending_requests ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.PENDING_REQUESTS') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>


                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="#"><i data-feather="clock" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $approved_requests ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.APPROVED_REQUESTS') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="#"><i data-feather="clock" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $rejected_requests ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.REJECTED_REQUESTS') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>





            </div>
        </section>
        <!-- Dashboard Analytics end -->

    </div>
@endsection
