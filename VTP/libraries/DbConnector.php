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
     * @param int $userId - userId on hostSite
     * @param string $hostSite - Faceboor or Google
     * Description: Checks for existing users and adds them to DB
     */
    function addUser($userId, $hostSite)
    {
        $query = "SELECT `users`.`userId` FROM `users` WHERE `users`.`userId` = '".$userId."' AND `users`.`hostSite` = '".$hostSite."' LIMIT 1";
        $result = $this->query($query);
        if(!$this->getNumRows($result)) {
            $query = "INSERT INTO `users` SET `users`.`userId` = '".$userId."', `users`.`hostSite` = '".$hostSite."'";
            if($this->query($query)) {
                return true;
            }else {
                return false;
            }
        }
        return true;
    }
    
    /*
     * Function: addFBUser,
     * @param int $userId - userId on Facebook.com
     * Description: Checks for existing users and adds them to DB
     */
    function addFBUser($userId)
    {
        return $this->addUser($userId, 'Facebook');
    }
    
    /*
     * Function: addGoogleUser,
     * @param int $userId - userId on Google.com
     * Description: Checks for existing users and adds them to DB
     */
    function addGoogleUser($userId)
    {
        return $this->addUser($userId, 'Google');
    }
	
    /*
     * Function: addYtTags,
     */
    function addYtTags($videoId, $tagStartTime, $tagEndTime, $action, $content)
    {
        $query = "INSERT INTO `yttags` SET `yttags`.`videoId`= '".$videoId."', `yttags`.`start`= '".$tagStartTime."', `yttags`.`end`= '".$tagEndTime."', `yttags`.`action`= '".$action."', `yttags`.`content`= '".$content."' ";
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
     * Function: disconnect
     * Description: Closes the DB connection
     */
    function disconnect()
    {
        mysql_close($this->link);
    }
}

?>
