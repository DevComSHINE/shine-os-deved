
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
        <style>
            html, body {
                font-size: 13px;
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
            #onepage {
                background: url("{{ asset('public/dist/img/rx_symbol_gry.png') }}") center center no-repeat;
                min-height:660px;
                border-bottom: 2px dotted #888;
                overflow: hidden;
            }
            #footlogo img {
                margin:5px 30px 0;
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
                font-size: 14px;
            }
            .section td, .section td p {
                font-size: 12px;
            }

        </style>
    </head>

    <body>
        <?php for($page = 1; $page <= $pages; $page++) { ?>
        <div id="onepage">
            <div class="letterhead">
                <?php if(isset($user->prescription_header)) { echo $user->prescription_header; } else { ?>
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
                                <td colspan="3"><strong>Patient Information</strong></td>
                                <td colspan="2" align="right"><?php echo date("F d, Y"); ?></td>
                            </tr>
                            <tr>
                                <td colspan="4">Name: <?php echo $patient->first_name." ".$patient->last_name; ?></td>
                                <td rowspan="3" align="right">
                                    <?php if(isset($user->qrcode) AND $user->qrcode == "1") { ?>
                                    {!! QrCode::margin(2)->size(150)->generate($patqrcode); !!}
                                    <?php } ?>
                                </td>
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
                        <img src="{{ asset('public/dist/img/rx_symbol.png') }}" style="float:left;margin-right: 15px;height:55px;" />
                        <table id="prescriptions" style="float:left;width:90%;">
                            <?php $dc = 0;
                            foreach($drugs as $drug) {
                                $dcode = $freq = NULL;
                                switch($drug->dosage_regimen)
                                {
                                    case 'OD': $regimen = 'Once a day'; break;
                                    case 'BID': $regimen = '2 x a day - Every 12 hours'; break;
                                    case 'TID': $regimen = '3 x a day - Every 8 hours'; break;
                                    case 'QID': $regimen = '4 x a day - Every 6 hours'; break;
                                    case 'QOD': $regimen = 'Every other day'; break;
                                    case 'QHS': $regimen = 'Every bedtime'; break;
                                    case 'OTH': $regimen = 'Others'; break;
                                    default: $regimen = 'Not given';
                                }
                                $intake = explode(" ",$drug->duration_of_intake);
                                if(isset($intake[1])) {
                                    switch($intake[1])
                                    {
                                        case 'D': $freq = 'Days'; break;
                                        case 'W': $freq = 'Weeks'; break;
                                        case 'M': $freq = 'Months'; break;
                                        case 'Q': $freq = 'Quarters'; break;
                                        case 'Y': $freq = 'Years'; break;
                                        case 'O': $freq = 'Others'; break;
                                        default: $freq = 'Not given';
                                    }
                                    $dcode = NULL;
                                }

                                if(isset($intake[0])) {
                                    $drugin = $intake[0];
                                } else {
                                    $drugin = "none";
                                }
                                $dosage = explode(" ",$drug->dose_quantity);
                                $total = explode(" ",$drug->total_quantity);
                                if($dcode) {
                                    $drugline = $dcode->hprodid." #".$total[0]." ".$total[1];
                                } else {
                                    $drugline = $drug->generic_name." ".$drug->dose_quantity." #".$drug->total_quantity;
                                }
                            ?>
                            <tr>
                                <td width="80%" valign="top">
                                    <p>
                                        <strong>
                                            <?php if(isset($dcode->source)) { ?><span style="
                                                font-size: 9px;
                                                vertical-align: top;
                                                padding: 3px 5px;
                                                color: #FFF;
                                                background-color: #333;
                                                border-radius: 3px;
                                                box-shadow: 0px -1px 0px rgba(0, 0, 0, 0.25) inset;"><?php echo $dcode->source; ?></span> <?php } ?>
                                            <span class='bname'><?php echo $drugline; ?></span></strong>
                                            <?php if($drug->brand_name != "") echo "<br /><strong>(".$drug->brand_name.")</strong>"; ?>
                                            <?php if($regimen != '') echo "<br />1".str_singular($total[1])." - ".$regimen." for ".$intake[0]." ".$freq; ?>
                                            <?php if( $drug->regimen_startdate == '1970-01-01' OR $drug->regimen_startdate == '0000-00-00' ) { } else { ?>
                                                <br />From: <?php echo date("M. d, Y", strtotime($drug->regimen_startdate)); ?> - <?php echo date("M. d, Y", strtotime($drug->regimen_enddate)); ?>
                                            <?php } ?>
                                            <?php if($drug->prescription_remarks) echo "<br />".$drug->prescription_remarks; ?>
                                    </p>
                                </td>
                                <?php if(isset($user->qrcode) AND $user->qrcode == "1") { ?>
                                <td valign="top" align="center">
                                    {!! QrCode::margin(2)->size(300)->generate($qrdata[$page][$dc]); !!}
                                </td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td colspan="2"><hr /></td>
                            </tr>
                            <?php $dc++; } ?>
                        </table>
                    </div>
                </div>
            </div>

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
                <p class="small text-center">Powered by<br /><img src="{{ asset('public/dist/img/shine-logo-big.png') }}" height="37" /> <img src="{{ asset('public/dist/img/3ag_company_logo.png') }}" height="17" style="display:none;" /></p>
            </div>
        </div>
        <?php } ?>
    </body>
</html>
{!! HTML::script('public/dist/js/bootbox.min.js') !!}
<script type="text/javascript">

    $(document).load(function() {
        /*$.ajax({
            url : "http://medrxapistaging.azurewebsites.net/api/Prescription",
            method: "post",
            data : <?php //echo $medrx; ?>,
            async : false,
            dataType : "json",
            success : function( data ){
                alert("Sent to MedRX");
            }
        });*/
    });

    bootbox.alert({
        message: "In order to print this prescription properly, we suggest that you turn off the Headings and Footers settings on the print dialog box.",
        title: 'Prescription Printing'
    });
</script>
