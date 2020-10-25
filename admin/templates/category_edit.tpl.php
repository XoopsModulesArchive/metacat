<form name="editcategory" method="post" action="<?= XOOPS_URL ?>/modules/metacat/admin/index.php">
    <table width="100%" border="1" cellspacing="5" cellpadding="0">
        <tr>
            <th colspan="2"><?= _MC_LABEL_GENERALINFO ?></th>
        </tr>
        <tr>
            <td width="18%"><?= _MC_LABEL_CATTITLE ?></td>
            <td width="82%"><input name="title" type="text" size="40" value="<?= $cat->m_Title ?>"></td>
        </tr>
        <tr>
            <td><?= _MC_LABEL_CATDESCRIPTION ?></td>
            <td><textarea name="description" cols="40"><?= $cat->m_Description ?></textarea></td>
        </tr>
        <!-- <tr>
           <td>image</td>
           <td><select name="image">
               <option selected="selected">example1.jpg</option>
             </select></td>
         </tr>-->
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="hidden" name="metacat_id" value="<?= $cat->m_CatId ?>">
                <input type="hidden" name="op" value="do_edit_info">
                <input type="submit" name="submit" value="<?= _MC_SUBMIT ?>">
                <input type="reset" name="reset" value="<?= _MC_RESET ?>"></td>
        </tr>
</form>
<tr>
    <td colspan="2"><small>&nbsp;</small></td>
</tr>
<tr>
    <th colspan="2"><?= _MC_LBL_PARENTCATEGORY ?></th>
</tr>
<form name="change_parent" method="post">
    <tr>
        <td><?= _MC_LBL_PARENTCATEGORY ?></td>
        <td><?php $mytree->makeMySelBox('title', '', $cat->m_ParentId, true, 'parent_cat'); ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <input type="hidden" name="metacat_id" value="<?= $cat->m_CatId ?>">
            <input type="hidden" name="op" value="do_edit_parent">
            <input type="submit" name="submit" value="<?= _MC_SUBMIT ?>">
            <input type="reset" name="reset" value="<?= _MC_RESET ?>"></td>
    </tr>
</form>
<tr>
    <td colspan="2"><small>&nbsp;</small></td>
</tr>
<tr>
    <th colspan="2"><?= _MC_LBL_CATEGORYIMAGE ?></th>
</tr>
<tr>
    <td><?= _MC_LBL_CURRENTIMAGE ?></td>
    <td><img vspace="10" hspace="10" src="<?= XOOPS_URL ?>/uploads/<?= $cat->m_ImageFileName ?>" border=0></td>
</tr>
<form name="delete_image" method="post">
    <tr>
        <td>&nbsp;</td>
        <td>
            <input type="hidden" name="op" value="do_reset_image">
            <input type="hidden" name="metacat_id" value="<?= $cat->m_CatId ?>">
            <input type="submit" value="<?= _MC_LBL_RESETIMAGE ?>"></td>
    </tr>
</form>
<form enctype="multipart/form-data" name="upload_image" method="post">
    <tr>
        <td><?= _MC_LBL_NEWIMAGEFILE ?></td>
        <td><input name="cat_image" type="file"></td>
    </tr>
    <tr>
        <td>&nbsp;<input type="hidden" name="op" value="do_upload_image"> <input type="hidden" name="metacat_id" value="<?= $cat->m_CatId ?>">
        </td>
        <td><input type="submit" value="<?= _MC_SUBMIT ?>"></td>
    </tr>
</form>
</table>
