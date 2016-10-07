@extends('users::layouts.masterprofile')

@section('profile-content')
        @include('users::partials.user_nav')
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    @if (Session::has('message'))
                        <div class="alert alert-dismissible alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <p>{{ Session::get('message') }}</p>
                        </div>
                    @endif
                    @if (Session::has('warning'))
                        <div class="alert alert-dismissible alert-warning">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <p>{{ Session::get('warning') }}</p>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">User Information</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Profession</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Password</a></li>
                    <li><a href="#tab_4" data-toggle="tab">Settings</a></li>
                    <li><a href="#tab_5" data-toggle="tab">Role</a></li>
                </ul>
                <div class="tab-content">

                    <!-- TAB 1 -->
                    <div class="tab-pane active" id="tab_1">
                        @include('users::pages.userprofiles.user_info')
                    </div><!-- /.tab-pane -->

                    <!-- TAB 2 -->
                    <div class="tab-pane" id="tab_2">
                        @include('users::pages.userprofiles.user_background')
                    </div><!-- /.tab-pane -->

                    <!-- TAB 3 -->
                    <div class="tab-pane" id="tab_3">
                        @include('users::pages.userprofiles.change_pass')
                    </div><!-- /.tab-pane -->

                    <!-- TAB 4 -->
                    <div class="tab-pane" id="tab_4">
                        @include('users::pages.userprofiles.settings')
                    </div><!-- /.tab-pane -->

                    <!-- TAB 5 -->
                    <div class="tab-pane" id="tab_5">
                        @include('users::pages.userprofiles.userrole')
                    </div><!-- /.tab-pane -->

                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
        </div>

@stop

@section('before_validation_scripts')
{!! HTML::script('public/dist/plugins/jquery-validation/jquery.validate.min.js') !!}
{!! HTML::script('public/dist/plugins/chain/jquery.chained.min.js') !!}
{!! HTML::script('public/dist/plugins/chain/jquery.chained.remote.min.js') !!}
{!! HTML::script('public/dist/js/pages/users/userprofile.js') !!}
@stop
