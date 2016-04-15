<!DOCTYPE html>
<html>
    <head>
        <title>Oops! Page not found.</title>

        <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        {!! HTML::style('public/dist/css/bootstrap.min.css') !!}
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
                font-size:18px;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
                font-weight:100;
            }
            .error-page {
                padding-bottom: 50px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="box">
                    <div class="error-page box-body">
                        <h2 class="title text-red">Error 404</h2>
                        <div class="error-content">
                          <h3><i class="fa fa-warning text-red"></i> Oops! Page not found.</h3>
                            <p>We could not find the page you were looking for.</p>
                            <p>Meanwhile, you may <a href="{{ url('/') }}">return to dashboard</a>.
                            </p>
                        </div><!-- /.error-content -->
                    </div><!-- /.error-page -->
                </div>
            </div>
        </div>
    </body>
</html>
