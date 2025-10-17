function topicBackground(topicName,topicDomain) {
	var topic_name_domain = [
		"parliament/france",
		"parliament/italy"
	];

	var images = [
		'https://live.staticflickr.com/1555/23302903174_c80937186b_o.jpg',
		'https://live.staticflickr.com/5549/11631580435_1d124729fa_o.jpg'
		
	];

	var image_links = [
		'https://www.flickr.com/photos/emilio11/23302903174',
		'https://www.flickr.com/photos/simone_tagliaferri/11631580435/'
	];

	var authors = [
		'Emile Lombard',
		'Simone Tagliaferri'
	];

	var author_links = [
		'https://www.flickr.com/photos/emilio11',
		'https://www.flickr.com/photos/simone_tagliaferri/'
	];

	var licenses = [
		'CC BY-NC-SA 2.0',
		'CC BY 2.0'
	];

	var license_links = [
		'https://creativecommons.org/licenses/by-nc-sa/2.0/deed.',
		'https://creativecommons.org/licenses/by/2.0/deed.'
	];

	var index = topic_name_domain.indexOf(topicName+'/'+topicDomain);
	$('#full-screen-background-image').attr("src", images[index]);
	$('#imageLink').prop("href", image_links[index]);
	$('#authorLink').prop("href", author_links[index]).text(authors[index]);
	$('#licenseLink').prop("href", license_links[index]+getCookie('bestlang').substring(0,2)).text(licenses[index]);
}


function topicComboboxInit(topicName,topicDomain,msg) {
	var delegates = JSON.parse(msg);
	$.each(delegates, function(i, delegate) {
		switch(topicName+'/'+topicDomain){
			case "parliament/france" : $('#room_id').append('<option value="'+delegate.uid+'" data-tokens="'+delegate.firstname+' '+delegate.lastname+'">'+delegate.firstname+' '+delegate.lastname+' ('+delegate.group+')</option>'); break;
			case "parliament/italy" : $('#room_id').append('<option value="'+delegate.uid+'" data-tokens="'+delegate.firstname+' '+delegate.lastname+'">'+delegate.firstname+' '+delegate.lastname+' ('+delegate.group_short+')</option>'); break;
		}
	});
	
	//Two times to have a complete refresh
	$('.selectpicker').selectpicker("refresh");
	$('.selectpicker').selectpicker("refresh");
}