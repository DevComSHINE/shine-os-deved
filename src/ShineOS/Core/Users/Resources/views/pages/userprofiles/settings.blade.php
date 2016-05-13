@section('heads')
{!! HTML::style('public/dist/plugins/summernote/summernote.css') !!}
@stop

<h4>User Settings</h4>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Prescription Settings</a></li>
    </ul>
    <div class="tab-content">

        <!-- TAB 1 -->
        <div class="tab-pane active" id="tab_1">
            {!! Form::open(array( 'url'=>$modulePath.'/updatesettings/'.$userInfo->user_id, 'class'=>'form-horizontal' )) !!}

                    <div class="form-group icheck">
                        <label for="inputPrescriptionHeader" class="col-sm-12 control-label textleft">Prescription Header</label>
                        <div class="col-sm-12">
                            <textarea id="inputPrescriptionHeader" name="prescription_header" class="textarea form-control">{{ $userInfo->prescription_header }}</textarea>
                        </div>
                        <label for="inputQRCode" class="col-sm-12 control-label textleft">QRCode</label>
                        <div class="col-sm-12">
                            <div class="checkbox-inline">
                                <label>
                                    <input type="checkbox" value="1" id="inputQRCode" name="qrcode" id="inputNonReferralNotif" @if($userInfo->qrcode == '1') checked='checked' @endif />
                                    Print QRCode in Prescription
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                    <input type="submit" class="btn btn-success pull-right"/>
                    </div>
            {!! Form::close() !!}
        </div><!-- /.tab-pane -->


    </div><!-- /.tab-content -->
</div><!-- nav-tabs-custom -->


@section('scripts')
    {!! HTML::script('public/dist/plugins/summernote/summernote.min.js') !!}
    <script>
        $('.textarea').summernote({
          height: 200,                 // set editor height
          minHeight: null,             // set minimum height of editor
          maxHeight: null,             // set maximum height of editor
          focus: true,                  // set focus to editable area after initializing summernote
          toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['table', 'picture']],
                ['misc', ['codeview', 'fullscreen']]
            ]
        });

    </script>
@stop
