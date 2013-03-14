
// triggered when search/load button is clicked 
// performs task based on the user query and login status 
function processSearch() {
    //  http://youtu.be/FD44KytW4UU
    //  http://www.youtube.com/watch?v=FD44KytW4UU
    var query = $('#query').val();
    
    if(( query.search("youtu.be/") !== -1 ) || ( query.search("youtube.com/watch")  !== -1 )) {
        window.location = 'index.php?ytUrl=' + query;
    } else {
        // as of now search only works when user is logged in
        yTSearch();
    }
}

// Get video data from youtube and display
function yTSearch() {
    var query = $('#query').val();
    var data = 'q=' + query + '&key=' + YOUTUBE_DEVELOPER_KEY;
    data = data + '&part=snippet&order=relevance&maxResults=25&type=video&videoSyndicated=true&videoEmbeddable=true&videoDimension=2d';
    $.get("https://gdata.youtube.com/feeds/api/videos", data, function(response){
        var htmlResult = '<table class="videoResults" align="center" style="cursor:pointer;">';
        $(response).find('entry').each(function(){
            var videoId = $(this).find("id").text().split('/').slice(-1);
            var title = $(this).find("title").text();
            var description = $(this).find("content").text();         
            var thumbnail = $(this).find('thumbnail').attr('url');
            htmlResult += '<tr onclick="document.location = \'index.php?ytUrl=http://www.youtube.com/watch?v=' + videoId + '\'"><td><img src="' + thumbnail + '" alt="' + title + '"/></td><td id="info"><span>'+ '<span id="title">' + title + '</span><br/><span id="description">' + description + '</span></span></td></tr>';
        });
        htmlResult += '</table>';        
        $('#container').html(htmlResult);        
    });
}