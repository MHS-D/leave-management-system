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
                <div class="col-lg-6 col-md-12 col-sm-12">
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

                <!-- Orders Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-warning p-50 m-0">
                                <div class="avatar-content">
                                  <a href="{{ $active_users_route }}"><i data-feather="users" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $active_users ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.ACTIVE_USERS') }}</p>
                        </div>
                        <div id="order-chart"></div>
                    </div>
                </div>
                <!-- Orders Chart Card ends -->

                 <!-- Subscribers Chart Card starts -->
                 <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $projects_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $projects ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.PROJECTS') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->

                  <!-- Orders Chart Card starts -->
                  <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-warning p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $active_projects_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $active_projects ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.ACTIVE_PROJECTS') }}</p>
                        </div>
                        <div id="order-chart"></div>
                    </div>
                </div>
                <!-- Orders Chart Card ends -->

                <!-- Orders Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-warning p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $unactive_projects_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $unactive_projects ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.UNACTIVE_PROJECTS') }}</p>
                        </div>
                        <div id="order-chart"></div>
                    </div>
                </div>
                <!-- Orders Chart Card ends -->




                <!-- Subscribers Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $projects_done_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $projects_done ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.PROJECT_DONE') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->

                <!-- Subscribers Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $projects_in_created_case_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $projects_in_created_case ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.PROJECT_IN_CREATED_CASE') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->

                <!-- Subscribers Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $projects_in_cas1_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $projects_in_cas1 ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.PROJECT_IN_CAS1') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->


                <!-- Subscribers Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $projects_in_cas2_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $projects_in_cas2 ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.PROJECT_IN_CAS2') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->

                <!-- Subscribers Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $projects_in_cas3_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $projects_in_cas3 ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.PROJECT_IN_CAS3') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->

                <!-- Subscribers Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $projects_in_cas4_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $projects_in_cas4 ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.PROJECT_IN_CAS4') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->

                   <!-- Subscribers Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $projects_in_department2_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $projects_in_department2 ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.PROJECTS_IN_DEPARTMENT2') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->

                <!-- Subscribers Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $projects_in_department3_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $projects_in_department3 ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.PROJECTS_IN_DEPARTMENT3') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->

                <!-- Subscribers Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $projects_in_department4_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $projects_in_department4 ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.PROJECTS_IN_DEPARTMENT4') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->

                  <!-- Subscribers Chart Card starts -->
                  <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $number_of_project_positions_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $number_of_project_positions ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.NUMBER_OF_PROJECT_POSITIONS') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->

                <!-- Subscribers Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $number_of_assignment_book_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $number_of_assignment_book ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.NUMBER_OF_ASSIGNMENTS_BOOK') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->

                <!-- Subscribers Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $number_of_assignment_book_date_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $number_of_assignment_book_date ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.NUMBER_OF_ASSIGNMENTS_BOOK_DATE') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->

                <!-- Subscribers Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $number_of_assignment_book_submited_date_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $number_of_assignment_book_submited_date ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.NUMBER_OF_ASSIGNMENTS_BOOK_SUBMITED_DATE') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->


                <!-- Subscribers Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $number_of_contracts_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $number_of_contracts ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.NUMBER_OF_CONTRACTS') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->


                  <!-- Subscribers Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $number_of_signings_recieved_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $number_of_signings_recieved ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.NUMBER_OF_SIGNINGS_RECEIVED') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->

                <!-- Subscribers Chart Card starts -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card pb-3">
                        <div class="card-header flex-column align-items-start pb-0">
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <a href="{{ $number_of_work_started_route }}"><i data-feather="package" class="font-medium-5"></i></a>
                                </div>
                            </div>
                            <h2 class="fw-bolder mt-1">{{ $number_of_work_started ?? 0 }}</h2>
                            <p class="card-text">{{ __('strings.NUMBER_OF_WORK_STARTED') }}</p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <!-- Subscribers Chart Card ends -->

                @endif

            </div>
        </section>
        <!-- Dashboard Analytics end -->

    </div>
@endsection
