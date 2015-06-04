<?php

function getStyle() {
	$style = '<style>
		.logo {height:100px;}
		.lid{margin-top:20px;}
		.factuurnr{margin-top:50px;}
		.factuurgegevens{margin-top:50px;}
		.factuurregels{margin-top:30px;}
		td, th{border: 1px solid black; text-align:left; padding:3px;}
		th{background-color: #767676;}
		table{border-spacing: 0px;}</style>';
	return $style;
}

function buildData($lidnr) {
	//r = alle data die nodig is om een html te bouwen.
	$r = new stdClass;
	$r -> lidnr = $lidnr;
	//maak basisgegevens van elk lid.
	$sql = "SELECT L.Naam AS LNaam, L.Adres, L.Woonplaats, T.Contributiebedrag, T.Energietoeslag, T.Jaar,
	T.LiggeldLid, COUNT(S.SchipId) AS schiptotaal, T.Begindatum
	FROM lid L, tarief T, schip S
	WHERE L.LidId = " . $lidnr . " 
	AND S.Lid_LidId = L.LidId AND T.Begindatum = (
	SELECT MAX(T.Begindatum)
	FROM tarief T)";
	global $wpdb;
	$sqlresult = $wpdb -> get_results($sql, ARRAY_A);
	if (count($sqlresult) > 0) {
		foreach ($sqlresult as $query) {
			$r -> lidnr = $lidnr;
			$r -> lidnaam = $query['LNaam'];
			$r -> lidadres = $query['Adres'];
			$r -> lidwoonplaats = $query['Woonplaats'];
			$r -> contributie = $query['Contributiebedrag'];
			$r -> energietoeslag = $query['Energietoeslag'];
			$r -> jaar = $query['Jaar'];
			$r -> liggeldlid = $query['LiggeldLid'];
			$r -> schiptotaal = $query['schiptotaal'];
			$r -> begindatum = $query['Begindatum'];
		}
	}

	//maak factuurnummer
	$factuur = "SELECT MAX(FactuurID) AS hoogste FROM factuur";
	global $wpdb;
	$resultfactuur = $wpdb -> get_results($factuur, ARRAY_A);
	if (count($resultfactuur) > 0) {
		foreach ($resultfactuur as $factuurnr) {
			$nieuwnummer = $factuurnr["hoogste"] + 1;
			$r -> factuurnummer = $nieuwnummer;
		}
	} else {
		$r -> factuurnummer = 1;
	}

	//Factuurregels
	$r -> regels = array();

	//maak schepen
	$r -> boten = array();
	$boten = "SELECT S.Naam, S.Lengte FROM schip S WHERE S.Lid_LidId =" . $lidnr;
	global $wpdb;
	$resultboten = $wpdb -> get_results($boten, ARRAY_A);
	if (count($resultboten) > 0) {
		foreach ($resultboten as $boot) {
			$s = new stdClass;
			$s -> omschrijving = $boot['Naam'];
			$s -> aantal = $boot['Lengte'];
			$s -> prijspereenheid = $r -> liggeldlid;
			$r -> regels[] = $s;
		}
	}
	return $r;
}

function createHtml($r) {
	//html is de variabele waarin de factuur opgebouwd wordt.
	$html = '<html><body>';
	//De style van de factuur invoegen
	$html .= getStyle();
	//Logo toevoegen aan factuur
	$html .= '<div class="logo"><h1>Hier komt het logo</h1></div>';
	//Gegevens van de vereniging op de factuur zetten
	$html .= '<div class="adresgegevens"><b>De&lsquo;n oude haven</b><br>Adresregel 1<br>Adresregel 2
			<br>Telefoonnummer<br>Website<br>KvK nummer<br>IBAN nummer</div>';
	//Lidgegevens
	$html .= '<div class="lid"><b>' . $r -> lidnaam . '</b><br>' . $r -> lidadres . '<br>' . $r -> lidwoonplaats . '</div>';

	//Algemene factuurgegevens
	$html .= '<div class="factuurnr"><b>Factuurnummer: ' . $r -> factuurnummer . '<br>Factuurdatum: ' . date("d-m-Y") . '</b></div>';

	//Tabelhoofden
	$html .= '<div class="factuurregels"><table><tr><th class="omschrijving">Omschrijving</th><th class="aantal">Aantal</th>
	<th class="pps">Prijs per eenheid</th><th class="bedrag">Bedrag</th></tr>';

	//Contributie
	$html .= '<tr><td> Contributie </td><td> 1 </td><td>€' . $r -> contributie . '</td><td>€' . $r -> contributie . '</td></tr>';
	$totaalbedrag += $r -> contributie;
	$table = "factuurregel";
	$data = array('Omschrijving' => "Contributie", 'Aantal' => 1, 'BedragPerEenheid' => $r -> contributie, 'Factuur_FactuurId' => $r -> factuurnummer);
	global $wpdb;
	$wpdb -> insert($table, $data);

	//Energietoeslag
	if ($r -> schiptotaal > 0) {
		$html .= '<tr><td> Energietoeslag </td><td>' . $r -> schiptotaal . ' </td><td>€' . $r -> energietoeslag . '</td><td>€' . $r -> schiptotaal * $r -> energietoeslag . '</td></tr>';
		$totaalbedrag += $r -> energietoeslag * $r -> schiptotaal;
		$table = "factuurregel";
		$data = array('Omschrijving' => "Energietoeslag", 'Aantal' => $r -> schiptotaal, 'BedragPerEenheid' => $r -> energietoeslag, 'Factuur_FactuurId' => $r -> factuurnummer);
		global $wpdb;
		$wpdb -> insert($table, $data);
	}
	//loopen over de $r->regels
	foreach ($r->regels as $p) {
		$html .= '<tr><td>' . $p -> omschrijving . '</td><td>' . $p -> aantal . '</td><td>€' . $p -> prijspereenheid . '</td><td>€' . $p -> aantal * $p -> prijspereenheid . '</td></tr>';
		$totaalbedrag += $p -> prijspereenheid * $p -> aantal;
		$table = "factuurregel";
		$data = array('Omschrijving' => $r -> omschrijving, 'Aantal' => $p -> aantal, 'BedragPerEenheid' => $p -> prijspereenheid, 'Factuur_FactuurId' => $r -> factuurnummer);
		global $wpdb;
		$wpdb -> insert($table, $data);
	}
	//Totaalbedrag
	$html .= '<tr><td colspan="4"></td></tr>';
	$html .= '<tr><td colspan="3">Totaalbedrag</td><td>€' . $totaalbedrag . ',-</td></tr>';
	//Afsluiting
	$html .= '</table>Gelieve dit bedrag binnen 14 na ontvangen van de factuur over te maken op onze rekening.</div>
		</body></html>';
	$table = "factuur";
	$data = array('Status' => 0, 'Datum' => date('Y-m-d'), 'Lid_LidId' => $r -> lidnr, 'Tarief_Begindatum' => $r -> begindatum);
	global $wpdb;
	$wpdb -> insert($table, $data);
	return $html;
}
