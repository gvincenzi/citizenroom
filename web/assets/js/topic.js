function topicBackground(topicName,topicDomain) {
	var topic_name_domain = [
		"parliament/france",
		"parliament/italy",
		"parliament/europe",
		"municipality/france"
	];

	var images = [
		'https://live.staticflickr.com/1555/23302903174_c80937186b_o.jpg',
		'https://live.staticflickr.com/5549/11631580435_1d124729fa_o.jpg',
		'https://live.staticflickr.com/65535/54844780861_13a71e3b75_o.jpg',
		'https://live.staticflickr.com/4254/35004594794_c9f37d8282_o.jpg'
	];

	var image_links = [
		'https://www.flickr.com/photos/emilio11/23302903174',
		'https://www.flickr.com/photos/simone_tagliaferri/11631580435/',
		'https://www.flickr.com/photos/european_parliament/54844780861',
		'https://www.flickr.com/photos/10332960@N03/35004594794/'
	];

	var authors = [
		'Emile Lombard',
		'Simone Tagliaferri',
		'European Parliament',
		'John Blower'
	];

	var author_links = [
		'https://www.flickr.com/photos/emilio11',
		'https://www.flickr.com/photos/simone_tagliaferri/',
		'https://www.flickr.com/photos/european_parliament/',
		'https://www.flickr.com/photos/10332960@N03/'
	];

	var licenses = [
		'CC BY-NC-SA 2.0',
		'CC BY 2.0',
		'CC BY 4.0',
		'CC BY-NC-ND 2.0'
	];

	var license_links = [
		'https://creativecommons.org/licenses/by-nc-sa/2.0/deed.',
		'https://creativecommons.org/licenses/by/2.0/deed.',
		'https://creativecommons.org/licenses/by/4.0/deed.',
		'https://creativecommons.org/licenses/by-nc-nd/2.0/deed.'
	];

	var index = topic_name_domain.indexOf(topicName+'/'+topicDomain);
	$('#full-screen-background-image').attr("src", images[index]);
	$('#imageLink').prop("href", image_links[index]);
	$('#authorLink').prop("href", author_links[index]).text(authors[index]);
	$('#licenseLink').prop("href", license_links[index]+getCookie('bestlang').substring(0,2)).text(licenses[index]);
}


function topicComboboxInit(topicName,topicDomain,msg) {
	var items = JSON.parse(msg);
	$.each(items, function(i, item) {
		switch(topicName+'/'+topicDomain){
			case "parliament/france" : $('#room_id').append('<option value="'+item.uid+'" data-tokens="'+item.firstname+' '+item.lastname+'">'+item.firstname+' '+item.lastname+' ('+item.group+')</option>'); break;
			case "parliament/italy" : $('#room_id').append('<option value="'+item.uid+'" data-tokens="'+item.firstname+' '+item.lastname+'">'+item.firstname+' '+item.lastname+' ('+item.group_short+')</option>'); break;
			case "parliament/europe" : $('#room_id').append('<option value="'+item.mep_identifier+'" data-tokens="'+item.mep_given_name+' '+item.mep_family_name+'">'+item.mep_given_name+' '+item.mep_family_name+' - '+item.mep_country_of_representation+' ('+item.mep_political_group+')</option>'); break;
		}
	});
	
	//Two times to have a complete refresh
	$('.selectpicker').selectpicker("refresh");
	$('.selectpicker').selectpicker("refresh");
}