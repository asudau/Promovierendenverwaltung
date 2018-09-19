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
        
        $config['additional_fields']['values']['get'] = function ($item){
            return DoktorandenFieldValue::findBySQL("field_id LIKE ?", array($item->getIdOfValues()) );
        };
        
        $config['additional_fields']['search_object']['get'] = function ($item) {
            if (DoktorandenFieldValue::findOneBySQL("field_id LIKE ?", array($item->getIdOfValues()))){
                if ($item->value_key != NULL){
                    return new SQLSearch("SELECT " . $item->value_key . ", CONCAT(defaulttext, ' (' , uniquename, ')') as title " .
                    "FROM doktorandenverwaltung_field_values WHERE `field_id` LIKE '" . $item->getIdOfValues() . "' " .
                    "AND (`defaulttext` LIKE :input OR `uniquename` LIKE :input)", _($item->title), "field_id");
                }
            } else return NULL;

        };

        parent::configure($config);
    }
    
    public static function getHeaderFields() {
         
        return self::findBySQL('overview_position > 0 ORDER BY overview_position ASC');
    }
    
    public static function getExportHeaderArray(){
        $fields = self::findBySQL("export_name != '0'");
        $array = array();
        foreach($fields as $field){
            $array[] = $field['export_name'];
        }return $array;    
    }
    
    public static function getExportFieldsArray(){
        $fields = self::findBySQL("export_name != '0'");
        $array = array();
        //var_dump($fields[0]['export_name']);die();
        foreach($fields as $field){
            $array[] = $field['id'];
        }return $array;    
    }
    
    public function getValueTextByKey($key = null) {
        if($this->value_key != NULL && $key){
            $value = DoktorandenFieldValue::findOneBySQL("field_id = ? AND " . $this->value_key . " = '" . $key . "'", array($this->getIdOfValues()));
            return $value['defaulttext'];
        } else return false;
    }
    
    public function getValueAstatByKey($key = null){
        if($this->value_key != NULL && $key){
            $value = DoktorandenFieldValue::findOneBySQL("field_id = ? AND " . $this->value_key . " = '" . $key . "'", array($this->getIdOfValues()));
            return $value['astat_bund'];
        } else return false;
    }
    
    public static function getRequiredFields() {
        return self::findBySQL("fill = 'manual_req'" );
    }
    
    public function getIdOfValues(){
      return $this->value_id ? $this->value_id : $this->id;
    }
       
}
