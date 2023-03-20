@extends('core/base::layouts.master')
@section('content')
    {!! Form::open(['route' => ['sso-login.settings']]) !!}
    <div class="max-width-1200">
        <div class="flexbox-annotated-section">

            <div class="flexbox-annotated-section-annotation">
                <div class="annotated-section-title pd-all-20">
                    <h2>{{ trans('plugins/sso-login::sso-login.settings.title') }}</h2>
                </div>
                <div class="annotated-section-description pd-all-20 p-none-t">
                    <p class="color-note">{{ trans('plugins/sso-login::sso-login.settings.description') }}</p>
                </div>
            </div>

            <div class="flexbox-annotated-section-content">
                <div class="wrapper-content pd-all-20">
                    <div class="form-group mb-0">
                        <input type="hidden" name="sso_login_enable" value="0">
                        <label>
                            <input type="checkbox" class="hrv-checkbox" value="1"
                                   @if (setting('sso_login_enable')) checked @endif name="sso_login_enable" id="sso_login_enable">
                            {{ trans('plugins/sso-login::sso-login.settings.enable') }}
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="text-title-field"
                               for="sso_login_button_name">{{ trans('plugins/sso-login::sso-login.settings.sso_login_button_name') }}</label>
                        <input type="text" class="next-input" name="sso_login_button_name" id="sso_login_button_name"
                               value="{{ setting('sso_login_button_name') }}">
                    </div>

                    <div class="form-group">
                        <label class="text-title-field"
                               for="sso_login_client_id">{{ trans('plugins/sso-login::sso-login.settings.callback') }}</label>
                        <input type="text" class="next-input" name="sso_login_callback" id="sso_login_callback"
                               value="{{ setting('sso_login_callback') }}">
                    </div>

                    <div class="form-group">
                        <label class="text-title-field"
                               for="sso_login_client_id">{{ trans('plugins/sso-login::sso-login.settings.clientId') }}</label>
                        <input type="text" class="next-input" name="sso_login_client_id" id="sso_login_client_id"
                               value="{{ setting('sso_login_client_id') }}">
                    </div>


                    <div class="form-group">
                            <label class="text-title-field"
                                   for="sso_login_client_secret">{{ trans('plugins/sso-login::sso-login.settings.clientSecret') }}</label>
                            <input type="password" class="next-input" name="sso_login_client_secret" id="sso_login_client_secret"
                                   value="{{ setting('sso_login_client_secret') }}">
                    </div>


                    <div class="form-group">
                        <label class="text-title-field"
                               for="sso_login_client_id">{{ trans('plugins/sso-login::sso-login.settings.authorize_endpoint') }}</label>
                        <input type="text" class="next-input" name="authorize_endpoint" id="authorize_endpoint"
                               value="{{ setting('authorize_endpoint') }}">
                    </div>

                    <div class="form-group">
                        <label class="text-title-field"
                               for="sso_login_client_id">{{ trans('plugins/sso-login::sso-login.settings.access_token_endpoint') }}</label>
                        <input type="text" class="next-input" name="access_token_endpoint" id="access_token_endpoint"
                               value="{{ setting('access_token_endpoint') }}">
                    </div>

                    <div class="form-group">
                        <label class="text-title-field"
                               for="sso_login_client_id">{{ trans('plugins/sso-login::sso-login.settings.user_info_endpoint') }}</label>
                        <input type="text" class="next-input" name="user_info_endpoint" id="user_info_endpoint"
                               value="{{ setting('user_info_endpoint') }}">
                    </div>

                    <div class="form-group">
                        <label class="text-title-field"
                               for="sso_login_redirect_after_login">{{ trans('plugins/sso-login::sso-login.settings.redirect_after_login') }}</label>
                        <input type="text" class="next-input" name="redirect_after_login" id="redirect_after_login"
                               value="{{ setting('redirect_after_login') ?? route('dashboard.index') }}">
                    </div>

                </div>


            </div>
        </div>


        <div class="flexbox-annotated-section">

            <div class="flexbox-annotated-section-annotation">
                <div class="annotated-section-title pd-all-20">
                    <h2>{{ trans('plugins/sso-login::sso-login.settings.attribute_mapping') }}</h2>
                </div>
                <div class="annotated-section-description pd-all-20 p-none-t">
                    <p class="color-note">{{ trans('plugins/sso-login::sso-login.settings.attribute_mapping_description') }}</p>
                </div>
            </div>

            <div class="flexbox-annotated-section-content">
                <div class="wrapper-content pd-all-20">
                    <div class="form-group">
                        <label class="text-title-field"
                               for="sso_first_name">{{ trans('plugins/sso-login::sso-login.settings.sso_first_name') }}</label>
                        <input type="text" class="next-input" name="sso_first_name" id="sso_first_name"
                               value="{{ setting('sso_first_name') }}">
                    </div>

                    <div class="form-group">
                        <label class="text-title-field"
                               for="sso_last_name">{{ trans('plugins/sso-login::sso-login.settings.sso_last_name') }}</label>
                        <input type="text" class="next-input" name="sso_last_name" id="sso_last_name"
                               value="{{ setting('sso_last_name') }}">
                    </div>

                    <div class="form-group">
                        <label class="text-title-field"
                               for="sso_email">{{ trans('plugins/sso-login::sso-login.settings.sso_email') }}</label>
                        <input type="text" class="next-input" name="sso_email" id="sso_email"
                               value="{{ setting('sso_email') }}">
                    </div>

                    <div class="form-group">
                    <label class="text-title-field"
                       for="sso_permission">{{ trans('plugins/sso-login::sso-login.settings.sso_permission') }}</label>
                        @php
                       $roles = app(\Botble\ACL\Repositories\Interfaces\RoleInterface::class)
                                ->select()
                                ->get()
                                ->sortByDesc('id')
                                ->pluck('name','id');

                        @endphp
                        {{ Form::select('sso_permission', $roles, setting('sso_permission')) }}
                    </div>

                </div>
            </div>
        </div>

        <div class="flexbox-annotated-section" style="border: none">
            <div class="flexbox-annotated-section-annotation">
                &nbsp;
            </div>
            <div class="flexbox-annotated-section-content">
                <button class="btn btn-info" type="submit">{{ trans('core/setting::setting.save_settings') }}</button>
            </div>
        </div>


    </div>
    {!! Form::close() !!}
@endsection
