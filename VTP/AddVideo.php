<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Upload To YouTube</title>
        <style type="text/css">
            label,
            input {
                display: block;
                margin: 0 0 5px 0;
            }
        </style>
    </head>
    <body>
        
        <?php        
        //If the 1st step form has been submited, run the token script.
        if( isset( $_POST['video_title'] ) && isset( $_POST['video_description'] ) ) {
            $video_title = stripslashes( $_POST['video_title'] );
            $video_description = stripslashes( $_POST['video_description'] );
			
            include_once( 'get_youtube_token.php' );
        }
        
        // Specifies the url that youtube will return to. The data it returns are as get variables         
        $nexturl = "http://localhost/VTP/AddVideo.php";
        // These are the get variables youtube returns once the video has been uploaded.
		if(isset( $_GET['id']) && isset($_GET['status']))
		{
			$unique_id = $_GET['id'];
			$status = $_GET['status'];
		}
		
        ?>
        
        <!-- Step 1 of the youtube upload process -->
        <?php if( empty( $_POST['video_title'] ) && !isset($unique_id) ) : ?>                    
            <form action="" method="post">                
                <label for="video_title">Video Title</label>
                <input type="text" name="video_title" />
                <label for="video_description">Video Description</label>
                <textarea id="video-description" name="video_description"></textarea>
				<label for="emailLogin">Email Login to youtube</label>
				<input type="text" name="emailLogin" />
				<label for="pwd">Password to youtube</label>
				<input type="password" name="pwd">
                <input type="submit" value="Step 2" />
            </form> <!-- /form -->

        <!-- Step 2 -->           
        <?php elseif( isset($response) && $response->token != '' ) : ?>                        
            <h4>Title:</h4>
            <p><?php echo $video_title; ?></p>
            <h4>Description:</h4>
            <p><?php echo $video_description; ?></p>
            <form action="<?php echo( $response->url ); ?>?nexturl=<?php echo( urlencode( $nexturl ) ); ?>" method="post" enctype="multipart/form-data">
                <p class="block">
                    <label>Upload Video</label>
                    <span class="youtube-input">
                        <input id="file" type="file" name="file" />
                    </span>                        
                </p>
                <input type="hidden" name="token" value="<?php echo( $response->token ); ?>"/>
				<input type="hidden" name="emailLogin" value="<?php echo( $_POST['emailLogin']); ?>"/>
				<input type="hidden" name="pwd" value="<?php echo( $_POST['pwd']); ?>"/>
                <input type="submit" value="Upload Video" />
            </form> <!-- /form -->
            
        <!-- Final Step -->
        <?php elseif( isset($unique_id)  && $status = '200' ) : ?>        
        <div id="video-success">
            <h4>Video Successfully Uploaded!</h4>
            <form action="http://localhost/VTP/index.php" method="post">
				<p>Here is your url to view your video in YouTube:<a href="http://www.youtube.com/watch?v=<?php echo $unique_id; ?>" target="_blank">http://www.youtube.com/watch?v=<?php echo $unique_id; ?></a></p>
				<p>The video should be up any moment but could take up to 3 hours to be finished, Please Be Patient.
				<input type="hidden" name="ytUrl" value="http://www.youtube.com/watch?v=<?php echo $unique_id; ?>"/>
				<input type="submit" value="Finish" />
		</div> <!-- /div#video-success -->
        <?php endif; ?>
        
    </body>
</html>
