<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AddYearConfig extends Migration
{
    public function description()
    {
        return 'Add config entry for current report year for Doktorandenverwaltung';
    }

    public function up()
    {
        $db = DBManager::get();

        $stmt = $db->prepare('INSERT INTO config (field, value, section, type, `range`, mkdate, chdate, description)
              VALUES (:name, :value, :section, :type, :range, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), :description)');
        $stmt->execute([
            'name'        => 'DOKTORANDEN_REPORT_YEAR',
            'section'     => 'doktorandenverwaltung',
            'description' => 'Current report year',
            'range'       => 'global',
            'type'        => 'string',
            'value'       => date('Y')
        ]);

        SimpleORMap::expireTableScheme();
    }

    public function down()
    {
        $db = DBManager::get();

        $db->exec("DELETE FROM config WHERE namne = 'DOKTORANDEN_REPORT_YEAR' TABLE doktorandenverwaltung_emails");

        SimpleORMap::expireTableScheme();
    }
}
