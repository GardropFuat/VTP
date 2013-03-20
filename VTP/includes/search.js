// triggered when search/load button is clicked
// performs task based on the user query and login status
function processSearch() {
    //  http://youtu.be/FD44KytW4UU
    //  http://www.youtube.com/watch?v=FD44KytW4UU
    var query = $('#query').val();

    if( query.search("vimeo.com/") !== -1 ) {
        window.location = 'index.php?vimeoUrl=' + query;
    } else if(( query.search("youtu.be/") !== -1 ) || ( query.search("youtube.com/watch")  !== -1 )) {
        window.location = 'index.php?ytUrl=' + query;
    } else {
        // as of now search only works when user is logged in
        yTSearch(0);
    }
}

// Get video data from youtube and display
function yTSearch(pageNum) {
    var query = $('#query').val();
    var url = "https://gdata.youtube.com/feeds/api/videos";
    var startIndex = 25 * pageNum;
    var data = 'q=' + query + '&key=' + YOUTUBE_DEVELOPER_KEY;
    var htmlResult = '';
    var isSearchSucessful = false;
    
    data += '&part=snippet&order=relevance&maxResults=25&type=video&videoSyndicated=true&videoEmbeddable=true&videoDimension=2d';

    if(startIndex !== 0)
        data += '&start-index=' + startIndex;

    $.get(url, data, function(response){
        console.log(response);
        if(query === '')
            htmlResult = '<h1 align="center">Most popular videos</h1>';
        htmlResult += '<table class="videoResults" align="center" style="cursor:pointer;">';

        // manipulate each video entry data
        $(response).find('entry').each(function(){
            isSearchSucessful = true;
            var videoId = $(this).find("id").text().split('/').slice(-1);
            var title = $(this).find("title").text();
            var description = $(this).find("content").text();
            var thumbnail = $(this).find('thumbnail').attr('url');

            if(title.length > 100) {
                title = title.substr(0, 75) + '...';
            }
            if(description.length > 115) {
                description = description.substr(0, 115) + '...';
            }

            htmlResult += '<tr onclick="document.location = \'index.php?ytUrl=http://www.youtube.com/watch?v=' + videoId + '\'">';
            htmlResult += '<td><img src="' + thumbnail + '" alt="' + title + '"/></td>';
            htmlResult += '<td id="info"><span>'+ '<span id="title">' + title + '</span><br/>';
            htmlResult += '<span id="description">' + description + '</span></span></td></tr>';
        });
        htmlResult += '</table>';
        if(!isSearchSucessful) {
            htmlResult += '<div class="form">';
            htmlResult += '<p align="center"><label>No video results found for query "' + query + '"</label></p>';
            htmlResult += '<p align="center"><label>Hint: Type few words for better results</label></p>';
            htmlResult += '</div>';
        }else {
            // page navigation
            htmlResult +=  '<div class="pageNav">';
            htmlResult +=  '<img src="images/Button-Back-icon.png"';
            if(pageNum !== 0)
                htmlResult +=  ' onClick="yTSearch(' + (pageNum - 1) + ')"  title="' + (pageNum) + '"';
            htmlResult +=  ' alt="Previous Page"/>';
            htmlResult +=  '<p>&nbsp;&nbsp;'+ (pageNum + 1) + '&nbsp;&nbsp;</p>';
            htmlResult +=  '<img src="images/Button-Next-icon.png" onClick="yTSearch(' + (pageNum + 1) + ')" alt="Next Page" title="' + (pageNum + 2) + '" />';
            htmlResult +=  '</div>';
        }
        $('#container').html(htmlResult);
    });
}