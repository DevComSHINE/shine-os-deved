
var url = '/healthcareservices/add';
var Healthcare = {};

function firedate(el)
{
    $(el).daterangepicker({
        singleDatePicker: true,
        showDropdowns: true
    });
    $(el).inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
}

Healthcare.init = function () {
   $('#healthcare_services').on('change', function () {
        if($(this).val() == 'GeneralConsultation') {
            $('#medicalcategory').removeClass("hidden");
        } else {
            $('#medicalcategory').addClass("hidden");
        }
   });
  $('#consuTypeNewAdmit').on('click', function () {
        $('#inPatient').addClass("active");
        $('#inPatient input').attr("checked","checked");
        $('#outPatient').removeClass("active");
        $('#outPatient input').removeAttr("checked");
   });
  $('#consuTypeNewConsu').on('click', function () {
        $('#inPatient').removeClass("active");
        $('#inPatient input').removeAttr("checked");
        $('#outPatient').addClass("active");
        $('#outPatient input').attr("checked","checked");
   });
  $('#consuTypeFollow').on('click', function () {
        $('#inPatient').removeClass("active");
        $('#inPatient input').removeAttr("checked");
        $('#outPatient').addClass("active");
        $('#outPatient input').attr("checked","checked");
   });
  $("#diag_cat").remoteChained({
     parents : "#diag_parent",
     url : baseurl+"/lov/api/diagnosis/category",
     loading : "Loading . . ."
  });

  $("#diag_subcat").remoteChained({
      parents : "#diag_cat",
      url : baseurl+"/lov/api/diagnosis/subCat",
      loading : "Loading . . ."
  });

  $("#diag_subsubcat").remoteChained({
    parents : "#diag_subcat",
    url : baseurl+"/lov/api/diagnosis/subsubCat",
    loading : "Loading . . ."
  });
  $('#OT').on('ifChecked', function(event){
        $("#labOthers").removeClass("hidden");
  });
  $('#OT').on('ifUnchecked', function(event){
        $("#labOthers").addClass("hidden");
  });

   Healthcare.computeBMI();
   Healthcare.impAndDIag();
   Healthcare.medOrder();

   if($('.diagnosis_input').length>0) {
       $('.diagnosis_input').autocomplete({
            source: availableTags
       });
    }

   if(!$('#prescriptionTab.hidden').length) {
       //remove laboratory in selection
       $('#medorders').find('[value="MO_MED_PRESCRIPTION"]').remove();
   }
   if(!$('#procedureTab.hidden').length) {
       //remove others in selection
       $('#medorders').find('[value="MO_PROCEDURE"]').remove();
   }
   if(!$('#labTab.hidden').length) {
       //remove laboratory in selection
       $('#medorders').find('[value="MO_LAB_TEST"]').remove();
   }
   if(!$('#otherTab.hidden').length) {
       //remove others in selection
       $('#medorders').find('[value="MO_OTHERS"]').remove();
   }

}

Healthcare.diagAutoComplete = function () {
    var c = 0;
    var diagnosisforms = $('.diagnosis_input');
    diagnosisforms.each(function() {
        $( "#diagnosis_input"+c ).autocomplete({
            source: availableTags
        });
        c++;
    })
}

Healthcare.procedureAutoComplete = function () {
    var c = 0;
    var procforms = $('.procedure_input');
    procforms.each(function() {
        $( ".procedure_input" ).autocomplete({
            source: availableProcedures
        });
        c++;
    })
}

Healthcare.fireDiagAutoComplete = function()
{
    var diagnosisforms = $('.diagnosis_input');
    $( ".diagnosis_input" ).autocomplete({
        source: availableTags
    });
}
Healthcare.fireProcedureAutoComplete = function(id)
{
    var procforms = $('.procedure_input');
    procforms.each(function() {
        console.log("id "+id);
        $( "#procedure_input"+id).autocomplete({
            source: availableProcedures
        });
    })
}

