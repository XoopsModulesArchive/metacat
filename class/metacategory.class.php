<?php

/**
 * $Id: metacategory.class.php,v 1.1 2003/10/15 05:36:47 mikhail Exp $
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
 * load module data
 */
require XOOPS_ROOT_PATH . '/modules/metacat/class/modules.dat.php';

/**
 * A category used in multiple Xoops modules
 *
 * @version   $Id: metacategory.class.php,v 1.1 2003/10/15 05:36:47 mikhail Exp $
 * @copyright 2003
 */
class MetaCategory
{
    /**
     * Id of the category in the database
     *
     * @var int
     */

    public $m_CatId;

    /**
     * ID of the category's parent
     *
     * @var int
     */

    public $m_ParentId;

    /**
     * Object representing the parent of this object.
     *
     * @var object MetaCategory
     */

    public $m_Parent;

    /**
     * Title of the category
     *
     * @var string
     */

    public $m_Title;

    /**
     * Description of the category
     *
     * @var string
     */

    public $m_Description;

    /**
     * string of periods returned from the tree functions
     *
     * @var string
     */

    public $m_Nesting;

    /**
     * Array of IDs of the class in the modules
     *
     * @var array
     */

    public $m_ModuleIds;

    /**
     * Array of parent IDs in the modules
     *
     * @var array
     */

    public $m_ModuleParents;

    /**
     * base filename of the associated image file
     *
     * @var stirng
     */

    public $m_ImageFileName;

    /**
     * Full Path to the Image file
     *
     * @var string
     */

    public $m_ImageFullPath;

    /**
     * I this Category loaded from the Database?
     *
     * @var bool
     */

    public $m_FromDatabase = false;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Loads data for one category based on its ID in MetaCat
     *
     * @param string $categoryId
     * @return bool
     */
    public function LoadById($categoryId)
    {
        $xoopsDb = XoopsDatabaseFactory::getDatabaseConnection();

        $sql = 'SELECT * FROM `' . $xoopsDb->prefix('metacat_categories') . "` WHERE cat_id = '$categoryId'";

        if (false !== ($result = $xoopsDb->query($sql))) {
            if (false !== ($row = $xoopsDb->fetchArray($result))) {
                $this->PopulateFromData($row);

                $this->m_FromDatabase = true;

                return true;
            }
        }

        return false;
    }

    /**
     * Create a new object and load data for one ID
     *
     * @param int $categoryId
     * @return object MetaCategory
     */
    public function InstanceById($categoryId)
    {
        $new_category = new self();

        if ($new_category->LoadById($categoryId)) {
            return $new_category;
        }

        return false;
    }

    /**
     * Create a new object from row data
     *
     * @param array $categoryData
     * @param bool  $fromDatabase set to FALSE to create a brand new category
     * @return object MetaCategory
     */
    public function &InstanceFromData($categoryData, $fromDatabase = true)
    {
        $new_category = new self();

        $new_category->PopulateFromData($categoryData);

        $this->m_FromDatabase = $fromDatabase;

        return $new_category;
    }

    /**
     * Set attributes from row data
     *
     * @param array $categoryData
     */
    public function PopulateFromData($categoryData)
    {
        $this->m_CatId = $categoryData['cat_id'];

        $this->m_ParentId = $categoryData['parent_id'];

        $this->m_Title = $categoryData['title'];

        $this->m_Description = $categoryData['description'];

        $this->m_Nesting = @$categoryData['prefix'];

        $this->m_ImageFullPath = @$categoryData['image'];

        $this->m_ImageFileName = basename(@$categoryData['image']);

        if (is_array($categoryData['module_id'])) {
            $this->m_ModuleIds = $categoryData['module_id'];
        } else {
            $this->m_ModuleIds = unserialize($categoryData['module_id']);
        }

        if (is_array($categoryData['module_parent'])) {
            $this->m_ModuleParents = $categoryData['module_parent'];
        } else {
            $this->m_ModuleParents = unserialize($categoryData['module_parent']);
        }
    }

