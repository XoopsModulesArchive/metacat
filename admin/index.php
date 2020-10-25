<?php

/**
 * $Id: index.php,v 1.1 2003/10/15 05:36:46 mikhail Exp $
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
 * Include some library files we need...
 */
require dirname(__DIR__, 3) . '/include/cp_header.php';

if (false === @include '../language/' . $xoopsConfig['language'] . '/main.php') {
    include '../language/english/main.php';
}

require_once XOOPS_ROOT_PATH . '/include/functions.php';
require_once XOOPS_ROOT_PATH . '/class/xoopstopic.php';
require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';

require XOOPS_ROOT_PATH . '/modules/metacat/class/modules.dat.php'; // load module data
require_once XOOPS_ROOT_PATH . '/modules/metacat/class/metacategory.class.php';

/**
 * Find the index of a partially filled array in an array of arrays (phew)
 *
 * @param mixed $array
 * @param mixed $values
 * @return false|int|string
 * @return false|int|string
 */
function FindValuesInArray($array, $values)
{
    foreach ($array as $index => $entry) {
        $found = true;

        foreach ($values as $key => $value) {
            if ($entry[$key] != $value) {
                $found = false;

                break; // "short circuit logic"
            }
        } // loop thru values

        if ($found) {
            return $index;
        }
    } // loop through entries

    return false;
}

/**
 * Gather cat information from all modules
 *
 * @param mixed $categories
 * @param mixed $moduleInfo
 * @param mixed $pid
 * @param mixed $parentCategory
 */
function LoadCategoriesRecursive(&$categories, $moduleInfo, $pid = 0, $parentCategory = 0)
{
    static $s_next_id;

    if (empty($categories)) {
        $s_next_id = 1;
    }

    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix($moduleInfo['cat_table']) . '`';

    if (!empty($moduleInfo['parent_id_field'])) {
        $sql .= " WHERE `{$moduleInfo['parent_id_field']}`='$pid'";
    }

    $rows = $xoopsDB->query($sql);

    if (false !== $rows) {
        while (false !== $category = $xoopsDB->fetchArray($rows)) {
            $insertion_id = FindValuesInArray(
                $categories,
                ['title' => $category[$moduleInfo['title_field']], 'parent_id' => $parentCategory]
            );

            if (false === $insertion_id) {
                $insertion_id = $s_next_id++;
            }

            $categories[$insertion_id]['title'] = $category[$moduleInfo['title_field']];

            $categories[$insertion_id]['parent_id'] = $parentCategory;

            $categories[$insertion_id]['module_id'][$moduleInfo['name']] = $category[$moduleInfo['cat_id_field']];

            if (!empty($moduleInfo['parent_id_field'])) {
                $categories[$insertion_id]['module_parent'][$moduleInfo['name']] = $category[$moduleInfo['parent_id_field']];

                LoadCategoriesRecursive($categories, $moduleInfo, $category[$moduleInfo['cat_id_field']], $insertion_id, false);
            } else {
                $categories[$insertion_id]['module_parent'][$moduleInfo['name']] = 0;
            }
        } // while
    }
}

/**
 * Reads the Metacat categories Table from the database
 *
 * @return array
 */
function ReadCategoriesFromDatabase()
{
    $db = XoopsDatabaseFactory::getDatabaseConnection();

    $tree = new XoopsTree($db->prefix('metacat_categories'), 'cat_id', 'parent_id');

    $rows = $tree->getChildTreeArray();

    foreach ($rows as $key => $data) {
        $categories[$key] = &MetaCategory::InstanceFromData($data);
    }

    return $categories;
}

/**
 * Reads category information from the individual modules and writes it to
 * the metacat database.
 *
 * Attention: this function will delete the current metacat database and
 * overwrite it with the new information.
 */
function InitializeCategories()
{
    global $modules;

    $categories = [];

    foreach ($modules as $module) {
        LoadCategoriesRecursive($categories, $module);
    }

    WriteCategoriesToDatabase($categories);
}

/**
 * Writes all categories to the database, deleting all old data
 *
 * @param mixed $categories
 */
function WriteCategoriesToDatabase($categories)
{
    $db = XoopsDatabaseFactory::getDatabaseConnection();

    $db->query('TRUNCATE TABLE ' . $db->prefix('metacat_categories'));

    foreach ($categories as $cat) {
        $cat_object = &MetaCategory::InstanceFromData($cat, false);

        $cat_object->Commit();
    }
}

function CategoryAdmin()
{
    global $modules;

    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    // $myts = MyTextSanitizer::getInstance();

    require_once XOOPS_ROOT_PATH . '/class/xoopstree.php';

    // $mytree = new XoopsTree( $xoopsDB->prefix( "mylinks_cat" ), "cid", "pid" );

    $categories = ReadCategoriesFromDatabase();

    require XOOPS_ROOT_PATH . '/modules/metacat/admin/templates/catmanager.tpl.php';
}

/**
 * process activation/deactivation in modules
 */
function SetActiveCategories()
{
    $category = LoadMetaCategoryById($_POST['cat_id']);

    UpdateCategoryInModules($category);
}

/**
 * @param mixed $catId
 */
