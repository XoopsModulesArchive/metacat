<?php

/**
 * $Id: metacat_block.php,v 1.1 2003/10/15 05:36:47 mikhail Exp $
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
 * Show a related categories block
 */
function metacat_block_show()
{
    global $xoopsModule;

    $block = [];

    require XOOPS_ROOT_PATH . '/modules/metacat/class/modules.dat.php'; // load module data

    if (is_object($xoopsModule) and array_key_exists($xoopsModule->dirname(), $modules)) {
        $current_module = $xoopsModule->dirname();

        require_once XOOPS_ROOT_PATH . '/modules/metacat/class/metacategory.class.php';

        $categories = &ReadCategoriesFromDatabase();

        $current_category = '';

        if (array_key_exists($modules[$current_module]['cat_get_var'], $_GET)) {
            $current_category = $_GET[$modules[$current_module]['cat_get_var']];
        } elseif (array_key_exists($modules[$current_module]['content_get_var'], $_GET)) {
            $db = XoopsDatabaseFactory::getDatabaseConnection();

            $sql = sprintf(
                "SELECT %s FROM %s WHERE %s='%s'",
                $modules[$current_module]['content_cat_field'],
                $db->prefix($modules[$current_module]['content_table']),
                $modules[$current_module]['content_id_field'],
                $_GET[$modules[$current_module]['content_get_var']]
            );

            $result = $db->query($sql);

            $row = $db->fetchArray($result);

            $current_category = $row[$modules[$current_module]['content_cat_field']];
        }

        if ('' != $current_category) {
            foreach ($categories as $cat) {
                if (@$cat->m_ModuleIds[$current_module] == $current_category) {
                    $block['text'] = sprintf(_MC_IN_CATEGORY, $cat->m_Title);

                    foreach ($modules as $module) {
                        if (!empty($cat->m_ModuleIds[$module['name']])) {
                            $link['link_url'] = sprintf(XOOPS_URL . $module['cat_view_url'], $cat->m_ModuleIds[$module['name']]);

                            $link['link_text'] = $module['item_type'];

                            $block['links'][] = $link;
                        }
                    }
                }
            }

            return $block;
        }
    }
}

/**
 * Reads the Metacat categories Table from the database
 *
 * @return array
 */
function &ReadCategoriesFromDatabase()
{
    $db = XoopsDatabaseFactory::getDatabaseConnection();

    require_once XOOPS_ROOT_PATH . '/class/xoopstree.php';

    $tree = new XoopsTree($db->prefix('metacat_categories'), 'cat_id', 'parent_id');

    $rows = $tree->getChildTreeArray();

    foreach ($rows as $key => $data) {
        $categories[$key] = &MetaCategory::InstanceFromData($data);
    }

    return $categories;
}
