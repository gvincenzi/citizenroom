function changeLanguage(lang) {
	setCookie(lang, 'bestlang');
	window.location.reload();
}

function setCookie(content, nameCookie) {
	var exdays = 31;
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value = escape(content) + ((exdays == null) ? "" : "; path = /; expires=" + exdate.toUTCString());
	document.cookie = 'citizenroom[' + nameCookie + ']' + "=" + c_value;
}

function getCookie(nameCookie) {
	var c_name = 'citizenroom[' + nameCookie + ']';
	var c_value = document.cookie;
	var c_start = c_value.indexOf(" " + c_name + "=");
	if (c_start == -1) {
		c_start = c_value.indexOf(c_name + "=");
	}
	if (c_start == -1) {
		c_value = null;
	}
	else {
		c_start = c_value.indexOf("=", c_start) + 1;
		var c_end = c_value.indexOf(";", c_start);
		if (c_end == -1) {
			c_end = c_value.length;
		}
		c_value = unescape(c_value.substring(c_start, c_end));
	}
	return c_value;
}

function randomBackground() {
	var images = [
		'https://live.staticflickr.com/7897/46684372945_bdd3f29337_o_d.jpg',
		'https://live.staticflickr.com/8790/17878517048_bbfa43d136_o.jpg',
		'https://live.staticflickr.com/7734/27686053920_9400a9e160_o.jpg'
		
	];

	var image_links = [
		'https://www.flickr.com/photos/147592390@N06/46684372945',
		'https://www.flickr.com/photos/image-catalog/17878517048',
		'https://www.flickr.com/photos/we-the-people/27686053920'
	];

	var authors = [
		'John Beans',
		'Image Catalog',
		'We The People'
	];

	var author_links = [
		'https://www.flickr.com/photos/147592390@N06/',
		'https://www.flickr.com/photos/image-catalog/',
		'https://www.flickr.com/photos/we-the-people/'
	];

	var index = Math.floor(Math.random() * images.length);
	$('#full-screen-background-image').attr("src", images[index]);
	$('#imageLink').prop("href", image_links[index]);
	$('#authorLink').prop("href", author_links[index]).text(authors[index]);
}