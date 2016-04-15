
var url = '/healthcareservices/add';
var Healthcare = {};

function firedate(el)
{
    /* Initialize datepicker
    $(el).datepicker({
        setDate: new Date(),
        changeMonth: true,
        changeYear: true,
        minDate: '0D'
    });
    // Initialize mask datepicker
    $(el).inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});*/

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

   Healthcare.computeBMI();
   Healthcare.impAndDIag();
   Healthcare.medOrder();

   /*if($(".diagnosis_input").length > 0) {
       Healthcare.diagAutoComplete();
   }*/

   if($(".procedure_input").length > 0) {
       Healthcare.procedureAutoComplete();
   }

   if($('.MO_PROCEDURE_ON').length > 0) {
       //remove procedure in selection
       $('#medorders').find('[value="MO_PROCEDURE"]').remove();
       $('.procedure_add').click(function() {
            $procclone = $(this).parents('.procedure_group').clone(true);
            $procclone.find('.form-control').val("");
            $procclone.appendTo( $(this).parents('.MO_PROCEDURE_ON') );
            return false;
       });
       $('.procedure_less').click(function() {
           var pcount = $('.procedure_group').length;
           if(pcount > 2) {
                $procclone = $(this).parents('.procedure_group').remove();
            } else {
                alert("You can delete this last entry. If you do not need this Medical Order, click on Remove Order on the right side.");
            }
            return false;
       })
   }
   if($('.MO_MED_PRESCRIPTION_ON').length > 0) {
       //remove prescription in selection
       $('#medorders').find('[value="MO_MED_PRESCRIPTION"]').remove();
       $('.prescription_add').click(function() {
           $presclone = $(this).parents('.prescription_group').clone(true);
           $presclone.find('.form-control').val("");
           $presclone.appendTo( $(this).parents('.MO_MED_PRESCRIPTION_ON') );
           return false;
       });
       $('.prescription_less').click(function() {
            var pcount = $('.prescription_group').length;
            if(pcount > 2) {
                $(this).parents('.prescription_group').remove();
            } else {
                alert("You can delete this last entry. If you do not need this Medical Order, click on Remove Order on the right side.");
            }
            return false;
        })

   }
   if($('.MO_LAB_TEST_ON').length > 0) {
       //remove laboratory in selection
       $('#medorders').find('[value="MO_LAB_TEST"]').remove();
   }
   if($('.MO_OTHERS_ON').length > 0) {
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
    var c = 1;
    var procforms = $('.procedure_input');
    procforms.each(function() {
        $( "#procedure_input"+c ).autocomplete({
            source: availableProcedures
        });
        c++;
    })
}

Healthcare.fireDiagAutoComplete = function() {
    var diagnosisforms = $('.diagnosis_input');
    $( ".diagnosis_input" ).autocomplete({
        source: availableTags
    });
}

Healthcare.fireProcedureAutoComplete = function() {
    $( ".procedure_input" ).autocomplete({
        source: availableProcedures
    });
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

Healthcare.cloneForm = function (form) {

}

Healthcare.medOrder = function () {
  var count = 1;
  $('select[id=medorders]').on('change', function() {
      var $selected = $(this).val();

      //check if this is a new form
      var formCount = $('.dynamic-content.hidden').length;
      if(formCount == 1) {
          $('.dynamic-content').removeClass('hidden');
          $('.dynamic-content').find('div.form-add').addClass('hidden');
          $('.dynamic-content').find('div.'+$selected).removeClass('hidden');
          $('.dynamic-content').find('input[name="insert[type][]"]').attr('value', $selected);
          $('.dynamic-content').find('.procedure_input').attr('id','procedure_input_1').autocomplete({
                    source: availableProcedures
                });
          $('.dynamic-content').attr('id', "added1");
          $('.dynamic-content').find('.datepicker_future').attr('id','datepicker_future_1')
          firedate($('#datepicker_future_1'));
      } /*else {
          var $clone = $('.dynamic-content:eq(-1)').clone(true);
          $clone.removeClass('hidden');
          console.log('count '+count);
          var idcounter = ++count;
          $clone.attr('id', "added"+idcounter);
          $clone.find('.form-control').val("");
          $clone.find('div.form-add').addClass('hidden');
          $clone.find('div.'+$selected).removeClass('hidden');
          $clone.find('input[name="insert[type][]"]').attr('value', $selected);

          $clone.find('.rmvbtn').attr('id','rmvbtn'+idcounter);
          $clone.find('#rmvbtn'+idcounter).removeClass('hidden');
          $('.dynamic-content').last().after($clone);

          $clone.find('#rmvbtn'+idcounter).click(function(){
              //$('#added'+idcounter).remove();
              $(this).parents('.dynamic-content').remove();
              if (count>1)  $('#rmvbtn').removeAttr('disabled');
              else $('#rmvbtn').attr('disabled', 'disabled');
          });

          if($selected == 'MO_PROCEDURE') {
              $clone.find('.procedure_input').attr('id','procedure_input'+idcounter);
          }
          Healthcare.fireProcedureAutoComplete();
      }*/

      if($selected == 'MO_MED_PRESCRIPTION') {
          $('#medorders').find('[value="MO_MED_PRESCRIPTION"]').remove();
          $('.prescription_add').click(function() {
                $presclone = $(this).parents('.prescription_group').clone(true)
                $presclone.find('.form-control').val("");
                $presclone.appendTo( $(this).parents('.MO_MED_PRESCRIPTION') );

                $('.prescription_less').click(function() {
                    var pcount = $('.prescription_group').length;
                    if(pcount > 2) {
                        $(this).parents('.prescription_group').remove();
                    } else {
                        alert("You can delete this last entry. If you do not need this Medical Order, click on Remove Order on the right side.");
                    }
                    return false;
                })
                return false;
          });
      }
      if($selected == 'MO_PROCEDURE') {

          $('#medorders').find('[value="MO_PROCEDURE"]').remove();
          $('.procedure_add').click(function() {
                var pcount = $('.procedure_group').length;
                idcounter = ++pcount;

                $procclone = $(this).parents('.procedure_group').clone(true);
                $procclone.attr('id', "procedure_form_"+idcounter);
                $procclone.find('.form-control').val("");
                $procclone.find('.procedure_input').attr('id', "procedure_input_"+idcounter).autocomplete({
                    source: availableProcedures
                });
                $procclone.find('.datepicker_future').attr('id', "datepicker_future_"+idcounter)
                $procclone.appendTo( $(this).parents('.MO_PROCEDURE') );
                firedate($('#datepicker_future_'+idcounter));
                return false;
          });

          $('.procedure_less').click(function() {
                var pcount = $('.procedure_group').length;
                if(pcount > 1) {
                    $procclone = $(this).parents('.procedure_group').remove();
                } else {
                    alert("You can delete this last entry. If you do not need this Medical Order, click on Remove Order on the right side.");
                }
                return false;
          })
      }
      if($selected == 'MO_LAB_TEST') {
          $('#medorders').find('[value="MO_LAB_TEST"]').remove();
      }
      if($selected == 'MO_OTHERS') {
          $('#medorders').find('[value="MO_OTHERS"]').remove();
      }

      $('#medorders').prop('selectedIndex', 0);
  });

  $('#regimenothers0').change(function(e) {
      var value = $.trim( this.value );
      //console.log('value '+value);
      if(value=='OTH') {
        $("#forregimenothers0").removeClass("hidden");
      } else {
        $("#forregimenothers0").addClass("hidden");
      }
  });

  $('.rmvbtn').click(function(){
        $(this).parent().parent().parent().parent().remove();
        if (count>1)  $('#rmvbtn').removeAttr('disabled');
        else $('#rmvbtn').attr('disabled', 'disabled');
    });

  $('.prescription_add').click(function() {
      $(this).parents('.prescription_group').clone().appendTo('MO_MED_PRESCRIPTION');
  })

}



$(function () {
   Healthcare.init();
});
