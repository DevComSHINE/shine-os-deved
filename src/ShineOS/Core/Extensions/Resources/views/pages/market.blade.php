@extends('extensions::index')
@section('header-content') Add Extensions @stop
@section('list-content')
<div class="row icheck" id="extensions">
    <div class="col-xs-12">
        <div class="nav-tabs-custom main-tabs">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#modules" data-toggle="tab">Featured</a></li>
                <li><a href="#plugins" data-toggle="tab">Popular</a></li>
                <li><a href="#plugins" data-toggle="tab">Recommended</a></li>
                <li><a href="#plugins" data-toggle="tab">Favorites</a></li>
                <li class="btn btn-info hidden">Upload Extension</li>

                <li class="pull-right">Search</li>
            </ul>
            <div class="tab-content">

                <div class="tab-pane active" id="modules">
                    <h4>Extensions</h4>
                    <p>Extensions adds functionalities to ShineOS+. You may automatically install extensions from the ShineOS+ Extension Directory or if you have downloaded them, upload the extension in .zip format via this page.</p>
                    {!! Form::open(array('url' => 'extensions/install', 'name'=>'settingsForm', 'class'=>'form-horizontal')) !!}

                        <div class="col-md-6">
                          <div class="box box-solid box-default">
                            <div class="box-header with-border">
                              <i class="fa fa-text-width"></i>

                              <h3 class="box-title">Description</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                              <dl>
                                <dt>Description lists</dt>
                                <dd>A description list is perfect for defining terms.</dd>
                                <dt>Euismod</dt>
                                <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</dd>
                                <dd>Donec id elit non mi porta gravida at eget metus.</dd>
                                <dt>Malesuada porta</dt>
                                <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
                              </dl>
                            </div>
                            <!-- /.box-body -->
                          </div>
                          <!-- /.box -->
                        </div>

                        <div class="col-md-6">
                          <div class="box box-solid box-default">
                            <div class="box-header with-border">
                              <i class="fa fa-text-width"></i>

                              <h3 class="box-title">Description</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                              <dl>
                                <dt>Description lists</dt>
                                <dd>A description list is perfect for defining terms.</dd>
                                <dt>Euismod</dt>
                                <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</dd>
                                <dd>Donec id elit non mi porta gravida at eget metus.</dd>
                                <dt>Malesuada porta</dt>
                                <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
                              </dl>
                            </div>
                            <!-- /.box-body -->
                          </div>
                          <!-- /.box -->
                        </div>
                    {!! Form::close() !!}

                    <br clear="all" />
                </div>

            </div>
        </div>
    </div>
</div>
@stop
