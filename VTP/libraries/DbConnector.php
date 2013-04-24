<?php
/*
 *
 * File Name:       DbConnector.php
 * Class:           DbConnector
 * Description:     Class to handle frequent DB queries
 * Author:          Anudeep Potlapally
 * Created:         10/19/2012
 * Last Updated:
 */

if(file_exists('config.php')) {
    include_once 'config.php';
} else if(file_exists('../config.php')) {
    include_once '../config.php';
}
 
class DbConnector {

    var $theQuery;
    var $link;

    /*
     * Function: DbConnector
     * Description: Connects to the database
     */
    function DbConnector($host = DB_HOST, $database = DB_DB, $user = DB_USER, $password = DB_PASSWORD)
    {
        $this->link = mysql_connect($host, $user, $password);
        mysql_select_db($database);
        // disconnect from DB while shutting down PHP
        register_shutdown_function(array(&$this, 'disconnect'));
    }

    /*
     * Function: query
     * @param string $query - SQL Query
     * Description: Execute a database query
     */
    function query($query)
    {
        $this->theQuery = $query;
        return mysql_query($query, $this->link);
    }

    /*
     * Function: getQuery
     * Description: Returns the last database query, for debugging
     */
    function getQuery()
    {
        return $this->theQuery;
    }

    /*
     * Function: getNumRows
     * Description: Return row count, MySQL version
     */
    function getNumRows($result)
    {
        return mysql_num_rows($result);
    }

    /*
     * Function: fetchArray,
     * Description: Get array of query results with column name as key
     */
    function fetchArray($result)
    {
        return mysql_fetch_array($result, MYSQL_ASSOC);
    }

    /*
     * Function: getAllRows,
     * @param string $query - SQL Query
     * Description: Get array of query results with column name as key
     */
    function getAllRows($query)
    {
        $result = $this->query($query);
        if( !is_resource($result))
        {
            //for INSERT, UPDATE, DELETE, etc.
            return $result;
        }

        $rows = array();

        while($value = $this->fetchArray($result))
        {
            $rows[] = $value;
        }
        return $rows;
    }

    /*
     * Function: getYTTags,
     * @param string $videoId - youtube video id
     * Description: Returns all tags linked to the provided youtube video id
     */
    function getYTTags($videoId, $filterIds = '')
    {
        $addlQuery = (empty($filterIds)) ? '':"AND `yttags`.`userId` IN (SELECT `users`.`id` FROM `users` WHERE `users`.`facebookId` IN ($filterIds))";
        $query = "SELECT * FROM `yttags` WHERE `yttags`.`videoId` = '".$videoId."' ".$addlQuery;
        return $this->getAllRows($query);
    }
    
    /*
     * Function: getViemoTags,
     * @param string $videoId - Viemo video id
     * Description: Returns all tags linked to the provided youtube video id
     */
    function getViemoTags($videoId, $filterIds = '')
    {
        $addlQuery = (empty($filterIds)) ? '':"AND `viemoTags`.`userId` IN (SELECT `users`.`id` FROM `users` WHERE `users`.`facebookId` IN ($filterIds))";
        $query = "SELECT * FROM `viemoTags` WHERE `viemoTags`.`videoId` = '".$videoId."' ".$addlQuery;
        return $this->getAllRows($query);
    }

    /*
     * Function: addUser,
     * @param $hostId - User id on hostSite
     * @param string $hostSite - facebookId or googleId
     * Description: Checks for existing users and adds them to DB
     */
    function addUser($name, $hostId, $hostSite, $otherSite, $refreshToken = '', $fbFriendIds = '')
    {
        global $_SESSION;
        // check if user already existed
        $query = "SELECT `users`.`id`, `users`.`".$otherSite."`, `users`.`googleRefreshtkn` FROM `users` WHERE `users`.`".$hostSite."` = '".$hostId."' LIMIT 1";
        $user = $this->getAllRows($query);
        if($user) {
            $_SESSION['vtpUserId'] = $user[0]['id'];
            $_SESSION[$otherSite] = $user[0][$otherSite];
            if( ($hostSite == 'facebookId') && !empty($user[0]['googleRefreshtkn']) ) {
                if(is_file('includes/getOauth2Token.php')){
                    include_once 'includes/getOauth2Token.php';
                    $_SESSION['access_token'] = getAccessToken($user[0]['googleRefreshtkn']);
                }
                
                $friendIds = $this->getFriendIds($fbFriendIds);
                if(!empty($friendIds)) {
                    $query = "UPDATE `users` SET `users`.`friendIds` = '".$friendIds."' WHERE `users`.`id` = '".$user[0]['id']."'";
                    $this->query($query);
                }
            }
            return true;
        } else {
            $friendIds = $this->getFriendIds($fbFriendIds);
        
            $query = "INSERT INTO `users` SET `users`.`name` = '".$name."', `users`.`".$hostSite."` = '".$hostId."', `users`.`googleRefreshtkn` = '".$refreshToken."', `users`.`friendIds` = '".$friendIds."' ";
            if($this->query($query)) {
                return true;
            }else {
                return false;
            }
        }
        return false;
    }

