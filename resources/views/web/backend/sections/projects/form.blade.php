@extends('backend::layout.app')

@section('title', __('strings.PROJECTS'))

@section('content')
    <div class="content-body">
        <section>
            <form id="form" method="POST" action="{{ isset($project) ? route('projects.update', $project->id) : route('projects.store') }}">
                @csrf
                @if (isset($project))
                    @method('PUT')
                @endif

                {{-- Main Info --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ isset($project) ?  __('strings.UPDATE_PROJECT') :  __('strings.ADD_PROJECT')  }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="name" class="form-label">{{ __('strings.PROJECT_NAME') }}</label>
                                    <input required class="form-control" type="text" name="name" id="name"
                                        value="{{ $project->name ?? '' }}" />
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="description" class="form-label">{{ __('strings.COMPANY') }}</label>
                                    <input required class="form-control" type="text" name="company" id="company" value=" {{$project->company ?? '' }}" />
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="number_of_book" class="form-label">{{ __('strings.NUMBER_OF_BOOK') }}</label>
                                    <input required  class="form-control numeral-mask" type="text" name="number_of_book"
                                        id="number_of_book" value="{{ $project->number_of_book ?? '' }}" />
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="date_of_book" class="form-label">{{ __('strings.DATE_OF_BOOK') }}</label>
                                    <input required  class="form-control" type="date" name="date_of_book"
                                        id="date_of_book" value="{{ $project->date_of_book ?? '' }}" />
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="budget" class="form-label">{{ __('strings.BUDGET') }}</label>
                                    <input required  class="form-control numeral-mask" type="text" name="budget"
                                        id="budget" value="{{ $project->budget ?? '' }}" />
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="invitation_date" class="form-label">{{ __('strings.INVITATION_DATE') }}</label>
                                    <input required  class="form-control" type="date" name="invitation_date"
                                        id="invitation_date" value="{{ $project->invitation_date ?? '' }}" />
                                </div>
                            </div>

                            <div class="col-12 col-md-12 note_div">
                                <div class="mb-2">
                                    <label for="type" class="form-label">{{ __('strings.PROJECT_POSITION') }}</label>
                                    <textarea required class="form-control" name="project_position" id="project_position" cols="15" rows="3"> {{ $project->project_position ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="status" class="form-label">{{ __('strings.PROCESS') }}</label>
                                    <select required class="form-control" name="status" id="status">
                                        @foreach ($statuses as $key => $status)
                                            <option {{ isset($project) ? ($project->status == $key ? 'selected' : '') : '' }}
                                                value="{{ $key }}">{{ __('strings')[$status] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="type" class="form-label">{{ __('strings.STATUS') }}</label>
                                    <select required  class="form-control" name="active" id="active">
                                        @foreach ($types as $key => $type)
                                            <option {{ isset($project) ? ($project->active == $key ? 'selected' : '') : '' }}
                                                value="{{ $key }}">{{ __('strings')[$type] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Additional information --}}
                @isset($project)

                    @if (in_array($project->status, [$project_status::FOUR_INPROGRESS, $project_status::FOUR_DONE]))
                        <div class="card ">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('strings.ADDITIONAL_INFORMATION')  }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-12 col-md-6">
                                        <div class="mb-2">
                                            <label for="assignment_book_number" class="form-label">{{ __('strings.ASSIGNMENT_BOOK_NUMBER') }}</label>
                                            <input  class="form-control numeral-mask" type="text" name="assignment_book_number"
                                                id="assignment_book_number" value="{{ $project->assignment_book_number ?? '' }}" />
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="mb-2">
                                            <label for="assignment_book_date" class="form-label">{{ __('strings.ASSIGNMENT_BOOK_DATE') }}</label>
                                            <input  class="form-control" type="date" name="assignment_book_date"
                                                id="assignment_book_date" value="{{ $project->assignment_book_date ?? '' }}" />
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="mb-2">
                                            <label for="assignment_book_submition_day" class="form-label">{{ __('strings.ASSIGNMENT_BOOK_SUBMITION_DATE') }}</label>
                                            <input  class="form-control" type="date" name="assignment_book_submition_day"
                                                id="assignment_book_submition_day" value="{{ $project->assignment_book_submition_day ?? '' }}" />
                                        </div>
                                    </div>


                                    <div class="col-12 col-md-6">
                                        <div class="mb-2">
                                            <label for="contract_book_number" class="form-label">{{ __('strings.CONTRACT_BOOK_NUMBER') }}</label>
                                            <input  class="form-control numeral-mask" type="text" name="contract_book_number"
                                                id="contract_book_number" value="{{ $project->contract_book_number ?? '' }}" />
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="mb-2">
                                            <label for="contract_book_date" class="form-label">{{ __('strings.CONTRACT_BOOK_DATE') }}</label>
                                            <input  class="form-control" type="date" name="contract_book_date"
                                                id="contract_book_date" value="{{ $project->contract_book_date ?? '' }}" />
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="mb-2">
                                            <label for="signature_date" class="form-label">{{ __('strings.SIGNATURE_RECEIPT_DATE') }}</label>
                                            <input  class="form-control" type="date" name="signature_date"
                                                id="signature_date" value="{{ $project->signature_date ?? '' }}" />
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="mb-2">
                                            <label for="work_starting_date" class="form-label">{{ __('strings.WORK_STARTING_DATE') }}</label>
                                            <input  class="form-control" type="date" name="work_starting_date"
                                                id="work_starting_date" value="{{ $project->work_starting_date ?? '' }}" />
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    @endif

                @endisset

                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($project) ? __('strings.UPDATE_PROJECT') :  __('strings.ADD_PROJECT') }}
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection

@push('scripts')
    @includeIf('backend::sections.projects.form_scripts')
@endpush
