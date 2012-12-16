jQuery(document).ready(function($) {

  // get the action filter option item on page load
  var $filterType = $('#afp-filter li.afp-active-cat a').attr('class');
	
  // get and assign the afp-items element to the
	// $holder varible for use later
  var $holder = $('ul.afp-items');

  // clone all items within the pre-assigned $holder element
  var $data = $holder.clone();

  // attempt to call Quicksand when a filter option
	// item is clicked
	$('#afp-filter li a').click(function(e) {
		// reset the active class on all the buttons
		$('#afp-filter li').removeClass('afp-active-cat');
		
		// assign the class of the clicked filter option
		// element to our $filterType variable
		var $filterType = $(this).attr('class');
		$(this).parent().addClass('afp-active-cat');
		
		if ($filterType == 'All') {
			// assign all li items to the $filteredData var when
			// the 'All' filter option is clicked
			var $filteredData = $data.find('li[data-type]');
		} 
		else {
			// find all li elements that have our required $filterType
			// values for the data-type element
			var $filteredData = $data.find('li[data-type=' + $filterType + ']');
		}
		
		// call quicksand and assign transition parameters
		$holder.quicksand($filteredData, {
			duration: 600,
			easing: 'easeInOutQuad'
		});
		return false;
	});
});
jQuery(document).ready(function($) {
	
	/*-- FANCYBOX --*/
	/*
			maxWidth	: 800,
			maxHeight	: 600,
			type        : 'ajax',
	*/
	$(".fancybox").fancybox({
		maxWidth	: 1000,
		maxHeight	: 800,
		fitToView	: false,
		width		: '85%',
		height		: '85%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});	
});

