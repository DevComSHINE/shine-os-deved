<div class="tab-pane" id="tab_2">
                <fieldset>
                    <legend>Visits</legend>
                    <div class="col-sm-12">
                        <div class="box no-border">
                          <div class="box-header">
                            <h3 class="box-title text-shine-blue">&nbsp;</h3>
                              <div class="box-tools">
                                <div class="input-group">
                                  <input type="text" name="table_search" class="input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                  <div class="input-group-btn">
                                  <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                                  <a href="{{ url('/patients/add')}}" class="btn btn-sm btn-primary">Add New Visit / Service</a>
                                </div><!-- /.input-group -->
                              </div><!-- /.box-tools -->
                            </div><!-- /.box-title -->
                          </div><!-- /.box-header -->

                          <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                              <tr>
                                <th>Visit ID</th>
                                <th>Encounter Date</th>
                                <th>Patient Name</th>
                                <th>Seen by</th>
                                <th>Service</th>
                                <th>Action</th>
                              </tr>

                              <tr>
                                <td><a href="" class="btn btn-action-text bg-orange text-white btn-xs">39</a></td>
                                <td>2014-08-11</td>
                                <td>John Doe</td>
                                <td>Dr. Reyes</td>
                                <td><span class="badge bg-red">PN</span></td>
                                <td>
                                <a href="{{ url('/consultations/add')}}" style="border: 1px solid #ddd; background-color: #fafafa; color: #363636; padding: 2px 7px" title="Delete User"><i class="fa fa-eye"></i> View</a>
                                <a href="#" style="border: 1px solid #ddd; background-color: #fafafa; color: #363636; padding: 2px 7px" title="Delete User"><i class="fa fa-pencil"></i> Edit</a>
                                <a href="#" style="border: 1px solid #ddd; background-color: #fafafa; color: #363636; padding: 2px 7px" title="Delete User"><i class="fa fa-trash-o"></i> Delete</a>
                                </td>
                              </tr>

                              <tr>
                                <td><a href="" class="btn btn-action-text bg-orange text-white btn-xs">39</a></td>
                                <td>2014-08-11</td>
                                <td>John Doe</td>
                                <td>Dr. Reyes</td>
                                <td><span class="badge bg-red">PN</span></td>
                                <td>
                                <a href="{{ url('/consultations/add')}}" style="border: 1px solid #ddd; background-color: #fafafa; color: #363636; padding: 2px 7px" title="Delete User"><i class="fa fa-eye"></i> View</a>
                                <a href="#" style="border: 1px solid #ddd; background-color: #fafafa; color: #363636; padding: 2px 7px" title="Delete User"><i class="fa fa-pencil"></i> Edit</a>
                                <a href="#" style="border: 1px solid #ddd; background-color: #fafafa; color: #363636; padding: 2px 7px" title="Delete User"><i class="fa fa-trash-o"></i> Delete</a>
                                </td>
                              </tr>

                              <tr>
                                <td><a href="" class="btn btn-action-text bg-orange text-white btn-xs">39</a></td>
                                <td>2014-08-11</td>
                                <td>John Doe</td>
                                <td>Dr. Reyes</td>
                                <td><span class="badge bg-red">PN</span></td>
                                <td>
                                <a href="{{ url('/consultations/add')}}" style="border: 1px solid #ddd; background-color: #fafafa; color: #363636; padding: 2px 7px" title="Delete User"><i class="fa fa-eye"></i> View</a>
                                <a href="#" style="border: 1px solid #ddd; background-color: #fafafa; color: #363636; padding: 2px 7px" title="Delete User"><i class="fa fa-pencil"></i> Edit</a>
                                <a href="#" style="border: 1px solid #ddd; background-color: #fafafa; color: #363636; padding: 2px 7px" title="Delete User"><i class="fa fa-trash-o"></i> Delete</a>
                                </td>
                              </tr>

                              <tr>
                                <td><a href="" class="btn btn-action-text bg-orange text-white btn-xs">39</a></td>
                                <td>2014-08-11</td>
                                <td>John Doe</td>
                                <td>Dr. Reyes</td>
                                <td><span class="badge bg-red">PN</span></td>
                                <td>
                                <a href="{{ url('/consultations/add')}}" style="border: 1px solid #ddd; background-color: #fafafa; color: #363636; padding: 2px 7px" title="Delete User"><i class="fa fa-eye"></i> View</a>
                                <a href="#" style="border: 1px solid #ddd; background-color: #fafafa; color: #363636; padding: 2px 7px" title="Delete User"><i class="fa fa-pencil"></i> Edit</a>
                                <a href="#" style="border: 1px solid #ddd; background-color: #fafafa; color: #363636; padding: 2px 7px" title="Delete User"><i class="fa fa-trash-o"></i> Delete</a>
                                </td>
                              </tr>
                            </table>
                          </div><!-- /.box-body -->
                          <div class="box-footer clearfix">
                            <p class="pull-left">Showing 50 out of 100 entries</p>
                            <ul class="pagination pagination-sm no-margin pull-right">
                              <li><a href="#">«</a></li>
                              <li><a href="#">1</a></li>
                              <li><a href="#">2</a></li>
                              <li><a href="#">3</a></li>
                              <li><a href="#">»</a></li>
                            </ul>
                          </div><!-- /.box-footer -->
                        </div><!-- /.box -->
                    </div>
                </fieldset>
          </div><!-- /.tab-pane -->
