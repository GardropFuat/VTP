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
    function DbConnector($host = 'localhost', $database = 'videoTagPortal', $user = 'root', $password = '')
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
     * Function: disconnect
     * Description: Closes the DB connection
     */
    function disconnect()
    {
        mysql_close($this->link);
    }
}

?>
