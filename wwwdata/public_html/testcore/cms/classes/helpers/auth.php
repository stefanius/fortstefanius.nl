<?php


// {{{ Auth class

class Auth
{
	public function getAuthByUserId($userid)
	{
		$auth = array();
		$userGroup = Auth::getUserGroup($userid);
                $auth = Auth::getAuthByGroupId($userGroup['group_id']);
                $auth['Group'] = $userGroup;
		return $auth;
	}

	public function getAuthByGroupId($groupid)
	{
		$auth = array();
		$DB = Registry::getInstance()->DB;
                
		$Acls = $DB->select("SELECT * FROM acl ORDER BY controller");
		$AclsGroup = $DB->select("SELECT IFNULL( auth.gid, ".$groupid." ) AS gid , acl.id AS acl_id, auth.id AS auth_id, acl.controller, acl.action, IFNULL( auth.allow, false ) AS allow 
                                        FROM acl
                                        LEFT JOIN auth ON acl.id = auth.acl_id
                                        WHERE auth.gid =".$groupid);
                        	
		foreach ($Acls as $Acl){
			$auth[$Acl->controller][$Acl->action]['allow'] = 0;
                        $auth[$Acl->controller][$Acl->action]['auth_id'] = 0;
                        $auth[$Acl->controller][$Acl->action]['acl_id'] = $Acl->id;
                        $auth[$Acl->controller][$Acl->action]['gid'] = $groupid;
		}
                
		foreach ($AclsGroup as $Acl){
			$auth[$Acl->controller][$Acl->action]['allow'] = $Acl->allow;
                        $auth[$Acl->controller][$Acl->action]['auth_id'] = $Acl->auth_id;
                        $auth[$Acl->controller][$Acl->action]['acl_id'] = $Acl->acl_id;
                        $auth[$Acl->controller][$Acl->action]['gid'] = $Acl->gid;
		}
                
		return $auth;
	}
        
	public function retrieveUsersAndGroup()
	{
            $Users  = UserFactory::getAllAdmin();
            $UsersGroups = array();
		      
            if ($Users === false)
            {
                $Users = array();
            }	
		
		foreach($Users as $User)
		{
			$userGroup = Auth::getUserGroup($User->id);
			$group = Auth::getGroup($userGroup['group_id']);
			$UsersGroups[$User->id]['id']  = $User->id;
			$UsersGroups[$User->id]['firstname']  = $User->firstname;
			$UsersGroups[$User->id]['surname']  = $User->surname;
			$UsersGroups[$User->id]['group']  = $group;
		}
		return $UsersGroups;
	}

	public function retrieveUserAndGroup($user_id)
	{
        $User  = UserFactory::getAdminById($user_id);
		$UserGroups = array();
		   			
		$userGroup = Auth::getUserGroup($User->id);
		$group = Auth::getGroup($userGroup['group_id']);
		$UserGroups['id']  = $User->id;
		$UserGroups['firstname']  = $User->firstname;
		$UserGroups['surname']  = $User->surname;
		$UserGroups['group']  = $group;
		
		return $UserGroups;
	}
	
	public function getGroups()
	{
		$Groups = DBHelper::select(array('tables'=> array("groups"),
						 'cols' => array("*")));
		return $Groups;
	}
	
	public function getUserGroup($userid)
	{
		$row = DBHelper::select(array('tables'	=> array("users_groups"),
                                              'cols' 	=> array("*"),
                                              'where'	=> array("user_id" => $userid)));
		
		if (!count($row)) {
			$userGroup['user_id'] = $userid;
			$userGroup['group_id'] = "none";
                }else{
			$userGroup['user_id'] = $row->current()->user_id;
			$userGroup['group_id'] = $row->current()->gid;		
		}

		return $userGroup;		
	}	

	public function getGroup($groupid)
	{
		$row = DBHelper::select(array(	'tables'	=> array("groups"),
										'cols' 		=> array("*"),
										'where'		=> array("id" => $groupid)));
		if (!count($row)) {
			$group['id'] = $groupid;
			$group['omschrijving'] = "none";	
        }else{
			$group['id'] = $row->current()->id;
			$group['omschrijving'] = $row->current()->omschrijving;	
		}

		return $group;		
	}	
	
	public function getAcls(){
            $Acls = DBHelper::select(array(	'tables'=> array("acl"),
                                                'cols' 	=> array("*")));	
            return $Acls;
	}

	public function saveAuth($gid, $save_rules){
            $DB = Registry::getInstance()->DB;
            foreach($save_rules as $save_rule){
                $result = $DB->alter("SELECT * from auth WHERE gid=".$gid. " AND acl_id=".$save_rule['rule']);
                if($result==0){
                  DBHelper::insert(array('tables' => array("auth"),
                                         'set'    => array("gid" => $save_rule['gid'], 'acl_id' => $save_rule['rule'], 'allow' => $save_rule['allow'])));              
                }else{
                    $result = $DB->alter("UPDATE auth SET allow=". $save_rule['allow']. " WHERE gid=".$gid. " AND acl_id=".$save_rule['rule']);
                }              
            }
	}
 
        public function changeUserGroup($user_id,$gid){
            $DB = Registry::getInstance()->DB;
            $result = $DB->alter("UPDATE users_groups SET gid=".$gid. " WHERE user_id=".$user_id);
            if(!$result){
                $DB->insert("INSERT INTO users_groups SET user_id=".$user_id.", gid=".$gid);
            }
            foreach($save_rules as $save_rule){
                DBHelper::insert(array( 'tables' => array("auth"),
                                        'set'    => array("gid" => $save_rule['gid'], 'acl_id' => $save_rule['rule'], 'allow' => $save_rule['allow'])));
                
            }  
	}

	public function getAllowedByGroup($group_id){
            $Allowed = DBHelper::select(array(	'tables'=> array("auth"),
                                                'cols' 	=> array("*"),
                                                'where' => array("allow" => 1, 'gid' => $group_id)));	
            return $Allowed;
	}        
}
