@extends('extensions::index')
@section('header-content') <i class="fa fa-gear"></i> Add Extensions @stop
@section('list-content')
<div class="row icheck" id="extensions">
    <div class="col-xs-12">
        <div class="nav-tabs-custom main-tabs">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#featured" data-toggle="tab">Featured</a></li>
                <li><a href="#popular" data-toggle="tab">Popular</a></li>
                <li><a href="#recommended" data-toggle="tab">Recommended</a></li>
                <li class="btn btn-info">Upload Extension</li>

                <li class="pull-right"><input type="text" class="form-control" name="search" placeholder="Search Extensions" /></li>
            </ul>
            <div class="tab-content">

                <div class="tab-pane active" id="featured">
                    <h4>Extensions</h4>
                    <p>Extensions adds functionalities to SHINE OS+. You may automatically install extensions from the SHINE OS+ Extension Directory or if you have downloaded them, upload the extension in .zip format via this page.</p>
                    <div class="col-md-12">
                        <div class="col-md-6 extBox">
                          {!! Form::open(array('url' => 'extensions/install/module', 'class'=>'extBoxForm')) !!}
                          <div class="box box-solid box-default with-border">
                            <div class="box-header with-border">
                              <i class="fa fa-cubes"></i>
                              <h3 class="box-title">eLaboratory Module</h3>
                              <input name="extensionID" value="12345678" type="hidden" />
                              <input name="extensionType" value="module" type="hidden" />
                              <input name="extensionBuy" value="month" type="hidden" />
                              <input name="extensionPrice" value="2000" type="hidden" />
                              <input name="extensionName" value="eLaboratory Module" type="hidden" />
                              <input name="extensionDesc" value="The eLaboratory Module makes it possible to encode laboratory results. It can used by laboratory technicians, nurses, health workers and encoders. Data capture with then be available to the doctors during consultations." type="hidden" />
                              <input type="submit" class="btn btn-warning pull-right" value="Subscribe & Install">

                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                              <dl>
                                <dt class="bg-smartlitblue">Lab</dt>
                                <dd name='extDesc'>The eLaboratory Module makes it possible to encode laboratory results. It can used by laboratory technicians, nurses, health workers and encoders. Data capture with then be available to the doctors during consultations.
                                <br /><em>by ShineLabs</em>
                                <br />
                                <p class="lead">Php2,000.00 per month</p>
                                </dd>
                              </dl>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-md-4">
                                    <i class="fa fa-star fa-lg text-red"></i> <i class="fa fa-star fa-lg text-red"></i> <i class="fa fa-star fa-lg text-red"></i> <i class="fa fa-star fa-lg text-red"></i> <i class="fa fa-star-o fa-lg text-red"></i>
                                    <br />100 active install
                                </div>
                                <div class="col-md-8 text-right">
                                    <strong>Updated:</strong> 2 weeks ago<br />
                                </div>
                            </div>
                          </div>
                          {!! Form::close() !!}
                          <!-- /.box -->
                        </div>

                        <div class="col-md-6 extBox">
                          <div class="box box-solid box-default">
                            <div class="box-header with-border">
                              <i class="fa fa-plug"></i>
                              <h3 class="box-title">Patient Employment Information Plugin</h3>
                              {!! Form::open(array('url' => 'extensions/install/plugin', 'class'=>'extBoxForm')) !!}
                              <input name="extensionID" value="12345678" type="hidden" />
                              <input name="extensionType" value="plugin" type="hidden" />
                              <input type="submit" class="btn btn-warning pull-right" value="Install">
                              {!! Form::close() !!}
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                              <dl>
                                <dt class="bg-smartred">PEI</dt>
                                <dd>The Patient Employment Information Plugin. Capture employment data of a patient using this plugin. This is a simple example of data capture plugins. This plugin also creates its own DB Table.
                                <br /><em>by ShineLabs</em>
                                <br />
                                <p class="lead">FREE</p>
                                </dd>
                              </dl>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-md-4">
                                    <i class="fa fa-star fa-lg text-red"></i> <i class="fa fa-star fa-lg text-red"></i> <i class="fa fa-star-o fa-lg text-red"></i> <i class="fa fa-star-o fa-lg text-red"></i> <i class="fa fa-star-o fa-lg text-red"></i>
                                    <br />100 active install
                                </div>
                                <div class="col-md-8 text-right">
                                    <strong>Updated:</strong> 2 weeks ago<br />
                                </div>
                            </div>
                          </div>
                          <!-- /.box -->
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6 extBox">
                          <div class="box box-solid box-default">
                            <div class="box-header with-border">
                              <i class="fa fa-plug"></i>
                              <h3 class="box-title">Student Information Plugin</h3>
                              {!! Form::open(array('url' => 'extensions/install/plugin', 'class'=>'extBoxForm')) !!}
                              <input name="extensionID" value="12345678" type="hidden" />
                              <input name="extensionType" value="plugin" type="hidden" />
                              <input name="extensionName" value="Student Information Plugin" type="hidden" />
                              <input type="submit" class="btn btn-warning pull-right" value="Install">
                              {!! Form::close() !!}
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                              <dl>
                                <dt>ST</dt>
                                <dd>The Patient Student Information Plugin. Capture student data of a patient using this plugin. This is a simple example of data capture plugins. This plugin also creates its own DB Table.
                                <em>by ShineLabs</em>
                                <br />
                                <p class="lead">FREE</p>
                                </dd>
                              </dl>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-md-4">
                                    <i class="fa fa-star fa-lg text-red"></i> <i class="fa fa-star fa-lg text-red"></i> <i class="fa fa-star fa-lg text-red"></i> <i class="fa fa-star-o fa-lg text-red"></i> <i class="fa fa-star-o fa-lg text-red"></i>
                                    <br />100 active install
                                </div>
                                <div class="col-md-8 text-right">
                                    <strong>Updated:</strong> 2 weeks ago<br />
                                </div>
                            </div>
                          </div>
                          <!-- /.box -->
                        </div>

                        <div class="col-md-6 extBox">
                          <div class="box box-solid box-default">
                            <div class="box-header with-border">
                              <i class="fa fa-cubes"></i>
                              <h3 class="box-title">School Clinic Module</h3>
                              {!! Form::open(array('url' => 'extensions/install/module', 'class'=>'extBoxForm')) !!}
                              <input name="extensionID" value="12345678" type="hidden" />
                              <input name="extensionType" value="module" type="hidden" />
                              <input name="extensionBuy" value="single" type="hidden" />
                              <input name="extensionPrice" value="35000" type="hidden" />
                              <input name="extensionName" value="School Clinic Module" type="hidden" />
                              <input name="extensionDesc" value="The School Clinic Module is a module extension that expands the patient module to cover school requirements." type="hidden" />
                              <input type="submit" class="btn btn-warning pull-right" value="Buy & Install">
                              {!! Form::close() !!}
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                              <dl>
                                <dt class="bg-yellow">SC</dt>
                                <dd>The School Clinic Module is a module extension that expands the patient module to cover school requirements.
                                <br /><em>by ShineLabs</em>
                                <br />
                                <p class="lead">Php35,000.00</p>
                                </dd>
                              </dl>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-md-4">
                                    <i class="fa fa-star fa-lg text-red"></i> <i class="fa fa-star-o fa-lg text-red"></i> <i class="fa fa-star-o fa-lg text-red"></i> <i class="fa fa-star-o fa-lg text-red"></i> <i class="fa fa-star-o fa-lg text-red"></i>
                                    <br />20 active install
                                </div>
                                <div class="col-md-8 text-right">
                                    <strong>Updated:</strong> 2 weeks ago<br />
                                </div>
                            </div>
                          </div>
                          <!-- /.box -->
                        </div>
                    </div>

                    <br clear="all" />
                </div>

                <div class="tab-pane" id="popular">
                    <div class="col-md-12">
                        <h4>Extensions</h4>
                        <p>Popularity based on the number of installations.</p>
                    </div>
                    <br clear="all" />
                </div>

                <div class="tab-pane" id="recommended">
                        <div class="col-md-12">
                            <h4>Extensions</h4>
                            <p>Recommended extensions based on reviews.</p>
                        </div>
                        <br clear="all" />
                    </div>

            </div>

    </div>
</div>
@stop
