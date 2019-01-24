$( document ).ready(function() {
	$('.navbar-toggler').on('click', function(){
		$('.navbar-collapse').toggle();
	});

	var volume = 100;
	if ($.cookie("volume")) {
		volume = $.cookie("volume");
	} 
	$("#volume").slider({
		min: 0,
		max: 100,
		value: volume,
		range: "min",
		slide: function(event, ui) {
		setVolume(ui.value / 100);
		}
	});
	$('#volume').trigger('change');
	$("#volume").slider('value',volume*100);
	setVolume(volume);
	console.log(volume);
});



function setVolume(myVolume) {
console.log(myVolume);
 $('video').prop("volume", myVolume);
 $.cookie("volume", myVolume, { expires : 10 });
}

