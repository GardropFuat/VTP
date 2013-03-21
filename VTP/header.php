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
    $loginBtn = "<input type='button' data-dropdown='#logoutDropdown' value='".$_SESSION['vtpUserName']."' style='width:100px;'/>";
    $friendsOptn = '<li style="padding: 10px;font-size: 15px;font-weight: bold;" onclick="window.location.href = \'getFriends.php\';"><img src="images/friends.png" style="padding-bottom: 0px;width: 16px;"><span class="link"> Friends</span></li>';
    $uploadOptn = '<li style="padding: 10px;font-size: 15px;font-weight: bold;" onclick="window.location.href = \'AddVideo.php\';"><img src="images/upload.png" style="padding-bottom: 0px;width: 16px;"><span class="link"> Upload</span></li>';
    $favoriteOptn = '<li style="padding: 10px;font-size: 15px;font-weight: bold;" onclick="window.location.href = \'favorites.php\';"><img src="images/favorites.png" style="padding-bottom: 0px;width: 16px;"><span class="link"> Favorites</span></li>';

    if(empty($_SESSION['facebookId'])) {
        $addlBtn = '<li style="padding:10px;height:29px;"><img src="images/link_Facebook_Account.png" onClick="window.location.href = \'index.php?action=login&method=facebook\';" alt="Link Facebook Account" style="cursor:pointer;"/></li>';
        $addlBtn = $addlBtn.'<li><hr style="padding-left: 10px;width: 125px;"></li>';
        $friendsOptn = '<li style="padding: 10px;font-size: 15px;font-weight: bold;" onClick="alert(\'Please Login to Facebook to see Friends\');"><img src="images/friends.png" style="padding-bottom: 0px;width: 16px;"><span class="link"> Friends</span></li>';
    }else if(empty($_SESSION['googleId'])) {
        $addlBtn = '<li style="padding:10px;height:29px;"><img src="images/link_Google_Account.png" onClick="window.location.href = \'index.php?action=login&method=google\';" alt="Link Google Account" style="cursor:pointer;"/></li>';
        $addlBtn = $addlBtn.'<li><hr style="padding-left: 10px;width: 125px;"></li>';
        $uploadOptn = '<li style="padding: 10px;font-size: 15px;font-weight: bold;" onclick="alert(\'Please Login to Google to Upload Videos into YouTube\');"><img src="images/upload.png" style="padding-bottom: 0px;width: 16px;"><span class="link"> Upload</span></li>';
    }else {
        $addlBtn = '';
    }    
}else{
    $loginBtn = "<input type='button' data-dropdown='#loginDropdown' value='Login' style='width:100px;'/>";
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
            <?=$friendsOptn;?>
            <?=$favoriteOptn;?>
            <?=$uploadOptn;?>
            <li style="padding: 10px;font-size: 15px;font-weight: bold;" onclick="window.location.href = 'login.php?login=logout';">
                <img src="images/logout-icon-16.png" style="padding-bottom: 0px;width: 16px;">
                <span class="link"> Logout</span>
            </li>
        </ul>
    </div>

<!----        Header      ----->
    <div class="headerTable">
        <div class="form">
            <p>
                <input type="button" value="" style="width: 40px;background-image: url('images/home.png');background-repeat: no-repeat;background-position:center;" onclick="window.location='index.php'">
                <input type="text" style="width:550px;" id="query" value=''/>
                <input type="submit" id="search-button" value="Search/Load URL" style="width:130px;" onClick="processSearch();"/>
                <?=$loginBtn;?>
            </p>
        </div>
    </div>