    function getFriendIds($fbFriendIds)
    {
        if(empty($fbFriendIds))
            return '';
        $query = "SELECT `users`.`id` FROM `users` WHERE `users`.`facebookId` IN ($fbFriendIds)";
        $users = $this->getAllRows($query);
        foreach ($users as $user) {
            $friendIds = $user['id'].','.$friendIds;
        }
        $friendIds = substr($friendIds, 0, -1);
        return $friendIds;
    }
    
    function getFbFriendIds($userId)
    {
        $query = "SELECT `users`.`friendIds` FROM `users` WHERE `users`.`id` = '".$userId."' LIMIT 1";
        $userIds = $this->getAllRows($query);
        if(!empty($userIds)) {
            $query = "SELECT `users`.`facebookId` FROM `users` WHERE `users`.`id` IN (".$userIds[0]['friendIds'].") ";
            $users = $this->getAllRows($query);
            $facebookIds = array();
            foreach ($users as $user) {
                array_push($facebookIds, $user['facebookId']);
            }
            return $facebookIds;
        }
        return '';
    }
    
    /*
     * Function: addFBUser,
     * @param $facebookId - userId on Facebook.com
     * Description: Checks for existing users and adds them to DB
     */
    function addFBUser($name, $facebookId, $fbFriendIds)
    {
        return $this->addUser($name, $facebookId, 'facebookId', 'googleId', '', $fbFriendIds);
    }

    /*
     * Function: addGoogleUser,
     * @param $googleId - userId on Google.com
     * @param $refreshtoken - refresh token is given at initial authentication by Google
     * Description: Checks for existing users and adds them to DB
     */
    function addGoogleUser($name, $googleId, $refreshToken)
    {
        return $this->addUser($name, $googleId, 'googleId', 'facebookId', $refreshToken);
    }

    /*
     * Function: addYtTags,
     * Description: adds YouTube tags to the DB
     */
    function addYtTags($userId, $videoId, $tagStartTime, $tagEndTime, $action, $content)
    {
        $query = "INSERT INTO `yttags` SET `yttags`.`userId`= '".$userId."', `yttags`.`videoId`= '".$videoId."', `yttags`.`start`= '".$tagStartTime."', `yttags`.`end`= '".$tagEndTime."', `yttags`.`action`= '".$action."', `yttags`.`content`= '".$content."' ";
        if($this->query($query)) {
            return true;
        }else {
            return false;
        }
    }
    
    /*
     * Function: addVimeoTags,
     * Description: adds Vimeo tags to the DB
     */
    function addVimeoTags($userId, $videoId, $tagStartTime, $tagEndTime, $action, $content)
    {
        $query = "INSERT INTO `vimeoTags` SET `vimeoTags`.`userId`= '".$userId."', `vimeoTags`.`videoId`= '".$videoId."', `vimeoTags`.`start`= '".$tagStartTime."', `vimeoTags`.`end`= '".$tagEndTime."', `vimeoTags`.`action`= '".$action."', `vimeoTags`.`content`= '".$content."' ";
        if($this->query($query)) {
            return true;
        }else {
            return false;
        }
    }

    /*
     * Function: getFavorites,
     * @param int $userId
     * Description: Finds Favorites for a given user
     */
	function getFavorites($userId)
    {
        $query = "SELECT * FROM `favorites` WHERE `favorites`.`userId` = '".$userId."' ";
        return $this->getAllRows($query);
    }

	/*
     * Function: addFavorites,
     * @param int $userId, $videoId
     * Description: Finds Favorites for a given user
     */
	function addFavorites($userId, $videoId)
	{
		$query = "INSERT INTO favorites (userId, videoId) VALUES( \"".$userId."\",\"".$videoId."\")";
		if($this->query($query)) {
			return true;
		}
		else {
			return false;
		}
	}

	/*
     * Function: isFavorites,
     * @param int $userId, $videoId
     * Description: Finds Favorites for a given user
     */
	function isFavorite($userId, $videoId)
	{
		$query = "SELECT * FROM `favorites` WHERE `favorites`.`userId` = '".$userId."' AND `favorites`.`videoId` = '".$videoId."' ";
		if($this->getAllRows($query)) {
			return true;
		}
		else {
			return false;
		}
	}

    /*
     * Function: getFriends,
     * @param int $userId
     * Description: Finds the friends that use the site
     */
    function getFriends($userId)
    {
        $query = "SELECT * FROM `users` WHERE `facebookId` = '".$userId."'";
        if($this->getAllRows($query)) {
            return true;
        }
        else {
            return false;
        }

    }

