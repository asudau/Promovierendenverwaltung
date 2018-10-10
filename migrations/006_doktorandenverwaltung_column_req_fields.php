<?php

class DoktorandenverwaltungFieldHelptext extends Migration
{
    public function description()
    {
        return 'Add field for helptext';
    }

    public function up()
    {
        $db = DBManager::get();

        $query = "ALTER TABLE `doktorandenverwaltung_fields` ADD `helptext` VARCHAR( 255 ) NOT NULL AFTER `title`";
        $db->exec($query);
        SimpleORMap::expireTableScheme();
        
        $query = "UPDATE `doktorandenverwaltung_fields` "
                . "SET `helptext` = 'Bei einer Ersteinschreibung im Ausland, soll hier \'Auslandshochschule\' ausgewählt werden' "
                . "WHERE `doktorandenverwaltung_fields`.`id` = 'hochschule_erst'";
        $db->exec($query);
    }

    public function down()
    {
    }
}
