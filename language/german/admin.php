<?php

/**
 * $Id: admin.php,v 1.1 2003/10/15 05:36:48 mikhail Exp $
 *
 * @version   $Revision: 1.1 $
 * @since     18.06.2003
 * @author    Jochen Buennagel <jb at buennagel dot com>
 * @copyright copyright (c) 2003 by Jochen Buennagel
 *
 * This file is part of MetaCat, a category management module for Xoops
 *
 * MetaCat is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * MetaCat is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

/**#@+
 *   Translations
 */
define('_AM_DBUPDATED', 'Datenbank erfolgreich aktualisiert!');
define('_AM_UPDATED', 'MetaCat-Datenbank aktualisiert');
define('_AM_NOTUPDATED', 'MetaCat-Datenbank konnte nicht aktualisiert werden.');

define('_MC_EDIT', '&Auml;ndern');
define('_MC_DELETE', 'L&ouml;schen');
define('_MC_SUBMIT', 'Abschicken');
define('_MC_RESET', 'Zur&uuml;cksetzen');
define('_MC_ADD_CAT_TO_MODULE', 'Zu Modul hinzuf&uuml;gen');
define('_MC_REMOVE_CAT_FROM_MODULE', 'Aus Modul entfernen');
define('_MC_LBL_ACTION', 'Aktion');
define('_MC_LBL_MANAGE_CATEGORIES', 'Kategorien verwalten');
define('_MC_LBL_CATEGORY_TITLE', 'Titel');
define('_MC_MSG_CONFIRM_ADD_TO_MODULE', 'Kategorie %s zu Modul %s hinzuf&uuml;gen?');
define('_MC_MSG_CONFIRM_REMOVE_FROM_MODULE', 'Kategorie %s aus Modul %s entfernen?');
define('_MC_MSG_CONFIRM_INITIALIZE', 'Datenbank wirklich initialisieren?<br>(Die MetaCat-Datenbank wird mit den Daten aus den Modulen &uuml;berschrieben.)');
define('_MC_MSG_FAILED_CORRUPT', 'Datenbankoperation fehlgeschlagen.<br>Die MetaCat-Datenbank k&ouml;nnte fehlerhaft sein - Initialisierung der MetaCat-Datenbank wird empfohlen.');
define('_MC_MSG_CONFIRM_DELETE_CATEGORY', 'Kategorie %s l&ouml;schen?');
define('_MC_MSG_NOTVALIDPARENT', 'Keine g&uuml;ltige &uuml;bergeordnete Kategorie.');
define('_MC_MSG_IMAGE_UPLOADED', 'Bild erfolgreich hochgeladen.');
define('_MC_MSG_IMAGE_UPLOAD_FAILED', 'Hochladen fehlgeschlagen. Bitte versuchen Sie es noch einmal.');
define('_MC_LABEL_GENERALINFO', 'Allgemeine Informationen');
define('_MC_LABEL_CATTITLE', 'Titel');
define('_MC_LABEL_CATDESCRIPTION', 'Beschreibung');
define('_MC_LBL_PARENTCATEGORY', '&Uuml;bergeordnete Kategorie');
define('_MC_LBL_CATEGORYIMAGE', 'Bild');
define('_MC_LBL_CURRENTIMAGE', 'Aktuelles Bild');
define('_MC_LBL_NEWIMAGEFILE', 'Neue Bilddatei');
define('_MC_LBL_RESETIMAGE', 'Kein Bild');
define('_MC_MSG_IMAGERESET', 'Bild gel&ouml;scht');

//addedbyfrankblack
define('_MC_NEWCAT', 'Neue Kategorie erstellen');
define('_MC_NEWCATNAME', 'Kategoriename');
define('_MC_NEWCATDESC', 'Beschreibung');
