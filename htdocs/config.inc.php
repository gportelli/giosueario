<?php
class Statics
{
	const months = array(
			"Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"
	);

	const days = array("Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato", "Domenica");
		
	const shifts = array("Sera", "Pomeriggio", "Mattina", "Notte", "Riposo", "Fuori turno", "Aggiornamento");
}

// First day of an entire cycle
$refDay = mktime(1, 0, 0, 3, 10, 2014);