Healthcare.computeBMI = function () {
    if($('input[name="height"]').val() != '' && $('input[name="weight"]').val() != '') {
        var weight = $('input[name="weight"]').val();
        var height = $('input[name="height"]').val();
        var bmi = weight / (height / 100 * height / 100);
        bmi = Math.round(bmi * 100) / 100;
        $('p.bmiResult').text(isNaN(bmi) ? '' : bmi);
        //$('input[name=bmi]').val(isNaN(bmi) ? '' : bmi);

        if(bmi < 18.5) {
            $(".weightStat").html("<p class='bmi_result control-label'>Patient is Underweight.</p>");
        }
        if(bmi >= 18.5 && bmi < 25) {
            $(".weightStat").html("<p class='bmi_result control-label'>Patient is Normal.</p>");
        }
        if(bmi >= 25 && bmi < 30) {
            $(".weightStat").html("<p class='bmi_result control-label'>Patient is Overweight.</p>");
        }
        if(bmi >= 30) {
            $(".weightStat").html("<p class='bmi_result control-label'>Patient is Obese</p>");
        }
    }

    $('input[name="height"], input[name="weight"]').on('keyup keydown keypress click change', function () {
        var weight = $('input[name="weight"]').val();
        var height = $('input[name="height"]').val();
        var bmi = weight / (height / 100 * height / 100);
        bmi = Math.round(bmi * 100) / 100;
        $('p.bmiResult').text(isNaN(bmi) ? '' : bmi);
        //$('input[name=bmi]').val(isNaN(bmi) ? '' : bmi);

        if(bmi < 18.5) {
            $(".weightStat").html("<p class='bmi_result control-label'>Patient is Underweight.</p>");
        }
        if(bmi >= 18.5 && bmi < 25) {
            $(".weightStat").html("<p class='bmi_result control-label'>Patient is Normal.</p>");
        }
        if(bmi >= 25 && bmi < 30) {
            $(".weightStat").html("<p class='bmi_result control-label'>Patient is Overweight.</p>");
        }
        if(bmi >= 30) {
            $(".weightStat").html("<p class='bmi_result control-label'>Patient is Obese</p>");
        }
    });
}

Healthcare.impAndDIag = function () {
  var count = 0;
  //let us count all forms
  count = $('.diagnosis_input').length - 1;
  if (count>0)  $('.deleteRow').removeAttr('disabled');
  else $('.deleteRow').attr('disabled', 'disabled');

  $("select[id=diagnosisType]").on('change', function() {
    var value = $.trim( this.value );
    // console.log('value '+value);

    if(this.value == 'FINDX') {
      $("#FinalDiagnosis").removeClass("hidden");
      $("option[value='FINDX']").addClass("hidden");
      $(".addRow").addClass("hidden");
    } else {
      $("#FinalDiagnosis").addClass("hidden");
      $("option[value='FINDX']").removeClass("hidden");
      $(".addRow").removeClass("hidden");
    }
  });

  $('.addRow').click(function() {
        //remove autocomplete first
        $('.diagnosis_input').autocomplete('destroy');
        var $clone = $('.impanddiag:eq(0)').clone(true);
        $clone.find('.form-control').val("");
        $clone.find('input[type=hidden]').val("");
        $clone.find('div.active').hide().removeClass('active');
        console.log('count '+count);
        var idcounter = ++count;
        $clone.attr('id', "added"+idcounter);
        $('.impanddiag').last().after($clone);
        $clone.find('.deleteRow').removeClass('hidden');
        $('.deleteRow').removeAttr('disabled');
        $clone.find('.diagnosis_input').attr('id','diagnosis_input'+idcounter);
        //reinit autocomplete
        Healthcare.fireDiagAutoComplete();
  });

  $('.deleteRow').click(function(){
    $('#added'+(count--)).remove();
    if (count>0)  $('.deleteRow').removeAttr('disabled');
    else $('.deleteRow').attr('disabled', 'disabled');
    $("#FinalDiagnosis").addClass("hidden");
    $(".addRow").removeClass("hidden");
  });

}

