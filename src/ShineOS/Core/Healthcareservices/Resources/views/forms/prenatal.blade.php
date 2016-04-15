{!! Form::open(array( 'url'=>'healthcareservices/addPrenatal',
                                'id'=>'prenatal',
                                'name'=>'prenatal',
                                'class'=>'form-horizontal'
                            )) !!}

<fieldset>
    <legend> Prenatal </legend>
    <div class="form-group">
        <div class="col-xs-12">
            <label class="col-sm-2 control-label"> Last Menstruation Period (LMP) </label>
            <div class="col-sm-4"> 
                <input class="form-control" name="lastMenstruationPeriod" type="date"> 
            </div>
            <label class="col-sm-2 control-label"> Estimated Date of Delivery (EDD) </label>
            <div class="col-sm-4"> 
                <input class="form-control" name="estimatedDateDelivery" type="date"> 
            </div>
        </div><!-- /.col-12 -->
        <div class="col-xs-12">
            <label class="col-sm-2 control-label"> Gravidity </label>
            <div class="col-sm-4">
                <input type="text" name="gravidity" class="form-control" name=""  placeholder="" value="">
            </div>
            <label class="col-sm-2 control-label"> Parity </label>
            <div class="col-sm-4">
                <input type="text" name="parity" class="form-control" name=""  placeholder="" value="">
            </div>
        </div>
        <div class="col-xs-12">
            <label class="col-sm-2 control-label"> Term </label>
            <div class="col-sm-4">
                <input type="text" name="term" class="form-control" name=""  placeholder="" value="">
            </div>
            <label class="col-sm-2 control-label"> Pre-Term </label>
            <div class="col-sm-4">
                <input type="text" name="preterm" class="form-control" name=""  placeholder="" value="">
            </div>
        </div>
        <div class="col-xs-12">
            <label class="col-sm-2 control-label"> Abortion </label>
            <div class="col-sm-4">
                <input type="text" name="abortion" class="form-control" name=""  placeholder="" value="">
            </div>
            <label class="col-sm-2 control-label"> Living </label>
            <div class="col-sm-4">
                <input type="text" name="living" class="form-control" name=""  placeholder="" value="">
            </div>
        </div>
    </div>
</fieldset>

<fieldset>
    <legend> Prenatal Visits </legend> 
        <div class="m_prenatalvisit col-sm-12">
            <table class="col-sm-12">
                <tbody>
                    <tr class="prenatal">
                        <td class="hidden"><input type="text" name="id[]" value="0" class="id" /></td>
                        <td class="col-sm-4">
                            <dl>
                                <dt> Trimester </dt>
                                <dd>
                                    <select class="form-control" name="prenatalTrimester[]">
                                        <option disabled="" selected=""> -- Select -- </option>
                                        <option value="1">First</option>
                                        <option value="2">Second</option>
                                        <option value="3">Third</option>
                                    </select>
                                </dd>
                            </dl>
                        </td>
                        <td class="col-sm-3">
                            <dl>
                                <dt> Scheduled Visit </dt>
                                <dd>  
                                    <input class="form-control" name="prenatalScheduledVisit[]" type="date"> 
                                </dd>
                            </dl>
                        </td>
                        <td class="col-sm-3">
                            <dl>
                                <dt> Actual Visit </dt>
                                <dd>  
                                    <input class="form-control" name="prenatalActualVisit[]" type="date">
                                </dd>
                            </dl>
                        </td>
                        <td class="col-sm-2">
                            <input type='button' class="deleteRow btn btn-default btn-sm" value="Delete">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="col-sm-12">
                <input type='button' class="add btn btn-default btn-sm" value="Add">
            </div>
        </div> 
</fieldset>

