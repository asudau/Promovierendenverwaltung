<html>

<body>
    <div>
<h1><?= sizeof($entries) ?> Einträge <?= $inst_id[1] ? Institute::find($inst_id[1])->name : ''?> </h1>

<table id='doktoranden-entries' class="sortable-table default">
    <thead>
		<tr>
            <?php foreach($fields as $field): ?>
                <th data-sort="text"><span><?= $field['title'] ?></span></th>   
            <?php endforeach ?>
            <th data-sort="text" style='width:10%'>Status</th>    
            <th data-sort="false" style='width:10%'>Aktionen</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($entries as $entry): ?>
    <tr>
        <a href='<?=$this->controller->url_for('index/edit/' . $entry['id']) ?>' title='Eintrag editieren' data-dialog="size=big">
        <?php foreach($fields as $field): ?>
            
            <?php if ($field->value_key) : ?>
                <td><?= $field->getValueTextByKey($entry[$field->id]) ?></td>
            <?php else: ?>
                <td><?= htmlReady($entry[$field->id]) ?></td>
            <?php endif ?>

        <?php endforeach ?>
        <td title='Noch <?= $entry->numberRequiredFields()-$entry->completeProgress() ?> fehlende Einträge'><?= round($entry->completeProgress()/$entry->numberRequiredFields(), 2)*100 ?>%</td>
        <td><a href='<?=$this->controller->url_for('index/edit/' . $entry['id']) ?>' title='Eintrag editieren' data-dialog="size=big"><?=Icon::create('edit')?></a>
        <?php if (in_array($GLOBALS['user']->id, $this->admin_ids ) ): ?>
            <a href='<?=$this->controller->url_for('index/delete/' . $entry['id']) ?>' title='Eintrag löschen' ><?=Icon::create('trash')?></a>
        <?php endif ?>    
        <br/></td>
        </a>
    </tr>
    <?php endforeach ?>
    </tbody>
</table>
</div>


</body>


<script type="text/javascript">

    
//$(function(){
//  $('#doktoranden-entries').tablesorter(); 
//});


</script>



