
{!! Form::open(array('route' => 'insert')) !!}
{!! Form::hidden('action', 'tb') !!}
{!! Form::hidden('hservices_id', $consultID) !!}
<fieldset>
    <legend>Tuberculosis</legend>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-md-3 control-label">TB Case No. <!--<br/><small>YYFFFCCC ex.12021001 </small><br /><small>Y-Year F-Facility Code C-Case Number</small>--></label>
                <div class="col-md-8">
                    <input class="form-control required" type="text" name="case_no">
                </div>
            </div><!--./tb case no-->

            <!--<strong>Diagnostic Tests</strong>-->
            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">BCG Scar</label>
                    <div class="col-md-8">
                            <div class="radio inline">
                                <label>
                                  <input type="radio" name="r_bcg" id="" value="1" checked="true"> Yes
                                </label>
                            </div>

                            <div class="radio inline">
                                <label>
                                  <input type="radio" name="r_bcg" id="" value="2"> No
                                </label>
                            </div>

                            <div class="radio inline">
                                <label>
                                  <input type="radio" name="r_bcg" id="" value="3"> Doubtful
                                </label>
                            </div>
                    </div>
                </div><!--./form-group-->
            </div> <!--end row-->

            <div class="row">

                <div class="form-group">
                    <label class="col-md-3 control-label">1. Tuberculin Skin Test (TST)</label>
                    <div class="col-md-8">
                        Result: <input class="form-control" type="text" placeholder="" name="diag[1][result]">
                        Date Read: <input class="form-control" type="date" name="diag[1][date]"> 
                    </div>
                </div><!--./tbt-->

                <div class="form-group">
                    <label class="col-md-3 control-label">2. CXR Findings</label>
                    <div class="col-md-8">
                        TBDC: <input class="form-control" type="text" name="diag[2][result]">
                        Date Read: <input class="form-control" type="date" name="diag[2][date]"> 
                    </div>
                </div><!--./cxr findings-->

                <div class="form-group">
                    <label class="col-md-3 control-label">3. Other exam</label>
                    <div class="col-md-8">
                        <input class="form-control" type="hidden" value="" name="diag[3][result]">  
                        Date of exam: <input class="form-control" type="date" name="diag[3][date]">  
                    </div>
                </div><!--./others-->

                <div class="form-group">
                    <label class="col-md-3 control-label">4. XPERT MTB/RIF Result</label>
                    <div class="col-md-8">
                        Result: <input class="form-control" type="text" name="diag[4][result]">
                        Date Collected: <input class="form-control" type="date" name="diag[4][date]"> 
                    </div>
                </div><!--./others-->
            </div> <!--end row-->

            <div class="row">

                <label>5. DSSM Results</label>
                <table>
                    <th>Month</th>
                    <th>Due Date</th>
                    <th>Date Examined</th>
                    <th>Result</th>
                    <tr>
                        <td>0</td>
                        <td><input class="form-control" type="text" readonly></td>
                        <td><input class="form-control" type="date"></td>
                        <td><input class="form-control" type="text"></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><input class="form-control" type="date"></td>
                        <td><input class="form-control" type="date"></td>
                        <td><input class="form-control" type="text"></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td><input class="form-control" type="date"></td>
                        <td><input class="form-control" type="date"></td>
                        <td><input class="form-control" type="text"></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td><input class="form-control" type="date"></td>
                        <td><input class="form-control" type="date"></td>
                        <td><input class="form-control" type="text"></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td><input class="form-control" type="date"></td>
                        <td><input class="form-control" type="date"></td>
                        <td><input class="form-control" type="text"></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td><input class="form-control" type="date"></td>
                        <td><input class="form-control" type="date"></td>
                        <td><input class="form-control" type="text"></td>
                    </tr>
                    <tr>
                        <td> 7</td>
                        <td><input class="form-control" type="date"></td>
                        <td><input class="form-control" type="date"></td>
                        <td><input class="form-control" type="text"></td>
                    </tr>
                </table>
            </div> <!--end row-->

            <div class="row" style="margin-top : 10px">

                <div class="form-group">
                    <label class="col-md-3 control-label">6. PICT done?</label>
                    <div class="col-md-8">
                            <div class="radio inline">
                                <label>
                                  <input type="radio" name="" id="" value="" checked="true"> Yes
                                </label>
                            </div>

                            <div class="radio inline">
                                <label>
                                  <input type="radio" name="" id="" value=""> No
                                </label>
                            </div>
                    </div>
                </div><!--./form-group-->
            </div> <!--end row-->

             <div class="row" style="margin-top : 10px">

                <div class="form-group">
                    <label class="col-md-3 control-label">Diagnosis</label>
                    <div class="col-md-8">
                        <select class="form-control">
                            <option>TB Disease</option>
                            <option>TB Infection, for IPT (for children below 5 yo)</option>
                            <option>TB Exposure, for IPT (for children below 5 yo)</option>
                        </select>
                    </div>
                </div><!--./others-->
            </div> <!--end row-->

        </div><!--./col-xs-6-->

        <div class="col-xs-6">
            <div class="row">
                <div class="pull-left"><h5>Household Members</h5></div>
                <div class="pull-right"><button class="btn btn-primary">Add member</button></div>            
                <table class="table table-bordered">
                    <th>First Name</th>
                    <th>Age</th>
                    <th>Date Screened</th>
                    <tr>
                        <td>Sample</td>
                        <td>Sample</td>
                        <td>Sample</td>
                </table>
            </div> <!--end row-->


            <div class="row">

                History of Anti-TB Drug Intake
                <div class="form-group">
                    <div class="radio inline">
                        <label>
                          <input type="radio" name="" id="" value="1"> Yes
                        </label>
                    </div>

                    <div class="radio inline">
                        <label>
                          <input type="radio" name="" id="" value="0"> No
                        </label>
                    </div>
                </div><!--./tbt-->
            </div> <!--end row-->

           <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">When</label>
                    <div class="col-md-8">
                        <input class="form-control" type="date" name="drugintake_when"> 
                    </div>
                </div><!--./tbt-->

                <div class="form-group">
                    <label class="col-md-3 control-label">Duration</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text"> 
                    </div>
                </div><!--./tbt-->

                <div class="form-group">
                    <label class="col-md-3 control-label">Drugs Taken</label>
                    <div class="col-md-8">
                        H <input type="checkbox" name>
                        R <input type="checkbox">
                        Z <input type="checkbox">
                        E <input type="checkbox">
                        S <input type="checkbox">
                    </div>
                </div><!--./tbt-->
            </div> <!--end row-->


                 <div class="row">

                    <div class="form-group">
                        <label class="col-md-3 control-label">Bacteriological Status</label>
                        <div class="col-md-8">
                            <select class="form-control">
                                <option>Bacteriologically Confirmed</option>
                                <option>Clinically Diagnosed</option>
                            </select>
                        </div>
                    </div><!--./tbt-->
                </div> <!--end row-->

                <div class="row">

                    <div class="form-group">
                        <label class="col-md-3 control-label">Anatomical Site</label>
                        <div class="col-md-8">
                            <select class="form-control">
                                <option>Pulmonary</option>
                                <option>Extra-pulmonary</option>
                            </select>
                        </div>
                    </div><!--./tbt-->
                </div> <!--end row-->

                 <div class="row">

                    <div class="form-group">
                        <label class="col-md-3 control-label">Registration Group</label>
                        <div class="col-md-8">
                            <select class="form-control">
                                <option>New</option>
                                <option>Relapse</option>
                                <option>Treatment after failure</option>
                                <option>TALF</option>
                                <option>PTOU</option>
                                <option>Other</option>
                                <option>Transfer-in</option>
                            </select>
                        </div>
                    </div><!--./tbt-->
                </div> <!--end row-->
            


            
            <div class="row">
                     <label>TB DISEASE TREATMENT REGIMEN (click one)</label>
                    <div class="col-md-6">
                        <strong>I. 2HRZE*/4HR</strong><br />
                        <input type="checkbox"> PTB, New-bacteriologically confirmed <br />
                        <input type="checkbox"> PTB, New-clinically diagnosed <br />
                        <input type="checkbox"> EPTB, New <br />

                        <br />
                        <strong>I. 2HRZE*/4HR</strong><br />
                        <input type="checkbox"> EPTB, New-CNS/bones or joint <br /><br />

                        <small>*For children < 4weeks, it should be S instead of E </small>
                    </div>
                    
                    <div class="col-md-6">
                        <strong>II. 2HRZES/1HRZE/5HRE</strong><br />
                        <input type="checkbox"> Relapse <br />
                        <input type="checkbox"> Treatment after failure <br />
                        <input type="checkbox"> TALF <br />
                        <input type="checkbox"> Previous Treatment Outcome Unknown <br />

                        <br />
                        <strong>II. 2HRZES/1HRZE/9HRE</strong><br />
                        <input type="checkbox"> EPTB, Retx-CNS/bones or joint<br />

                    </div>
            </div><!--./row-->

            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Date Treatment / IPT Started</label>
                    <div class="col-md-8">
                        <input type="date" class="form-control">
                    </div>
                </div><!--./tbt-->
            <div> <!--end row-->

             <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Treatment Outcome</label>
                    <div class="col-md-8">
                        <select class="form-control" name="treat_outcome">
                            <option value="1">Cured</option>
                            <option value="2">Treatment Completed</option>
                            <option value="3">Died</option>
                            <option value="4">Failed</option>
                            <option value="5">Lost to follow-up</option>
                            <option value="6">Not evaluated</option>
                            <option value="7">Excluded from cohort</option>
                        </select>
                    </div>
                </div><!--./tbt-->
            <div> <!--end row-->
            


            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Remarks</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control">
                    </div>
                </div><!--./tbt-->
            </div>
        </div><!--./col-xs-6-->

       
    </div>

</fieldset>

     <div class="row">
            <button type="submit" class="btn btn-primary pull-right">Add</button>
        </div>

{!! Form::close() !!}