<!DOCTYPE HTML>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="Content-Language" Content="en">
    <link type="text/css" rel="stylesheet" media="all" href="<?php print shineos_includes_url(); ?>css/install.css"/>
    <link type="text/css" rel="stylesheet" media="all" href="<?php print shineos_includes_url(); ?>css/ui.css"/>

<meta charset="UTF-8">
<title><?php _e("ShineOS v3.0 installation"); ?></title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="description" content="ShineOS+ EMR, the first Philippine Health Exchange System">
<meta name="author" content="ShineOS+">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<meta name="apple-mobile-web-app-title" content="ShineOS+">
<link href="{{ asset('public/dist/img/icon.png') }}"
      sizes="152x152"
      rel="apple-touch-icon">
<link rel='shortcut icon' type='image/x-icon' href='<?php echo shineos_includes_url(); ?>img/favicon.ico' />
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!--Global Fonts-->
<link href='http://fonts.googleapis.com/css?family=Raleway:100,200,300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700|Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,100' rel='stylesheet' type='text/css'>
<!-- FontAwesome 4.3.0 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<!--Global styles-->

<!-- Bootstrap 3.3.4 helloooo-->
<link rel="stylesheet" href="<?php echo shineos_includes_url(); ?>css/bootstrap.min.css">
<!-- Bootstrap Switch -->
<link rel="stylesheet" href="<?php echo shineos_includes_url(); ?>css/bootstrap-switch.min.css">
    <link rel="stylesheet" href="<?php echo shineos_includes_url(); ?>css/install.css">
<!-- FontAwesome 4.3.0 -->

<style>

</style>

