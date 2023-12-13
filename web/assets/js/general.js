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
		'https://live.staticflickr.com/7897/46684372945_bdd3f29337_o_d.jpg',
		'https://live.staticflickr.com/817/27559977898_2fff7ec050_o.jpg'
	];

	var image_links = [
		'https://www.flickr.com/photos/147592390@N06/46684372945',
		'https://www.flickr.com/photos/157089461@N07/27559977898'
	];

	var authors = [
		'John Beans',
		'Best Picko'
	];

	var author_links = [
		'https://www.flickr.com/photos/147592390@N06/',
		'https://www.flickr.com/photos/157089461@N07/'
	];

	var index = Math.floor(Math.random() * images.length);
	$('#full-screen-background-image').attr("src", images[index]);
	$('#imageLink').prop("href", image_links[index]);
	$('#authorLink').prop("href", author_links[index]).text(authors[index]);
}