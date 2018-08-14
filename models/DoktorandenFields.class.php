<?php

/**
 * @author  <asudau@uos.de>
 *
 * @property int        $chdate
 */

class DoktorandenFields extends \SimpleORMap
{
    private static $values = array('ef011' => array(
        '148' => 'Sozialwissenschaften', 
        '8' => 'Anglistik / Englisch',
        '48' => 'Elektrotechnik',
        '691' => 'Kosmetologie', 
        '67' => 'Germanistik / Deutsch' ,
        '132' => 'Psychologie',
        '86' => 'Katholische Theologie',
        '26' => 'Biologie',
        '150' => 'Spanisch',
        '113' => 'Musikerziehung',
        '59' => 'Französisch',
        '68' => 'Geschichte',
        '50' => 'Geographie / Erdkunde',
        '48' => 'Elektrotechnik',
        '245' => 'Sachunterricht',
        '188' => 'Literaturwissenschaft',
        '127' => 'Philosophie',
        '693' => 'Gesundheitswissenschaften',
        '234' => 'Pflegewissenschaften',
        '135' => 'Rechtswissenschaften',
        '53' => 'Evangelische Theologie',
        '140' => 'Umweltsysteme und Ressourcenmanagement',
        '83' => 'Islamische Theologie',
        '137' => 'Romanistik / 2 Sprachen',
        '79' => 'Informatik',
        '184' => 'Accounting & Economics',
        '32' => 'Chemie',
        '729' => 'Cognitive Science',
        '767' => 'Advanced Materials /Biologie',
        '105' => 'Mathematik',
        '128' => 'Physik',
        '91' => 'Kunst/Kunstpädagogik',
        '92' =>  'Kunstgeschichte',
        '114' => 'Bachelor-2-Fächer Musikwissenschaft',
        '116' => 'Textiles Gestalten',
        '129' => 'Politikwissenschaft /Politologie',
        '149' => 'Soziologie',
        '171' => 'Geoinformatik',
        '175' => 'Diplom(U)Volkswirtschaft',
        '21' => 'Kein AbschComputerlinguistik',
        '30' => 'Internationale Migration und Interkulturelle Beziehungen',
        '52' => 'Erziehungswissenschaft /Pädagogik',
        '809' => 'Politik:Demokratisches Regieren u. Zivilgesellschaft',
        '95' => 'Latein',
        '98' => 'Sport / Sportwissenschaft',
       
        ),
        
        'ef005' => array(
            '1' => 'männlich', '2' => 'weiblich'
        ),
        
        'ef008' => array(
             '000' => 'Deutschland',
        ),
        
        'ef010' => array(
             '01' => 'Promotion an Hochschulen mit Promotionsrecht (einschl. Kooperation mit anderer Universität in Deutschland)',
        ),
        
        'ef012' => array(
             '1' => 'Erstregistrierung', '2' => 'Neuregistrierung'
        )
    );
    
    protected static function configure($config = array())
    {
        $config['db_table'] = 'doktorandenverwaltung_fields';
        
        $config['additional_fields']['search_object']['get'] = function ($item) {

            if (FieldValue::findOneBySQL("field_id LIKE ?", array($item->id))){
                    return new SQLSearch("SELECT his_id, CONCAT(defaulttext, ' (' , uniquename, ')') as title " .
                    "FROM doktorandenverwaltung_field_values WHERE `field_id` LIKE '" . $item->id . "' " .
                    "AND (`defaulttext` LIKE :input OR `uniquename` LIKE :input)", _($item->title), "his_id");
            } else return NULL;

        };

        parent::configure($config);
    }
    
    public static function getHeaderFields() {
         
        return self::findBySQL('overview_position > 0 ORDER BY overview_position ASC');
    }
    
    public static function getGroupedFields() {
         
        return DoktorandenEntry::$groupedFields;
    }
    
    public static function getValueMap() {
         
        return DoktorandenEntry::$values;
    }
}
