/* Polish initialisation for the jQuery UI date picker plugin. */
/* Written by Jacek Wysocki (jacek.wysocki@gmail.com). */
jQuery(function($){
	$.timepicker.regional['pl'] = {
		closeText: 'Zamknij',
		currentText: 'Dziś',
		timeOnlyTitle: 'Podaj czas',
		timeText: 'Czas',
		hourText: 'Godzina',
		minuteText: 'Minuta',
		secondText: 'Sekunda'	
		};
	$.timepicker.setDefaults($.timepicker.regional['pl']);
});
