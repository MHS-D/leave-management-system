/**
 * Init loader
 */
window.loader = 0

/**
 * Create the loader HTML element
 */
function createTheLoaderElement() {
	$('#loader').remove()
	$('body').append('<div id="loader"><div></div><div></div><div></div><div></div></div>')
}

/**
 * Start loader
 * 
 */
function startLoader() {
	if (window.loader < 0) {
		window.loader = 0
	}

	window.loader++;

	toggleLoaderDisplay()
}

/**
 * Stop loader
 * 
 */
function stopLoader() {
	window.loader--;

	if (window.loader < 0) {
		window.loader = 0
	}

	toggleLoaderDisplay()
}

/**
 * Show/hide loader with respect to the "window.loader" variable
 *  
 */
function toggleLoaderDisplay() {
	if ($('#loader').length == 0) {
		createTheLoaderElement()
	}

	if (window.loader > 0) {
		$('#loader').addClass('active')
	}
	else {
		$('#loader').removeClass('active')
	}
}