<fieldset>
    <legend> Tetanus Toxoid Vaccination </legend> 
        <div class="m_prenataltetanus col-sm-12">
            <table class="col-sm-12">
                <tbody>
                    <tr class="prenatal">
                        <td class="hidden"><input type="text" name="id[]" value="0" class="id" /></td>
                        <td class="col-sm-4">
                            <dl>
                                <dt> Tetanus </dt>
                                <dd>
                                    <select class="form-control" name="prenatalTetanus">
                                        <option disabled="" selected=""> -- Select -- </option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </dd>
                            </dl>
                        </td>
                        <td class="col-sm-3">
                            <dl>
                                <dt> Scheduled Visit </dt>
                                <dd>  
                                    <input class="form-control" name="prenatalTetanusScheduledVisit[]" type="date"> 
                                </dd>
                            </dl>
                        </td>
                        <td class="col-sm-3">
                            <dl>
                                <dt> Actual Visit </dt>
                                <dd> 
                                    <input class="form-control" name="prenatalTetanusActualVisit[]" type="date"> 
                                </dd>
                            </dl>
                        </td>
                        <td class="col-sm-2">
                            <input type='button' class="deleteRow btn btn-default btn-sm" value="Delete">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="col-sm-12">
                <input type='button' class="add btn btn-default btn-sm" value="Add">
            </div>
        </div> 
</fieldset>

<fieldset>
    <legend> Micronutrient Supplementation </legend> 
        <div class="m_micronutrientsupplementation col-sm-12">
            <table class="col-sm-12">
                <tbody>
                    <tr class="prenatal">
                        <td class="hidden"><input type="text" name="id[]" value="0" class="id" /></td>
                        <td class="col-sm-4">
                            <dl>
                                <dt> Supplementation </dt>
                                <dd>
                                    <select class="form-control" name="prenatalSupplementation[]">
                                        <option disabled="" selected=""> -- Select -- </option>
                                        <option value="1">Vitamin A</option>
                                        <option value="2">Iron with Folic Acid</option>
                                    </select>
                                </dd>
                            </dl>
                        </td>
                        <td class="col-sm-3">
                            <dl>
                                <dt> Date Given </dt>
                                <dd>  
                                    <input class="form-control" name="prenatalSupplementationDateGiven[]" type="date">
                                </dd>
                            </dl>
                        </td>
                        <td class="col-sm-3">
                            <dl>
                                <dt> Quantity Dispensed </dt>
                                <dd> 
                                    <input type="number" name="prenatalSupplementationQty[]" class="form-control" > 
                                </dd>
                            </dl>
                        </td>
                        <td class="col-sm-2">
                            <input type='button' class="deleteRow btn btn-default btn-sm" value="Delete">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="col-sm-12">
                <input type='button' class="add btn btn-default btn-sm" value="Add">
            </div>
            
        </div> 
</fieldset>

<div class="box-footer">
        {!! Form::submit('Save', ['class'=> 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}


@section('scripts') 
<script type="text/javascript">
    $(document).ready(function () {
        var id = 0;
        // Add button functionality
        $("div.m_prenatalvisit .add").click(function () {
            id++;
            var master = $(this).parents("div.m_prenatalvisit");
            // Get a new row based on the prenatal row
            var prot = master.find(".prenatal").clone();
            prot.attr("class", "")
            prot.find(".id").attr("value", id);
            master.find("tbody").append(prot);
            console.log("m_prenatalvisit add "+id);
        });

        // Remove button functionality
        $('div.m_prenatalvisit').on("click", ".deleteRow", document.getElementById("prenatal"), function() {
           console.log("m_prenatalvisit remove "+id);
            $(this).parents("tr").remove(); 
        });


        $("div.m_prenataltetanus .add").click(function () {
            id++;
            var master = $(this).parents("div.m_prenataltetanus");
            // Get a new row based on the prenatal row
            var prot = master.find(".prenatal").clone();
            prot.attr("class", "")
            prot.find(".id").attr("value", id);
            master.find("tbody").append(prot);

            console.log("m_prenataltetanus add "+id);
        });

        // Remove button functionality
        $('div.m_prenataltetanus').on("click", ".deleteRow", document.getElementById("prenatal"), function() {
            $(this).parents("tr").remove();
            console.log("m_prenataltetanus remove "+id);
        });

        $("div.m_micronutrientsupplementation .add").click(function () {
            id++;
            var master = $(this).parents("div.m_micronutrientsupplementation");
            // Get a new row based on the prenatal row
            var prot = master.find(".prenatal").clone();
            prot.attr("class", "")
            prot.find(".id").attr("value", id);
            master.find("tbody").append(prot);

            console.log("m_micronutrientsupplementation add "+id);
        });

        // Remove button functionality
        $('div.m_micronutrientsupplementation').on("click", ".deleteRow", document.getElementById("prenatal"), function() {
            $(this).parents("tr").remove();
            console.log("m_micronutrientsupplementation remove "+id);
        }); 
    });

</script>
@stop
