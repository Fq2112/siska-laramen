@section('title', ''.$user->name.'\'s Account Settings &ndash; Change Password | '.env('APP_TITLE'))
@extends('layouts.auth.mst_agency')
@section('inner-content')
    <div class="row" style="font-family: 'PT Sans', Arial, serif">
        <div class="to-animate col-lg-12">
            <div class="col-lg-4 text-center">
                @include('layouts.partials.auth.Agencies._form_ava-agency')
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form class="form-horizontal" role="form" method="POST"
                                  id="form-password">
                                {{ csrf_field() }}
                                {{ method_field('put') }}
                                <div class="card-content">
                                    <div class="card-title">
                                        <small>Account Settings</small>
                                        <hr class="hr-divider">
                                        <small>Primary E-mail (verified)</small>
                                        <div class="row form-group has-feedback">
                                            <div class="col-md-12">
                                                <input type="email" class="form-control"
                                                       value="{{ $user->email }}" disabled>
                                                <span class="glyphicon glyphicon-check form-control-feedback"></span>
                                            </div>
                                        </div>

                                        <small style="cursor: pointer; color: #00ADB5"
                                               id="show_password_settings">Change Password ?
                                        </small>
                                        <div id="password_settings" style="display: none">
                                            <div id="error_curr_pass"
                                                 class="row form-group has-feedback">
                                                <div class="col-md-12">
                                                    <input placeholder="Current password"
                                                           id="check_password"
                                                           type="password" class="form-control"
                                                           name="password" minlength="6" required
                                                           autofocus>
                                                    <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                                    <span class="help-block">
                                                                    <strong class="aj_pass"
                                                                            style="text-transform: none"></strong>
                                                                </span>
                                                </div>
                                            </div>

                                            <div id="error_new_pass"
                                                 class="form-group has-feedback">
                                                <div class="col-md-6">
                                                    <input placeholder="New password" id="password"
                                                           type="password" class="form-control"
                                                           name="new_password" minlength="6"
                                                           required>
                                                    <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                                    @if ($errors->has('new_password'))
                                                        <span class="help-block">
                                                                        <strong>{{ $errors->first('new_password') }}</strong>
                                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <input placeholder="Retype password"
                                                           id="password-confirm" type="password"
                                                           class="form-control"
                                                           name="password_confirmation"
                                                           minlength="6" required
                                                           onkeyup="return checkPassword()">
                                                    <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                                    <span class="help-block">
                                                                        <strong class="aj_new_pass"
                                                                                style="text-transform: none"></strong>
                                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-read-more">
                                    <button id="btn_save_password" class="btn btn-link btn-block"
                                            data-placement="bottom"
                                            data-toggle="tooltip"
                                            title="Click here to submit your changes!" disabled>
                                        <i class="fa fa-lock"></i>&nbsp;SAVE CHANGES
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('layouts.partials.auth.Agencies._scripts_auth-agency')
    @include('layouts.partials.auth.Agencies._scripts_ajax-agency')
@endpush
