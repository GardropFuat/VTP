<?php
/*
 *
 * File Name:           headJS.php
 * Description:         Contains JS code to include in <head>
 * Author:
 * Created:             10/25/2012
 * Last Modified:       Anudeep 10/25/12
 * Copyright:           Echostar Systems @ http://www.echostar.com/
 */
?>


<script type="text/javascript">
// increase the default animation speed to exaggerate the effect
$.fx.speeds._default = 500;

// on window resize set player height
$(window).resize(function() {
    $('#playerDiv').height('50%');
    $('#tagdescription').height('50%');
});

// 
function login(type){
    $.post('login.php', {login: type}, function(data) {
      $('#loginDialog').html(data);
    });
}
</script>