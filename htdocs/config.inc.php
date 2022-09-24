<?php
class Statics
{
	const months = array(
			"Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"
	);

	const days = array("Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato", "Domenica");
		
	const shifts = array("Pomeriggio", "Mattina", "Sera", "Notte", "Riposo", "Fuori turno", "Aggiornamento");
	const times = array("13:00 - 19:00", "07:00 - 13:00", "19:00 - 24:00", "24:00 - 07:00");
	const times_forth_week = array("14:00 - 19:00", "08:00 - 14:00", "19:00 - 24:00", "24:00 - 07:00");
}

// First day of an entire cycle
// hour, minute, second, month, day, year
$refDay = mktime(1, 0, 0, 9, 1, 2022);