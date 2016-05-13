var Patients = {};

function show_maiden()
{
    var marital_status = $("#marital_status_field").val();
    var gender = $(".gender:checked").val();

    console.log(gender);
    if (marital_status == 'M' && gender == 'F')
      {
        $('.maiden').show();
        $('.maiden').removeClass('hidden');
        $('input[name=inputMaidenLastName]').val($('input[name=inputPatientMiddleName]').val());
      }
      else
      {
        $('.maiden').hide();
        $('.maiden').addClass('hidden');
        $('input[name=inputMaidenLastName]').val('');
      }
}

Patients.deathInfo = function ()
{
  $("#deathPlace_select").change( function() {
    var value = $(this).val();
    if(value == 'NID')
    {
      $("#deathPlaceHead").removeClass("hidden");
      $("#deathplace_NID").removeClass("hidden");
      $("#deathplace_FB").addClass("hidden");
      $("#deathplace_FB :selected").removeAttr("selected");
    }
    else if(value == 'FB')
    {
      $("#deathPlaceHead").removeClass("hidden");
      $("#deathplace_FB").removeClass("hidden");
      $("#nidOthersSpecifiy").addClass("hidden");
      $("#deathplace_NID").addClass("hidden");
      $("#deathplace_NID :selected").removeAttr("selected");
    }
    else
    {
      $("#deathPlaceHead").addClass("hidden");
      $("#deathplace_FB").addClass("hidden");
      $("#deathplace_NID").addClass("hidden");
      $("#nidOthersSpecifiy").addClass("hidden");
      $("#deathplace_NID :selected").removeAttr("selected");
      $("#deathplace_FB :selected").removeAttr("selected");
    }
  });

  $("#deathplace_NID").change( function() {
    console.log('Nid change');
    var value = $(this).val();
    console.log(value);
    if(value == 'oth')
    {
      $("#nidOthersSpecifiy").removeClass("hidden");
    }
    else
    {
      $("#nidOthersSpecifiy").addClass("hidden");
    }
  });
}

Patients.init = function ()
{
   Patients.cloneDiv();
   Patients.checkMorbidity(patientId);
   Patients.showChildDiv();

   if($('#wizardForm').length > 0) {
      Patients.wizard();
   }
}

Patients.cloneDiv = function ()
{
  $('.addAllergy-button').on('click', function (){
    var clone = $('.clone').first().clone().find("input:text, textarea, select").val("").end();
    clone.appendTo('.parentDiv');
    clone.find('.allergyname').addClass('required').attr('required','required');
    clone.find('.allergyreaction').addClass('required').attr('required','required');
    clone.find('.allergyseverity').addClass('required').attr('required','required');
    clone.find('.help-block').remove();
    clone.find('.removeAllergyLine').removeClass('hidden');
    clone.find('.removeAllergyLine').on('click', function(){
      $(this).parent().parent().remove();
    })

    $('form').validate();
  });

  $('.removeAllergyLine').on('click', function(){
      $(this).parent().parent().remove();
  })
}

Patients.checkMorbidity = function (patientId)
{
  if(patientId) {
      var url = baseurl + "patients/" + patientId + '/checkPatientMorbidity';

      Helper.ajaxGet(url, [], function(result) {
        if (result == 1)
        {
          $(".patient-form :input, button").attr("disabled", "disabled");
          $('.deadPatient-button').html('DEAD');
        }
      });
  }
}

Patients.showChildDiv = function ()
{
    $('#chk_aller').on('ifChecked', function(event){
      $('#allergies').removeClass('hide');
      $('.allergyname').addClass('required').attr('required','required');
      $('.allergyreaction').addClass('required').attr('required','required');
      $('.allergyseverity').addClass('required').attr('required','required');
    });
    $('#chk_aller').on('ifUnchecked', function(event){
      $('#allergies').addClass('hide');
      $('#allergies .form-control').val("");
      $('.allergyname').removeClass('required').removeAttr('required','required');
      $('.allergyreaction').removeClass('required').removeAttr('required','required');
      $('.allergyseverity').removeClass('required').removeAttr('required','required');

    });

  $('#chk_disab').on('ifChecked', function(event){
        $('#disabilities').removeClass('hide');
  });
  $('#chk_disab').on('ifUnchecked', function(event){
        $('#disabilities').addClass('hide');
        $('#disabilities input').iCheck('uncheck');
  });

  $('#chk_other').on('ifChecked', function(event){
      $('.alert-other').removeClass('hide');
      $('.alert_other_field').addClass('required').attr('required','required');
  });
  $('#chk_other').on('ifUnchecked', function(event){
      $('.alert-other').addClass('hide');
      $('.alert_other_field').removeClass('required').removeAttr('required','required');
  });
}

Patients.wizard = function() {
    $("#step_visualization").on('click','a.disabled', function(e){
        return false;
    })

    //trigger form wizard
    //bind callback to the before_remote_ajax event
    $("#wizardForm").formwizard({
        validationEnabled: true,
        focusFirstInput : true,
        disableUIStyles: true,
        remoteAjax : {"basic" : { // add a remote ajax call when moving next from the first step
            url : baseurl + "patients/check", //checks whether new record already exists
            dataType : 'json',
            beforeSend : function(){},
            complete : function(){},
            success : function(data)
            {
              console.log(data);
                if(data.firstname != "none")
                {
                    $("#results").removeClass("hidden");

                    htmltext = "<h4>Found records with same name and birthdate:</h4>";
                    var del = "";
                    var name = "";
                    for(var i=0;i<data.length;i++){
                        var obj = data[i];
                        if(obj['deleted_at']!=null){
                            del = " --- Record deleted: <a href='"+baseurl+"patients/undelete/"+obj['patient_id']+"'>Undelete</a>?";
                            name = "&rsaquo; "+obj['first_name']+" "+obj['last_name'];
                        } else {
                            name = "<a href='"+baseurl+"patients/"+obj['patient_id']+"' class='ajax-link'>&rsaquo; "+obj['first_name']+" "+obj['last_name']+"</a>";
                        }
                        htmltext = htmltext + "<p>"+name+" - Profiled by: "+obj['facility_name']+del+"</p>";
                        del = ""; name="";
                    }

                    $("#results").html(htmltext); //.fadeTo(5000, 0);
                    return false; //return false to stop the wizard from going forward to the next step
                } else {
                    return true; //return true to make the wizard move to the next step
                }
            }
        }}
    });

    // function for appending step visualization
    function addVisualization(id){
        $('#step_visualization li').removeClass("active");
        $("#"+id+"tab").addClass("active");
    }
    // initial call to addVisualization (for visualizing the first step)
    addVisualization($("#wizardForm").formwizard("state").firstStep);

    $("#wizardForm").bind("step_shown", function(event, data){
        if(data.isBackNavigation || !data.isFirstStep){
            var direction = (data.isBackNavigation)?"back":"forward";
        }
        $.each(data.activatedSteps, function(){
            addVisualization(this)
        });

        console.log(event);
    });


}

$(function ()
{
   Patients.init();
   Patients.deathInfo();
});
