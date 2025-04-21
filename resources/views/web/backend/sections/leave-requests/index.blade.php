@extends('backend::layout.app')

@section('title', __('strings.PROJECTS'))

@section('content')
    <div class="content-header row">
    </div>
    <div class="content-body">
        <!-- users list start -->
        <section class="app-user-list">
            <!-- list and filter start -->
            <div class="card">
                <div class="card-body border-bottom">
                    <h4 class="card-title">Search & Filter</h4>
                </div>
                <div class="card-datatable table-responsive p-1">
                    {{ $dataTable->table([],true) }}
                </div>

                <!-- Modal to update status-->
                <div class="modal modal-slide-in fade" id="update_status_modal">
                    <div class="modal-dialog">
                        <form id="form__add-subtract-amount" class="modal-content pt-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title">{{ __('strings.UPDATE_LEAVE_REQUEST') }}</h5>
                            </div>
                            <div class="modal-body flex-grow-1">

                            <div class="col-12 col-md-12">
                                <div class="mb-2">
                                    <label for="type" class="form-label">{{ __('strings.STATUS') }}</label>
                                    <select required class="form-control" name="active" id="actions_select2">

                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="request_id" id="request_id">

                            <div class="col-12 col-md-12 note_div">
                                <div class="mb-2">
                                    <label for="type" class="form-label">{{ __('strings.NOTE') }}</label>
                                    <textarea class="form-control" name="note" id="note" cols="15" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="mb-1">
                                <label class="form-label">{{ __('strings.LATEST_STATUS_DATE') }}</label>
                                <input type="text" readonly disabled class="form-control"  id="latest_status_date" />
                            </div>

                                <button type="submit" class="btn btn-primary me-1 btn-submit update_status_action">{{ __('strings.SAVE') }}</button>
                                <button type="reset" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">{{ __('strings.CANCEL') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection


@push('scripts')
    @includeIf('backend::sections.leave-requests.scripts')
@endpush
