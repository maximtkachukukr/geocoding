<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
 
<?php echo form_tag_for($form, '@user') ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" value="Get access token" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form ?>
    </tbody>
  </table>
</form>