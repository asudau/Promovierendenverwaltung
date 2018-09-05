
<?
use Studip\Button, Studip\LinkButton;
?>

<html>

<h1>Eintrag bearbeiten</h1>

<form name="course-settings" name="settings" method="post" action="<?= $controller->url_for('index/save', $entry->id) ?>" <?= $dialog_attr ?> class="default collapsable">
    <?= CSRFProtection::tokenTag() ?>
    <input id="open_variable" type="hidden" name="open" value="<?= $flash['open'] ?>">
    
    <?php foreach ($groupedFields as $group): ?>
    <fieldset <?= isset($flash['open']) && $flash['open'] != 'bd_basicsettings' ? 'class="collapsed"' : ''?> data-open="bd_basicsettings">
        <legend><?= $group['title'] ?></legend>
        <table>
            <?php foreach ($group['entries'] as $field_entry): ?>
            <? ($entry[$field_entry->id])? $value = $field_entry->getValueTextByKey($entry[$field_entry->id]): $value = NULL; ?>
            
            <tr>
                <td style="width:500px" <? if ($entry->req($field_entry->id)): ?> class='required' <? endif ?> >
                    <?=$field_entry->title?>: 
                </td>
                <td style="width:700px">
                    <?php if(sizeof($field_entry->values) > 1104) : ?>
                    
                    <?= QuickSearch::get($field_entry->id, $field_entry->search_object)
                        ->setInputStyle("width: 240px")
                        //->fireJSFunctionOnSelect('doktoranden_select')
                        ->defaultValue( $entry[$field_entry->id], $value) 
                        ->withButton()
                        ->render();?>
                    
                    <?php elseif (sizeof($field_entry->values) > 1) : ?>
                    <select class='nested-select' name ='<?=$field_entry->id?>'>
                        <option value="">-- ggf. auswählen --</option>
                        <?php foreach ($field_entry->values as $entry_value): ?>
                        <? $key = $field_entry->value_key; ?>
                            <option <? if ($entry[$field_entry->id] == $entry_value->$key) :?> selected <? endif ?> value="<?= $entry_value->$key ?>"><?= $entry_value->defaulttext?></option>
                        <?php endforeach ?>
                    </select>
                    
                    <?php elseif ($field_entry->id == 'geburtstag') : ?>
                    <input type='text' name ='<?=$field_entry->id?>' data-date-picker value ='<?= $entry[$field_entry->id] ? $entry[$field_entry->id] : ''?>'>
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
    
    $(function() {
            $('.mydate-picker').datepicker( {
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'MM yy',
            onClose: function(dateText, inst) { 
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
            });
        });
    

</script>



