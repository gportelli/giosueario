<?php
include("config.inc.php");

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
		
		echo "<a href='?offset=" . $this->getOffset() . "&year=" . ($currY-1) . "&month=$currM'>&laquo</a> ";
		
		echo "<select id='year' name='year' onChange='update()'>";
		
		for($i=$currY - 5; $i<$currY + 5; $i++)
			echo "<option value='$i' " . ($i == $currY ? "selected='selected'" : ""). ">$i</option>";
		
		echo "</select>";
		
		echo " <a href='?offset=" . $this->getOffset() . "&year=" . ($currY+1) . "&month=$currM'>&raquo</a> ";
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
		
		echo "<a href='?offset=" . $this->getOffset() . "&year=$prevY&month=$prevM'>&laquo</a> ";
		
		echo "<select id='month' name='month' onChange='update()'>";
	
		for($i=0; $i<12; $i++)
			echo "<option value='" . ($i+1) . "' " . ($i+1 == $currM ? "selected='selected'" : ""). ">" . $months[$i] . "</option>";
	
		echo "</select>";
		
		echo " <a href='?offset=" . $this->getOffset() . "&year=$nextY&month=$nextM'>&raquo</a> ";
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
					echo "<td class='$style'>";
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
		
		$turni = Statics::shifts;
		$delta  = round(($day - $refDay) / 3600 / 24); // Attenzione all'ora legale, che sfalsa gli offset di 1h
		$offset = $this->getOffset();
		
		if($offset === "") {
			$a = $delta % 49;
            if($a < 0) $a += 49;
			if($a < 35) $t = $a % 5; else $t = 5;
		}
		else $t = ($delta + $offset) % 5;
		
		if($t<0) $t += 5;
		
		//echo date('w', $day);
		if($t == 4 && date('w', $day) == 2) $t = 6; // Se il riposo cade di martedì si fa aggiornamento
		
		return $turni[$t];
	}
	
	public function getOffset() {
		if(! isset($_GET['offset'])) return "";
		if($_GET['offset'] === "") return "";
		
		$values = array(0, 1, 2, 3, 4);
		
		if(! in_array($_GET['offset'], $values)) return "";
		
		return (int) $_GET['offset'];
	}
}