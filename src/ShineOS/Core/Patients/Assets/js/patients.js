var Patients = {};

Patients.init = function ()
{
   Patients.cloneDiv();
   Patients.showModal();
   Patients.checkMorbidity(patientId);
   Patients.showChildDiv();
}

Patients.cloneDiv = function ()
{
  $('.addAllergy-button').on('click', function (){
    Helper.cloneElement('.clone', $('.parentDiv'));
  });
}

Patients.showModal = function ()
{
  $('.deadPatient-button').on('click', function (){
    $('#myModal').modal('show');
  });
}

Patients.checkMorbidity = function (patientId)
{
  var url = '/patients/'+ patientId +'/checkPatientMorbidity';

  Helper.ajaxGet(url, [], function(result) {
    if (result == 1)
    {
      $(".patient-form :input, button").attr("disabled", "disabled");
      $('.deadPatient-button').html('DEAD');
    }
  });
}

Patients.showChildDiv = function ()
{
  $('#chk_aller').on('click',function() {
      if($('#chk_aller').is(":checked"))   
          $('#allergies').show();
      else
          $('#allergies').hide();
  });

  $('#chk_disab').on('click',function() {
      if($('#chk_disab').is(":checked"))   
          $('#disabilities').show();
      else
          $('#disabilities').hide();
  });

  $('#chk_other').on('click',function() {
      if($('#chk_other').is(":checked"))   
          $('.alert-other').show();
      else
          $('.alert-other').hide();
  });
}
// Patients.setModalBox = function() {
//   document.getElementById('modal-body').innerHTML=content;
//   document.getElementById('myModalLabel').innerHTML=title;
//   document.getElementById('modal-footer').innerHTML=footer;
//   if($size == 'large')
//   {
//       $('#myModal').attr('class', 'modal fade bs-example-modal-lg')
//                    .attr('aria-labelledby','myLargeModalLabel');
//       $('.modal-dialog').attr('class','modal-dialog modal-lg');
//   }
//   if($size == 'standard')
//   {
//       $('#myModal').attr('class', 'modal fade')
//                    .attr('aria-labelledby','myModalLabel');
//       $('.modal-dialog').attr('class','modal-dialog');
//   }
//   if($size == 'small')
//   {
//       $('#myModal').attr('class', 'modal fade bs-example-modal-sm')
//                    .attr('aria-labelledby','mySmallModalLabel');
//       $('.modal-dialog').attr('class','modal-dialog modal-sm');
//   }
// }

$(function ()
{
   Patients.init();
});