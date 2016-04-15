<?php $qview = 1; ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Modal title</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-xs-12">

            <?php
            if(empty($addendum_record)) { $addendumRead = ''; }
            else { $addendumRead = 'disabled'; }
            ?>

            @if (Session::has('flash_message'))
            <div class="alert {{Session::get('flash_type') }}">{{ Session::get('flash_message') }}</div>
            @endif

            @if(count($errors) > 0 )
            <div class="alert alert-danger">
             @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
            @endif



            <div class="no-padding">
              <!-- Main content -->
                <div class="">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      @if (isset($tabs_child))
                        @foreach ($tabs_child as $key => $val)
                           <li class="{{($edit_default_tabs == $val) ? 'active' : ''}}"><a href="#qv-{{$val}}" data-toggle="tab">{{$tabs[$val]}}</a></li>
                         @endforeach
                      @else
                          <li class="active"><a href="#qv-{{$default_tabs}}" data-toggle="tab">{{$tabs[$default_tabs]}}</a></li>

                      @endif
                    </ul>
                    <div class="tab-content">
                      @if (isset($tabs_child))
                        @foreach ($tabs_child as $key => $val)
                          <div class="tab-pane {{($edit_default_tabs == $val) ? 'active' : ''}}" id="qv-{{$val}}">
                            @if(strpos($val, '_plugin') > 0)
                              <?php
                                View::addNamespace('pluginform', plugins_path().$plugin);
                                echo View::make('pluginform::'.$plugin, array('data'=>$plugindata))->render();
                              ?>
                            @else
                                @include('healthcareservices::forms.' . $val)
                            @endif
                          </div><!-- /.tab-pane -->
                         @endforeach
                      @else
                         <div class="tab-pane active" id="qv-{{$default_tabs}}">
                            @include('healthcareservices::forms.' . $default_tabs)
                          </div><!-- /.tab-pane -->

                      @endif
                    </div><!-- /.tab-content -->
                  </div><!-- nav-tabs-custom -->
                </div>
            </div>
        </div><!-- /.row -->
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
@section('scripts')
<script>
    Healthcare.computeBMI();
</script>
@stop