    /**
     * Write this Category to the Database
     */
    public function Commit()
    {
        $db = XoopsDatabaseFactory::getDatabaseConnection();

        $sql_set = "parent_id='" . $this->m_ParentId . "', " . "title='" . $this->m_Title . "', " . "description='" . $this->m_Description . "', " . "image='" . $this->m_ImageFullPath . "', " . "module_id='" . serialize($this->m_ModuleIds) . "', " . "module_parent='" . serialize(
            $this->m_ModuleParents
        ) . "' ";

        if ($this->m_FromDatabase) {
            $sql = 'UPDATE ' . $db->prefix('metacat_categories') . ' SET ' . $sql_set . " WHERE cat_id='" . $this->m_CatId . "'";
        } else {
            $sql = 'INSERT INTO ' . $db->prefix('metacat_categories') . ' SET ' . $sql_set;
        }

        if (!$db->query($sql)) {
            trigger_error('Database query failed: ' . $sql);

            return false;
        }

        if (!$this->m_FromDatabase) {
            $this->m_CatId = $db->getInsertId();

            $this->m_FromDatabase = true;
        }

        return true;
    }

    /**
     * Adds the category to a module
     *
     * @param mixed $moduleName
     */
    public function AddToModule($moduleName)
    {
        global $modules;

        $parent_category = self::InstanceById($this->m_ParentId);

        $db = XoopsDatabaseFactory::getDatabaseConnection();

        $module = $modules[$moduleName];

        // this assumes it doesn't exist yet...

        $sql = 'insert into ' . $db->prefix($module['cat_table']) . ' set `' . $module['title_field'] . "`='" . $this->m_Title . "'";

        if (!empty($module['descr_field'])) {
            $sql .= ', ' . $module['descr_field'] . "='" . $this->m_Description . "'";
        }

        if (!empty($module['parent_id_field'])) {
            $sql .= ', ' . $module['parent_id_field'] . "='" . $parent_category->m_ModuleIds[$moduleName] . "'";
        }

        if ($db->query($sql)) {
            $this->m_ModuleIds[$moduleName] = $db->getInsertId();

            $this->Commit();

            $this->WriteImageToModule($module);
        }
    }

    /**
     * Check if there's content in a module
     *
     * @param string $moduleName
     * @return bool
     */
    public function HasContent($moduleName)
    {
        // check if there is content

        global $modules;

        $db = XoopsDatabaseFactory::getDatabaseConnection();

        $module = $modules[$moduleName];

        $sql = sprintf(
            "SELECT * FROM %s WHERE %s='%s'",
            $db->prefix($module['content_table']),
            $module['content_cat_field'],
            $this->m_ModuleIds[$module['name']]
        );

        $rows = $db->getRowsNum($db->query($sql));

        $has_content = ($rows['content_count'] > 0);

        return $has_content;
    }

    /**
     * Remove the category from module
     *
     * @param string $moduleName
     * @return bool
     * @return bool
     */
    public function RemoveFromModule($moduleName)
    {
        global $modules;

        $db = XoopsDatabaseFactory::getDatabaseConnection();

        $module = $modules[$moduleName];

        if (false === $this->CanRemoveFromModule($moduleName)) {
            return false;
        }

        $sql = sprintf(
            "DELETE FROM %s WHERE %s='%s'",
            $db->prefix($module['cat_table']),
            $module['cat_id_field'],
            $this->m_ModuleIds[$module['name']]
        );

        if (false !== $db->query($sql)) {
            unset($this->m_ModuleIds[$moduleName]);

            $this->Commit();

            return true;
        }

        return false;
    }

    /**
     * Replace the categoryID by the category object
     *
     * @param mixed $category ID or object
     * @return \MetaCategory
     * @return \MetaCategory
     */
    public function &LoadIfNotObject(&$category)
    {
        if (!is_object($category)) {
            $result = new self();

            $result->LoadById($category);

            return $result;
        }

        return $category;
    }

    /**
     * Sets a new parent for the category
     *
     * @param mixed $newParentCategory
     * @return bool
     * @return bool
     */
    public function SetNewParent($newParentCategory)
    {
        global $modules;

        $newParentCategory = &$this->LoadIfNotObject($newParentCategory);

        if (!$this->IsValidParent($newParentCategory)) {
            return false;
        }

        $this->m_ParentId = $newParentCategory->m_CatId;

        $this->m_ModuleParents = $newParentCategory->m_ModuleIds;

        $this->Commit();

        $db = XoopsDatabaseFactory::getDatabaseConnection();

        foreach ($modules as $module) {
            if (!empty($module['parent_id_field']) and !empty($this->m_ModuleIds[$module['name']])) {
                // write parent data to module

                $sql = 'UPDATE  ' . $db->prefix($module['cat_table']) . ' SET ' . $module['parent_id_field'] . "='" . $this->m_ModuleParents[$module['name']] . "' " . ' WHERE ' . $module['cat_id_field'] . "='" . $this->m_ModuleIds[$module['name']] . "' ";

                if (!$db->query($sql)) {
                    echo $db->error();

                    return false;
                } // if
            } // if
        } // foreach
        return true;
    }

