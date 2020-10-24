<?php
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
// DB table to use
$table = 'F_CREGLEMENT';
// Table's primary key
$primaryKey = 'RG_No';
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => 'C.RG_Date', 'dt' => 0, 'field' => 'RG_Date', 'formatter' => function( $d, $row ) {return date( 'jS M y', strtotime($d));}),
	array( 'db' => 'C.RG_Libelle', 'dt' => 1, 'field' => 'C.RG_Libelle' ),
	array('db'  => 'C.RG_Montant',     'dt' => 2, 'field' => 'C.RG_Montant', 'formatter' => function( $d, $row ) {return '$'.number_format($d);}),
	array( 'db' => 'CA.CA_Intitule',  'dt' => 3, 'field' => 'CA.CA_Intitule' ),
	array( 'db' => 'CAISSIER',   'dt' => 4, 'field' => 'CAISSIER')
);
// SQL server connection information
//require('config.php');
$sql_details = array(
	'user' => 'sa',
	'pass' => 'Rostand2012',
	'db'   => 'SECODI_GESCOM_DEV',
	'host' => 'localhost'
);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
// require( 'ssp.class.php' );
require('ssp.customized.class.php');
$joinQuery = "SELECT C.RG_Date,C.RG_Libelle,RG_Montant,CA.CA_Intitule,ISNULL(CO.CO_Nom,0) AS CAISSIER FROM F_CREGLEMENT C 
INNER JOIN F_CAISSE CA ON CA.CA_No = C.CA_No
LEFT JOIN SECODI.DBO.F_COLLABORATEUR CO ON C.CO_NoCaissier = CO.CO_No";
$extraWhere = "WHERE C.RG_Type = 2";        
echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);