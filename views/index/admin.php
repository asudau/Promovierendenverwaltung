<html>

<body>
    <div>
<h1></h1>

<table id='doktoranden-entries' class="default sortable">
    <thead>
		<tr>
            <th style='width:10%'>Aktionen</th>
            <?php foreach($fields as $field): ?>
                <th <? if ($sortby === $field['name']) printf('class="sort%s"', strtolower($sortFlag)) ?>>
                    <a href="<?= URLHelper::getLink('', array('sortby' => $field['name'], 'sortFlag' => strtolower($sortFlag))) ?>" title="<?= $field['name'] ?>">
                            <?= $field['name'] ?>
                        </a>
                </th>   
            <?php endforeach ?>
                
            <?php foreach($additionalfields as $field => $contents): ?>
                <th  <? if ($sortby === $field) printf('class="sort%s"', strtolower($sortFlag)) ?> >
                    <a href="<?= URLHelper::getLink('', array('sortby' => $field, 'sortFlag' => strtolower($sortFlag))) ?>" title="<?= $field ?>">
                        <?= $field ?>
                    </a>
                </th>   
            <?php endforeach ?>
        <!--<th>Courseware besucht?</th>-->
        </tr>
    </thead>
    <tbody>
    <?php foreach ($entries as $entry): ?>
    <tr>
        <td><a href='<?=$this->controller->url_for('index/edit/' . $entry['id']) ?>' title='Eintrag editieren' data-dialog="size=auto;reload-on-close"><?=Icon::create('edit')?></a><br/></td>
        <?php foreach($fields as $field): ?>
            <? $name = $field['name']; ?>
            <td><?= $entry->$name ?></td>
        <?php endforeach ?>
         <?php foreach($additionalfields as $field => $contents): ?>
            <td><?= $entry->$field ?></td>   
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



