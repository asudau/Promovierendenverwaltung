
<?
use Studip\Button, Studip\LinkButton;
?>

<html>

<h1>Eintrag bearbeiten</h1>

<form data-dialog="size=auto;reload-on-close" style="width:1000px" name="course-settings" name="settings" method="post" action="<?= $controller->url_for('index/save', $entry->id) ?>" <?= $dialog_attr ?> class="default collapsable">
    <?= CSRFProtection::tokenTag() ?>
    <input id="open_variable" type="hidden" name="open" value="<?= $flash['open'] ?>">
    
    <?php foreach ($groupedFields as $date): ?>
    <fieldset <?= isset($flash['open']) && $flash['open'] != 'bd_basicsettings' ? 'class="collapsed"' : ''?> data-open="bd_basicsettings">
        <legend><?= $date['title'] ?></legend>
        <table>
            <?php foreach ($date['values'] as $field): ?>
            <tr> 
                <td style="width:500px">
                    <?=$fields[$field]['title']?>: 
                </td>
                <td>
                    <?= QuickSearch::get("text", $fach_suche)
                        ->setInputStyle("width: 240px")
                        ->defaultValue($entry[$field], $fields[$field]['title']) 
                          ->render();?>
                    <input type='text' name ='<?=$field?>' value ='<?= $entry[$field]?>'> 
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








