<?php
/**
 *
 * File Name:       index.php
 * Description:     Base file for the project.
 * Author:
 * Created:         09/27/2012
 * Last Modified:   Anudeep 10/09/12
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */

include_once( "head_std.php" );
?>
<div id="buttons" align="center">
    <label> 
        <input id="query" value='nba' type="text"/> 
        <button id="search-button" disabled onclick="search()">Search</button>
        <div id="searchAuthDiv" style="display:none;">
            <input type='button' id="login-link" value='Authorize Youtube search'/>
        </div>
    </label>
</div>
<div id="container"></div>

<script src="includes/GoogleAuth.js"></script>
<script src="includes/YTSearch.js"></script>
<script src="https://apis.google.com/js/client.js?onload=googleApiClientReady"></script>
<?php
    include_once( "tail_std.php" );
?>