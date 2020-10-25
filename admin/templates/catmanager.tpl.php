<table width="100%" border="1" cellspacing="5" cellpadding="0">
    <tr>
        <th colspan="8"><?= _MC_LBL_MANAGE_CATEGORIES ?></th>
    </tr>
    <tr>
        <th><?= _MC_LBL_CATEGORY_TITLE ?></th>
        <?php foreach ($modules as $name => $moduledata) { ?>

            <th colspan="2" width=0 align="center"><?= ucwords($name) ?></th>
        <?php } ?>

        <th><?= _MC_LBL_ACTION ?></th>
    </tr>
    <?php foreach ($categories as $catid => $cat) { ?>

        <tr>
            <td><?= str_replace('.', '|&nbsp;', mb_substr($cat->m_Nesting, 1)) ?><?= $cat->m_Title ?><!-- <?= $cat['cat_id'] ?>(<?= $cat['parent_id'] ?>)--></td>
            <?php foreach ($modules as $name => $moduledata) { ?>
                <td align="right">
                    <?php if ($cat->IsActiveInModule($name)) { ?>
                        <img src="images/active.gif">
                    <?php } else { ?>&nbsp;<?php } ?>
                </td>
                <td align="left">
                    <?php if ($cat->CanRemoveFromModule($name)) { ?>
                        <a href="<?= $_SERVER['PHP_SELF'] . '?metacat_title=' . $cat->m_Title . '&metacat_id=' . $cat->m_CatId . '&module_name=' . $name . '&op=remove_from_module' ?>">
                            <img src="images/trash.png" alt="<?= _MC_REMOVE_CAT_FROM_MODULE ?>">
                        </a>
                    <?php } elseif ($cat->CanAddToModule($name)) { ?>
                        <a href="<?= $_SERVER['PHP_SELF'] . '?metacat_title=' . $cat->m_Title . '&metacat_id=' . $cat->m_CatId . '&module_name=' . $name . '&op=add_to_module' ?>">
                            <img src="images/add.gif" alt="<?= _MC_ADD_CAT_TO_MODULE ?>">
                        </a>
                    <?php } elseif ($cat->CannotRemoveFromModule($name)) { ?>
                        <img src="images/trash-x.png">
                    <?php } else { ?>&nbsp;<?php } ?>
                </td>
            <?php } ?>
            <td nowrap="nowrap"><a href="<?= $_SERVER['PHP_SELF'] ?>?op=detail&metacat_id=<?= $cat->m_CatId ?>"><?= _MC_EDIT ?></a>
                <?php if ($cat->CanDelete()) { ?> / <a href="<?= $_SERVER['PHP_SELF'] ?>?metacat_title=<?= $cat->m_Title ?>&op=delete_cat&metacat_id=<?= $cat->m_CatId ?>"><?= _MC_DELETE ?></a><?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>
