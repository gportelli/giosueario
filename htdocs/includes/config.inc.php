<?php
class Shifts
{
	const MORNING = 0;
	const AFTERNOON = 1;
	const EVENING = 2;
	const NIGHT = 3;
	const REST = 4;
	const OFF = 5;
	const COURSE = 6;
}

class Statics
{
	const months = array(
		"Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"
	);

	const days = array("Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato", "Domenica");

	const shift_names = array(
		Shifts::MORNING => "Mattina",
		Shifts::AFTERNOON => "Pomeriggio",
		Shifts::EVENING => "Sera",
		Shifts::NIGHT => "Notte",
		Shifts::REST => "Riposo",
		Shifts::OFF => "Fuori turno",
		Shifts::COURSE => "Aggiornamento"
	);

	const shifts = array(
		array(Shifts::AFTERNOON),
		array(Shifts::MORNING, Shifts::EVENING),
		array(Shifts::NIGHT),
		array(Shifts::REST),
		array(Shifts::REST)
	);

	const times = array(
		Shifts::MORNING => array("07:00 - 13:00", "08:00 - 14:00"), 
		Shifts::AFTERNOON => array("13:00 - 19:00"),
		Shifts::EVENING => array("19:00 - 24:00"),
		Shifts::NIGHT=> array("00:00 - 07:00")
	);
}

// First day of an entire cycle
// hour, minute, second, month, day, year
$refDay = mktime(1, 0, 0, 9, 6, 2022);
