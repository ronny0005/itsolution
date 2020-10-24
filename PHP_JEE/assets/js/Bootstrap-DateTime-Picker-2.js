jQuery(function ($) {

	$.datepicker.regional['fr'] = {
		closeText: 'Fermer',
		prevText: '&#x3c;Préc',
		nextText: 'Suiv&#x3e;',
		currentText: 'Aujourd\'hui',
		monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
			'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
		monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Jun',
			'Jul','Aou','Sep','Oct','Nov','Dec'],
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
		dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
		weekHeader: 'Sm',
		dateFormat: 'ddmmyy',
		firstDay: 1
	};
	$.datepicker.setDefaults($.datepicker.regional['fr']);
	$("#datedebut").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
	$("#datefin").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
	$("#dateReglementEntete_deb").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
	$("#dateReglementEntete_fin").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
}); // End of use strict