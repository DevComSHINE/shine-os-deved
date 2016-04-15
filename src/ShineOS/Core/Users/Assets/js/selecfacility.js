var dataFacility = $('a.dataFacility');
dataFacility.on('click.dataFacility', function () {
	var facility = $(this).attr('data-facility');
	window.location = '/selectfacility/assign/'+facility;
	
	return false;
});