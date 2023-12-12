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

//cleanArray removes all duplicated elements
function cleanArray(array) {
	var i, j, len = array.length, out = [], obj = {};
	for (i = 0; i < len; i++) {
		obj[array[i].id] = array[i];
	}
	for (j in obj) {
		out.push(obj[j]);
	}
	return out;
}

function validateEmail(inputText) {
	var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	if (inputText.match(mailformat)) {
		return true;
	}
	return false;
}

function randomBackground() {
	var images = [
		'https://live.staticflickr.com/65535/44574560331_0101fffd98_h.jpg',
		'https://live.staticflickr.com/7897/46684372945_bdd3f29337_o_d.jpg',
		'https://live.staticflickr.com/3160/2916921362_b6f3fc219d_o_d.jpg',
		'https://live.staticflickr.com/4840/30849318147_2c71bed2d7_o_d.jpg',
		'https://live.staticflickr.com/1928/31917962768_9424013e2a_o_d.jpg',
		'https://live.staticflickr.com/3941/15529536722_9aa1d93351_o_d.jpg'
	];

	var image_links = [
		'https://www.flickr.com/photos/nikiforovpizza/44574560331/',
		'https://www.flickr.com/photos/147592390@N06/46684372945',
		'https://www.flickr.com/photos/jenik/2916921362/',
		'https://www.flickr.com/photos/byrawpixel/30849318147',
		'https://www.flickr.com/photos/byrawpixel/31917962768',
		'https://www.flickr.com/photos/fordschool/15529536722'
	];

	var authors = [
		'Mykyta Nikiforov',
		'John Beans',
		'Alvaro',
		'Rawpixel Ltd',
		'Rawpixel Ltd',
		'Gerald R. Ford School'
	];

	var author_links = [
		'https://www.flickr.com/photos/nikiforovpizza/',
		'https://www.flickr.com/photos/147592390@N06/',
		'https://www.flickr.com/photos/jenik/',
		'https://www.flickr.com/photos/byrawpixel/',
		'https://www.flickr.com/photos/byrawpixel/',
		'https://www.flickr.com/photos/fordschool/'
	];

	var index = Math.floor(Math.random() * images.length);
	$('#full-screen-background-image').attr("src", images[index]);
	$('#imageLink').prop("href", image_links[index]);
	$('#authorLink').prop("href", author_links[index]).text(authors[index]);
}