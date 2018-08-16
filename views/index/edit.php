
<?
use Studip\Button, Studip\LinkButton;
?>

<html>

<h1>Eintrag bearbeiten</h1>

<form data-dialog="size=auto;reload-on-close" style="width:1000px" name="course-settings" name="settings" method="post" action="<?= $controller->url_for('index/save', $entry->id) ?>" <?= $dialog_attr ?> class="default collapsable">
    <?= CSRFProtection::tokenTag() ?>
    <input id="open_variable" type="hidden" name="open" value="<?= $flash['open'] ?>">
    
    <?php foreach ($groupedFields as $group): ?>
    <fieldset <?= isset($flash['open']) && $flash['open'] != 'bd_basicsettings' ? 'class="collapsed"' : ''?> data-open="bd_basicsettings">
        <legend><?= $group['title'] ?></legend>
        <table>
            <?php foreach ($group['entries'] as $field_entry): ?>
            <tr> 
                <td style="width:500px" <? if ($entry->req($field_entry->id)): ?> class='required' <? endif ?> >
                    <?=$field_entry->title?>: 
                </td>
                <td>
                    <?php if($field_entry->search_object != NULL) : ?>
                    <? ($entry[$field_entry->id])? $value = $field_entry->getValueTextByKey($entry[$field_entry->id]): $value = NULL; ?>
                    
                    <?= QuickSearch::get($field_entry->id, $field_entry->search_object)
                        ->setInputStyle("width: 240px")
                        //->fireJSFunctionOnSelect('doktoranden_select')
                        ->defaultValue( $entry[$field_entry->id], $value) 
                        ->withButton()
                        ->render();?>
                    <?php else : ?>
                    <input type='text' name ='<?=$field_entry->id?>' value ='<?= $entry[$field_entry->id]?>'> 
                    <?php endif ?>
                </td>
            </tr>
            <?php endforeach ?>
        </table>

       
    </fieldset>
     <?php endforeach ?>

    
    <footer data-dialog-button>
        <?= Button::create(_('Übernehmen')) ?>
    </footer>
</form>


<script>

    jQuery('.quicksearch_frame').autocomplete({ minLength: 1 });
    function doktoranden_select(){
        //alert($('#abschluss_1').val());
        //$('.abschluss').val($('#abschluss_1').val);
    }
    

</script>