    /**
     * Write's the category's image to a module
     *
     * @param array $module
     * @return bool
     * @return bool
     */
    public function WriteImageToModule($module)
    {
        if (!empty($module['image_reference_type'])) {
            if ('PATH' == $module['image_reference_type'] and !empty($this->m_ImageFileName)) {
                $module_image_information = $this->m_ImageFileName;

                $module_filename = $module['image_upload_path'] . $module_image_information;

                if (false === copy($this->m_ImageFullPath, $module_filename)) {
                    trigger_error('can\'t copy file to module dir', E_USER_WARNING);

                    return false;
                }
            } elseif ('URL' == $module['image_reference_type']) {
                if (!empty($this->m_ImageFileName)) {
                    $module_image_information = XOOPS_URL . '/uploads/' . $this->m_ImageFileName;
                } else {
                    $module_image_information = XOOPS_URL . '/uploads/blank.gif';
                }
            } else {
                trigger_error('no module image upload information', E_USER_WARNING);

                return false;
            }

            $db = XoopsDatabaseFactory::getDatabaseConnection();

            $sql = sprintf(
                "UPDATE %s SET %s='%s' WHERE %s='%s'",
                $db->prefix($module['cat_table']),
                $module['image_reference_field'],
                $module_image_information,
                $module['cat_id_field'],
                $this->m_ModuleIds[$module['name']]
            );

            if (!$db->query($sql)) {
                trigger_error('writing to database failed: ' . $sql, E_USER_WARNING);

                return false;
            }
        }

        return true;
    }

    /**
     * Remove the current image from a module
     *
     * @param mixed $module
     * @return bool
     * @return bool
     */
    public function RemoveImageFromModule($module)
    {
        if (!empty($module['image_reference_type'])) {
            if ('PATH' == $module['image_reference_type']) {
                $module_image_information = $this->m_ImageFileName;

                $module_filename = $module['image_upload_path'] . $module_image_information;

                if (false === unlink($module_filename)) {
                    trigger_error('can\'t delete file from module dir', E_USER_WARNING);

                    return false;
                }
            } else {
                $module_image_information = ''; //XOOPS_URL . '/uploads/blank.gif';
            }

            $db = XoopsDatabaseFactory::getDatabaseConnection();

            $sql = sprintf(
                "UPDATE %s SET %s='%s' WHERE %s='%s'",
                $db->prefix($module['cat_table']),
                $module['image_reference_field'],
                $module_image_information,
                $module['cat_id_field'],
                $this->m_ModuleIds[$module['name']]
            );

            if (!$db->query($sql)) {
                trigger_error('writing to database failed: ' . $sql, E_USER_WARNING);

                return false;
            }
        }

        return true;
    }

    /**
     * Upload an image, and apply to modules
     *
     * @param mixed $uploadname
     * @return bool
     */
    public function UploadImage($uploadname)
    {
        require_once XOOPS_ROOT_PATH . '/class/uploader.php';

        $allowed_mimetypes = ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png'];

        $maxfilesize = 50000;

        $uploader = new XoopsMediaUploader(XOOPS_ROOT_PATH . '/uploads', $allowed_mimetypes, $maxfilesize);

        $uploader->setPrefix('mc');

        if ($uploader->fetchMedia($uploadname)) {
            if (!$uploader->upload()) {
                return false;
            }

            $this->m_ImageFileName = $uploader->getSavedFileName();

            $this->m_ImageFullPath = $uploader->getSavedDestination();

            $this->Commit();

            global $modules;

            foreach ($modules as $module) {
                if ($this->IsActiveInModule($module['name'])) {
                    if (false === $this->WriteImageToModule($module)) {
                        return false;
                    }
                }
            }

            return true;
        }

        echo $uploader->getErrors();

        return false;
    }

    /**
     * Remove the category image
     */
    public function ResetImage()
    {
        global $modules;

        foreach ($modules as $module) {
            if ($this->IsActiveInModule($module['name'])) {
                if (false === $this->RemoveImageFromModule($module)) {
                    return false;
                }
            }
        }

        $this->m_ImageFileName = '';

        $this->m_ImageFullPath = '';

        $this->Commit();

        return true;
    }

