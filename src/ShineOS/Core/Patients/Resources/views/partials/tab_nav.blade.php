<?php if($action == "view") { ?>
    <ul class="nav nav-tabs">
         <li class="active"><a href="#basic" data-toggle="tab" aria-expanded="true">Basic</a></li>
         <li><a href="#location" data-toggle="tab">Location</a></li>
         <li id="plugin-insert"><a href="#health" data-toggle="tab">Health Info</a></li>
         <li><a href="#notifications" data-toggle="tab">Record Settings</a></li>
         <li><a href="#photos" class="text-lg" data-toggle="tab">Photo</a></li>

         <li role="presentation" class="dropdown special">
            <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents"> + Additional Patient Data  </a>
            <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                @if($plugs)
                  @foreach($plugs as $plug)
                    @if($plug['plugin_location'] == 'newdata')
                        <li><a href="{{ url('plugin/call/'.$plug['folder'].'/'.$plug['plugin'].'/view/'.$patient->patient_id) }}" role="tab">@if(!$plug['pdata']) + Add {{ $plug['title'] }} @else &bull; View {{ $plug['title'] }} @endif</a></li>
                    @endif
                  @endforeach
                @endif
            </ul>
          </li>

          <li class="floatright"><button class="btn btn-danger deadPatient-button deathModal" data-id="{{ $patient->patient_id }}" data-toggle="modal" data-target="#deathModal">Declare Dead</button></li>

          <li class="floatright"><a class="btn btn-primary" href="{{ url('healthcareservices/add', [$patient->patient_id]) }}">Add New Consultation</a></li>
    </ul>
<?php } ?>
<?php if($action == "add") { ?>
    <ul id="step_visualization" class="nav nav-tabs new-record">
         <li id="basictab" class="active"><a class="disabled" data-toggle="tab" aria-expanded="true">Basic</a></li>
         <li id="personaltab"><a class="disabled" data-toggle="tab">Personal</a></li>
         <li id="locationtab"><a class="disabled" data-toggle="tab">Location</a></li>
         <li id="healthtab"><a class="disabled" data-toggle="tab">Health Info</a></li>
         <li id="notificationstab"><a class="disabled" data-toggle="tab">Record Settings</a></li>
         <li id="photostab"><a class="disabled" data-toggle="tab">Photo</a></li>
    </ul>
<?php } ?>
