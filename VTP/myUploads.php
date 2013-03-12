<?php
include_once('head_std.php');    


$feedURL = 'http://gdata.youtube.com/feeds/api/users/'.$_SESSION['vtpUserName'].'/uploads?max-results=50';
$sxml = simplexml_load_file($feedURL);
$i=0;
foreach ($sxml->entry as $entry) {
      $media = $entry->children('media', true);
      $watch = (string)$media->group->player->attributes()->url;
      $thumbnail = (string)$media->group->thumbnail[0]->attributes()->url;
      ?>
      <div class="videoitem">
        <div class="videothumb"><a href="<?php echo $watch; ?>" class="watchvideo"><img src="<?php echo $thumbnail;?>" alt="<?php echo $media->group->title; ?>" /></a></div>
        <div class="videotitle">
            <h3><a href="<?php echo $watch; ?>" class="watchvideo"><?php echo $media->group->title; ?></a></h3>
            <p><?php echo $media->group->description; ?></p>
        </div>
      </div>      
<?php
    $i++;
    if($i==3) {
        echo '<div class="clear small_v_margin"></div>';
        $i=0; 
    }
}

include('tail_std.php');
?>