<?php
/*******************************************************************************************************
Plugin: DNHAdmin
Script: leden-list.inc.php
Doel  : "Template" voor de pagina waarin de lijst met leden wordt getoond.
Auteur: Rajenco
*******************************************************************************************************/

// Beperk toegang
if ( !current_user_can( 'manage_options' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

?>
<div class="wrap">
    <div id="icon-users" class="icon32"><br/></div>
	<h2>Leden</h2>

    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <form id="<?php echo $items ?>-filter" method="get">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <!-- Now we can render the completed list table -->
        <?php 
        	$myListTable->display() ?>
    </form>
    

	<h2><?php 
		if ( current_user_can( 'manage_options' ) )
			echo ' <a href="' . admin_url('admin.php?page=dnh_leden_create') . '" class="add-new-h2">Nieuw lid</a>'; 
			echo '<a href="' . admin_url('admin.php?page=dnh_leden_edit&LidId=' . $_POST['radiolid']) . '" class="add-new-h2">Wijzig lid</a>';
			
		if ( ! empty( $_REQUEST['s'] ) )
			printf( ' <span class="subtitle">' . __('Search results for &#8220;%s&#8221;') . '</span>', get_search_query() );
		?>
	</h2>
</div>
