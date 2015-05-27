<?php
/*******************************************************************************************************
Plugin: DNHAdmin
Script: lid details-list-table-class.inc.php
Doel  : Klasse die de lijst met lid details kan renderen
Auteur: Rajenco
*******************************************************************************************************/

 /*************************** LOAD THE BASE CLASS *******************************
 *******************************************************************************
 * The WP_List_Table class isn't automatically available to plugins, so we need
 * to check if it's available and load it if necessary.
 */
if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


/************************** CREATE A PACKAGE CLASS *****************************
 *******************************************************************************
 * Create a new list table package that extends the core WP_List_Table class.
 * WP_List_Table contains most of the framework for generating the table, but we
 * need to define and override some methods so that our data can be displayed
 * exactly the way we need it to be.
 * 
 * To display this example on a page, you will first need to instantiate the class,
 * then call $yourInstance->prepare_items() to handle any data manipulation, then
 * finally call $yourInstance->display() to render the table to the page.
 * 
 * Our theme for this list table is going to be movies.
 */
class DNHlid_details_List_Table extends WP_List_Table {
    
    
    /** ************************************************************************
     * REQUIRED. Set up a constructor that references the parent constructor. We 
     * use the parent reference to set some default configs.
     ***************************************************************************/
    function __construct(){
        global $status, $page;
                
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'lid',     //singular name of the listed records
            'plural'    => 'leden',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }
    
    
	/********************* CONFIGUREREN VAN DE DATA*************************************
	 * 
	 * De volgende methoden worden gebruikt om de data (kolommen en rijen) te definieren
	 * 
	 * @return array An associative array containing row data
	 *************************************************************************************/
	function get_data() {
        global $wpdb; //This is used only if making any database queries
        return $wpdb->get_results("SELECT * FROM LID WHERE LidId= ' ".$_GET['LidId']." ' ");
	}
	
	/********************* CONFIGUREREN VAN DE TABEL HEADER *******************************
	 * 
	 * De volgende methoden renderen de cellen van de verschillende kolommen
	 * 
	 *************************************************************************************/
	
    /********************* KOLOMNAMEN RENDEREN ***************************************
     * REQUIRED! This method dictates the table's columns and titles. This should
     * return an array where the key is the column slug (and class) and the value 
     * is the column's title text. If you need a checkbox for bulk actions, refer
     * to the $columns array below.
     * 
     * The 'cb' column is treated differently than the rest. If including a checkbox
     * column in your table you must create a column_cb() method. If you don't need
     * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
     * 
     * @see WP_List_Table::::single_row_columns()
     * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_columns(){
        $columns = array(
            'LidId'     => 'ID',
            'Naam'    => 'Naam',
            'Adres' => 'Adres',
            'Woonplaats' => 'Woonplaats',
            'Telefoonnummer' => 'Telefoonnummer',
            'Emailadres' => 'Emailadres',
            'Status' => 'Status',
            'Factuur' =>    'Factuur'
        );
        return $columns;
    }
    
    /********************* CELLEN RENDEREN ************************************************
     * 
     * De volgende methoden renderen de cellen van de verschillende kolommen. Voor elke 
     * kolom moet een functie komen met de naam column_[slug] (Bij voorbeeld column_cb). 
     * De slugs definieer je in de functie get_columns() hierboven.
     * 
     *************************************************************************************/
		
	function column_lidid($item) {
		return $item->LidId;
	}
	
	function column_naam($item) {
		return $item->Naam;
	}
	
    function column_adres($item) {
        return $item->Adres;
    }
    
	function column_woonplaats($item) {
		return $item->Woonplaats;
	}
	
	function column_telefoonnummer($item) {
		return $item->Telefoonnummer;
	}
	
	function column_emailadres($item) {
		return $item->Emailadres;
	}
	
	function column_status($item) {
		if($item->Status == 1) {
			return "Actief";
		} else {
			return "non-actief";
		}
	}
	
	function column_factuur($item) {
		return "<a href='index.php?page=factuur&lidnr=" . $item->LidId . "'>Factuur</a>";
	}
    
   /** ************************************************************************
 	 * Functie die aangeroepen wordt als PHP niet de goede functie kan vinden
    **************************************************************************/
    function column_default($item, $column_name){
        return 'ERROR: '.print_r($item,true); //Show the whole array for troubleshooting purposes
    }

    /** ************************************************************************
     * REQUIRED! This is where you prepare your data for display. This method will
     * usually be used to query the database, sort and filter the data, and generally
     * get it ready to be displayed. At a minimum, we should set $this->items and
     * $this->set_pagination_args(), although the following properties and methods
     * are frequently interacted with here...
     * 
     * @global WPDB $wpdb
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     **************************************************************************/
    function prepare_items() {

        /**
         * First, lets decide how many records per page to show
         */
        $per_page = 100;
        
        
        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $data = $this->get_data();
        
        
        /**
         * REQUIRED. Finally, we build an array to be used by the class for column 
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);
                
        
        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */
        $current_page = $this->get_pagenum();
        
        /**
         * REQUIRED for pagination. Let's check how many items are in our data array. 
         * In real-world use, this would be the total number of items in your database, 
         * without filtering. We'll need this later, so you should always include it 
         * in your own package classes.
         */
        $total_items = count($data);
        
        
        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        
        
        
        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where 
         * it can be used by the rest of the class.
         */
        $this->items = $data;
        
        
        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }    
}

?>