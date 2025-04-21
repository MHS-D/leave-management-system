@extends('backend::layout.app')

@section('title', 'Users')

@section('content')
    <div class="content-header row">
    </div>
    <div class="content-body">
        <!-- users list start -->
        <section class="app-user-list">
            <div class="users-statistics"></div>

            <!-- list and filter start -->
            <div class="card">
                <div class="card-body border-bottom">
                    <h4 class="card-title">Search & Filter</h4>
                    <div class="row">
                        <div class="col-md-4 user_role"></div>
                        <div class="col-md-4 user_plan"></div>
                        <div class="col-md-4 user_status"></div>
                    </div>
                </div>
                <div class="card-datatable table-responsive pt-0">
                    {{ $dataTable->table(['class' => 'row-selection']) }}
                </div>
                <!-- Modal to add new user starts-->
                <div class="modal modal-slide-in new-user-modal fade" id="crud-modal">
                    <div class="modal-dialog">
                        <form class="add-new-user modal-content pt-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                            </div>
                            <div class="modal-body flex-grow-1">
                                {{-- First Name --}}
                                <div class="mb-1">
                                    <label class="form-label" for="first-name">{{ __('strings.FIRST_NAME') }}</label>
                                    <input type="text" class="form-control" id="first-name" name="first_name" required />
                                </div>
                                {{-- Last Name --}}
                                <div class="mb-1">
                                    <label class="form-label" for="last-name">{{ __('strings.LAST_NAME') }}</label>
                                    <input type="text" class="form-control" id="last-name" name="last_name" required />
                                </div>
                                {{-- Username --}}
                                <div class="mb-1">
                                    <label class="form-label" for="username">{{ __('strings.USERNAME') }}</label>
                                    <input type="text" id="username" class="form-control" name="username" required />
                                </div>

                                {{-- Password --}}
                                <div class="mb-1">
                                    <label class="form-label" for="password">{{ __('strings.PASSWORD') }}</label>
                                    <input type="password" id="password" class="form-control" name="password" />
                                </div>
                                {{-- Confirm Password --}}
                                <div class="mb-1">
                                    <label class="form-label" for="password-confirmation">{{ __('strings.PASSWORD_CONFIRMATION') }}</label>
                                    <input type="password" id="password-confirmation" class="form-control"
                                        name="password_confirmation" />
                                </div>

                                {{-- Status --}}
                                <div class="mb-1">
                                    <label class="form-label" for="status">{{ __('strings.STATUS') }}</label>
                                    <select id="status" class="select2 form-select" name="status" required>
                                        @foreach (App\Constants\Status::ALL as $key => $status)
                                            <option value="{{ $key }}">{{ __('strings')[$status] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Role --}}
                                <div class="mb-1" id="roles__div">
                                    <label class="form-label" for="role">{{ __('strings.ROLE') }}</label>
                                    <select id="role" class="select2 form-select" name="role">
                                        <option value="">{{ __('strings.SELECT_ROLE') }}</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ __('strings')[$role->name] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary me-1 btn-submit">{{ __('strings.SAVE') }}</button>
                                <button type="reset" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">{{ __('strings.CANCEL') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal to add new user Ends-->


                {{-- Modal notify starts --}}
          {{--       <div class="modal fade text-start" id="inlineForm" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="notification_modal_label">Notification to</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="#">
                                <div class="modal-body">
                                    <label>Name: </label>
                                    <div class="mb-1">
                                        <input readonly type="text" id="notification_reciever" class="form-control" />
                                    </div>

                                    <label>Title: </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Title" id="notification_title" class="form-control" />
                                    </div>
                                    <div class="mb-1">
                                        <label>Message: </label>

                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a comment here"
                                                id="notification_message" style="height: 100px"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-id="" data-type="" class="btn btn-primary" id="notification_send_button">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
                {{-- Modal notify ends --}}
            </div>
            <!-- list and filter end -->
        </section>
        <!-- users list ends -->

    </div>
@endsection


@push('scripts')
    @includeIf('backend::sections.users.scripts')
@endpush
