<?php
/*
 *
 * File Name:       header.php
 * Description:     
 * Author:
 * Created:         09/27/2012
 * Last Modified:   Anudeep 10/25/12
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */

if(!empty($_SESSION['vtpUserId'])) {
    $loginBtn = "<a href='#' data-dropdown='#logoutDropdown'>".$_SESSION['vtpUserName']."</a>";
    if(empty($_SESSION['facebookId'])) {
        $addlBtn = '<li style="padding:10px;height:29px;"><img src="images/link_Facebook_Account.png" onClick="window.location.href = \'index.php?action=login&method=facebook\';" alt="Link Facebook Account" style="cursor:pointer;"/></li>';
    }else if(empty($_SESSION['googleId'])) {
        $addlBtn = '<li style="padding:10px;height:29px;"><img src="images/link_Google_Account.png" onClick="window.location.href = \'index.php?action=login&method=google\';" alt="Link Google Account" style="cursor:pointer;"/></li>';
    }else {
        $addlBtn = '';
    }    
}else{
    $loginBtn = "<a href='#' data-dropdown='#loginDropdown'>Login</a>";
}
?>

<!----   include Dialog Boxes here      --->

<!----   include Dropdown lists here    -->
    <!---       Login Options Dropdown  --->
    <div id="loginDropdown" class="dropdown-menu has-tip">
        <form id="loginOptForm" action="login.php">
            <ul>
                <li style="padding:10px;height:29px;"><img src="images/facebook_login_icon.png" onClick="window.location.href = 'index.php?action=login&method=facebook';" alt="Login with Facebook" style="cursor:pointer;"/></li>
                <li align="center">- OR -</li>
                <li style="padding:10px;height:29px;"><img src="images/google_login_icon.png" onClick="window.location.href = 'index.php?action=login&method=google';" alt="Login with Google" style="cursor:pointer;"/></li>
            </ul>
        </form>
    </div>
    <!---       Profile/Logout Options Dropdown --->
    <div id="logoutDropdown" class="dropdown-menu has-tip">
        <ul>
            <?=$addlBtn;?>
            <li style="padding: 10px;"><span onClick="window.location.href = 'login.php?login=logout';" class="link">Logout</span></li>
        </ul>
    </div>

<!----        Header      ----->

    <div class='header'>

        <table class="headerTable">
            <tr>
                <td>
                    <input id="query" value='' type="text" style="width:400px;"/> 
                    <button id="search-button" onclick="processSearch();">Load/Search</button> 
                </td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td><a href="favorites.php">Favorites</a></td>
				<td><a href="AddVideo.php">Upload</a></td>
                <td><?=$loginBtn;?></td>
            </tr>
        </table>
    </div>
    