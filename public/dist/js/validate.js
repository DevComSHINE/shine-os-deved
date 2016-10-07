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
            message: 'This is field required.'
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
                message: 'Not a valid phone string'
              }
            }
};
var mobileonly = {
    validators: {
              notEmpty: {
                message: 'This is field required.'
              },
              regexp: {
                  regexp: /^[-0-9\s]+$/i,
                  message: 'Numbers and dashes only'
              },
              stringLength: {
                min: '12',
                max: '12',
                message: 'Not a valid phone string'
              }
            }
};

$(document).ready(function() {

    $('form').bootstrapValidator({
        message: 'This value is not valid',
        framework: 'bootstrap',
        excluded: [':disabled'],
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
          Required: {
              selector: '.require',
              validators: {
                    notEmpty: {
                        message: 'This is field required.'
                    }
                }
          },
          DOH_facility_code: {
              validators: {
                    callback: {
                        message: 'This is field required.',
                        callback: function(value, validator, $field) {
                            var channel = $('form').find('[name="ownership_type"]').val();
                                return (channel == 'government') ? true : false;
                        }
                    }
              }
          },
          role: {
            validators: {
              notEmpty: {
                message: 'This is field required.'
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
                message: 'This is field required.'
              },
              emailAddress: {
                message: 'Not a valid email address'
              }
            }
          },
          reminder_email: {
            validators: {
              emailAddress: {
                message: 'Not a valid email address'
              }
            }
          },
          phone: telephoneonly,
          emergency_phone: telephoneonly,
          mobile: mobileonly,
          emergency_mobile: {
              validators: {
                  regexp: {
                      regexp: /^[-0-9\s]+$/i,
                      message: 'Numbers and dashes only'
                  },
                  stringLength: {
                    min: '12',
                    max: '12',
                    message: 'Not a valid phone string'
                  }
                }
          },
          reminder_mobile: {
              validators: {
                  regexp: {
                      regexp: /^[-0-9\s]+$/i,
                      message: 'Numbers and dashes only'
                  },
                  stringLength: {
                    min: '12',
                    max: '12',
                    message: 'Not a valid phone string'
                  }
                }
          },
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
                        min: 40,
                        max: 210,
                        message: 'Must be between 40 and 210'
                    }
                }
          },
          bloodpressure_diastolic: {
              validators: {
                    integer: {
                        message: 'The diastolic must contain numbers'
                    },
                    between: {
                        min: 0,
                        max: 170,
                        message: 'Must be between 0 and 170'
                    }
                }
          },
          heart_rate: {
              validators: {
                    numeric: {
                        message: 'The Heart Rate must contain numbers'
                    },
                    between: {
                        min: 0,
                        max: 200,
                        message: 'Must be between 0 and 300'
                    }
                }
          },
          pulse_rate: {
              validators: {
                    numeric: {
                        message: 'The Pulse Rate must contain numbers'
                    },
                    between: {
                        min: 0,
                        max: 200,
                        message: 'Must be between 0 and 300'
                    }
                }
          },
          respiratory_rate: {
              validators: {
                    numeric: {
                        message: 'The Respiratory Rate must contain numbers'
                    },
                    between: {
                        min: 0,
                        max: 70,
                        message: 'Must be between 0 and 70'
                    }
                }
          },
          height: {
              validators: {
                    numeric: {
                        message: 'The Height must contain numbers'
                    }
                }
          },
          weight: {
              validators: {
                    numeric: {
                        message: 'The Weight must contain numbers'
                    }
                }
          },
          waist: {
              validators: {
                    numeric: {
                        message: 'The Waist must contain numbers'
                    }
                }
          },
          role: {
              notEmpty: {
                message: 'This is field required.'
              }
          },
          newPassword: {
                selector: ".password",
                validators: {
                    notEmpty: {
                        message: 'This is field required.'
                    },
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
                selector: ".confirmPassword",
                validators: {
                    notEmpty: {
                        message: 'This is field required.'
                    },
                    identical: {
                        field: 'newPassword',
                        message: 'The new password and its confirm are not the same'
                    },
                    stringLength: {
                        min: '6'
                    }
                }
            },
            "allergy[inputAllergyName][]": {
                enabled: false,
                validators: {
                  regexp: {
                      regexp: /^[-a-zñÑ\s]+$/i,
                      message: 'Alphabetical characters and spaces only'
                  },
                  notEmpty: {
                    message: 'This is field required.'
                  }
                }
            },
            "inputAlertOthers" : alphaonly,
            "update[MO_MED_PRESCRIPTION][Dose_Qty][]":numericonly,
            "insert[MO_MED_PRESCRIPTION][Dose_Qty][]":numericonly,
            "update[MO_MED_PRESCRIPTION][Total_Quantity][]":numericonly,
            "update[MO_MED_PRESCRIPTION][Duration_Intake][]":numericonly,
            Dose_Qty:numericonly,
            Total_Quantity:numericonly,
            Duration_Intake:numericonly,
            Required: {
                selector: ".notempty",
                validators: {
                  notEmpty: {
                    message: 'This is field required.'
                  }
                }
            },
            NumericOnly: {
                selector: ".numericonly",
                validators: {
                  numeric: {
                        message: 'The value is not a number',
                        // The default separators
                        thousandsSeparator: '',
                        decimalSeparator: '.'
                    }
                }
            },
            Captcha: {
              selector: '.captcha',
              validators: {
                    notEmpty: {
                        message: 'This is field required.'
                    },
                    remote: {
                        url: 'registration/check_captcha',
                        type: 'POST',
                        cache: false,
                        async: false,
                        data: {
                            'captcha' : function () {
                                return $('input[name=test_captcha]').val();
                            },
                            '_token' : $('input[name=_token]').val()
                        },
                        dataFilter: function(response) {
                            return response;
                        }
                    }
              }
          }
        }
      })
        .on('error.field.fv', function(e, data) {
            // data.fv --> The FormValidation instance

            // Get the first invalid field
            var $invalidFields = data.bv.getInvalidFields().eq(0);

            // Get the tab that contains the first invalid field
            var $tabPane     = $invalidFields.parents('.tab-pane'),
                invalidTabId = $tabPane.attr('id');

            // If the tab is not active
            if (!$tabPane.hasClass('active')) {
                // Then activate it
                $tabPane.parents('.tab-content')
                        .find('.tab-pane')
                        .each(function(index, tab) {
                            var tabId = $(tab).attr('id'),
                                $li   = $('a[href="#' + tabId + '"][data-toggle="tab"]').parent();

                            if (tabId === invalidTabId) {
                                // activate the tab pane
                                $(tab).addClass('active');
                                // and the associated <li> element
                                $li.addClass('active');
                            } else {
                                $(tab).removeClass('active');
                                $li.removeClass('active');
                            }
                        });

                // Focus on the field
                $invalidFields.focus();
            }
        })
        .on('error.field.bv', function(e, data) {
            if (data.bv.getSubmitButton()) {
                data.bv.disableSubmitButtons(false);
            }
        })
        .on('success.field.bv', function(e, data) {
            if (data.bv.getSubmitButton()) {
                data.bv.disableSubmitButtons(false);
            }
        });
});
