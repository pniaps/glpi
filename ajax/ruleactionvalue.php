<?php
/*
 * @version $Id$
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2009 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 --------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file: Julien Dombre
// Purpose of file:
// ----------------------------------------------------------------------

// Direct access to file
if (strpos($_SERVER['PHP_SELF'],"ruleactionvalue.php")) {
   define('GLPI_ROOT','..');
   include (GLPI_ROOT."/inc/includes.php");
   header("Content-Type: text/html; charset=UTF-8");
   header_nocache();
}

if (!defined('GLPI_ROOT')) {
   die("Can not acces directly to this file");
}

include_once (GLPI_ROOT."/inc/rule.function.php");
checkLoginUser();
$display=false;

switch ($_POST["action_type"]) {
   //If a regex value is used, then always display an autocompletiontextfield
   case "regex_result" :
   case "append_regex_result" :
      autocompletionTextField("value", "glpi_ruleactions", "value", "", 40);
      break;

   default :
      if (isset($RULES_ACTIONS[$_POST["sub_type"]][$_POST["field"]]['type'])) {
         switch($RULES_ACTIONS[$_POST["sub_type"]][$_POST["field"]]['type']) {
            case "dropdown" :
               Dropdown::dropdownValue($RULES_ACTIONS[$_POST["sub_type"]][$_POST["field"]]['table'],"value");
               $display=true;
               break;

            case "dropdown_assign" :
               User::dropdown("value",array('right'=>'own_ticket'));
               $display=true;
               break;

            case "dropdown_users" :
               User::dropdownAll("value");
               $display=true;
               break;

            case "dropdown_priority" :
               Ticket::dropdownPriority("value");
               $display=true;
               break;

            case "dropdown_status" :
               Ticket::dropdownStatus("value");
               $display=true;
               break;

            case "yesno" :
               Dropdown::showYesNo("value");
               $display=true;
               break;
         }
      }
      if (!$display) {
         autocompletionTextField("value", "glpi_ruleactions", "value", "", 40);
      }
}

?>
