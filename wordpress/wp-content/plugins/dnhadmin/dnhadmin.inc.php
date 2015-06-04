<?php
/*******************************************************************************************************
Plugin: DNHAdmin
Script: dnhadmin.inc.php
Doel  : "Template" voor de hoofdpagina van de plugin. Soort dashboard
Auteur: BugSlayer
*******************************************************************************************************/
//Alle wordpress admin content in een <div class="wrap"> element 
global $wpdb;
$sql = "SELECT COUNT(L.LidId) AS Som1 FROM Lid L WHERE L.Status = 1";
$sql2 = "SELECT COUNT(S.SchipId) AS Som2 FROM Schip S";
$resultsql = $wpdb -> get_results($sql, ARRAY_A);
if (count($resultsql) > 0) {
		foreach ($resultsql as $iets) {
?>
<div class="wrap">
	<H1>
		Dashboard d'n oude haven
	</H1>
	<br>
	<table>
		<tr>
			<td width="200px">Actieve leden</td><td width="200px">Aantal schepen</td>
		</tr>
		<?php
echo "<tr><td><a href ='admin.php?page=dnh_leden'>" . $iets['Som1'] . "</a></td>";
		}
}
$resultsql2 = $wpdb->get_results($sql2, ARRAY_A);
if(count($resultsql2)>0)
{
	foreach($resultsql2 as $iets2)
	{
		echo "<td><a href='admin.php?page=dnh_schepen'>" . $iets2['Som2'] . "</a></td></tr>" ;
	}
}
?>
	</table>
</div>

