@extends('extensions::index')
@section('header-content') Installed Extensions @stop
@section('list-content')

<div class="row icheck" id="extensions">
    <div class="col-xs-12">
        <div class="nav-tabs-custom main-tabs">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#modules" data-toggle="tab">Modules</a></li>
                <li><a href="#plugins" data-toggle="tab">Plugins</a></li>
                <li class="btn btn-primary hidden" onclick="location.href='{{ url('extensions/add') }}';">Add New</li>
            </ul>
            <div class="tab-content">
                @if(Session::has('message'))
                  <p class="alert {{ Session::get('alert-class', 'alert-info alert-dismissible') }}">{{ Session::get('message') }}</p>
                @endif
                <div class="tab-pane active" id="modules">
                    <h4>Installed Modules</h4>
                    {!! Form::open(array('url' => 'extensions/update', 'name'=>'settingsForm', 'class'=>'form-horizontal')) !!}
                    <table class="table tdtop">
                        <thead>
                        <tr>
                            <td width="15">&nbsp;</td>
                            <td width="300">Module Name</td>
                            <td>Description</td>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($mods as $c=>$m)

                            <?php if($m['mod_active'] == 0):
                                $enabled = "";
                                $but_name = "activate";
                                $but_title = "Activate";
                                $but_color = "btn-success";
                            else:
                                $enabled = 'checked="checked"';
                                $but_name = "deactivate";
                                $but_title = "Deactivate";
                                $but_color = "btn-warning";
                            endif;
                            ?>

                            <tr>
                                <input type="hidden" name="type" value="modules" />
                                <td width="15" valign="top"><input type="checkbox" disabled {{ $enabled }} /></td>
                                <td width="300" valign="top">
                                    <strong>{{ $m['mod_title'] }}</strong>
                                    <br clear="all" />
                                    <div class="btn-group" style="margin-top:5px;">
                                        <input type="submit" name="action[{{ $c }}]" class="btn {{ $but_color }} btn-xs" value="{{ $but_title }}" /> <input type="submit" name="delete" class="btn btn-danger btn-xs" value="Delete" />
                                    </div>
                                </td>
                                <td valign="top">
                                    {{ $m['mod_description'] }}
                                    <p>
                                        @if(isset($m['mod_version'])) {{ $m['mod_version'] }}@endif
                                        @if(isset($m['mod_developer'])) | <a href='http://{{ $m['mod_url'] }}'>{{ $m['mod_developer'] }}</a>@endif
                                         | <a href="#">View Info</a>
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                    {!! Form::close() !!}
                </div>

                <div class="tab-pane" id="plugins">
                    <h4>Installed Plugins</h4>
                    {!! Form::open(array('url' => 'extensions/update', 'name'=>'settingsForm', 'class'=>'form-horizontal')) !!}
                    <table class="table tdtop">
                        <thead>
                        <tr>
                            <td width="15">&nbsp;</td>
                            <td width="300">Plugin Name</td>
                            <td width="70">Module</td>
                            <td>Description</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($plugins as $p)

                        <?php if($p['plugin_active'] == 0):
                            $enabled = "";
                            $but_name = "activate";
                            $but_title = "Activate";
                            $but_color = "btn-success";
                        else:
                            $enabled = 'checked="checked"';
                            $but_name = "deactivate";
                            $but_title = "Deactivate";
                            $but_color = "btn-warning";
                        endif;
                        ?>
                        <input type="hidden" name="type" value="plugins" />
                        <tr>
                            <td width="15" valign="top"><input type="checkbox" disabled {{ $enabled }} name="{{ $p['plugin'] }}"></td>
                            <td width="300" valign="top">
                                <strong>{{ $p['plugin_title'] }}</strong>
                                <br clear="all" />
                                    <div class="btn-group" style="margin-top:5px;">
                                        <input type="submit" name="action[{{ $p['plugin'] }}]" class="btn {{ $but_color }} btn-xs" value="{{ $but_title }}" /> <input type="submit" name="delete" class="btn btn-danger btn-xs" value="Delete" />
                                    </div>
                            </td>
                            <td width="60" valign="top">{{ $p['plugin_module'] }}</td>
                            <td valign="top">
                                {{ $p['plugin_description'] }}
                                <p>
                                    @if(isset($p['plugin_version'])) {{ $p['plugin_version'] }}@endif
                                    @if(isset($p['plugin_developer'])) | <a href='http://{{ $p['plugin_url'] }}'>{{ $p['plugin_developer'] }}</a>@endif
                                     | <a href="#">View Info</a>
                                </p>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
</div>
@stop
