<object id="vidplayer" data="players/StrobeMediaPlayback.swf"> 
    <param name="movie" value="players/StrobeMediaPlayback.swf">
    <param name="flashvars" value="src=rtmp://localhost:1935/vod/html5/<?php echo $vidrow['id_video']; ?>.mp4&poster=media/thumbnails/<?php echo $vidrow['id_video']; ?>.jpg">
    <param name="allowFullScreen" value="true"><param name="allowscriptaccess" value="always"><param name="wmode" value="direct">
    <embed src="players/StrobeMediaPlayback.swf" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="direct" width="470" height="320" flashvars="src=rtmp://localhost:1935/vod/html5/<?php echo $vidrow['id_video']; ?>.mp4&poster=media/thumbnails/<?php echo $vidrow['id_video']; ?>.jpg">
</object>