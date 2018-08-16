<html>

<body>
    <div>
<h1></h1>

<table id='doktoranden-entries' class="tablesorter default">
    <thead>
		<tr>
            <th style='width:10%'>Aktionen</th>
            <th style='width:10%'>Status</th>
            <?php foreach($fields as $field): ?>
                <th><span><?= $field['title'] ?></span></th>   
            <?php endforeach ?>
        <!--<th>Courseware besucht?</th>-->
        </tr>
    </thead>
    <tbody>
    <?php foreach ($entries as $entry): ?>
    <tr>
        <td><a href='<?=$this->controller->url_for('index/edit/' . $entry['id']) ?>' title='Eintrag editieren' data-dialog="size=auto;reload-on-close"><?=Icon::create('edit')?></a><br/></td>
        <td title='Noch <?= $number_required_fields-$entry->completeProgress() ?> fehlende Einträge'><?= round($entry->completeProgress()/$number_required_fields, 2)*100 ?>%</td>
        <?php foreach($fields as $field): ?>
            
            <?php if ($field->value_key) : ?>
                <td><?= $field->getValueTextByKey($entry[$field->id]) ?></td>
            <?php else: ?>
                <td><?= $entry[$field->id] ?></td>
            <?php endif ?>

        <?php endforeach ?>

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



