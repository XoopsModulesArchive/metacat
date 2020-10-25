<?php

/**
 * $Id: modules.dat.php,v 1.1 2003/10/15 05:36:47 mikhail Exp $
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
$modules['mydownloads'] = [
    // name of the module-directory

'name' => 'mydownloads',
    // name of the GET variable to select a category

'cat_get_var' => 'cid',
    // url (relative to site root) to display a category

'cat_view_url' => '/modules/mydownloads/viewcat.php?cid=%s',
    // descriptive name of the type of items the module has

'item_type' => 'Downloads',
    // database table where the module stores its category information

'cat_table' => 'mydownloads_cat',
    // column in cat_table that holds the category title

'title_field' => 'title',
    // column in cat_table that holds the category ID

'cat_id_field' => 'cid',
    // column in cat_table that holds the parent's ID
    // (leave empty if module has no sub-categories.)

'parent_id_field' => 'pid',
    // column in cat_table that holds the information about the category image/icon
    // (leave empty if module has no category images.)

'image_reference_field' => 'imgurl',
    // type of the image information used.
    // "URL" - image can be anywhere, fully qualified URL given
    // "PATH" - image is in module-specific directory "image_upload_path". Give filename only.

'image_reference_type' => 'URL',
    // if "image_reference_type" is "PATH", this is the absolute path to copy images to

'image_upload_path' => '',
    // table in the database that holds content for this module

'content_table' => 'mydownloads_downloads',
    // column in content_table that holds the category ID

'content_cat_field' => 'cid',
    // column in content_table that holds the content ID

'content_id_field' => 'lid',
    // name of the GET var to select one content item.

'content_get_var' => 'lid',
];
$modules['mylinks'] = [
    'name' => 'mylinks',
'cat_get_var' => 'cid',
'item_type' => 'Links',
'cat_view_url' => '/modules/mylinks/viewcat.php?cid=%s',
'cat_table' => 'mylinks_cat',
'title_field' => 'title',
'cat_id_field' => 'cid',
'parent_id_field' => 'pid',
'image_reference_field' => 'imgurl',
'image_reference_type' => 'URL',
'image_upload_path' => '',
'content_table' => 'mylinks_links',
'content_cat_field' => 'cid',
'content_id_field' => 'lid',
'content_get_var' => 'lid',
];
$modules['newbb'] = [
    'name' => 'newbb',
'cat_get_var' => 'cat',
'item_type' => 'Forums',
'cat_view_url' => '/modules/newbb/index.php?cat=%s',
'cat_table' => 'bb_categories',
'title_field' => 'cat_title',
'cat_id_field' => 'cat_id',
'parent_id_field' => '',
'image_reference_field' => '',
'image_reference_type' => '',
'image_upload_path' => '',
'content_table' => 'bb_forums',
'content_cat_field' => 'cat_id',
'content_id_field' => 'forum_id',
'content_get_var' => 'forum',
];
$modules['sections'] = [
    'name' => 'sections',
'cat_get_var' => 'secid',
'item_type' => 'Articles',
'cat_view_url' => '/modules/sections/index.php?op=listarticles&secid=%s',
'cat_table' => 'sections',
'title_field' => 'secname',
'cat_id_field' => 'secid',
'parent_id_field' => '',
'image_reference_field' => 'image',
'image_reference_type' => 'PATH',
'image_upload_path' => XOOPS_ROOT_PATH . '/modules/sections/images/',
'content_table' => 'seccont',
'content_cat_field' => 'secid',
'content_id_field' => 'artid',
'content_get_var' => 'artid',
];
$modules['news'] = [
    'name' => 'news',
'cat_get_var' => 'storytopic',
'item_type' => 'News',
'cat_view_url' => '/modules/news/index.php?storytopic=%s',
'cat_table' => 'topics',
'title_field' => 'topic_title',
'cat_id_field' => 'topic_id',
'parent_id_field' => 'topic_pid',
'image_reference_field' => 'topic_imgurl',
'image_reference_type' => 'PATH',
'image_upload_path' => XOOPS_ROOT_PATH . '/modules/news/images/topics/',
'content_table' => 'stories',
'content_cat_field' => 'topicid',
'content_id_field' => 'storyid',
'content_get_var' => 'storyid',
];
$modules['xoopsfaq'] = [
    'name' => 'xoopsfaq',
'cat_get_var' => 'cat_id',
'cat_view_url' => '/modules/xoopsfaq/index.php?cat_id=%s',
'item_type' => 'FAQs',
'cat_table' => 'xoopsfaq_categories',
'title_field' => 'category_title',
'cat_id_field' => 'category_id',
'parent_id_field' => '',
'image_reference_field' => '',
'image_reference_type' => '',
'image_upload_path' => '',
'content_table' => 'xoopsfaq_contents',
'content_cat_field' => 'category_id',
'content_id_field' => 'contents_id',
'content_get_var' => 'cat_id',
];