<script type="text/javascript" src="<?php print shineos_includes_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script type="text/javascript" src="<?php print shineos_includes_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php print shineos_includes_url(); ?>plugins/jQueryUI/jquery-ui.min.js"></script>

    <?php
    $rand = uniqid();
    $ua = $_SERVER["HTTP_USER_AGENT"];
    $defhost = strpos($_SERVER["HTTP_USER_AGENT"], 'Linux') ? 'localhost' : '127.0.0.1';
    ?>
    <script type="text/javascript">
        function prefix_add(el) {
            var val = el.value.replace(/ /g, '').replace(/[^\w\s]/gi, '');
            el.value = val;
            if (val != '') {
                var last = val.slice(-1);
                if (last != '_') {
                    el.value = el.value + '_';
                }
            }
        }

        function showForm(select) {
            var def = false;
            for(var i=0; i<select.options.length; i++) {
                var v = select.selectedIndex == i;
                def = def || setFormDisplay(select.options[i].value, v);
            }
            $('#db_name_value').val('');



            setFormDisplay('', !def);
        }

        function setFormDisplay(id, show) {
            var el = $('#db-form' + (id.length ? '-'+id : ''));
            if(el.length) {
                $(el).css('display', (show ? 'block' : 'none'));
                return show;
            }
            return false;
        }

        $(document).ready(function () {
            $("input[name='table_prefix']").bind('keydown', function (e) {
                if (( e.keycode || e.which ) == 32) {
                    e.preventDefault();
                }
            });

            showForm($("select[name='db_driver']")[0]);
            $('#form_<?php print $rand; ?>').submit(function () {

                if (this.elements["admin_password"].value != this.elements["admin_password2"].value) {
                    alert("<?php _e("Passwords don't match."); ?>");
                    return false;
                }
                $('#shineos_log').hide();
                installprogress();
                $('.shineos-install-holder').slideUp();

                $data = $('#form_<?php print $rand; ?>').serialize();

                $.post("<?php print site_url() ?>", $data,
                    function (data) {
                        if (data.indexOf('Warning') !== -1) {
                            installprogressStop()
                        }
                        $('#shineos_log').hide().empty();
                        if (data != undefined) {
                            if (data == 'done') {
                                //location.reload();
                                window.location.href = "<?php print admin_url(); ?>";
                            } else {
                                $('#shineos_log').html(data).show();
                                $('.shineos-install-holder').slideDown();
                            }
                        }
                        $('#installprogressbar').slideUp();
                    });
                return false;
            });
        });

        installprogressStopped = false;

        installprogress = function (reset) {

            if (installprogressStopped) {
                installprogressStopped = false;
                return false;
            }

            var holder = $('#installprogressbar'),
                bar = $(".shineos-ui-progress-bar", holder),
                percent = $(".shineos-ui-progress-percent", holder),
                reset = typeof reset === 'undefined' ? true : reset;

            if (reset === true) {
                bar.width('0%');
                percent.html('0%');
                holder.fadeIn();
            }

            <?php $log_file_url = userfiles_url().'install_log.txt'; ?>
            $.get('<?php print $log_file_url ?>', function (data) {
                var data = data.replace(/\r/g, '');
                var arr = data.split('\n'),
                    l = arr.length,
                    i = 0,
                    last = arr[l-2],
                    percentage = Math.round( ((l-1) / 30) * 100);
                bar[0].style.width = percentage + '%';
                percent.html(percentage + '%');
                if(last == 'done') {
                    percent.html('0%');
                    installprogressStop();
                    $("#installinfo").html('');
                }
                else{
                    $("#installinfo").html(last);
                    setTimeout(function(){
                        installprogress(false);
                    }, 1000);
                }

            });
        }

        installprogressStop = function () {
            var holder = $('#installprogressbar'),
                bar = $(".shineos-ui-progress-bar", holder),
                percent = $(".shineos-ui-progress-percent", holder);
            holder.fadeOut();
            bar.width('0%');
            percent.html('0%');
            installprogressStopped = true;
        }


    </script>

</head>
<body>

<div class="installholder">
<small class="version">v. <?php print SHINEOS_VERSION ?></small>
<div class="shineos-ui-box">
<div class="shineos-ui-box-header">
    <a href="http://www.shine.ph" target="_blank" id="logo">
        <span class="shineos-icon-mw"></span>
        <h2>Developer Edition</h2>
    </a>

</div>
<div class="shineos-ui-box-content">
<div class="demo" id="demo-one">
<div class="description">
<div id="shineos_log" class="error shineos-ui-box shineos-ui-box-content" style="display: none"></div>
<div class="shineos_install_progress">
    <div class="shineos-ui-progress" id="installprogressbar" style="display: none">
        <div class="shineos-ui-progress-bar" style="width: 0%;"></div>
        <div class="shineos-ui-progress-info"><?php _e("Installing"); ?></div>
        <span class="shineos-ui-progress-percent">0%</span>
    </div>
    <div id="installinfo"></div>
</div>
<div class="shineos-install-holder">
<?php if ($done == false): ?>
    <?php

    $check_pass = true;
    $server_check_errors = array();
    if (version_compare(phpversion(), "5.4.0", "<=")) {
        $check_pass = false;
        $server_check_errors['php_version'] = _e("You must run PHP 5.4 or greater", true);
    }

    if (function_exists('apache_get_modules')) {
        if (!in_array('mod_rewrite', apache_get_modules())) {
            $check_pass = false;
            $server_check_errors['mod_rewrite'] = _e("mod_rewrite is not enabled on your server", true);
        }
    }

    if (!extension_loaded("dom")) {
        $check_pass = false;
        $server_check_errors['dom'] = _e("The DOM PHP extension must be loaded", true);
    }

    if (!extension_loaded("xml")) {
        $check_pass = false;
        $server_check_errors['xml'] = _e("The lib-xml PHP extension must be loaded", true);
    }

    if (!extension_loaded("json")) {
        $check_pass = false;
        $server_check_errors['json'] = _e("The json PHP extension must be loaded", true);
    }

    $is_pdo_loaded = false;
    if (class_exists('PDO', false)) {
        $is_pdo_loaded = true;
    }
    if ($is_pdo_loaded == false) {
        if (extension_loaded('pdo')) {
            $is_pdo_loaded = true;
        }
    }
    if ($is_pdo_loaded == false) {
        if (defined('PDO::ATTR_DRIVER_NAME')) {
            $is_pdo_loaded = true;
        }
    }

    if ($is_pdo_loaded != false) {
        if (!defined('PDO::MYSQL_ATTR_LOCAL_INFILE')) {
            $is_pdo_loaded = false;
        }
    }
    if ($is_pdo_loaded == false) {
        $check_pass = false;
        $server_check_errors['pdo'] = "The PDO MYSQL PHP extension must be loaded";
    }
    if (extension_loaded('gd') && function_exists('gd_info')) {

    } else {
        $check_pass = false;
        $server_check_errors['gd'] = _e("The GD extension must be loaded in PHP", true);
    }

    if (defined('SHINEOS_USERFILES') and is_dir(SHINEOS_USERFILES) and !is_writable(SHINEOS_USERFILES)) {
        $check_pass = false;
        $must_be = SHINEOS_USERFILES;
        $server_check_errors['SHINEOS_USERFILES'] = _e("The directory " . SHINEOS_USERFILES . " must be writable", true);
    }

    if (defined('SHINEOS_CACHE_ROOT_DIR') and is_dir(SHINEOS_CACHE_ROOT_DIR) and !is_writable(SHINEOS_CACHE_ROOT_DIR)) {
        $check_pass = false;
        $must_be = SHINEOS_CACHE_ROOT_DIR;
        $server_check_errors['SHINEOS_CACHE_ROOT_DIR'] = _e("The directory " . SHINEOS_CACHE_ROOT_DIR . " must be writable", true);
    }


    if (defined('SHINEOS_CACHE_ROOT_DIR') and is_dir(SHINEOS_CACHE_ROOT_DIR) and !is_writable(SHINEOS_CACHE_ROOT_DIR)) {
        $check_pass = false;
        $must_be = SHINEOS_CACHE_ROOT_DIR;
        $server_check_errors['SHINEOS_CACHE_ROOT_DIR'] = _e("The directory " . SHINEOS_CACHE_ROOT_DIR . " must be writable", true);
    }

    if (function_exists('media_base_path') and is_dir(media_base_path()) and !is_writable(media_base_path())) {
        $check_pass = false;
        $must_be = media_base_path();
        $server_check_errors['media_base_path'] = _e("The directory " . media_base_path() . " must be writable", true);
    }
    ?>
    <?php if ($check_pass == false): ?>
        <?php if (!empty($server_check_errors)): ?>
            <h3>
                <?php _e("Server check"); ?>
            </h3>
            <h4>
                <?php _e("There are some errors on your server that will prevent Microweber from working properly"); ?>
            </h4>
            <ol class="error">
                <?php foreach ($server_check_errors as $server_check_error): ?>
                    <li> <?php print $server_check_error; ?> </li>
                <?php endforeach ?>
            </ol>
        <?php endif; ?>
    <?php else: ?>
        <?php $hide_db_setup = isset($_REQUEST['basic']); ?>
        <form method="post" id="form_<?php print $rand; ?>" autocomplete="true">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="shineos-ui-row" id="install-row">
                <div class="shineos-ui-col">
                    <div class="shineos-ui-col-container">
                        <div
                            id="shineos_db_setup_toggle" <?php if ($hide_db_setup == true): ?> style="display:none;" <?php endif; ?>>

                            <?php if (!$hide_db_setup): ?>
                                <h2>
                                    <?php _e("Database Server"); ?>
                                </h2>
                            <?php else: ?>
                                <h2>
                  <span class="shineos-ui-btn" onclick="$('#shineos_db_setup_toggle').toggle();">
                  <?php _e("Database Server"); ?>
                  </span>
                                </h2>
                            <?php endif; ?>
                            <div class="hr"></div>
                            <div class="shineos-ui-field-holder">
                                <label class="shineos-ui-label">
                                    Database Engine
                                    <span data-help="Choose the database type"><span
                                            class="shineos-icon-help-outline mwahi tip"></span></span></label>

                                 <select class=" shineos-ui-field form-control" name="db_driver"
                                    onchange="showForm(this)">
                                    <?php foreach ($dbEngines as $engine): ?>
                                        <option value="<?php echo $engine; ?>"
                                            <?php if ($dbDefaultEngine == $engine) echo 'selected'; ?>>
                                            <?php echo $dbEngineNames[$engine]; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="db-form">
                                <div class="shineos-ui-field-holder">
                                    <label class="shineos-ui-label">
                                        <?php _e("Hostname"); ?>
                                        <span data-help="<?php _e("The address of your database server"); ?>"><span
                                                class="shineos-icon-help-outline mwahi"></span></span></label>
                                    <input type="text" class="shineos-ui-field form-control" autofocus
                                           name="db_host" value="<?php if(isset($config['host'])) echo $config['host']; ?>"/>
                                </div>
                                <div class="shineos-ui-field-holder">
                                    <label class="shineos-ui-label">
                                        <?php _e("Username"); ?>
                                        <span data-help="<?php _e("The username of your database."); ?>"><span
                                                class="shineos-icon-help-outline mwahi tip"></span></span></label>
                                    <input type="text" class="shineos-ui-field form-control"
                                           name="db_user" value="<?php if(isset($config['username'])) echo $config['username']; ?>"/>
                                </div>
                                <div class="shineos-ui-field-holder">
                                    <label class="shineos-ui-label">
                                        <?php _e("Password"); ?>
                                    </label>
                                    <input type="password" class="shineos-ui-field form-control"
                                           name="db_pass" value="<?php if(isset($config['password'])) echo $config['password']; ?>" />
                                </div>
                                <div class="shineos-ui-field-holder">
                                    <label class="shineos-ui-label">
                                        <?php _e("Database"); ?>
                                        <span data-help="<?php _e("The name of your database."); ?>"><span
                                                class="shineos-icon-help-outline mwahi tip"></span></span></label>
                                    <input type="text" class="shineos-ui-field form-control"
                                           name="db_name" id="db_name_value" value="<?php if(isset($config['database'])) echo $config['database']; ?>"/>
                                </div>
                            </div>
                            <div id="db-form-sqlite" style="display:none">
                                <div class="shineos-ui-field-holder">
                                    <label class="shineos-ui-label">
                                        <?php _e("Database file"); ?>
                                        <span data-help="<?php _e("A writable file path that may be relative to the root of your Microweber installation"); ?>">
                                            <span class="shineos-icon-help-outline mwahi tip"></span>
                                        </span>
                                    </label>
                                    <input type="text" class=" shineos-ui-field form-control" autofocus
                                           name="db_name_sqlite" value="<?php if(isset($config['db_name_sqlite'])) echo $config['db_name_sqlite']; ?>"/>
                                </div>
                            </div>
                            <div class="shineos-ui-field-holder">
                                <label class="shineos-ui-label">
                                    <?php _e("Table Prefix"); ?>
                                    <span
                                        data-help="<?php _e("Change this If you want to install multiple instances of Microweber to this database. Only latin letters and numbers are allowed."); ?>"><span
                                            class="shineos-icon-help-outline mwahi tip"></span></span></label>
                                <input type="text" class=" shineos-ui-field form-control"
                                       name="table_prefix" value="<?php if(isset($config['prefix'])) echo $config['prefix']; ?>"
                                       onblur="prefix_add(this)"/>
                            </div>
                            <?php
                            /*$templates = site_templates();


                            ?>
                            <?php if (is_array($templates) and !empty($templates)): ?>


                                <div class="shineos-ui-field-holder">
                                    <label class="shineos-ui-label">
                                        <?php print("Template"); ?>
                                        <span data-help="<?php print("Choose default site template"); ?>"><span
                                                class="shineos-icon-help-outline mwahi tip"></span></span></label>


                                    <select class=" shineos-ui-field form-control" name="default_template">
                                        <?php foreach ($templates as $template): ?>
                                            <?php if (isset($template['dir_name']) and isset($template['name'])): ?>
                                                <option <?php if (isset($template['is_default']) and ($template['is_default']) != false): ?> selected="selected" <?php endif; ?>
                                                    value="<?php print $template['dir_name']; ?>"><?php print $template['name']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>


                                </div>




                            <?php endif;*/ ?>

                                <div class="shineos-ui-field-holder pull-left">
                                    <label class="shineos-ui-check">
                                        <input name="with_default_content" type="checkbox" checked="checked" value="1">
                                        <span></span>&nbsp;
                                        <?php _e("Install default content"); ?>
                                        <span
                                            data-help="<?php _e("If checked, some default content will be added."); ?>"><span
                                                class="shineos-icon-help-outline mwahi tip"></span></span>
                                    </label>
                                </div>

                        </div>

                    </div>
                </div>
                <div id="admin-user">

                    <div class="shineos-ui-col-container">


                        <div class="admin-setup">

                            <h2>
                                <?php _e("Create Admin user"); ?>
                            </h2>

                            <div>
                                <div class="hr"></div>
                                <div class="shineos-ui-field-holder">
                                    <label class="shineos-ui-label">
                                        <?php _e("Admin username"); ?>
                                    </label>
                                    <input type="text" class="shineos-ui-field"
                                           name="admin_username" value="admin" />
                                </div>
                                <div class="shineos-ui-field-holder">
                                    <label class="shineos-ui-label">
                                        <?php _e("Admin email"); ?>
                                    </label>
                                    <input type="text" class=" shineos-ui-field form-control"
                                           name="admin_email" value="admin@shine.ph" />
                                </div>
                                <div class="shineos-ui-field-holder">
                                    <label class="shineos-ui-label">
                                        <?php _e("Admin password"); ?>
                                    </label>
                                    <input type="password" class=" shineos-ui-field form-control"
                                           name="admin_password" value="password" />
                                </div>
                                <div class="shineos-ui-field-holder">
                                    <label class="shineos-ui-label">
                                        <?php _e("Repeat password"); ?>
                                    </label>
                                    <input type="password" class=" shineos-ui-field form-control"
                                           name="admin_password2" value="password"  />
                                </div>
                                <a name="create-admin"></a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>


            <?php $default_content_file = shineos_root_path() . '.htaccess'; ?>

            <div class="shineos_clear"></div>
            <hr />
            <input type="hidden" name="make_install" value="1" id="is_installed_<?php print $rand; ?>">
            <input type="hidden" value="UTC" name="default_timezone"/>
            <input type="submit" name="submit" class="btn btn-big btn-info pull-right" value="<?php _e("Install"); ?>">


        </form>
    <?php endif; ?>
<?php else: ?>
    <h2><?php _e("Welcome to your new website!"); ?></h2>
    <br/>
    <a href="<?php print site_url() ?>admin" class="shineos-ui-btn shineos-ui-btn-info pull-left">
        <?php _e("Login to admin panel"); ?>
    </a> <a href="<?php print site_url() ?>" class="shineos-ui-btn pull-left" style="margin-left: 20px;">
        <?php _e("Visit your site"); ?>
    </a>

<?php endif; ?>
    <br clear="all" />
</div>
<div id="shineos-install-done" style="display:none">
    <h2>
        <?php _e("Installation is completed"); ?>
    </h2>
    <br/>
    <a href="<?php print site_url() ?>" class="shineos-ui-btn">
        <?php _e("Visit your site"); ?>
    </a>
    <a href="<?php print site_url() ?>admin" class="shineos-ui-btn shineos-ui-btn-info">
        <?php _e("Login to admin panel"); ?>
    </a>
</div>
</div>
</div>

</div>
</div>
</div>
</body>
</html>
