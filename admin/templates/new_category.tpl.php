<form name="editcategory" method="post" action="<?= XOOPS_URL ?>/modules/metacat/admin/index.php">
    <table width="100%" border="1" cellspacing="5" cellpadding="0">
        <tr>
            <th colspan="2"><?php echo _MC_NEWCAT; ?></th>
        </tr>
        <tr>
            <td width="18%"><?php echo _MC_NEWCATNAME; ?></td>
            <td width="82%"><input name="title" type="text" size="40" value=""></td>
        </tr>
        <tr>
            <td><?php echo _MC_NEWCATDESC; ?></td>
            <td><textarea name="description" cols="40"></textarea></td>
        </tr>
        <!--
         <tr>
              <td>image</td>
              <td><select name="image">
                  <option selected="selected">example1.jpg</option>
                </select></td>
            </tr>
            -->
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="hidden" name="op" value="create_new_cat">
                <input type="submit" name="submit" value="<?= _MC_SUBMIT ?>">
                <input type="reset" name="reset" value="<?= _MC_RESET ?>"></td>
        </tr>
    </table>
</form>
