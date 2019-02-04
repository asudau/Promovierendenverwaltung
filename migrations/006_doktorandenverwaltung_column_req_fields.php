<?php

class DoktorandenverwaltungColumnReqFields extends Migration
{
    public function description()
    {
        return 'Add field for required fields';
    }

    public function up()
    {
        $db = DBManager::get();
        $db->exec("ALTER TABLE doktorandenverwaltung ADD COLUMN number_required_fields int(11)");


        SimpleORMap::expireTableScheme();

    }

    public function down()
    {
    }
}
