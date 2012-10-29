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
?>
<!----   include Dialog Boxes here      --->

<!----   include Dropdown lists here    -->
<div id="loginDropdown" class="dropdown-menu has-tip">
    <ul>
        <li style="padding: 10px;"><img src="images/facebook_login_icon.png" alt="Login with Facebook" onClick="login('facebook');" style="cursor:pointer;"/></li>
        <li align="center">- OR -</li>
        <li style="padding: 10px;"><img src="images/google_login_icon.png" alt="Login with Google" onClick="login('google');" style="cursor:pointer;"/></li>
    </ul>
</div>

<!----        Header      ----->
<div class='header'>
    <table class="headerTable">
        <tr>
            <td style="width:500px;">
				<form action="index.php" method="post">
					Url: <input type="text" name="ytUrl" style="width: 80%;"/>
					<input type="submit" value="Load" />
					<?php if($_POST["ytUrl"] == ""){$_POST["ytUrl"] = "http://www.youtube.com/watch?v=kweUVUCYRa8";}?>
				</form> 
            </td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><a href="#">Liked</a></td>
            <td><a href="#">Faviorites</a></td>
            <td><a href="#" data-dropdown="#loginDropdown">Login</a></td>
        </tr>
    </table>
</div>