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
                <div class="card-datatable table-responsive pt-0">
                    {{ $dataTable->table([],true) }}
                </div>

                <!-- Modal to update status-->
                <div class="modal modal-slide-in fade" id="update_status_modal">
                    <div class="modal-dialog">
                        <form id="form__add-subtract-amount" class="modal-content pt-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title">{{ __('strings.UPDATE_PROJECT') }}</h5>
                            </div>
                            <div class="modal-body flex-grow-1">

                            <div class="col-12 col-md-12">
                                <div class="mb-2">
                                    <label for="type" class="form-label">{{ __('strings.STATUS') }}</label>
                                    <select required class="form-control" name="active" id="actions_select2">

                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="project_id" id="project_id">

                            <div class="col-12 col-md-12 department_list_div d-none">
                                <div class="mb-2">
                                    <label for="type" class="form-label">{{ __('strings.CHOOSE_DEPARTMENT') }}</label>
                                    <select disabled class="form-control" name="department" id="departments_list">

                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-12 note_div">
                                <div class="mb-2">
                                    <label for="type" class="form-label">{{ __('strings.NOTE') }}</label>
                                    <textarea class="form-control" name="note" id="note" cols="15" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="mb-1">
                                <label class="form-label" for="add-subtract-amount">{{ __('strings.LATEST_STATUS_DATE') }}</label>
                                <input type="text" readonly disabled class="form-control"  id="latest_status_date" />
                            </div>

                                <button type="submit" class="btn btn-primary me-1 btn-submit update_status_action">{{ __('strings.EDIT') }}</button>
                                <button type="reset" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">{{ __('strings.CANCEL') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                  <!-- Modal to update info-->
                  <div class="modal modal-slide-in fade" id="update_info_modal">
                    <div class="modal-dialog">
                        <form id="form__add-subtract-amount" class="modal-content pt-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title">{{ __('strings.ADDITIONAL_INFORMATION') }}</h5>
                            </div>
                            <div class="modal-body flex-grow-1">

                            <input type="hidden" name="project_id" id="project_id">

                            <div class="row">

                                <div class="col-12 col-md-12">
                                    <div class="mb-2">
                                        <label for="assignment_book_number" class="form-label">{{ __('strings.ASSIGNMENT_BOOK_NUMBER') }}</label>
                                        <input  class="form-control numeral-mask" type="text" name="assignment_book_number"
                                            id="assignment_book_number" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-12">
                                    <div class="mb-2">
                                        <label for="assignment_book_date" class="form-label">{{ __('strings.ASSIGNMENT_BOOK_DATE') }}</label>
                                        <input  class="form-control" type="date" name="assignment_book_date"
                                            id="assignment_book_date" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-12">
                                    <div class="mb-2">
                                        <label for="assignment_book_submition_day" class="form-label">{{ __('strings.ASSIGNMENT_BOOK_SUBMITION_DATE') }}</label>
                                        <input  class="form-control" type="date" name="assignment_book_submition_day"
                                            id="assignment_book_submition_day" />
                                    </div>
                                </div>


                                <div class="col-12 col-md-12">
                                    <div class="mb-2">
                                        <label for="contract_book_number" class="form-label">{{ __('strings.CONTRACT_BOOK_NUMBER') }}</label>
                                        <input  class="form-control numeral-mask" type="text" name="contract_book_number"
                                            id="contract_book_number" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-12">
                                    <div class="mb-2">
                                        <label for="contract_book_date" class="form-label">{{ __('strings.CONTRACT_BOOK_DATE') }}</label>
                                        <input  class="form-control" type="date" name="contract_book_date"
                                            id="contract_book_date" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-12">
                                    <div class="mb-2">
                                        <label for="signature_date" class="form-label">{{ __('strings.SIGNATURE_RECEIPT_DATE') }}</label>
                                        <input  class="form-control" type="date" name="signature_date"
                                            id="signature_date" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-12">
                                    <div class="mb-2">
                                        <label for="work_starting_date" class="form-label">{{ __('strings.WORK_STARTING_DATE') }}</label>
                                        <input  class="form-control" type="date" name="work_starting_date"
                                            id="work_starting_date" />
                                    </div>
                                </div>


                            </div>

                                <button type="submit" class="btn btn-primary me-1 btn-submit update_info_action">{{ __('strings.EDIT') }}</button>
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
    @includeIf('backend::sections.projects.scripts')
@endpush
