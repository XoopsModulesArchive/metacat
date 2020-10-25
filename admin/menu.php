<?php

/**
 * $Id: menu.php,v 1.1 2003/10/15 05:36:46 mikhail Exp $
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

/**
 * Entries for the admin menu
 *
 * @var array
 */
$adminmenu[1]['title'] = _MI_METACAT_CATMANAGER;
$adminmenu[1]['link'] = 'admin/index.php';
$adminmenu[2]['title'] = _MI_METACAT_INITIALIZE;
$adminmenu[2]['link'] = 'admin/index.php?op=initialize';