function prescriptionEdit() {

    $(".prescription_edit").click(function(){

        $('.prescription_group input[name=PrescriptionMedID]').val($(this).parents('.medical_prescription_item').find('input.prescid').val());
        $('.prescription_group #drug_input').val($(this).parents('.medical_prescription_item').find('input.dcode').val());
        $('.prescription_group input[name=Drug_Brand_Name]').val($(this).parents('.medical_prescription_item').find('input.brand').val());
        $('.prescription_group input[name=Dose_Qty]').val($(this).parents('.medical_prescription_item').find('input.dqty').val());
        $('.prescription_group select[name=Dose_UOM]').val($(this).parents('.medical_prescription_item').find('input.dqtyoum').val());
        $('.prescription_group input[name=Total_Quantity]').val($(this).parents('.medical_prescription_item').find('input.TQ').val());
        $('.prescription_group select[name=Total_Quantity_UOM]').val($(this).parents('.medical_prescription_item').find('input.TQuom').val());
        $('.prescription_group select[name=dosage]').val($(this).parents('.medical_prescription_item').find('input.regimen').val());
        $('.prescription_group input[name=Duration_Intake]').val($(this).parents('.medical_prescription_item').find('input.di').val());
        $('.prescription_group select[name=Duration_Intake_Freq]').val($(this).parents('.medical_prescription_item').find('input.dio').val());

        if($(this).parents('.medical_prescription_item').find('input.dio').val() == 'OTH'){
            $('#forregimenothers').removeClass('hidden');
            $('.prescription_group input[name=Specify]').val($(this).parents('.medical_prescription_item').find('input.regimenothers').val())
        }

        if($(this).parents('.medical_prescription_item').find('input.dio').val() == 'O'){
            $('#forintakeothers').removeClass('hidden');
            $('.prescription_group input[name=IntakeOther]').val($(this).parents('.medical_prescription_item').find('input.intakeothers').val())
        }
        if($(this).parents('.medical_prescription_item').find('input.dio').val() != 'C'){
            $('#regimen_range').removeClass('hidden');
            $('.prescription_group select#daterangepicker').val($(this).parents('.medical_prescription_item').find('input.regimen_dates').val())
        }
        //remove the listed prescription
        $(this).parents(".medical_prescription_item").remove();

        var newPrescCount = $('.medical_prescription_item.added').length;

        if(newPrescCount == 0) {
            $(".printPrescription").addClass('hidden');
        }
    })
}
function procedureEdit() {
    $(".procedure_edit").click(function(){

        $('.procedure_group input[name=ProcedureMedID]').val($(this).parents('.medical_procedure_item').find('input.procid').val());
        $('.procedure_group #procedure_input').val($(this).parents('.medical_procedure_item').find('input.procorder').val());
        $('.procedure_group #datepicker_future').val($(this).parents('.medical_procedure_item').find('input.procdate').val());
        $('.procedure_group input[name=Procedure_Remarks]').val($(this).parents('.medical_procedure_item').find('input.procinstruct').val());

        //remove the listed prescription
        $(this).parents(".medical_procedure_item").remove();

    })
}
function removePrescriptionTab() {
    $('a.removePrescriptionTab').click(function(){
        $('#medorders').append('<option value="MO_MED_PRESCRIPTION">Give Medical Prescription</option>');
        $('.medicalOrders .nav-tabs li.prescTab').addClass('hidden');
        $('#prescriptionTab').addClass('hidden');

        var pitems = $('.medical_prescription_item.added');
        if( pitems.length > 0) {
            pitems.each(function(){
                var id = $(this).find("input.remid").val();
                var mid = $(this).find("input.medid").val();
                $(this).html('<input type="hidden" name="delete[type][]" value="MO_MED_PRESCRIPTION" /><input type="hidden" name="delete[MO_MED_PRESCRIPTION][medicalorder_id][]" value="'+mid+'" /><input type="hidden" name="delete[MO_MED_PRESCRIPTION][medicalorderprescription_id][]" value="'+id+'" />').addClass('removed').removeClass("added");
            })
        }
        $('#prescriptionTab textarea.instructions').html("");
        $('#prescriptionTab').find('.form-control').val("");

    })
}
function removeProcedureTab() {
    $('a.removeProcedureTab').click(function(){
        $('#medorders').append('<option value="MO_PROCEDURE">Medical Procedure</option>');
        $('.medicalOrders .nav-tabs li.procTab').addClass('hidden');
        $('#procedureTab').addClass('hidden');

        var pitems = $('.medical_procedure_item.added');
        if( pitems.length > 0) {
            pitems.each(function(){
                var id = $(this).find("input.remid").val();
                var mid = $(this).find("input.medid").val();
                $(this).html('<input name="delete[type][]" value="MO_PROCEDURE" type="hidden"><input type="hidden" name="delete[MO_PROCEDURE][medicalorder_id][]" value="'+mid+'" /><input type="hidden" name="delete[MO_PROCEDURE][medicalorderprocedure_id][]" value="'+id+'" />').addClass('removed').removeClass("added");
            })
        }
        $('#procedureTab textarea.instructions').html("");
        $('#procedureTab').find('.form-control').val("");

    })
}
function removeLaboratoryTab() {
    $('a.removeLaboratoryTab').click(function(){
        $('#medorders').append('<option value="MO_LAB_TEST">Laboratory Exam</option>');
        $('.medicalOrders .nav-tabs li.labTab').addClass('hidden');
        $('#labTab').addClass('hidden');

        $('#labTab textarea.instructions').remove();
        $('#labTab').find('.form-control').val("");
        $('#labTab').find('.form-control').removeAttr("checked");
        $('#labTab').find('.form-control').html("");

    })
}
function removeOtherTab() {
    $('a.removeOtherTab').click(function(){
        $('#medorders').append('<option value="MO_OTHER">Specify Other</option>');
        $('.medicalOrders .nav-tabs li.otherTab').addClass('hidden');
        $('#otherTab').addClass('hidden');

        $('#otherTab textarea.instructions').html("");
        $('#otherTab').find('.form-control').val("");
        $('#otherTab').find('.form-control').html("");

    })
}

