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

class DbConnector {

    var $theQuery;
    var $link;

    /*
     * Function: DbConnector
     * Description: Connects to the database
     */
    function DbConnector($host = 'localhost', $database = 'vtphoste_vtp', $user = 'vtphoste_root', $password = 'VTPvtp123123')
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
    function getYTTags($videoId)
    {
        $query = "SELECT * FROM `yttags` WHERE `yttags`.`videoId` = '".$videoId."' ";
        return $this->getAllRows($query);
    }

    /*
     * Function: addUser,
     * @param $userId - userId on hostSite
     * @param string $hostSite - Faceboor or Google
     * Description: Checks for existing users and adds them to DB
     */
    function addUser($userId, $hostSite, $otherSite)
    {
        global $_SESSION;
        // check if user already existed
        $query = "SELECT `users`.`id`, `users`.`".$otherSite."` FROM `users` WHERE `users`.`".$hostSite."` = '".$userId."' LIMIT 1";
        $user = $this->getAllRows($query);
        if($user) {
            $_SESSION['vtpUserId'] = $user[0]['id'];
            $_SESSION[$otherSite] = $user[0][$otherSite];
            return true;
        } else {
            $query = "INSERT INTO `users` SET `users`.`".$hostSite."` = '".$userId."'";
            if($this->query($query)) {
                return true;
            }else {
                return false;
            }
        }
        return false;
    }

    /*
     * Function: addFBUser,
     * @param $facebookId - userId on Facebook.com
     * Description: Checks for existing users and adds them to DB
     */
    function addFBUser($facebookId)
    {
        return $this->addUser($facebookId, 'facebookId', 'googleId');
    }

    /*
     * Function: addGoogleUser,
     * @param $googleId - userId on Google.com
     * Description: Checks for existing users and adds them to DB
     */
    function addGoogleUser($googleId)
    {
        return $this->addUser($googleId, 'googleId', 'facebookId');
    }

    /*
     * Function: addYtTags,
     * Description: adds YouTube tags to the DB
     */
    function addYtTags($videoId, $userId, $tagStartTime, $tagEndTime, $action, $content)
    {
        $query = "INSERT INTO `yttags` SET `yttags`.`videoId`= '".$videoId."',`yttags`.`userId`='".$userId."', `yttags`.`start`= '".$tagStartTime."', `yttags`.`end`= '".$tagEndTime."', `yttags`.`action`= '".$action."', `yttags`.`content`= '".$content."' ";
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
     * Description: Finds the freinds that use the site
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
     * Description: links user accounts from different hosts
     */
    function linkUserAccounts($vtpUserId, $hostId, $hostSite, $otherId, $otherSite)
    {
        global $_SESSION;
        $query = "SELECT `users`.`id` FROM `users` WHERE `users`.`id` = '".$vtpUserId."' AND `users`.`".$hostSite."` = '".$hostId."' LIMIT 1";
        $user = $this->getAllRows($query);
        if($user) {
            // user account exists
            $query = "UPDATE `users` SET `users`.`".$otherSite."` = '".$otherId."' WHERE `users`.`id` = '".$vtpUserId."' ";
            if($this->query($query))
            {   
                $_SESSION[$otherSite] = $otherId;
                return true;
            }
        } else {
            // user account does not exists
            return false;
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
    function linkGoogleAccount($vtpUserId, $facebookId, $googleId)
    {
        return $this->linkUserAccounts($vtpUserId, $facebookId, 'facebookId', $googleId, 'googleId');
    }

    /*
     * Function: linkFacebookAccount,
     * @param $vtpUserId:   userId in VTP DB
     *        $facebookId:    userId in Facebook
     *        $googleId:      userId in Google
     * Description: links Facebook account to existing Google Account
     */
    function linkFacebookAccount($vtpUserId, $facebookId, $googleId)
    {
        return $this->linkUserAccounts($vtpUserId, $googleId, 'googleId', $facebookId, 'facebookId');
    }

    /*
     * Function: disconnect
     * Description: Closes the DB connection
     */
    function getFriendId($facebookID)
    {
        $query = "SELECT `id` FROM `users` WHERE `users`.`facebookid` = '".$facebookID."' ";
        return $this->getAllRows($query);

    }

    function disconnect()
    {
        mysql_close($this->link);
    }
}

?>
