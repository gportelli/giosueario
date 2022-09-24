<?php
include("includes/config.inc.php");

class Giosueario {
	private function getCurrY() {
		return empty($_GET['year']) ? date("Y") : $_GET['year'];
	}
	
	private function getCurrM() {
		return empty($_GET['month']) ? date("n") : $_GET['month'];
	}
	
	public function getYearSelect() {
		$currY = $this->getCurrY();
		$currM = $this->getCurrM();
				
		echo "<input type='hidden' id='offset' value='" . $this->getOffset() . "'/>";
		
		echo "<span class='date-input'>";
		
		echo "<a href='?offset=" . $this->getOffset() . "&year=" . ($currY-1) . "&month=$currM'>&laquo</a> ";
		
		echo "<select id='year' name='year' onChange='update()'>";
		
		for($i=$currY - 5; $i<$currY + 5; $i++)
			echo "<option value='$i' " . ($i == $currY ? "selected='selected'" : ""). ">$i</option>";
		
		echo "</select>";
		
		echo " <a href='?offset=" . $this->getOffset() . "&year=" . ($currY+1) . "&month=$currM'>&raquo</a> ";

		echo "</span>";
	}
	
	public function getMonthSelect() {
		$months = Statics::months;
	
		$currY = $this->getCurrY();
		$currM = $this->getCurrM();
		
		$nextM = $currM +1;
		$prevM = $currM -1;
		
		$nextY = $currY;
		$prevY = $currY;
		
		if($prevM == 0) {
			$prevM = 12;
			$prevY--;
		}
		
		if($nextM == 13) {
			$nextM = 1;
			$nextY++;
		}
		
		echo "<span class='date-input'>";

		echo "<a href='?offset=" . $this->getOffset() . "&year=$prevY&month=$prevM'>&laquo</a> ";
		
		echo "<select id='month' name='month' onChange='update()'>";
	
		for($i=0; $i<12; $i++)
			echo "<option value='" . ($i+1) . "' " . ($i+1 == $currM ? "selected='selected'" : ""). ">" . $months[$i] . "</option>";
	
		echo "</select>";
		
		echo " <a href='?offset=" . $this->getOffset() . "&year=$nextY&month=$nextM'>&raquo</a> ";

		echo "</span>";
	}
	
	public function drawCalendar() {
		$year = $this->getCurrY();
		$month = $this->getCurrM();
		
		$startDay = mktime(1, 0, 0, $month, 1, $year);
		$wd = date("w", $startDay);
		if($wd == 0) $wd = 6; else $wd = $wd - 1;
		$startDay -= $wd * 3600 * 24;
		
		$days = Statics::days;
		
		echo "<table cellspacing='1' cellpadding='4' width='100%'>";
		
		$day = $startDay;
		for($i=0; $i<7; $i++) {
			echo "<tr>";
			
			for($j=0; $j<7; $j++) {
				if($i == 0)
					echo "<th>" . $days[$j] . "</th>";
				else {
					$style = date("n", $day) == $month ? "currMonth" : "otherMonth";
					if(date("j", $day) == date("j") && date("n", $day) == date("n") && date("Y", $day) == date("Y")) {
						$style = 'currDay';
					}
					echo "<td class='$style' valign='top'>";
					echo date("j", $day);
					echo "<br/>";
					echo $this->getTurno($day);
					echo "</td>";				
					$day += 3600 * 24;
				}
			}
			
			echo "</tr>";
		}
			
		echo "</table>";
	}
	
	private function getTurno($day) {
		global $refDay; // lunedì - sera - inizio ciclo di 7 turni in quinta + 2 settimane fuori turno = 5 * 7 + 7 * 2 = 49 giorni
		
		$delta  = round(($day - $refDay) / 3600 / 24); // Attenzione all'ora legale, che sfalsa gli offset di 1h (ref day starts at 1 a.m. instead of midnight)
		$offset = $this->getOffset();
		if($offset === "") $offset = 0;

		$cicle_day = ($delta + $offset) % 49;
        if($cicle_day < 0) $cicle_day += 49;

		$turno = 0;
		if($cicle_day < 35) $turno = $cicle_day % 5; else return Statics::shift_names[Shifts::OFF];
		
		if($turno<0) $turno += 5;
		
		//echo date('w', $day);
		//if($t == 4 && date('w', $day) == 2) $t = 6; // Se il riposo cade di martedì si fa aggiornamento

		$forth_week = floor($cicle_day / 5) == 3;

		$result = "";
		foreach(Statics::shifts[$turno] as $value)
		{
			$result .= "<p>".Statics::shift_names[$value];
			
			if(array_key_exists($value, Statics::times))
			{
				$index = 0;
				if($forth_week && count(Statics::times[$value]) == 2) $index = 1;

				$result .= "<br>" . Statics::times[$value][$index];
			}

			$result .= "</p>";
		}

		return $result;
	}
	
	public function getOffset() {
		if(! isset($_GET['offset'])) return "";
		if($_GET['offset'] === "") return "";
		
		$values = array(0, 1, 2, 3, 4);
		
		if(! in_array($_GET['offset'], $values)) return "";
		
		return (int) $_GET['offset'];
	}
}