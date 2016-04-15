{!! Form::open(array( 'url'=>'healthcareservices/addPostpartum',
                                'id'=>'partograph',
                                'name'=>'partograph',
                                'class'=>'form-horizontal'
                            )) !!}

<fieldset>
    <legend> Postpartum Visits </legend> 
        <div class="m_postpartumvisit col-sm-12">
            <table class="col-sm-12">
                <tbody>
                    <tr class="postpartum">
                        <td class="hidden"><input type="text" name="id[]" value="0" class="id" /></td>
                        <td class="col-sm-4">
                            <dl>
                                <dt> Trimester </dt>
                                <dd>
                                    <select class="form-control" name="postpartumTrimester[]">
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
                                    <input class="form-control" name="postpartumScheduledVisit[]" type="date"> 
                                </dd>
                            </dl>
                        </td>
                        <td class="col-sm-3">
                            <dl>
                                <dt> Actual Visit </dt>
                                <dd>  
                                    <input class="form-control" name="postpartumActualVisit[]" type="date">
                                </dd>
                            </dl>
                        </td>
                        <td class="col-sm-2">
                            <input type='button' class="deleteRow btn btn-default btn-sm" value="Delete">
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type='button' class="add btn btn-default btn-sm" value="Add">
        </div> 
</fieldset>

<fieldset>
    <legend> Micronutrient Supplementation </legend> 
        <div class="m_micronutrientsupplementation col-sm-12">
            <table class="col-sm-12">
                <tbody>
                    <tr class="postpartum">
                        <td class="hidden"><input type="text" name="id[]" value="0" class="id" /></td>
                        <td class="col-sm-4">
                            <dl>
                                <dt> Supplementation </dt>
                                <dd>
                                    <select class="form-control" name="postpartumSupplementation[]">
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
                                    <input class="form-control" name="postpartumSupplementationDateGiven[]" type="date">
                                </dd>
                            </dl>
                        </td>
                        <td class="col-sm-3">
                            <dl>
                                <dt> Quantity Dispensed </dt>
                                <dd> 
                                    <input type="number" name="postpartumSupplementationQty[]" class="form-control" > 
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
    <legend> Breastfeeding </legend> 
    <div class="col-xs-12">
        <label class="col-sm-2 control-label"> Date </label>
        <div class="col-sm-4">
            <input type="date" class="form-control" name="postpartumBreastFeedingDate"  placeholder="" value="">
        </div>
    </div><!-- /.col-12 --> 
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
        $("div.m_postpartumvisit .add").click(function () {
            id++;
            var master = $(this).parents("div.m_postpartumvisit");
            // Get a new row based on the postpartum row
            var prot = master.find(".postpartum").clone();
            prot.attr("class", "")
            prot.find(".id").attr("value", id);
            master.find("tbody").append(prot);
            console.log("m_postpartumvisit add "+id);
        });

        // Remove button functionality
        $('div.m_postpartumvisit').on("click", ".deleteRow", document.getElementById("postpartum"), function() {
           console.log("m_postpartumvisit remove "+id);
            $(this).parents("tr").remove(); 
        });


        $("div.m_micronutrientsupplementation .add").click(function () {
            id++;
            var master = $(this).parents("div.m_micronutrientsupplementation");
            // Get a new row based on the prenatal row
            var prot = master.find(".postpartum").clone();
            prot.attr("class", "")
            prot.find(".id").attr("value", id);
            master.find("tbody").append(prot);

            console.log("m_micronutrientsupplementation add "+id);
        });

        // Remove button functionality
        $('div.m_micronutrientsupplementation').on("click", ".deleteRow", document.getElementById("postpartum"), function() {
            $(this).parents("tr").remove();
            console.log("m_micronutrientsupplementation remove "+id);
        }); 
    });


</script>
@stop
