<?php

/**
 * -----------------------------------------------
 * INCLUDES
 * -----------------------------------------------
 */
 
# load and initialise any global libraries
require_once 'phpinc/includes.inc.php';

/**
 * -----------------------------------------------
 * Routing logic for front controller
 * to determine which controller to call
 * -----------------------------------------------
 */

# call to static methods to initialise routing
Epi::init('route');
Epi::setSetting('exceptions', true);	

# routes to controller functions
getRoute()->get('/','index');
getRoute()->get('/login','login');
getRoute()->post('/loggingIn','loggingIn');
getRoute()->get('/authHome','authHome');
getRoute()->get('/authAdmin','authAdmin');
getRoute()->post('/authForwardTo','authForwardTo');
getRoute()->post('/authCreateTicker','authCreateTicker');
getRoute()->get('/authDisplayTicker','authDisplayTicker');

# navigation
getRoute()->get('/authIncident','authIncident');
getRoute()->get('/authTicker','authTicker');

# incident create/update
getRoute()->post('/authAddIncident','authAddIncident');
getRoute()->post('/authUpdateIncident','authUpdateIncident');

# export to excel
getRoute()->get('/authExportMySqlToExcel','authExportMySqlToExcel');

# user create/edit/delete 
getRoute()->post('/authEditUser','authEditUser');
getRoute()->post('/authDeleteUser','authDeleteUser');
getRoute()->post('/authCreateUser','authCreateUser');
getRoute()->post('/authUserEdited','authUserEdited');
getRoute()->post('/authUserDeleted','authUserDeleted');
getRoute()->post('/authUserCreated','authUserCreated');

# dashBoard Admin
getRoute()->get('/authDashAdmin','authDashAdmin');
getRoute()->post('/authDashboardAdminUpdate','authDashboardAdminUpdate');

# dashBoard Client
getRoute()->get('/dashClient','dashClient');
getRoute()->get('/dashJSON','dashJSON');

# route to display messages
getRoute()->get('/messageDisplay','messageDisplay');
getRoute()->get('.*','error404');

getRoute()->run();