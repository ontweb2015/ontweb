<?php
function show_Factuur()
{
	if(isset($_GET['page']) && $_GET['page']== 'showFactuur')
	{
		if (isset($_GET['lidnr'])) {
		include ('factuur_functions.php');
		}
		$data = buildData($lidnr);
		$html = createHtml($data);
		echo $html;
	}
}
