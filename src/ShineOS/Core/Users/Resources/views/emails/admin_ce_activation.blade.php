<html>
    <head>
        <title> SHINE OS+ </title>

        <style>
            body {
                font-family: Arial;
                background: #eceff0 !important;
                color:#888;
            }
            a {
                color:#999;
                text-decoration: none;
            }
            hr {
                height: 1px;
                color: #CCC;
                border: 1px solid #CCC;
            }
            h2, h4 {
                font-weight: 100;
            }
        </style>
    </head>
    <body>
    <div style="background: #eceff0;">
        <table class="" cellspacing="0" border="0" cellpadding="20" align="center" width="600" style="background: #eceff0;">
            <tbody>
                <tr>
                    <td valign="top" colspan="2">
                        <h2 style="text-align:center;">
                            <img src="{{ asset('http://www.shine.ph/emr/public/dist/img/shine-logo-big.png') }}">
                        </h2>
                    </td>
                </tr>
                <tr style="background-color: #FFFFFF; border-radius: 9px;">
                    <td valign="top" colspan="2">
                        <h2>SHINE OS+ Community Edition Activation</h2>
                        <h4> <strong> Name: </strong> {{ $name }} </h4>
                        <h4> <strong> Email: </strong> {{ $email }}  </h4>
                        <hr />
<p>Your SHINEOS+ Community Edition Account Registration is received and activated. You can now download your SHINEOS+ Community Edition. Please take note of the password you registered with.</p>
                        <h4>CE Activitation Key Code File</h4>
                        <p style="padding:20px;font-family:monospace;">File attachment: <?php echo $code; ?></p>
                        <p>Download the attached file to activate your SHINE OS+ CE. After you installed CE in your computer, click on Activate on the login page and upload this file. Please keep this until you activate your SHINEOS+ CE.</p>
                        <p>Thank you.</p>

                        </td>
                </tr>
                <tr>
                    <td style="text-align:center;font-size:36px;padding:35px 0;">
                        <a href="https://www.facebook.com/SHINEOSPLUS" style="padding:0 15px;"><img src="{{ asset('http://www.shine.ph/emr/public/dist/img/fb.png') }}" width='26' height='26'></a>
                        <a href="https://twitter.com/shineOSplusEMR" style="padding:0 15px;"><img src="{{ asset('http://www.shine.ph/emr/public/dist/img/twitter.png') }}" width='26' height='26'></a>
                    </td>
                </tr>
                <tr style="font-size:11px;">
                    <td style="text-align:center;">
                        &copy; 2011-{{ date('Y') }}. ShineLabs. All rights reserved<br>
                        SHINE OS+ is a product of ShineLabs<br>
                        in partnerships with Smart Communications.<br>
                        AJWCC, Ateneo de Manila University, Katipunan Ave., Q.C., Philippines<br>
                        <a href="http://www.shine.ph">Shine.ph</a> | <a href="http://www.shine.ph/developer">SHINE Developer</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    </body>
</html>
