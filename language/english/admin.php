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

/**
 * *#@+
 *    Translations
 */
define('_AM_DBUPDATED', 'Database Updated Successfully!');
define('_AM_UPDATED', 'Categories Database Updated');
define('_AM_NOTUPDATED', 'Unable to Update Categories Database');

define('_MC_EDIT', 'edit');
define('_MC_DELETE', 'delete');
define('_MC_SUBMIT', 'submit');
define('_MC_RESET', 'reset');
define('_MC_ADD_CAT_TO_MODULE', 'Add to Module');
define('_MC_REMOVE_CAT_FROM_MODULE', 'Remove from Module');
define('_MC_LBL_ACTION', 'Action');
define('_MC_LBL_MANAGE_CATEGORIES', 'Manage Categories');
define('_MC_LBL_CATEGORY_TITLE', 'Title');
define('_MC_MSG_CONFIRM_ADD_TO_MODULE', 'Add Category %s to Module %s?');
define('_MC_MSG_CONFIRM_REMOVE_FROM_MODULE', 'Remove Category %s from Module %s?');
define('_MC_MSG_CONFIRM_INITIALIZE', 'Really Initialize Database?<br>(This will completely overwrite your MetaCat database with data gathered from the modules.)');
define('_MC_MSG_FAILED_CORRUPT', 'Database operation failed.<br>Category information may be corrupt - we recommend to reinitialize your MetaCat Database.');
define('_MC_MSG_CONFIRM_DELETE_CATEGORY', 'Delete Category %s?');
define('_MC_MSG_NOTVALIDPARENT', 'The Selected Category is not a Valid Parent.');
define('_MC_MSG_IMAGE_UPLOADED', 'Image successfully uploaded.');
define('_MC_MSG_IMAGE_UPLOAD_FAILED', 'Image upload failed. Please try again.');
define('_MC_LABEL_GENERALINFO', 'General Info');
define('_MC_LABEL_CATTITLE', 'Title');
define('_MC_LABEL_CATDESCRIPTION', 'Description');
define('_MC_LBL_PARENTCATEGORY', 'Parent');
define('_MC_LBL_CATEGORYIMAGE', 'Category Image');
define('_MC_LBL_CURRENTIMAGE', 'Current Image');
define('_MC_LBL_NEWIMAGEFILE', 'New Image File');
define('_MC_LBL_RESETIMAGE', 'No Image');
define('_MC_MSG_IMAGERESET', 'Image has been reset');
