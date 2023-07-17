@extends('backend::layout.app')

@section('title', __('strings.PROCCESSES'))

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
                    {{ $dataTable->table() }}
                </div>

            </div>
        </section>
    </div>
@endsection


@push('scripts')
    @includeIf('backend::sections.projects.process.scripts')
@endpush
