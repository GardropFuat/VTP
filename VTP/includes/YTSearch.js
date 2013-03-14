// Once the api loads call enable the search box.
function handleAPILoaded() {
    isUserLoggedIn = true;
    $('#search-button').text('Search/Load');
    //  $('#search-button').attr('disabled', false);
}

// Search for a given string. 
function yTSearch() {
    var q = $('#query').val();
    
    // For more parameters see ref: https://developers.google.com/youtube/v3/docs/search/list
    var request = gapi.client.youtube.search.list({
        q: q,
        part: 'snippet',
        order: 'relevance',
        maxResults: 25,
        type: 'video',
        videoSyndicated: true,
        videoEmbeddable: true,
        videoDimension: '2d'
    });
    
    //  Manipulate search response
    request.execute(function(response) {
        var searchResponse = JSON.parse( JSON.stringify(response.result) );
        var videoResults = searchResponse['items'];
        var htmlResult = '<table class="videoResults" align="center" style="cursor:pointer;">';
        
        $.each(videoResults, function(index, value) {
            var refId = '';
            var resultKind = value['id']['kind'];
            resultKind = resultKind.split('#')[1];
            switch(resultKind) {
                case 'video':
                    refId = value['id']['videoId'];
                    break;
                case 'playlist':
                    refId = value['id']['playlistId'];
                    break;
                case 'channel':
                    refId = value['id']['channelId'];
                    break;
            }            
            var videoTitle = value['snippet']['title'];
            var videoDescription = value['snippet']['description'];
            var videoThumbnail = value['snippet']['thumbnails']['medium']['url'];
            
            htmlResult += '<tr onclick="document.location = \'index.php?ytUrl=http://www.youtube.com/watch?v=' + refId + '\'"><td><img src="'+ videoThumbnail +'" alt="'+videoTitle+'"/></td><td id="info"><span>'+ '<span id="title">' + videoTitle + '</span><br/><span id="description">' + videoDescription + '</span></span></td></tr>';
        });
        htmlResult += '</table>';
        
        $('#container').html(htmlResult);
    });
}