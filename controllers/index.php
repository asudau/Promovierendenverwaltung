<?php
class IndexController extends StudipController {

    public function __construct($dispatcher)
    {
        parent::__construct($dispatcher);
        $this->plugin = $dispatcher->plugin;
        
        $sidebar = Sidebar::Get();

        $navcreate = new ActionsWidget();
        $navcreate->addLink("�bersicht", 'index' );
        $navcreate->addLink(_('Neuer Eintrag'),
                              $this->url_for('index/new'),
                              Icon::create('seminar+add', 'clickable'))->asDialog('size=50%');
        $navcreate->addLink(_('Exportieren'),
                              $this->url_for('index/export'),
                              Icon::create('seminar+add', 'clickable'));
        $sidebar->addWidget($navcreate);
        
//        $navcreate = new LinksWidget();
//        $navcreate->setTitle('Aktionen');
//        //$attr = array("onclick"=>"showModalNewSupervisorGroupAction()");
//        //$navcreate->addLink("Ausnahme hinzuf�gen", $this::url_for('/index'), Icon::create('add'), $attr);
//        // add "add dozent" to infobox
//        $search_obj = new SQLSearch("SELECT auth_user_md5.user_id, CONCAT(auth_user_md5.nachname, ', ', auth_user_md5.vorname, ' (' , auth_user_md5.email, ')' ) as fullname, username, perms "
//                            . "FROM auth_user_md5 "
//                            . "WHERE (CONCAT(auth_user_md5.Vorname, \" \", auth_user_md5.Nachname) LIKE :input "
//                            . "OR CONCAT(auth_user_md5.Nachname, \" \", auth_user_md5.Vorname) LIKE :input "
//                            . "OR auth_user_md5.username LIKE :input)"
//                            //. "AND auth_user_md5.user_id NOT IN "
//                            //. "(SELECT supervisor_group_user.user_id FROM supervisor_group_user WHERE supervisor_group_user.supervisor_group_id = '". $supervisorgroupid ."')  "
//                            . "ORDER BY Vorname, Nachname ",
//                _("Ausnahme hinzuf�gen"), "username");
//        
//        $mp = MultiPersonSearch::get('unset_user')
//            ->setLinkText(sprintf(_('Ausnahme hinzuf�gen')))
//            //->setDefaultSelectedUser($filtered_members['dozent']->pluck('user_id'))
//            ->setLinkIconPath("")
//            ->setTitle(sprintf(_('Ausnahme hinzuf�gen')))
//            ->setExecuteURL($this::url_for('/index/unset'))
//            ->setSearchObject($search_obj)
//            //->addQuickfilter(sprintf(_('%s der Einrichtung'), $this->status_groups['dozent']), $membersOfInstitute)
//            //->setNavigationItem('/')
//            ->render();
//        $element = LinkElement::fromHTML($mp, Icon::create('community+add', 'clickable'));
//        $navcreate->addElement($element);
//        
//        $sidebar = Sidebar::Get();
//        $sidebar->addWidget($navcreate);
    }

    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        PageLayout::setTitle(_("Doktorandenverwaltung - �bersicht"));

    }

    public function index_action()
    {
        Navigation::activateItem('doktorandenverwaltung/index');
        
        if($_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'] != '0' && isset($_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'])){
            //$search_query['abschlussjahr'] = ' `ef014u2` = ' . $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'];
        }
        if(Request::option('abschlussjahrSelector')){
            $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'] = Request::option('abschlussjahrSelector');
            $search_query['abschlussjahr'] = ' `ef014u2` = ' . Request::option('abschlussjahrSelector');
        } else $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'] = 0;
        
        $query = '';
        foreach($search_query as $query_part) {
            $query .= $query_part;
        }
        if ($query == '') $query = 'true';
        
        $this->fields = DoktorandenFields::getHeaderFields();
        $this->entries = DoktorandenEntry::findBySQL($query); 
        $this->number_required_fields = sizeof(DoktorandenFields::getRequiredFields());
        
        $sidebar = Sidebar::get();
        
        
        $this->abschlussjahre = array('2016', '2017');
        $widget = new SelectWidget('Ende der Promotion (Jahr)', PluginEngine::GetURL('doktorandenverwaltung/index'), 'abschlussjahrSelector');
        $option = new SelectElement('0', _('Alle Abschlussjahre anzeigen'));
        if (('' ==  $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr']) || ('0' ==  $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'])) {
            $option->setActive();
        }
        $widget->addElement($option);
        foreach ($this->abschlussjahre as $aj) {
            $option = new SelectElement($aj, $aj);
            if ($aj == $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr']) {
                $option->setActive();
            }
            $widget->addElement($option);
        }
        $sidebar->insertWidget($widget, 'pdb_actions');
        
                
    }
    
    public function admin_action()
    {
        Navigation::activateItem('doktorandenverwaltung/index_admin');
        if($_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'] != '0' && isset($_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'])){
            //$search_query['abschlussjahr'] = ' `ef014u2` = ' . $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'];
        }
        if(Request::option('abschlussjahrSelector')){
            $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'] = Request::option('abschlussjahrSelector');
            $search_query['abschlussjahr'] = ' `ef014u2` = ' . Request::option('abschlussjahrSelector');
        } else $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'] = 0;
        
        $query = '';
        foreach($search_query as $query_part) {
            $query .= $query_part;
        }
        if ($query == '') $query = 'true';
        
        $field = DoktorandenEntry::findOneBySQL('true');
        $this->fields = $field->getFields();
        $this->additionalfields = $field->getAdditionalFields();
        $this->entries = DoktorandenEntry::findBySQL($query); 
        
        $sidebar = Sidebar::get();
        
        
        $this->abschlussjahre = array('2016', '2017');
        $widget = new SelectWidget('Ende der Promotion (Jahr)', PluginEngine::GetURL('doktorandenverwaltung/index'), 'abschlussjahrSelector');
        $option = new SelectElement('0', _('Alle Abschlussjahre anzeigen'));
        if (('' ==  $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr']) || ('0' ==  $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'])) {
            $option->setActive();
        }
        $widget->addElement($option);
        foreach ($this->abschlussjahre as $aj) {
            $option = new SelectElement($aj, $aj);
            if ($aj == $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr']) {
                $option->setActive();
            }
            $widget->addElement($option);
        }
        $sidebar->insertWidget($widget, 'pdb_actions');
        
                
    }
    
     public function edit_action($entry_id)
    {
        $this->entry = DoktorandenEntry::findOneBySQL('id = ' . $entry_id);
        $this->groupedFields = DoktorandenEntry::getGroupedFields();

    }

    public function new_action()
    {
        $this->entry = new DoktorandenEntry();
        //$this->entry->store();
        //$this->new = true;
        
        $this->groupedFields = DoktorandenEntry::getGroupedFields();
        $this->render_action('edit');
    }

    public function save_action($entry_id){

        if ($entry_id){
            $entry = DoktorandenEntry::findOneBySQL('id = ' . $entry_id);
        } else $entry = new DoktorandenEntry();
        $groupedFields = DoktorandenEntry::getGroupedFields();
        
        if($entry){
            foreach ($groupedFields as $group){
                foreach ($group['entries'] as $field_entry){
                    $field = $field_entry->id;
                    if(Request::get($field)){
                        $entry->$field = studip_utf8decode(Request::get($field));
                    }
                }
            }
            
            //anzahl required fields aktualisieren
            $filled = 0;
            $req_fields = DoktorandenFields::getRequiredFields();
            foreach($req_fields as $field){
                $field_id = $field->id;
                if ($entry->$field_id){
                    $filled ++;
                } 
            }
            $entry->complete_progress = $filled;
            
            if ($entry->store() !== false) {
                $message = MessageBox::success(_('Die �nderungen wurden �bernommen.'));
                PageLayout::postMessage($message);
            }
        } else {
            $message = MessageBox::success(_('Kein Eintrag mit dieser ID vorhanden'));
            PageLayout::postMessage($message);
        }
        
       
        $this->response->add_header('X-Dialog-Close', '1');
        $this->render_nothing();
        //$this->redirect($this::url_for('/index'));
          
    }
    
    public function export_action()
    {
        
        $doktoranden_entries = DoktorandenEntry::findBySQL('true');
        
        if (!empty($doktoranden_entries)) {
            $xls = new ExcelExport();

            $xls->addRow(DoktorandenFields::getExportHeaderArray());

            foreach ($doktoranden_entries as $entry) {
                $xls->addRow(self::handleSingleRow($entry));
            }
            $xls->download('Export_'
                    . date("d-m-y") . '.xls');
        }
        $this->render_nothing();
    }
    
     static function handleSingleRow($entry)
    {
        $rowData = array();
        $fields = DoktorandenFields::getExportHeaderArray();
        foreach($fields as $field){
            $rowData[] = $entry->$field;
        }

        return $rowData;
    }

    
    // customized #url_for for plugins
    public function url_for($to = '')
    {
        $args = func_get_args();

        # find params
        $params = array();
        if (is_array(end($args))) {
            $params = array_pop($args);
        }

        # urlencode all but the first argument
        $args = array_map('urlencode', $args);
        $args[0] = $to;

        return PluginEngine::getURL($this->dispatcher->plugin, $params, join('/', $args));
    }
    
    
    
}
