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
<div id="loginDialog" title="Login">
    <table align="center">
        <tr><td><img src="images/facebook_login_icon.png" alt="Login with Facebook" onClick="login('facebook');" style="cursor:pointer;"/></td></tr>
        <tr align="center"><td>OR</td></tr>
        <tr><td><img src="images/google_login_icon.png" alt="Login with Google" onClick="login('google');" style="cursor:pointer;"/></td></tr>        
    </table>
</div>

<!----        Header      ----->
<div class='header'>
    <table class="headerTable">
        <tr>
            <td style="width:500px;">
                Url:    <input type="text" id="ytUrl" style="width: 80%;"/>
                <input type="button" OnClick="" value="Load" />
            </td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><a href="#">Liked</a></td>
            <td><a href="#">Faviorites</a></td>
                <!-- login popup trigger is in headJs.php-->
            <td><a href="#" id="loginBtn">Login</a></td>
        </tr>
    </table>
</div>