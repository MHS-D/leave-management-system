@extends('backend::layout.app')

@section('title', __('strings.LEAVE_REQUESTS'))

@section('content')
    <div class="content-body">
        <section>
            <form id="form" method="POST" action="{{ isset($leave_request) ? route('leave-requests.update', $leave_request->id) : route('leave-requests.store') }}">
                @csrf
                @if (isset($leave_request))
                    @method('PUT')
                @endif

                {{-- Main Info --}}
                <div class="card">

                    <div class="card-body">
                        <div class="row">

                            <div class="col-12 col-md-6 ">
                                <div class="mb-2">
                                    <label for="start_date" class="form-label">{{ __('strings.START_DATE') }}</label>
                                    <input required  class="form-control" type="date" name="start_date"
                                        id="start_date" value="{{ $leave_request->start_date ?? '' }}" />
                                </div>
                            </div>

                            <div class="col-12 col-md-6 ">
                                <div class="mb-2">
                                    <label for="end_date" class="form-label">{{ __('strings.END_DATE') }}</label>
                                    <input required  class="form-control" type="date" name="end_date"
                                        id="end_date" value="{{ $leave_request->end_date ?? '' }}" />
                                </div>
                            </div>


                            <div class="col-12 col-md-12 note_div">
                                <div class="mb-2">
                                    <label for="type" class="form-label">{{ __('strings.REASON') }}</label>
                                    <textarea required class="form-control" name="reason" id="reason" cols="15" rows="3"> {{ $leave_request->reason ?? '' }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-primary">
                        {{ !isset($leave_request) ? __('strings.ADD_LEAVE_REQUEST') :  __('strings.UPDATE_LEAVE_REQUEST') }}
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection

@push('scripts')
    @includeIf('backend::sections.leave-requests.form_scripts')
@endpush
