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

/*******************    jQuery Login Popup Dialog        **************************/
$(function() {
    $( "#loginOptions" ).dialog({
        autoOpen: false,
        show: "blind",
        hide: "explode"
    });

    $( "#loginBtn" ).click(function() {
        $( "#loginOptions" ).dialog( "open" );
        return false;
    });
});
</script>