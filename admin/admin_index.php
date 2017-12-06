<?php

define('ROOT_PATH', '../');
require_once ROOT_PATH . 'define.php';

include_once ROOT_PATH .'fonctions_conges.php' ;
include_once INCLUDE_PATH .'fonction.php';
include_once INCLUDE_PATH .'session.php';
include_once ROOT_PATH .'fonctions_calcul.php';

// verif des droits du user à afficher la page
verif_droits_user('is_admin');

/*************************************/
// recup des parametres reçus :
// SERVER
$PHP_SELF = filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_URL);
// GET / POST
$onglet = htmlentities(getpost_variable('onglet', 'admin-group'), ENT_QUOTES | ENT_HTML401);


/*********************************/
/*   COMPOSITION DES ONGLETS...  */
/*********************************/

$onglets = array();


$onglets['admin-users']    = _('admin_onglet_gestion_user');
//$onglets['ajout-user']    = _('admin_onglet_add_user');

if( $_SESSION['config']['admin_see_all'] || $_SESSION['userlogin']=="admin" || is_hr($_SESSION['userlogin']) ) {
    $onglets['admin-group'] = _('admin_onglet_gestion_groupe');
}

if ( !isset($onglets[ $onglet ]) && !in_array($onglet, array('ajout_group', 'modif_group', 'suppr_group')))
    $onglet = 'admin-group';

/*********************************/
/*   COMPOSITION DU HEADER...    */
/*********************************/

   $add_css = '<style>#onglet_menu .onglet{ width: '. (str_replace(',', '.', 100 / count($onglets) )).'% ;}</style>';
header_menu('', 'Libertempo : '._('button_admin_mode'),$add_css);


/*********************************/
/*   AFFICHAGE DE L'ONGLET ...    */
/*********************************/


/** initialisation des tableaux des types de conges/absences  **/
// recup du tableau des types de conges (seulement les conges)
$tab_type_cong=recup_tableau_types_conges();

// recup du tableau des types de conges exceptionnels (seulement les conges exceptionnels)
$tab_type_conges_exceptionnels=recup_tableau_types_conges_exceptionnels();

echo '<div class="'.$onglet.' main-content">';
    include_once ROOT_PATH . 'admin/admin_'.$onglet.'.php';
echo '</div>';

/*********************************/
/*   AFFICHAGE DU BOTTOM ...   */
/*********************************/

bottom();
exit;