function lessPresc()
{
    $(".prescription_less").click(function(){
        var id = $(this).parents(".medical_prescription_item").find("input.remid").val();

        $(this).parents(".medical_prescription_item").html('<input type="hidden" name="delete[type][]" value="MO_MED_PRESCRIPTION" /><input type="hidden" name="delete[MO_MED_PRESCRIPTION][medicalorderprescription_id][]" value="'+id+'" />').addClass('removed').removeClass("added");

        var newPrescCount = $('.medical_prescription_item.added').length;
        if(newPrescCount == 0) {
            $(".printPrescription").addClass('hidden');
        }
    })
}

function lessProc()
{
    $(".procedure_less").click(function(){
        var id = $(this).parents(".medical_procedure_item").find("input.remid").val();

        $(this).parents(".medical_procedure_item").html('<input name="delete[type][]" value="MO_PROCEDURE" type="hidden"><input type="hidden" name="delete[MO_PROCEDURE][medicalorderprocedure_id][]" value="'+id+'" />').addClass('removed').removeClass("added");

    })
}

Healthcare.medOrder = function () {

  var count = 1;
  $('select[id=medorders]').on('change', function() {
      var $selected = $(this).val();

      //check if this is a new form
      if($selected == 'MO_MED_PRESCRIPTION') {
          $('#medorders').find('[value="MO_MED_PRESCRIPTION"]').remove();
          $('.medicalOrders .nav-tabs li.prescTab').removeClass('hidden');
          $('#prescriptionTab').removeClass('hidden');
      }
      if($selected == 'MO_PROCEDURE') {
          $('#medorders').find('[value="MO_PROCEDURE"]').remove();
          $('.medicalOrders .nav-tabs li.procTab').removeClass('hidden');
          $('#procedureTab').removeClass('hidden');
      }
      if($selected == 'MO_LAB_TEST') {
          $('#medorders').find('[value="MO_LAB_TEST"]').remove();
          $('.medicalOrders .nav-tabs li.labTab').removeClass('hidden');
          $('#labTab').removeClass('hidden');
      }
      if($selected == 'MO_OTHERS') {
          $('#medorders').find('[value="MO_OTHERS"]').remove();
          $('.medicalOrders .nav-tabs li.otherTab').removeClass('hidden');
          $('#otherTab').removeClass('hidden');
      }

      $('#medorders').prop('selectedIndex', 0);
  });

  $('#regimenothers').change(function(e) {
      var value = $.trim( this.value );
      if(value=='OTH') {
        $("#forregimenothers").removeClass("hidden");
      } else {
        $("#forregimenothers").addClass("hidden");
      }
  });
  $('#intakeothers').change(function(e) {
      var value = $.trim( this.value );
      if(value=='O') {
        $("#forintakeothers").removeClass("hidden");
      } else {
        $("#forintakeothers").addClass("hidden");
      }

      if(value!='C') {
        $("#regimen_range").removeClass("hidden");
        $("#intake_input").removeAttr('disabled');
        $("#intake_input").addClass('required');
        $("#regimen_range input").addClass("required");
      } else {
        $("#regimen_range").addClass("hidden");
        $("#regimen_range input").removeClass("required");
        $("#intake_input").attr('disabled','disabled');
        $("#intake_input").removeClass('required');
        $("#intake_input").val('');
      }
  });

  $('.rmvbtn').click(function(){
        $(this).parent().parent().parent().parent().remove();
        if (count>1)  $('#rmvbtn').removeAttr('disabled');
        else $('#rmvbtn').attr('disabled', 'disabled');
    });

  $('.prescription_add').click(function() {
      var mayempty = 0;
      var itemCount = $('.medical_prescription_item.added').length;
      var f = "none";
      var chkforms = $('.prescription_group').find('.required');
      var formfield = "insert";
      chkforms.each( function(e) {
          if( mayempty == 0 && ($(this).val() == "" || $(this).val() == "undefined" )) {
              f = $(this).attr('name');
              mayempty = 1;
          };
      })
      if($('input[name=PrescriptionMedID]').val()) {
          formfield = "update";
      }

      if( $('input[name=Drug_Brand_Name]').val() ) {
          brand = "<p><strong>( "+$('input[name=Drug_Brand_Name]').val()+" )</strong><br />";
      } else {
          brand = "<p>";
      }

      var newform = '<div class="medical_prescription_item added"><input name="'+formfield+'[type][]" value="MO_MED_PRESCRIPTION" type="hidden" class="presctype"><input class="remid" name="'+formfield+'[medicalorder_id][]" value="'+$('input[name=prescriptionmedicalorder_id]').val()+'" type="hidden"><input name="'+formfield+'[MO_MED_PRESCRIPTION][medicalorderprescription_id][]" class="prescid" type="hidden" value="'+$('input[name=PrescriptionMedID]').val()+'"><input name="'+formfield+'[MO_MED_PRESCRIPTION][Drug_Code][]" class="dcode" type="hidden" value="'+$('textarea[name=Drug_Code]').val()+'"><input name="'+formfield+'[MO_MED_PRESCRIPTION][Drug_Brand_Name][]" type="hidden" class="brand" value="'+$('input[name=Drug_Brand_Name]').val()+'"><input name="'+formfield+'[MO_MED_PRESCRIPTION][Dose_Qty][]" type="hidden" class="dqty" value="'+$('input[name=Dose_Qty]').val()+'"><input name="'+formfield+'[MO_MED_PRESCRIPTION][Dose_UOM][]" class="dqtyuom" type="hidden" value="'+$('select[name=Dose_UOM]').val()+'"><input name="'+formfield+'[MO_MED_PRESCRIPTION][Total_Quantity][]" type="hidden" class="TQ" value="'+$('input[name=Total_Quantity]').val()+'"><input name="'+formfield+'[MO_MED_PRESCRIPTION][Total_Quantity_UOM][]" type="hidden" class="TQuom" value="'+$('select[name=Total_Quantity_UOM]').val()+'"><input name="'+formfield+'[MO_MED_PRESCRIPTION][dosage][]" type="hidden" class="regimen" value="'+$('select[name=dosage]').val()+'"><input name="'+formfield+'[MO_MED_PRESCRIPTION][Specify][]" type="hidden" class="regimenothers" value="'+$('textarea[name=Specify]').val()+'"><input name="'+formfield+'[MO_MED_PRESCRIPTION][Duration_Intake][]" type="hidden" class="di" value="'+$('input[name=Duration_Intake]').val()+'"><input name="'+formfield+'[MO_MED_PRESCRIPTION][Duration_Intake_Freq][]" type="hidden" class="dio" value="'+$('select[name=Duration_Intake_Freq]').val()+'"><input name="'+formfield+'[MO_MED_PRESCRIPTION][regimen_startend_date][]" type="hidden" class="regimen_dates" value="'+$('input[name=regimen_startend_date]').val()+'"><input name="'+formfield+'[MO_MED_PRESCRIPTION][Remarks][]" type="hidden" class="remarks" value="'+$('textarea[name=Remarks]').val()+'"><div class="col-md-12 form-group dynamic-row"><label class="col-md-1 control-label">&nbsp;</label><div class="col-md-10 has-feedback bordered-bottom"><h4>'+$('textarea[name=Drug_Code]').val()+' '+$('input[name=Dose_Qty]').val()+$('select[name=Dose_UOM]').val()+'  #'+$('input[name=Total_Quantity]').val()+' '+$('select[name=Total_Quantity_UOM]').val()+'</h4>'+brand+$('select[name=dosage] option:selected').html()+'<br />'+$('input[name=Duration_Intake]').val()+' '+$('select[name=Duration_Intake_Freq] option:selected').html()+' [ '+$('input[name=regimen_startend_date]').val()+' ]<br /><em>'+$('textarea[name=Remarks]').val()+'</em></p></div><div class="col-md-1"><span class="btn btn-default btn-sm prescription_less" id="" title="Remove Prescription"><i class="fa fa-times"></i></span><span class="btn btn-default btn-sm prescription_edit" id="" title="Edit Prescription"><i class="fa fa-pencil"></i></span></div></div>';

      if(mayempty == 0) {
          $('#medical_prescription_data').append(newform);
          $('.prescription_group').find('.form-control').val("");
      } else {
        bootbox.alert({
          title: "Incomplete Form!",
          message: "Please complete the form and try again."
        });
      }

      prescriptionEdit();
      lessPresc();

  })

  $('.procedure_add').click(function() {
      var mayempty = 0;
      var itemCount = $('.medical_procedure_item.added').length;

      var f = "none";
      var chkforms = $('.procedure_group').find('.required');
      chkforms.each( function(e) {
          if( mayempty == 0 && ($(this).val() == "" || $(this).val() == "undefined" )) {
              f = $(this).attr('name');
              mayempty = 1;
          };
      })
      var formfield = "insert";
      if($('input[name=ProcedureMedID]').val()) {
          formfield = "update";
      }

      var newform = '<div class="medical_procedure_item added"><input name="'+formfield+'[type][]" value="MO_PROCEDURE" type="hidden" class="proctype"><input name="'+formfield+'[medicalorder_id][]" value="'+$('input[name=proceduremedicalorder_id]').val()+'" type="hidden" class="medorderid"><input class="remid" name="'+formfield+'[MO_PROCEDURE][medicalorderprocedure_id][]" type="hidden" class="procid" value="'+$('input[name=ProcedureMedID]').val()+'"><input name="'+formfield+'[MO_PROCEDURE][Procedure_Order][]" type="hidden" class="procorder" value="'+$('textarea[name=Procedure_Order]').val()+'"><input name="'+formfield+'[MO_PROCEDURE][Date_of_Procedure][]" type="hidden" class="procdate" value="'+$('input[name=Date_of_Procedure]').val()+'"><input name="'+formfield+'[MO_PROCEDURE][Procedure_Remarks][]" type="hidden" class="procinstruct" value="'+$('textarea[name=Procedure_Remarks]').val()+'"><div class="col-md-12 form-group dynamic-row"><label class="col-md-1 control-label">&nbsp;</label><div class="col-md-10 has-feedback bordered-bottom"><h4>'+$('textarea[name=Procedure_Order]').val()+'</h4><p>'+$('input[name=Date_of_Procedure]').val()+'<br /><em>'+$('textarea[name=Procedure_Remarks]').val()+'</em></p></div><div class="col-md-1"><span class="btn btn-default btn-sm procedure_less" id="" title="Remove Procedure"><i class="fa fa-times"></i></span><span class="btn btn-default btn-sm procedure_edit" id="" title="Edit Procedure"><i class="fa fa-pencil"></i></span></div></div>';

      if(mayempty == 0) {
          $('#medical_procedure_data').append(newform);
          $('.procedure_group').find('.form-control').val("");
      } else {
          bootbox.alert({
              title: "Incomplete Form!",
              message: "Please complete the form and try again."
            });
      }

      procedureEdit();
      lessProc();

  })

  $('#saveMedOrder').click( function(e){

       if( $('#drug_input').val() != '') {
           e.preventDefault();
           var $this = $(this);
           bootbox.confirm({
               message: "There is a new Prescription entry that has not been added to the list.<br />If you choose Continue, it will not be saved.",
               title: "Form Alert",
               buttons: {
                   cancel: {
                       label: "Cancel"
                   },
                   confirm: {
                       label: "Continue"
                   }
               },
               callback: function(result){
                   if (result) {
                      $this.submit();
                   }
               }
           });
       }
      if( $('#procedure_input').val() != '') {
           e.preventDefault();
           var $this = $(this);
           bootbox.confirm({
               message: "There is a new Medical Procedure entry that has not been added to the list.<br />If you choose Continue, it will not be saved.",
               title: "Form Alert",
               buttons: {
                   cancel: {
                       label: "Cancel"
                   },
                   confirm: {
                       label: "Continue"
                   }
               },
               callback: function(result){
                   if (result) {
                      $this.submit();
                   }
               }
           });
       }

   })

   $( "#drug_input" ).autocomplete({
        source: availableDrugs
    });

   $("#procedure_input").autocomplete({
        source: availableProcedures
    });

    lessPresc();
    lessProc();

    prescriptionEdit();
    procedureEdit();

    removePrescriptionTab();
    removeProcedureTab();
    removeLaboratoryTab();
    removeOtherTab();

}



$(function () {
   Healthcare.init();
});