    /*
     * Function: linkUserAccounts,
     * @param $vtpUserId:   userId in VTP DB
     *        $hostId:      userId of the hosting site (Google or Facebook)
     *        $hostSite:    name of the hosting site (Google or Facebook)
     *        $otherId:      userId of the other site (Facebook or Google)
     *        $otherSite:    name of the other site (Facebook or Google)
     *        $refreshToken:    refresh token provided by Google
     *                          empty if it is facebook authentication
     * Description: links user accounts from different hosts
     */
    function linkUserAccounts($vtpUserId, $hostId, $hostSite, $otherId, $otherSite, $refreshToken = '', $fbFriendIds = '')
    {
        global $_SESSION;
        $query = "SELECT `users`.`id` FROM `users` WHERE `users`.`".$hostSite."` = '".$hostId."' LIMIT 1";
        $user = $this->getAllRows($query);
        if($user) {
            $friendIds = $this->getFriendIds($fbFriendIds);
            
            // user account exists
            $addlQuery = (!empty($refreshToken)) ? ' , `users`.`googleRefreshtkn` = "'.$refreshToken.'"':'';
            $addlQuery = (!empty($friendIds)) ? ' , `users`.`friendIds` = "'.$friendIds.'"':$addlQuery;
            $query = "UPDATE `users` SET `users`.`".$otherSite."` = '".$otherId."' ".$addlQuery." WHERE `users`.`id` = '".$vtpUserId."'";
            
            if($this->query($query))
            {
                $_SESSION[$otherSite] = $otherId;
                return true;
            }
        }
        return false;
    }

    /*
     * Function: linkGoogleAccount,
     * @param $vtpUserId:   userId in VTP DB
     *        $facebookId:    userId in Facebook
     *        $googleId:      userId in Google
     * Description: links Google account to existing Facebook account
     */
    function linkGoogleAccount($vtpUserId, $facebookId, $googleId, $refreshToken)
    {
        return $this->linkUserAccounts($vtpUserId, $facebookId, 'facebookId', $googleId, 'googleId', $refreshToken);
    }

    /*
     * Function: linkFacebookAccount,
     * @param $vtpUserId:   userId in VTP DB
     *        $facebookId:    userId in Facebook
     *        $googleId:      userId in Google
     * Description: links Facebook account to existing Google Account
     */
    function linkFacebookAccount($vtpUserId, $facebookId, $googleId, $fbFriendIds)
    {
        return $this->linkUserAccounts($vtpUserId, $googleId, 'googleId', $facebookId, 'facebookId', '', $fbFriendIds);
    }
	
	
	/*
     * Function: getFriendId,
     * @param $facebookID:    userId in Facebook
     * Description: gets the friends' ids from vtp db
     */
	function getFriendId($facebookID)
    {
        $query = "SELECT `id` FROM `users` WHERE `users`.`facebookid` = '".$facebookID."' ";
        return $this->getAllRows($query);

    }

    function setContainerPos($Posx, $Posy,$container_type, $userId)
    {
        $query = "SELECT `userId` FROM `ContainerPos` WHERE `ContainerPos`.`userId` = '".$userId."' ";
        if($this->getAllRows($query) ) {
            $query = "UPDATE `ContainerPos` SET `".$container_type."_x` = '".$Posx."', `".$container_type."_y` = '".$Posy."' WHERE `ContainerPos`.`userId` = '".$userId."' ";
            $this->query($query);
        }
        else {
            $query = "INSERT INTO `ContainerPos` (`userId`, `".$container_type."_x`, `".$container_type."_y`) VALUES('".$userId."','".$Posx."','".$Posy."')";
            $this->query($query);
        }

    }

    function getContainerPos($userId)
    {
        $query = "SELECT * FROM `ContainerPos` WHERE `ContainerPos`.`userId` = '".$userId."' ";
        return $this->getAllRows($query);
    }

	/*
     * Function: isVideoTagged,
     * @param $videoId:    Video id
     * @param $source:    if 'youtube' then searches in 'yttags' table else searches in 'vimeoTags' table
     * Description: checks and returns bool if the video exists.
     */
    function isVideoTagged( $videoId , $source = 'youtube') {
        $table = ($source == 'youtube') ? 'yttags':'vimeoTags';
        $query = "SELECT * FROM `".$table."` WHERE `".$table."`.`videoId` = '".$videoId."' LIMIT 1";
        if($this->getAllRows($query)) {
            return true;
        } else {
            return false;
        }
    }
    /*
     *
     */
    function getFirstName($userId) {
        $query = "SELECT `users`.`name` FROM `users` WHERE `users`.`id` = '".$userId."' LIMIT 1";
        $user = $this->getAllRows($query);
        if($user) {
            return $user[0]['name'];
        }
        return 'Anonymous';
    }
    
    /*
     * Function: disconnect
     * Description: Closes the DB connection
     */
    function disconnect()
    {
        mysql_close($this->link);
    }
}

?>
