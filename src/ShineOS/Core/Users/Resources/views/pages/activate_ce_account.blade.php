{!! Form::open(array( 'url'=>'activateaccount/activatece/', 'id'=>'crudForm', 'name'=>'crudForm', 'class'=>'form-horizontal', 'enctype'=>'multipart/form-data' )) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myInfoModalLabel"> <i class="fa fa-lock text-info"></i> Activation </h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12 top10 bottom10">
                <h3 class="text-danger">SHINEOS+ Community Edition Activation</h3>

                <p>Please check your email for your activation file. Download the file to your computer. Then upload your activation file here to activate your Community Edition.</p>

                <div class="form-group">
                    <input type="file" placeholder="Activation File" class="" id="activation_code" value="" name="activation_code" />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="submit" name="Activate" id="Activate" class="btn btn-success" value="Activate" />
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
{!! Form::close() !!}
