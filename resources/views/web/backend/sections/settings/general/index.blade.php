@extends('backend::layout.app')

@section('title', 'Settings')

@section('content')
    <div class="content-body">
        <section>
            <form id="settings__form" action="{{ route('settings.update') }}">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Transactions</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="transactions__system-percentage" class="form-label">System Percentage
                                        (%)</label>
                                    <input class="form-control" type="number" min="0" max="100"
                                        name="transactions_system_percentage" step="0.1" placeholder="2.5"
                                        id="transactions__system-percentage"
                                        value="{{ $settings['transactions_system_percentage'] }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Offers</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="offers__default-minimum-days" class="form-label">Default Minimum
                                        Days</label>
                                    <input class="form-control numeral-mask" type="text"
                                        name="offers_default_minimum_days" placeholder="33"
                                        id="offers__default-minimum-days"
                                        value="{{ $settings['offers_default_minimum_days'] }}" />
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="offers__default-minimum-balance" class="form-label">Default Minimum
                                        Balance</label>
                                    <input class="form-control numeral-mask" type="text"
                                        name="offers_default_minimum_balance" placeholder="10000"
                                        id="offers__default-minimum-balance"
                                        value="{{ $settings['offers_default_minimum_balance'] }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="offers__dynamic-minimum-days" class="form-label">Dynamic Minimum
                                        Days</label>
                                    <input class="form-control numeral-mask" type="text"
                                        name="offers_dynamic_minimum_days" placeholder="33"
                                        id="offers__dynamic-minimum-days"
                                        value="{{ $settings['offers_dynamic_minimum_days'] }}" />
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="offers__dynamic-minimum-balance" class="form-label">Dynamic Minimum
                                        Balance</label>
                                    <input class="form-control numeral-mask" type="text"
                                        name="offers_dynamic_minimum_balance" placeholder="10000"
                                        id="offers__dynamic-minimum-balance"
                                        value="{{ $settings['offers_dynamic_minimum_balance'] }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Followers</h4>
                    </div>
                    <div class="card-body">
                        {{--      <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="invitations__first-level--max-number" class="form-label">[First Level] Max invitations number</label>
                                    <input class="form-control numeral-mask" type="text"
                                        name="invitations_first_level_max_number" placeholder="10"
                                        id="invitations__first-level--max-number"
                                        value="{{ $settings['invitations_first_level_max_number'] }}" />
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="invitations__second-level--max-number" class="form-label">[Second Level] Max invitations number</label>
                                    <input class="form-control numeral-mask" type="text"
                                        name="invitations_second_level_max_number" placeholder="10"
                                        id="invitations__second-level--max-number"
                                        value="{{ $settings['invitations_second_level_max_number'] }}" />
                                </div>
                            </div>

                        </div> --}}

                        <div class="row">

                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="invitations__first-level--commission-amount" class="form-label">[First
                                        Level] Commission Amount</label>
                                    <input class="form-control numeral-mask" type="text"
                                        name="invitations_first_level_commission_amount" placeholder="2.5"
                                        id="invitations__first-level--commission-amount"
                                        value="{{ $settings['invitations_first_level_commission_amount'] }}" />
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="invitations__second-level--commission-amount" class="form-label">[Second
                                        Level] Commission Amount</label>
                                    <input class="form-control numeral-mask" type="text"
                                        name="invitations_second_level_commission_amount" placeholder="2.5"
                                        id="invitations__second-level--commission-amount"
                                        value="{{ $settings['invitations_second_level_commission_amount'] }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Subscriptions</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="offers-subscriptions__payment_days" class="form-label">Payment every (days)</label>
                                    <input class="form-control numeral-mask" type="text"
                                        name="offers_subscriptions_payment_days" placeholder="33"
                                        id="offers-subscriptions__payment_days"
                                        value="{{ $settings['offers_subscriptions_payment_days'] }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </section>
    </div>
@endsection

@push('scripts')
    @include('backend::sections.settings.general.scripts')
@endpush
