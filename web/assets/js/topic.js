function topicBackground($topicName,$topicDomain) {
	var topic_name_domain = [
		"parliament/france",
		"parliament/italy"
	];

	var images = [
		'https://live.staticflickr.com/1555/23302903174_c80937186b_o.jpg',
		'https://live.staticflickr.com/5797/22526174288_248ce7fa10_o.jpg'
		
	];

	var image_links = [
		'https://www.flickr.com/photos/emilio11/23302903174',
		'https://www.flickr.com/photos/image-catalog/22526174288'
	];

	var authors = [
		'Emile Lombard',
		'Image Catalog'
	];

	var author_links = [
		'https://www.flickr.com/photos/emilio11',
		'https://www.flickr.com/photos/image-catalog/'
	];

	var licenses = [
		'CC BY-NC-SA 2.0',
		'Public Domain Dedication (CC0)'
	];

	var license_links = [
		'https://creativecommons.org/licenses/by-nc-sa/2.0/deed.',
		'https://creativecommons.org/publicdomain/zero/1.0/deed.'
	];

	var index = topic_name_domain.indexOf($topicName+'/'+$topicDomain);
	$('#full-screen-background-image').attr("src", images[index]);
	$('#imageLink').prop("href", image_links[index]);
	$('#authorLink').prop("href", author_links[index]).text(authors[index]);
	$('#licenseLink').prop("href", license_links[index]+getCookie('bestlang').substring(0,2)).text(licenses[index]);
}