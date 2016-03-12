/* German initialisation for the jQuery UI date picker plugin. */
/* Written by Milian Wolff (mail@milianw.de). */
jQuery(function($){
	$.timepicker.regional['de'] = {
		closeText: 'Schliessen',
		currentText: 'Heute',
		timeOnlyTitle: 'Zeit geben',
		timeText: 'Zeit',
		hourText: 'Stunde',
		minuteText: 'Minute',
		secondText: 'Sekunde'	
		};
	$.timepicker.setDefaults($.timepicker.regional['de']);
});
