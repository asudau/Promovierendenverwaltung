<html>

<body>
    <div>
<h1><?= sizeof($entries) ?> Einträge</h1>

<table id='doktoranden-entries' class="tablesorter default">
    <thead>
		<tr>
            <?php foreach($fields as $field): ?>
                <th><span><?= $field['title'] ?></span></th>   
            <?php endforeach ?>
            <th style='width:10%'>Status</th>    
            <th style='width:10%'>Aktionen</th>
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
                <td><?= $entry[$field->id] ?></td>
            <?php endif ?>

        <?php endforeach ?>
        <td title='Noch <?= $number_required_fields-$entry->completeProgress() ?> fehlende Eintr�ge'><?= round($entry->completeProgress()/$number_required_fields, 2)*100 ?>%</td>
        <td><a href='<?=$this->controller->url_for('index/edit/' . $entry['id']) ?>' title='Eintrag editieren' data-dialog="size=big"><?=Icon::create('edit')?></a><br/></td>
        </a>
    </tr>
    <?php endforeach ?>
    </tbody>
</table>
</div>


</body>


<script type="text/javascript">

    
$(function(){
  $('#doktoranden-entries').tablesorter(); 
});


</script>



