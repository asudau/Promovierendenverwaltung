<?php
class IndexController extends StudipController {

    public function __construct($dispatcher)
    {
        parent::__construct($dispatcher);
        $this->plugin = $dispatcher->plugin;
        Navigation::activateItem('doktorandenverwaltung/index');
        
        $sidebar = Sidebar::Get();

        $navcreate = new ActionsWidget();
        $navcreate->addLink("Übersicht", 'index' );
        $sidebar->addWidget($navcreate);
        
//        $navcreate = new LinksWidget();
//        $navcreate->setTitle('Aktionen');
//        //$attr = array("onclick"=>"showModalNewSupervisorGroupAction()");
//        //$navcreate->addLink("Ausnahme hinzufügen", $this::url_for('/index'), Icon::create('add'), $attr);
//        // add "add dozent" to infobox
//        $search_obj = new SQLSearch("SELECT auth_user_md5.user_id, CONCAT(auth_user_md5.nachname, ', ', auth_user_md5.vorname, ' (' , auth_user_md5.email, ')' ) as fullname, username, perms "
//                            . "FROM auth_user_md5 "
//                            . "WHERE (CONCAT(auth_user_md5.Vorname, \" \", auth_user_md5.Nachname) LIKE :input "
//                            . "OR CONCAT(auth_user_md5.Nachname, \" \", auth_user_md5.Vorname) LIKE :input "
//                            . "OR auth_user_md5.username LIKE :input)"
//                            //. "AND auth_user_md5.user_id NOT IN "
//                            //. "(SELECT supervisor_group_user.user_id FROM supervisor_group_user WHERE supervisor_group_user.supervisor_group_id = '". $supervisorgroupid ."')  "
//                            . "ORDER BY Vorname, Nachname ",
//                _("Ausnahme hinzufügen"), "username");
//        
//        $mp = MultiPersonSearch::get('unset_user')
//            ->setLinkText(sprintf(_('Ausnahme hinzufügen')))
//            //->setDefaultSelectedUser($filtered_members['dozent']->pluck('user_id'))
//            ->setLinkIconPath("")
//            ->setTitle(sprintf(_('Ausnahme hinzufügen')))
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
        PageLayout::setTitle(_("Doktorandenverwaltung - Übersicht"));

    }

    public function index_action()
    {
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
        $this->fields_metadata = DoktorandenEntry::getFieldsMetadata();
        $this->entries = DoktorandenEntry::findBySQL($query); 
        $this->value_map = DoktorandenEntry::getValueMap();
        
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
         $this->fields = DoktorandenEntry::getFieldsMetadata();
         $this->groupedFields = DoktorandenEntry::getGroupedFields();

    }

    public function save_action($entry_id){

        $entry = DoktorandenEntry::findOneBySQL('id = ' . $entry_id);
        $groupedFields = DoktorandenEntry::getGroupedFields();
        
        if($entry){
            foreach ($groupedFields as $group){
                foreach ($group['entries'] as $field_entry){
                    $field = $field_entry->id;
                    if(Request::get($field)){
                        $entry->$field = Request::get($field);
                    }
                }
            }
            if ($entry->store() !== false) {
                $message = MessageBox::success(_('Die Änderungen wurden übernommen.'));
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
    
    public function unset_action($user_id){

         if ($user_id){
            $status_info = UsermanagementAccountStatus::find($user_id);
            $status_info->delete_mode = 'nie loeschen';
            $status_info->account_status = 0;
            UserConfig::get($user_id)->store("EXPIRATION_DATE", NULL);
            if ($status_info->store() !== false) {
                $message = MessageBox::success(_('Der Nutzer wird auch im Falle längerer Inaktivität nicht gelöscht.'));
                PageLayout::postMessage($message);
            }
        } else {
            $mp = MultiPersonSearch::load('unset_user');
            # User der Gruppe hinzufügen
            foreach ($mp->getAddedUsers() as $user_id) {
                $status_info = UsermanagementAccountStatus::find($user_id);
                if ($status_info){
                    $status_info->delete_mode = 'nie loeschen';
                    $status_info->account_status = 0;
                    UserConfig::get($user_id)->store("EXPIRATION_DATE", NULL);
                    if ($status_info->store() !== false) {
                        $message = MessageBox::success(_('Der Nutzer wird auch im Falle längerer Inaktivität nicht gelöscht.'));
                        PageLayout::postMessage($message);
                    }
                } else {
                    $status_info = new UsermanagementAccountStatus();
                    $status_info->user_id = $user_id;
                    $status_info->account_status = 0;
                    $status_info->delete_mode = 'nie loeschen'; //wenn nichts anderes bekannt ist das der default delete_mode
                    $status_info->chdate = time();
                    if ($status_info->store() !== false) {
                        $message = MessageBox::success(_('Der Nutzer wird auch im Falle längerer Inaktivität nicht gelöscht.'));
                        PageLayout::postMessage($message);
                    }
                }
            }
        }
       
        $this->redirect($this::url_for('/index'));
          
    }
    
     public function set_action($user_id){

        $status_info = UsermanagementAccountStatus::find($user_id);
        $status_info->delete_mode = 'aktivitaet';
        $status_info->account_status = 0;
        if ($status_info->store() !== false) {
            $message = MessageBox::success(_('Der Nutzer wird im Falle von Inaktivitaet gelöscht werden.'));
            PageLayout::postMessage($message);
        }
        $this->redirect($this::url_for('/index'));
          
    }
    
    // customized #url_for for plugins
    public function url_for($to)
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
