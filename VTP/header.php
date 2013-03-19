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
        $addlBtn = $addlBtn.'<li><hr style="padding-left: 10px;width: 125px;"></li>';
    }else if(empty($_SESSION['googleId'])) {
        $addlBtn = '<li style="padding:10px;height:29px;"><img src="images/link_Google_Account.png" onClick="window.location.href = \'index.php?action=login&method=google\';" alt="Link Google Account" style="cursor:pointer;"/></li>';
        $addlBtn = $addlBtn.'<li><hr style="padding-left: 10px;width: 125px;"></li>';
    }else {
        $addlBtn = '';
    }    
    
    if(empty($_SESSION['facebookId'])) {
        $friendsOpnt = '<a href="#" onClick="alert(\'Please Login to Facebook to see Friends\');">Friends</a>';
    }else{
        $friendsOptn = '<a href="getFriends.php">Friends</a>';
    }
    $favoriteOptn = '<a href="favorites.php">Favorites</a>';
    $uploadOptn = '<a href="AddVideo.php">Upload</a>';
}else{
    $friendsOpnt = '<a href="#" onClick="alert(\'Please Login to Facebook to see Friends\');">Friends</a>';
    $favoriteOptn = '<a href="#" onClick="alert(\'Please Login to see favorites\');">Favorites</a>';
    $uploadOptn = '<a href="#" onClick="alert(\'Please Login to upload videos\');">Upload</a>';
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
            <li style="padding: 10px;" align="center"><span onClick="window.location.href = 'login.php?login=logout';" class="link"><img src="images/logout-icon-16.png" style="padding:0px;">Logout</span></li>
        </ul>
    </div>

<!----        Header      ----->
<div class="headerTable">
    <form class="form" onSubmit="processSearch();">
        <p style="margin:0px;">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" style="width:400px;" id="query" value=''/>
            <input type="submit" id="search-button" value="Load/Search" style="width:100px;"/>
            <?=$friendsOptn;?>
            <?=$favoriteOptn;?>
            <?=$uploadOptn;?>
            <?=$loginBtn;?>
        </p>
    </form>
</div>
    