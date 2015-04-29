<?php


function dnh_tarieven_on_admin_menu() {
	
   /* Beschrijving van de parameters van de function add_submenu_page:
    * 1: De slug van het menu waaraan dit submenu aan gekoppeld moet zijn. Null als page niet in een menu komt, maar op een 
    *    andere manier kan worden opgeroepen.
    * 2: titel van de pagina in de browser
    * 3: Titel van het menu
    * 4: Rechten om het menu zichtbaar te maken
    * 5: slug van deze page
    * 6: PHP functie die wordt aangeroepen als de gebruiker de page oproept.
    */
    
	add_submenu_page( 'dnh_menu', 'Factuur printen test'  , 'Factuur'   , 'manage_options', 'factuur'  ,  'printFactuur'      );
	
}


function printFactuur()
{
	
		do_action("createInvoice");

}

function createInvoice()
{
	if(isset($_GET['page']) && $_GET['page']== 'factuur'){
	/*Door middel van dompdf is het mogelijk om een pdf te maken van een stuk html code.
 Dit script moet uitgevoerd worden wanneer een knop ingedrukt wordt. Tot nu toe is het me
 niet gelukt om dit uit te laten voeren in een bestaande webpagina, maar na het uitvoeren
 stuurt het script de browser direct terug naar de vorige pagina.

 Om het dompdf script te gebruiken is het nodig om het eerst in te laden.*/
require_once ("dompdf/dompdf_config.inc.php");
// Connectie met de database.
global $wpdb;
//lidnummer ophalen uit de url
if (isset($_GET['lidnr'])) {
	$lidnr = $_GET['lidnr'];
}
else{
	$lidnr = 0;
}
//sql statement die de meeste gegevens ophaalt.
$sql = "SELECT L.Naam AS LNaam, L.Adres, L.Woonplaats, T.Contributiebedrag, T.Energietoeslag, T.Begindatum,
T.LiggeldLid, COUNT(S.SchipId) AS schiptotaal
FROM lid L, tarief T, schip S
WHERE L.LidId = " . $lidnr . " 
AND S.Lid_LidId = L.LidId AND T.Begindatum = (
SELECT MAX(T.Begindatum)
FROM tarief T)";
$sqlresult = $wpdb->get_results($sql, ARRAY_A );
if(count($sqlresult) > 0)
{
		foreach ($sqlresult as $query) {
			
		
		$liggeldlid = $query["LiggeldLid"];
		$nieuwnummer = 0;
		$html = '<html><body><style>
			.logo {
				height:100px;
			}

			.lid{
				margin-top:20px;
			}
			.factuurnr{
				margin-top:50px;
			}
			.factuurgegevens{
				margin-top:50px;
			}
			.factuurregels{
				margin-top:30px;
			}
			td, th{
				border: 1px solid black;
				text-align:left;
				padding:3px;
			}
			th{
				background-color: #767676;
			}
			table{
				border-spacing: 0px;
			}
		</style>
		<div class="logo">
			<h1>Hier komt het logo</h1>
		</div>
		<div class="adresgegevens">
			<b>De&lsquo;n oude haven</b>
			<br>Adresregel 1
			<br>Adresregel 2
			<br>Telefoonnummer
			<br>Website
			<br>KvK nummer
			<br>IBAN nummer
		</div>
		<div class="lid">
			<b>' . $query["LNaam"] . '</b>
			<br>' . $query["Adres"] . '
			<br>' . $query["Woonplaats"] . '
		</div>';
		
		//een extra query om ook als er geen facturen naar deze persoon 
//zijn verzonden tot nu toe het factuurnummer te kunnen genereren.
		$factuur = "SELECT MAX(FactuurID) AS hoogste FROM factuur";
		$resultfactuur = $wpdb ->get_results($factuur, ARRAY_A );
		if(count($resultfactuur) > 0)
{
		foreach ($resultfactuur as $factuurnr) {
				$nieuwnummer = $factuurnr["hoogste"] + 1;
				$html = $html . '<div class="factuurnr">
			<b>
				Factuurnummer: ' . $nieuwnummer . '
				<br>Factuurdatum: ' . date("d-m-Y") . '
			</b>
			</div>';
			}
		}
//variabele waarin het totaalbedrag wordt opeslagen wordt aangemaakt. Deze wordt elke keer verder gevuld.
		$totaalbedrag = 0;
		$html = $html . '<div class="factuurregels">
			<table>
				<tr>
					<th class="omschrijving">Omschrijving</th>
					<th class="aantal">Aantal</th>
					<th class="pps">Prijs per eenheid</th>
					<th class="bedrag">Bedrag</th>
				</tr>
				<tr>
					<td>Contributie</td>
					<td>1</td>
					<td> €' . $query["Contributiebedrag"] . ',-</td>
					<td>€' . $query["Contributiebedrag"] . ',-</td>
				</tr>';
		$totaalbedrag = $totaalbedrag + $query["Contributiebedrag"];
		//Om de boten van een bepaald persoon te selecteren is het nodig om een losse query uit te voeren.
		//Dit stuk code maakt van elke boot een tabelrij met daarbij de ligprijs.
		$boten = "SELECT S.Naam, S.Lengte FROM schip S WHERE S.Lid_LidId =" . $lidnr;
		$resultboten = $wpdb -> get_results($boten, ARRAY_A );
		if(count($resultboten) > 0)
{
		foreach ($resultboten as $boot) {
				$html = $html . '<tr>
					<td>Liggeld "' . $boot["Naam"] . '"</td>
					<td> '.$boot["Lengte"].' </td>
					<td>€' . $liggeldlid . ',-</td>
					<td>€' . $liggeldlid * $boot["Lengte"] . ',-</td>
				</tr>';
				$totaalbedrag = $totaalbedrag + $liggeldlid * $boot["Lengte"];
			}
		}
		//De elektriciteitskosten worden per schip berekend en het totaalbedrag wordt weergegeven.
		$totaalbedrag = $totaalbedrag + $query["Energietoeslag"] * $query["schiptotaal"];
		if($query["schiptotaal"]>0)
		{
			$html .= '
				<tr>
					<td>Elektriciteitskosten</td>
					<td>' . $query["schiptotaal"] . '</td>
					<td>€' . $query["Energietoeslag"] . ',-</td>
					<td>€' . $query["Energietoeslag"] * $query["schiptotaal"] . ',-</td>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td colspan="3">Totaalbedrag</td>
					<td>€' . $totaalbedrag . ',-</td>
				</tr>';
		}
		$html.='
			</table>
			Gelieve dit bedrag binnen 14 na ontvangen van de factuur over te maken op onze rekening.
		</div>
	</body></html>';
//$insert = "INSERT INTO factuur VALUES (".$nieuwnummer.", 0 ,'".date("Y-m-d")."',".$lidnr.", '".$query["Begindatum"]."')";
//$wpdb->get_result($insert);
	}
}

//In de variabele dompdf wordt een nieuwe dompdf aangemaakt.
$dompdf = new DOMPDF();
//Hier wordt de html variabele in ingeladen
$dompdf -> load_html($html);
//Deze wordt omgezet naar een pdf
$dompdf -> render();
/*En wordt doorgestuurd naar de pc van de gebruiker. Deze krijgt een "opslaan als"
 venster te zien, waar hij zelf kan beslissen waar de file opgeslagen moet worden.*/
$dompdf -> stream("sample.pdf");
	}
}
?>