function CategoryDetail($catId = 0)
{
    global $modules;

    $cat = MetaCategory::InstanceById($catId);

    $db = XoopsDatabaseFactory::getDatabaseConnection();

    require_once XOOPS_ROOT_PATH . '/class/xoopstree.php';

    $mytree = new XoopsTree($db->prefix('metacat_categories'), 'cat_id', 'parent_id');

    include __DIR__ . '/templates/category_edit.tpl.php';
}

function NewCategoryForm()
{
    include __DIR__ . '/templates/new_category.tpl.php';
}

xoops_cp_header();
switch (@$_REQUEST['op']) {
    case 'remove_from_module':
        xoops_confirm(
            [
                'op' => 'do_remove_from_module',
'metacat_id' => $_GET['metacat_id'],
'module_name' => $_GET['module_name'],
            ],
            $_SERVER['PHP_SELF'],
            sprintf(_MC_MSG_CONFIRM_REMOVE_FROM_MODULE, $_GET['metacat_title'], ucwords($_GET['module_name']))
        );
        break;
    case 'do_remove_from_module':
        $cat = MetaCategory::InstanceById($_POST['metacat_id']);
        $cat->RemoveFromModule($_POST['module_name']);
        redirect_header($_SERVER['PHP_SELF'], 3, _AM_UPDATED);
        exit();
        break;
    case 'add_to_module':
        xoops_confirm(
            [
                'op' => 'do_add_to_module',
'metacat_id' => $_GET['metacat_id'],
'module_name' => $_GET['module_name'],
            ],
            $_SERVER['PHP_SELF'],
            sprintf(_MC_MSG_CONFIRM_ADD_TO_MODULE, $_GET['metacat_title'], ucwords($_GET['module_name']))
        );
        break;
    case 'do_add_to_module':
        $cat = MetaCategory::InstanceById($_POST['metacat_id']);
        $cat->AddToModule($_POST['module_name']);
        redirect_header($_SERVER['PHP_SELF'], 3, _AM_UPDATED);
        exit();
        break;
    case 'delete_cat':
        xoops_confirm(
            [
                'op' => 'do_delete_cat',
'metacat_id' => $_GET['metacat_id'],
            ],
            $_SERVER['PHP_SELF'],
            sprintf(_MC_MSG_CONFIRM_DELETE_CATEGORY, $_GET['metacat_title'])
        );
        break;
    case 'do_delete_cat':
        $cat = MetaCategory::InstanceById($_POST['metacat_id']);
        if ($cat->Delete()) {
            redirect_header($_SERVER['PHP_SELF'], 3, _AM_UPDATED);
        } else {
            redirect_header($_SERVER['PHP_SELF'], 3, _MC_MSG_FAILED_CORRUPT);
        }
        exit();
        break;
    case 'detail':
        CategoryDetail($_GET['metacat_id']);
        break;
    case 'do_edit_info':
        $cat          = MetaCategory::InstanceById($_POST['metacat_id']);
        $cat->m_Title = $_POST['title'];
        $cat->m_Description = $_POST['description'];
        if ($cat->Commit() and $cat->WriteToModules()) {
            redirect_header($_SERVER['PHP_SELF'], 3, _AM_UPDATED);
        } else {
            redirect_header($_SERVER['PHP_SELF'], 3, _MC_MSG_FAILED_CORRUPT);
        }
        exit();
        break;
    case 'do_upload_image':
        $cat = MetaCategory::InstanceById($_POST['metacat_id']);
        if ($cat->UploadImage('cat_image')) {
            redirect_header($_SERVER['PHP_SELF'], 3, _MC_MSG_IMAGE_UPLOADED);
        } else {
            redirect_header($_SERVER['PHP_SELF'], 3, _MC_MSG_IMAGE_UPLOAD_FAILED);
        }
        exit();
        break;
    case 'do_reset_image':
        $cat = MetaCategory::InstanceById($_POST['metacat_id']);
        $cat->ResetImage();
        redirect_header($_SERVER['PHP_SELF'], 3, _MC_MSG_IMAGERESET);
        exit();
        break;
    case 'initialize':
        xoops_confirm(
            ['op' => 'do_initialize'],
            $_SERVER['PHP_SELF'],
            _MC_MSG_CONFIRM_INITIALIZE
        );
        break;
    case 'do_initialize':
        InitializeCategories();
        redirect_header($_SERVER['PHP_SELF'], 3, _AM_UPDATED);
        exit();
        break;
    case 'create_new_cat':
        $cat = new MetaCategory();
        $cat->m_Title = $_POST['title'];
        $cat->m_Description = $_POST['description'];
        $cat->Commit();
        redirect_header($_SERVER['PHP_SELF'], 3, _AM_UPDATED);
        exit();
        break;
    case 'do_edit_parent':
        $cat = MetaCategory::InstanceById($_POST['metacat_id']);
        if (!$cat->IsValidParent($_POST['parent_cat'])) {
            redirect_header($_SERVER['PHP_SELF'], 3, _MC_MSG_NOTVALIDPARENT);

            exit();
        }
        if (!$cat->SetNewParent($_POST['parent_cat'])) {
            redirect_header($_SERVER['PHP_SELF'], 3, _MC_MSG_FAILED_CORRUPT);

            exit();
        }
        redirect_header($_SERVER['PHP_SELF'], 3, _AM_UPDATED);
        exit();
        break;
    case 'list':
    default:
        CategoryAdmin();
        NewCategoryForm();
} // switch
xoops_cp_footer();