    /**
     * Write Category Information to modules
     */
    public function WriteToModules()
    {
        $db = XoopsDatabaseFactory::getDatabaseConnection();

        global $modules;

        foreach ($modules as $module) {
            if (!empty($this->m_ModuleIds[$module['name']])) { // does the category exist in this module?
                $sql = 'UPDATE ' . $db->prefix($module['cat_table']) . ' SET ';

                if (!empty($module['descr_field'])) { // does the module have category descriptions?
                    $sql .= $module['descr_field'] . "='" . $this->m_Description . "', ";
                }

                if (!empty($module[''])) {
                }

                $sql .= $module['title_field'] . "='" . $this->m_Title . "' ";

                $sql .= ' WHERE ' . $module['cat_id_field'] . "='" . $this->m_ModuleIds[$module['name']] . "'";

                if (false === $db->query($sql)) {
                    echo $sql;

                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Check to see if a new parent Category is valid for this category
     *
     * The new parent category can only be set if it is active in all modules where the
     * child category is active.
     *
     * @param mixed $parentCategoryId
     * @return bool
     * @return bool
     */
    public function IsValidParent($parentCategoryId)
    {
        global $modules;

        $parent_category = $this->LoadIfNotObject($parentCategoryId);

        $db = XoopsDatabaseFactory::getDatabaseConnection();

        require_once XOOPS_ROOT_PATH . '/class/xoopstree.php';

        $mytree = new XoopsTree($db->prefix('metacat_categories'), 'cat_id', 'parent_id');

        $children = $mytree->getAllChildId($this->m_CatId, '', [$this->m_CatId]);

        if (array_key_exists($parent_category->m_CatId, $children)) {
            return false;
        }

        foreach ($this->m_ModuleIds as $module_name => $module_id) {
            if (!empty($module_id) and empty($modules[$module_name]['parent_id_field'])) {
                return false;
            }

            if (!empty($module_id) and empty($parent_category->m_ModuleIds[$module_name])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if the category can be activated in a given module
     *
     * @param string $moduleName
     * @return bool
     */
    public function CanAddToModule($moduleName)
    {
        global $modules;

        if (!empty($this->m_ModuleIds[$moduleName])) {
            return false;
        }

        if (empty($modules[$moduleName]['parent_id_field']) and $this->m_ParentId > 0) {
            return false;
        }

        if (0 == $this->m_ParentId and empty($this->m_ModuleIds[$moduleName])) {
            return true;
        }

        if (!is_object($this->m_Parent)) {
            $this->m_Parent = self::InstanceById($this->m_ParentId);
        }

        $result = !empty($this->m_Parent->m_ModuleIds[$moduleName]);

        return $result;
    }

    /**
     * Check if the category is active in a module
     *
     * @param string $moduleName
     * @return bool
     * @return bool
     */
    public function IsActiveInModule($moduleName)
    {
        $result = !empty($this->m_ModuleIds[$moduleName]);

        return $result;
    }

    /**
     * Check if the category can be deactivated in a given module
     *
     * @param string $moduleName
     * @return bool
     * @return bool
     */
    public function CanRemoveFromModule($moduleName)
    {
        global $modules;

        $db = XoopsDatabaseFactory::getDatabaseConnection();

        if (empty($this->m_ModuleIds[$moduleName])) {
            return false;
        }

        if (empty($modules[$moduleName]['parent_id_field'])) {
            return true;
        }

        $sql = 'SELECT * FROM ' . $db->prefix($modules[$moduleName]['cat_table']) . ' WHERE ' . $modules[$moduleName]['parent_id_field'] . "='" . $this->m_ModuleIds[$moduleName] . "'";

        $result = $db->query($sql);

        if ($db->getRowsNum($result) > 0) {
            return false;
        }

        if ($this->HasContent($moduleName)) {
            return false;
        }

        return true;
    }

    /**
     * @param mixed $moduleName
     * @return bool
     * @return bool
     */
    public function CannotRemoveFromModule($moduleName)
    {
        $result = $this->IsActiveInModule($moduleName) and !$this->CanRemoveFromModule($moduleName);

        return $result;
    }

    /**
     * Check if the category can be deleted
     */
    public function CanDelete()
    {
        global $modules;

        foreach ($modules as $module) {
            if ($this->IsActiveInModule($module['name'])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Delete a Category from the Database
     */
    public function Delete()
    {
        $db = XoopsDatabaseFactory::getDatabaseConnection();

        $sql = 'DELETE FROM ' . $db->prefix('metacat_categories') . " WHERE cat_id='" . $this->m_CatId . "'";

        if ($db->query($sql)) {
            return true;
        }

        return false;
    }
}
