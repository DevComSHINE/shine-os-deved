
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
        rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        {!! HTML::style('public/dist/plugins/iCheck/square/_all.css') !!}
        <style>
            html, body {
                height: 100%;
            }
            body, .container {
                width: 100%;
                max-width: 800px;
                margin:auto;
            }
            h1 {
                font-size: 27px;
                margin:5px 0;
            }
            hr {
                margin:8px 0;
            }
            hr.bodysep {
                border-top: 2px solid #CCC;
            }
            .letterhead {
                margin-bottom: 20px;
                border-bottom:3px solid #AAA;
                padding-bottom: 10px;
                min-height: 150px;
            }
            #logos {
                height: 75px;
            }
            #logos img {
                margin:15px 20px 0;
            }
            <?php if(strtolower($provider->ownership_type) != "government") { ?>
            #logos h1 {
                position: relative;
                  top: 50%;
                  transform: translateY(-50%);
            }
            <?php } ?>
            .page {
                min-height:660px;
                border-bottom: 2px dotted #888;
                overflow: hidden;
            }
            #footlogo img {
                margin:5px 5px 0;
            }
            #section-body {
                min-height: 23%;
            }
            #section-footer {
                position: relative;
                bottom:0;
            }
            #section-footer img {
                margin:0 9px;
            }
            kbd {
                font-size:9px;
                vertical-align:top;
            }
            .bname {
                font-size: 18px;
            }
            .section td, .section td p {
                font-size: 16px;
            }
            .checkbox + .checkbox, .radio + .radio {
                margin-top: 0;
            }
            .checkbox, .radio {
                margin-bottom: 6px;
                margin-top: 0px;
            }
        </style>
    </head>

    <body>
        <div class="page">
            <div class="letterhead">
                <?php if($user->prescription_header) { echo $user->prescription_header; } else { ?>
                <div class="col-md-12" id="logos">
                    <?php if(strtolower($provider->ownership_type) == "private") { ?>
                    <p class="small text-center"><img src="{{ asset('public/dist/img/doh.png') }}" height="55" /> <img src="{{ asset('public/dist/img/UHCNew.png') }}" height="55" /> <img src="{{ asset('public/dist/img/tsekap.jpg') }}" height="55" /> <img src="{{ asset('public/dist/img/philhealth.png') }}" height="55" /></p>
                    <?php } ?>
                    <h1 class="text-center"><?php echo $provider->facility_name; ?></h1>
                </div>
                <?php } ?>
            </div>
            <div class="section" id="section-header">
                <div class="container">
                    <div class="row">
                        <table width="100%">

                            <tr>
                                <td colspan="2"><strong>Patient Information</strong></td>
                                <td colspan="2" align="right"><?php echo date("F d, Y"); ?></td>
                            </tr>
                            <tr>
                                <td colspan="4">Name: <?php echo $patient->first_name." ".$patient->last_name; ?></td>
                            </tr>
                            <tr>
                                <td colspan="5">Address: <?php echo getBrgyName($patient->patientContact->barangay); ?><?php echo getCityName($patient->patientContact->city); ?></td>
                            </tr>
                            <tr>
                                <td width="20%" valign="top">Contact:<br /><?php echo $patient->patientContact->mobile; ?></td>
                                <td width="20%" valign="top">
                                        PhilHealth#:<br /><?php if(isset($phic->MEMID_NO)) echo $phic->MEMID_NO; ?><br>
                                        <?php if(isset($phic->MEMID_NO)) echo "Member"; ?>
                                        </td>
                                <td width="20%" valign="top">Sex:<br /><?php echo $patient->gender; ?></td>
                                <td width="20%" valign="top">Birth:<br /><?php echo date("F d, Y", strtotime($patient->birthdate)); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <hr class="bodysep" />
            <div class="section" id="section-body">
                <div class="container">
                    <div class="row">
                        <h4>Laboratory Examination Request</h4>
                        <table width="100%">

                            <div class="form-group">
                                <div class="icheck row">
                                    @foreach($lovlaboratories as $llabs)
                                        <div class="col-md-4 checkbox">
                                            <label>
                                              <?php $selectd = ""; ?>
                                              @foreach ($labs as $lab_key => $lab_value)
                                                @if($lab_value->laboratory_test_type == $llabs->laboratorycode)
                                                    <?php $selectd = "checked='checked'"; ?>
                                                @endif
                                              @endforeach
                                              <input type="checkbox" value="{{ $llabs->laboratorycode }}" {{ $selectd }} class="form-control" /> {{ $llabs->laboratorydescription }}

                                            </label>
                                          </div>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <h5>Instructions</h5>
                                    <div class="col-md-12">
                                        {!! $instructions !!}
                                    </div>
                                </div>
                            </div>

                    </table>
                </div>
            </div>
            <hr />
            <div class="sectionn" id="section-footer">
                <div class="container">
                    <div class="row">
                        <table width="100%">
                            <tr>
                                <td valign="top">
                                    <p>MD: <strong><?php echo $user->first_name; ?> <?php echo $user->last_name; ?></strong>
                                        <br>Lic#: <?php echo $user->professional_license_number; ?> | PHIC Accr#: <?php echo $provider->phic_accr_id; ?>
                                        <br>Tel: <?php echo $user->phone; ?> | Email: <?php echo $user->email; ?>
                                    </p>
                                </td>
                                <td width="30%" valign="top">
                                    <p><strong><?php echo $provider->facility_name; ?></strong>
                                        <br>{{ isset($provider->facility_contact->street_name) ? $provider->facility_contact->street_name : "" }}
                                        {{ isset($provider->facility_contact->barangay) ? ", ".getBrgyName($provider->facility_contact->barangay) : "" }}{{ isset($provider->facility_contact->municipality) ? ", ".getCityName($provider->facility_contact->municipality) : "" }}
                                        <br><?php if(isset($provider->facility_contact->province)) echo getProvinceName($provider->facility_contact->province).", "; ?><?php if(isset($provider->facility_contact->zip)) echo $provider->facility_contact->zip.", "; ?><?php if(isset($provider->facility_contact->region)) echo getRegionName($provider->facility_contact->region); ?>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <hr />
            <div class="col-md-12" id="footlogo">
                <p class="small text-center">Powered by <img src="{{ asset('public/dist/img/shine-logo-big.png') }}" height="37" style="margin-top:-3px;" /> <img src="{{ asset('public/dist/img/3ag_company_logo.png') }}" height="17" style="display:none;" /></p>
            </div>
        </div>
    </body>
</html>
{!! HTML::script('public/dist/js/bootbox.min.js') !!}
{!! HTML::script('public/dist/plugins/iCheck/icheck.js') !!}
<script type="text/javascript">
    $('.icheck input').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green'
      });

    bootbox.alert({
        message: "In order to print this prescription properly, we suggest that you turn off the Headings and Footers settings on the print dialog box.",
        title: 'Prescription Printing'
    });
</script>
