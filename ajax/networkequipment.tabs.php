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
// Original Author of file:
// Purpose of file:
// ----------------------------------------------------------------------

$NEEDED_ITEMS=array("computer","contract","document","enterprise","group","infocom","link",
                    "networking","peripheral","phone","printer","reservation","tracking","user");

define('GLPI_ROOT', '..');
include (GLPI_ROOT . "/inc/includes.php");
header("Content-Type: text/html; charset=UTF-8");
header_nocache();

if (!isset($_POST['id'])) {
   exit();
}
if (!isset($_POST["sort"])) {
   $_POST["sort"] = "";
}
if (!isset($_POST["order"])) {
   $_POST["order"] = "";
}
if (!isset($_POST["withtemplate"])) {
   $_POST["withtemplate"] = "";
}
$netdevice=new NetworkEquipment();
$netdevice->check($_POST["id"],'r');

if (!empty($_POST["withtemplate"])) {
   if ($_POST["id"]>0) {
      switch($_REQUEST['glpi_tab']) {
         case 4 :
            Infocom::showForItem($CFG_GLPI["root_doc"]."/front/infocom.form.php",
                                 $netdevice,1,$_POST["withtemplate"]);
            Contract::showAssociated($netdevice,$_POST["withtemplate"]);
            break;

         case 5 :
            Document::showAssociated($netdevice,$_POST["withtemplate"]);
            break;

         default :
            if (!displayPluginAction(NETWORKING_TYPE,$_POST["id"],$_REQUEST['glpi_tab'],
                                     $_POST["withtemplate"])) {
               showPorts($_POST["id"], NETWORKING_TYPE,$_POST["withtemplate"]);
               if ($_POST["withtemplate"]!=2) {
                  showPortsAdd($_POST["id"],NETWORKING_TYPE);
               }
            }
      }
   }
} else {
   switch($_REQUEST['glpi_tab']) {
      case -1 :
         showPortsAdd($_POST["id"],NETWORKING_TYPE);
         showPorts($_POST["id"],NETWORKING_TYPE);
         Infocom::showForItem($CFG_GLPI["root_doc"]."/front/infocom.form.php",$netdevice);
         Contract::showAssociated($netdevice);
         Document::showAssociated($netdevice,$_POST["withtemplate"]);
         showJobListForItem(NETWORKING_TYPE,$_POST["id"]);
         showLinkOnDevice(NETWORKING_TYPE,$_POST["id"]);
         displayPluginAction(NETWORKING_TYPE,$_POST["id"],$_REQUEST['glpi_tab'],$_POST["withtemplate"]);
         break;

      case 4 :
         Infocom::showForItem($CFG_GLPI["root_doc"]."/front/infocom.form.php",$netdevice);
         Contract::showAssociated($netdevice);
         break;

      case 5 :
         Document::showAssociated($netdevice,$_POST["withtemplate"]);
         break;

      case 6 :
         showJobListForItem(NETWORKING_TYPE,$_POST["id"]);
         break;

      case 7 :
         showLinkOnDevice(NETWORKING_TYPE,$_POST["id"]);
         break;

      case 10 :
         showNotesForm($_POST['target'],NETWORKING_TYPE,$_POST["id"]);
         break;

      case 11 :
         showDeviceReservations($_POST['target'],NETWORKING_TYPE,$_POST["id"]);
         break;

      case 12 :
         showHistory(NETWORKING_TYPE,$_POST["id"]);
         break;

      default :
         if (!displayPluginAction(NETWORKING_TYPE,$_POST["id"],$_REQUEST['glpi_tab'],
                                  $_POST["withtemplate"])) {
            showPortsAdd($_POST["id"],NETWORKING_TYPE);
            showPorts($_POST["id"],NETWORKING_TYPE);
         }
   }
}

ajaxFooter();

?>
