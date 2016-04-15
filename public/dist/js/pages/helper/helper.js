var Helper = {};

Helper.ajaxGet = function (url, params, callback) {
  $.ajax({
    url: url,  
    type: 'GET',
    data: params,
    success:function(result) {
      callback(result);
    },
    error: function() {
      callback(false);
    },
  });    
}

Helper.cloneElement = function (cloneDiv, parentDiv) {
    console.log($(cloneDiv).first());
    var clone = $(cloneDiv).first().clone().find("input:text, textarea, select").val("").end();
    clone.appendTo(parentDiv);
}