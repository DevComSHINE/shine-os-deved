@extends('extensions::index')
@section('header-content') <i class="fa fa-credit-card"></i> Pay &amp; Install @stop
@section('list-content')
    <div class="row">
        <div class="col-xs-12">
            <h3>{{ $extensionName }}</h3>
            <p>{{ $extensionDesc }}</p>
            <p class="lead no-margin">Subscription Price:</p>
            <h4 class="btn btn-danger text-white btn-lg no-margin"><strong>Php {{ number_format($extensionPrice,2,".",",") }} @if($extensionBuy!='single')/ {{ $extensionBuy }}@endif</strong></h4>
            <hr />
        </div>
        <!-- You can make it whatever width you want. I'm making it full width
             on <= small devices and 4/12 page width on >= medium devices -->
        <form role="form" id="payment-form" method="POST" action="javascript:void(0);">
            <div class="col-xs-12 col-md-6">
                <div class="panel panel-default credit-card-box">
                    <div class="panel-heading" >
                        <div class="roww" >
                            <h3 class="panel-title" >Personal Details</h3>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <fieldset class="col-xs-12">
                              <legend>Personal Information</legend>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-12 control-label" for="textinput">First Name</label>
                                    <input type="text" class="form-control notempty" name="firstname" />
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-12 control-label" for="textinput">Last Name</label>
                                    <input type="text" class="form-control notempty" name="lastname" />
                                </div>

                              <!-- Form Name -->
                              <legend>Billing Details</legend>

                              <!-- Street -->
                              <div class="form-group">
                                <label class="col-sm-4 control-label" for="textinput">Street</label>
                                <div class="col-sm-6">
                                  <input type="text" name="street" placeholder="Street" class="address form-control notempty">
                                </div>
                              </div>

                              <!-- City -->
                              <div class="form-group">
                                <label class="col-sm-4 control-label" for="textinput">City</label>
                                <div class="col-sm-6">
                                  <input type="text" name="city" placeholder="City" class="form-control notempty">
                                </div>
                              </div>

                              <!-- State -->
                              <div class="form-group">
                                <label class="col-sm-4 control-label" for="textinput">Province/State</label>
                                <div class="col-sm-6">
                                  <input type="text" name="province" placeholder="Province/State" class="form-control notempty">
                                </div>
                              </div>

                              <!-- Postcal Code -->
                              <div class="form-group">
                                <label class="col-sm-4 control-label" for="textinput">Postal Code</label>
                                <div class="col-sm-6">
                                  <input type="text" name="zip" placeholder="Postal Code" class="form-control notempty">
                                </div>
                              </div>

                              <!-- Country -->
                              <div class="form-group">
                                <label class="col-sm-4 control-label" for="textinput">Country</label>
                                <div class="col-sm-6">
                                  <!--input type="text" name="country" placeholder="Country" class="country form-control"-->
                                  <div class="country bfh-selectbox bfh-countries" name="country" placeholder="Select Country" data-flags="true" data-filter="true"> </div>
                                </div>
                                <br clear="all" />
                              </div>

                              <!-- Email -->
                              <div class="form-group">
                                <label class="col-sm-4 control-label" for="textinput">Email</label>
                                <div class="col-sm-6">
                                  <input type="text" name="email" maxlength="65" placeholder="Email" class="email form-control">
                                </div>
                              </div>
                              </fieldset>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-6">
                <!-- CREDIT CARD FORM STARTS HERE -->
                <div class="panel panel-default credit-card-box">

                    <div class="panel-heading display-table col-sm-12" >
                        <div class="row display-tr" >
                            <h3 class="panel-title display-td" >Payment Details</h3>
                            <div class="display-td" >
                                <img class="img-responsive pull-right" src="{{ asset('public/dist/img/paymaya.png') }}">
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <fieldset class="col-xs-12">
                                <legend>Card Details</legend>

                                <!-- Card Holder Name -->
                                <div class="form-group">
                                  <label class="col-sm-4 control-label"  for="textinput">Card Holder's Name</label>
                                  <div class="col-sm-6">
                                    <input type="text" name="cardholdername" maxlength="70" placeholder="Card Holder Name" class="card-holder-name form-control">
                                  </div>
                                </div>

                                <!-- Card Number -->
                                <div class="form-group">
                                  <label class="col-sm-4 control-label" for="textinput">Card Number</label>
                                  <div class="col-sm-6">
                                    <input type="text" id="cardnumber" maxlength="19" placeholder="Card Number" class="card-number form-control">
                                  </div>
                                </div>

                                <!-- Expiry-->
                                <div class="form-group">
                                  <label class="col-sm-4 control-label" for="textinput">Card Expiry Date</label>
                                  <div class="col-sm-6">
                                    <div class="form-inline">
                                      <select name="select2" data-stripe="exp-month" class="card-expiry-month stripe-sensitive required form-control">
                                        <option value="01" selected="selected">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                      </select>
                                      <span> / </span>
                                      <select name="select2" data-stripe="exp-year" class="card-expiry-year stripe-sensitive required form-control">
                                      </select>
                                      <script type="text/javascript">
                                        var select = $(".card-expiry-year"),
                                        year = new Date().getFullYear();

                                        for (var i = 0; i < 12; i++) {
                                            select.append($("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
                                        }
                                    </script>
                                    </div>
                                  </div>
                                </div>

                                <!-- CVV -->
                                <div class="form-group">
                                  <label class="col-sm-4 control-label" for="textinput">CVV/CVV2</label>
                                  <div class="col-sm-3">
                                    <input type="text" id="cvv" placeholder="CVV" maxlength="4" class="card-cvc form-control">
                                  </div>
                                </div>

                                <br clear="all" />
                                <!-- Important notice -->
                                <div class="form-group col-xs-12">
                                    <div class="panel panel-success">
                                      <div class="panel-heading">
                                        <h3 class="panel-title">Important notice</h3>
                                      </div>
                                      <div class="panel-body">
                                        <p>Your card will be charged Php {{ number_format($extensionPrice,2,".",",") }} @if($extensionBuy!='single')/ {{ $extensionBuy }}@endif after submit.</p>
                                        <p>Your account statement will show the following booking text:
                                          ShineOS+ Extensions</p>
                                      </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="control-group">
                                      <div class="controls">
                                        <center>
                                          <button class="btn btn-success" type="submit">Pay Now</button>
                                        </center>
                                      </div>
                                    </div>
                                </div>
                        </fieldset>
                    </div>
                </div>
                <!-- CREDIT CARD FORM ENDS HERE -->
            </div>
            </div>
        </form>

    </div>

@stop
