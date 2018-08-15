<?php



/**
 * @author  <asudau@uos.de>
 *
 * @property int        $chdate
 */

class DoktorandenFields extends \SimpleORMap
{
   
    protected static function configure($config = array())
    {
        $config['db_table'] = 'doktorandenverwaltung_fields';
        
        $config['has_many']['values'] = array(
            'class_name' => 'DoktorandenFieldValue',
            'assoc_foreign_key' => 'field_id',
        );
        
        
        $config['additional_fields']['search_object']['get'] = function ($item) {

            if (DoktorandenFieldValue::findOneBySQL("field_id LIKE ?", array($item->id))){
                if ($item->value_key != NULL){
                    return new SQLSearch("SELECT " .$item->value_key. ", CONCAT(defaulttext, ' (' , uniquename, ')') as title " .
                    "FROM doktorandenverwaltung_field_values WHERE `field_id` LIKE '" . $item->id . "' " .
                    "AND (`defaulttext` LIKE :input OR `uniquename` LIKE :input)", _($item->title), "field_id");
                }
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
    
    public function getValueTextByKey($key) {
        if($this->value_key != NULL){
            $value = DoktorandenFieldValue::findOneBySQL('field_id = ? AND ' . $this->value_key . ' = ' . $key, array($this->id));
            return $value['defaulttext'];
        } else return false;
    }
    
    public function getValueAstatByKey($key){
        if($this->value_key != NULL){
            $value = DoktorandenFieldValue::findOneBySQL('field_id = ? AND ' . $this->value_key . ' = ' . $key, array($this->id));
            return $value['astat_bund'];
        } else return false;
    }
}
