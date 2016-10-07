var dataFacility = $('a.dataFacility');
dataFacility.on('click.dataFacility', function () {
	var facility = $(this).attr('data-facility');
	var user = $(this).attr('data-user');

	window.location = baseurl + 'selectfacility/assign/'+ facility + '/' + user;
	
	return false;
});