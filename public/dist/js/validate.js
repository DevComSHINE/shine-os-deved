/**
* ShineOS+ Form Validation
*
* ShineOS+ V3.0
**/

"use strict";

//common validators
var numericonly = {
        validators: {
          numeric: {
                message: 'The value is not a number',
                // The default separators
                thousandsSeparator: '',
                decimalSeparator: '.'
            }
        }
    };
var requiredalphaonly = {
        validators: {
          regexp: {
              regexp: /^[-a-zñÑ\s]+$/i,
              message: 'Alphabetical characters and spaces only'
          },
          notEmpty: {
            message: 'This is required and can\'t be empty'
          }
        }
    };
var alphaonly = {
        validators: {
          regexp: {
              regexp: /^[-a-zñÑ\s]+$/i,
              message: 'Alphabetical characters and spaces only'
          }
        }
    };
var telephoneonly = {
        validators: {
              regexp: {
                  regexp: /^[-0-9\s]+$/i,
                  message: 'Numbers and dashes only'
              },
              stringLength: {
                min: '10',
                max: '10',
                message: 'The value must be a valid phone string'
              }
            }
};
var mobileonly = {
    validators: {
              notEmpty: {
                message: 'Mobile Number is required and can\'t be empty'
              },
              regexp: {
                  regexp: /^[-0-9\s]+$/i,
                  message: 'Numbers and dashes only'
              },
              stringLength: {
                min: '12',
                max: '12',
                message: 'The value must be a valid phone string'
              }
            }
};

$(document).ready(function() {

    $('form').bootstrapValidator({
        message: 'This value is not valid',
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
          role: {
            validators: {
              notEmpty: {
                message: 'User Role is required and can\'t be empty'
              }
            }
          },
          first_name: requiredalphaonly,
          last_name: requiredalphaonly,
          inputPatientFirstName: requiredalphaonly,
          inputPatientLastName:  requiredalphaonly,
          inputPatientMiddleName:  requiredalphaonly,
          email: {
            validators: {
              notEmpty: {
                message: 'The Email Address is required and can\'t be empty'
              },
              emailAddress: {
                message: 'The input is not a valid email address'
              }
            }
          },
          phone: telephoneonly,
          emergency_phone: telephoneonly,
          mobile: mobileonly,
          emergency_mobile: mobileonly,
          inputPatientBirthDate: {
                validators: {
                    date: {
                        format: 'MM/DD/YYYY',
                        message: 'The value is not a valid date'
                    }
                }
          },
          inputPatientPhoneExtension: {
            numeric: {
                message: 'The value is not a number'
            }
          },
          inputPatientZip: {
                validators: {
                    regexp: {
                        regexp: /^\d{4}$/,
                        message: 'The zipcode must contain 4 digits'
                    }
                }
          },
          company_zip: {
              validators: {
                regexp: {
                    regexp: /^\d{4}$/,
                    message: 'The zipcode must contain 4 digits'
                }
            }
          },
          temperature: {
                validators: {
                    numeric: {
                        message: 'The temperature must contain numbers'
                    },
                    between: {
                        min: 29,
                        max: 40,
                        message: 'Must be between 29&deg; and 40&deg;'
                    }
                }
          },
          bloodpressure_systolic: {
              validators: {
                    integer: {
                        message: 'The systolic must contain numbers'
                    },
                    between: {
                        min: 70,
                        max: 200,
                        message: 'Must be between 70 and 200'
                    }
                }
          },
          bloodpressure_diastolic: {
              validators: {
                    integer: {
                        message: 'The diastolic must contain numbers'
                    },
                    between: {
                        min: 40,
                        max: 100,
                        message: 'Must be between 40 and 100'
                    }
                }
          },
          heart_rate: {
              validators: {
                    integer: {
                        message: 'The Heart Rate must contain numbers'
                    },
                    between: {
                        min: 60,
                        max: 200,
                        message: 'Must be between 60 and 200'
                    }
                }
          },
          pulse_rate: {
              validators: {
                    integer: {
                        message: 'The Pulse Rate must contain numbers'
                    },
                    between: {
                        min: 60,
                        max: 200,
                        message: 'Must be between 60 and 200'
                    }
                }
          },
          respiratory_rate: {
              validators: {
                    integer: {
                        message: 'The Respiratory Rate must contain numbers'
                    },
                    between: {
                        min: 12,
                        max: 25,
                        message: 'Must be between 12 and 25'
                    }
                }
          },
          height: {
              validators: {
                    integer: {
                        message: 'The Height must contain numbers'
                    },
                    between: {
                        min: 50,
                        max: 200,
                        message: 'Must be between 50 and 200'
                    }
                }
          },
          weight: {
              validators: {
                    integer: {
                        message: 'The Weight must contain numbers'
                    }
                }
          },
          role: {
              notEmpty: {
                message: 'Please select a role for your new user'
              }
          },
          newPassword: {
                validators: {
                    identical: {
                        field: 'confirmPassword',
                        message: 'The new password and its confirm are not the same'
                    },
                    stringLength: {
                        min: '6'
                    }
                }
            },
            confirmPassword: {
                validators: {
                    identical: {
                        field: 'newPassword',
                        message: 'The new password and its confirm are not the same'
                    },
                    stringLength: {
                        min: '6'
                    }
                }
            },
            "allergy[inputAllergyName][]": requiredalphaonly,
            "inputAlertOthers" : alphaonly,
            "update[MO_MED_PRESCRIPTION][Dose_Qty][]":numericonly,
            "insert[MO_MED_PRESCRIPTION][Dose_Qty][]":numericonly,
            height:numericonly,
            weight:numericonly,
            waist:numericonly
        }
      });
});
