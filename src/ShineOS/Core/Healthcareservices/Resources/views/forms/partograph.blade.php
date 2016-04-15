{!! Form::open(array( 'url'=>'healthcareservices/addPartograph',
                                'id'=>'partograph',
                                'name'=>'partograph',
                                'class'=>'form-horizontal'
                            )) !!}

<fieldset>
    <legend> Partrograph </legend> 
        <div class="col-xs-12">
            <label class="col-sm-2 control-label"> Date Examined </label>
            <div class="col-sm-4">
                <input type="date" class="form-control" name="partographDateExamined"  placeholder="" value="">
            </div>
        </div><!-- /.col-12 -->
        <div class="col-xs-12">
            <label class="col-sm-2 control-label"> Ruptured Membranes </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="rupturedMembranes"  placeholder="" value="">
            </div>
            <label class="col-sm-2 control-label"> Rapid Assessment Result </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="rapidAssessmentResult"  placeholder="" value="">
            </div>
        </div> 
</fieldset>

<fieldset>
    <legend> Partograph Entry </legend> 
        <div class="col-xs-12">
            <label class="col-sm-2 control-label"> Time Taken </label>
            <div class="col-sm-4">
                <input type="time" class="form-control" name="partographTimeTaken"  placeholder="" value="">
            </div>
            <label class="col-sm-2 control-label"> Cervical Dilation (CM) </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="cervicalDilation"  placeholder="" value="">
            </div>
        </div> <!-- /.col-12 -->
        <div class="col-xs-12">
            <label class="col-sm-2 control-label"> Fetal Station </label>
            <div class="col-sm-4">
                <select class="form-control" name="fetalStation">
                    <option value="">--select--</option>  
                    <option value="1">-2</option>
                    <option value="2">-1</option>
                    <option value="3">0</option>
                    <option value="4">+1</option>
                    <option value="5">+2</option>
                    <option value="6">+3</option>
                    <option value="7">+4</option>
                </select>
            </div>
            <label class="col-sm-2 control-label"> Amount of Bleeding </label>
            <div class="col-sm-4">
                <select class="form-control" name="amountOfBleeding">
                    <option value="">--select--</option>
                    <option value="1">0</option>
                    <option value="2">+</option>
                    <option value="3">++</option>
                    <option value="4">+++</option>
                </select>
            </div>
        </div> <!-- /.col-12 -->
        <div class="col-xs-12">
            <label class="col-sm-2 control-label"> No. of Contractions </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="numContractions"  placeholder="" value="">
            </div>
            <label class="col-sm-2 control-label"> Fetal Heart Rate per Min </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="fetalHeartRatePM"  placeholder="" value="">
            </div>
        </div> <!-- /.col-12 -->
        <div class="col-xs-12">
            <label class="col-sm-2 control-label"> Blood Pressure Diastolic/Systolic </label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="BPDiastolic"  placeholder="" value="">
            </div>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="BPSystolic"  placeholder="" value="">
            </div>
            <label class="col-sm-2 control-label"> Pulse </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="Pulse"  placeholder="" value="">
            </div>
        </div> <!-- /.col-12 -->
</fieldset>

<fieldset>
    <legend> Delivery </legend> 
        <div class="col-xs-12">
            <label class="col-sm-2 control-label"> Placenta Delivered </label>
            <div class="col-sm-4">
                <div class="radio inline">
                    <label>
                      <input type="radio" name="placentaDelivered" id="placentaDelivered" value="1" > yes
                    </label>
                </div>
                <div class="radio inline">
                    <label>
                      <input type="radio" name="placentaDelivered" id="placentaDelivered" value="0" > no
                    </label>
                </div>
            </div>
            <label class="col-sm-2 control-label"> Amniotic Fluid Characteristic </label>
            <div class="col-sm-4">
                <select class="form-control" name="amnioticFluidChar">
                    <option value="">--select--</option>
                    <option value="1">Absent</option>
                    <option value="2">Bloody</option>
                    <option value="3">Clear</option>
                    <option value="4">Meconium Stained</option>
                </select>
            </div>
        </div> <!-- /.col-12 --> 
</fieldset>

<div class="box-footer">
        {!! Form::submit('Save', ['class'=> 'btn btn-primary']) !!}
</div>
{!! Form::close() !!}