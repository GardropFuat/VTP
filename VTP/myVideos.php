<!doctype html>
<html>
  <head>
      <title>My Uploads</title>
      <style>
      .paging-button {
  visibility: hidden;
}

.video-content {
  width: 200px;
  height: 200px;
  background-position: center;
  background-repeat: no-repeat;
  float: left;
  position: relative;
  margin: 5px;
}

.video-title {
  width: 100%;
  text-align: center;
  background-color: rgba(0, 0, 0, .5);
  color: white;
  top: 50%;
  left: 50%;
  position: absolute;
  -moz-transform: translate(-50%, -50%);
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

.video-content:nth-child(3n+1) {
  clear: both;
}

.button-container {
  clear: both;
}
      </style>
  </head>
  <body>
    <div id="login-container" class="pre-auth">This application requires access to your YouTube account.
      Please <a href="#" id="login-link">authorize</a> to continue.
    </div>
    <div id="video-container">
    </div>
    <div class="button-container">
      <button id="prev-button" class="paging-button" onclick="previousPage();">Previous Page</button>
      <button id="next-button" class="paging-button" onclick="nextPage();">Next Page</button>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="auth.js"></script>
    <script>
        // Some variables to remember state.
        var playlistId, nextPageToken, prevPageToken, myResponse;

        // Once the api loads call a function to get the uploads playlist id.
        function handleAPILoaded() {
          requestUserUploadsPlaylistId();
        }

        //Retrieve the uploads playlist id.
        function requestUserUploadsPlaylistId() {
          // https://developers.google.com/youtube/v3/docs/channels/list
          var request = gapi.client.youtube.channels.list({
            // mine: '' indicates that we want to retrieve the channel for the authenticated user.
            mine: true,
            part: 'contentDetails'
          });
          request.execute(function(response) {
            myResponse = response;
            console.log(response);
            playlistId = response.result.items[0].contentDetails.relatedPlaylists.uploads;
            console.log(playlistId);
            requestVideoPlaylist(playlistId);
          });
        }

        // Retrieve a playist of videos.
        function requestVideoPlaylist(playlistId, pageToken) {
          $('#video-container').html('');
          var requestOptions = {
            playlistId: playlistId,
            part: 'snippet',
            maxResults: 9
          };
          if (pageToken) {
            requestOptions.pageToken = pageToken;
          }
          var request = gapi.client.youtube.playlistItems.list(requestOptions);
          request.execute(function(response) {
            // Only show the page buttons if there's a next or previous page.
            nextPageToken = response.result.nextPageToken;
            var nextVis = nextPageToken ? 'visible' : 'hidden';
            $('#next-button').css('visibility', nextVis);
            prevPageToken = response.result.prevPageToken
            var prevVis = prevPageToken ? 'visible' : 'hidden';
            $('#prev-button').css('visibility', prevVis);

            var playlistItems = response.result.items;
            if (playlistItems) {
              // For each result lets show a thumbnail.
              jQuery.each(playlistItems, function(index, item) {
                createDisplayThumbnail(item.snippet);
              });
            } else {
              $('#video-container').html('Sorry you have no uploaded videos');
            }
          });
        }


        // Create a thumbnail for a video snippet.
        function createDisplayThumbnail(videoSnippet) {
          var titleEl = $('<h3>');
          titleEl.addClass('video-title');
          $(titleEl).html(videoSnippet.title);
          var thumbnailUrl = videoSnippet.thumbnails.medium.url;

          var div = $('<div>');
          div.addClass('video-content');
          div.css('backgroundImage', 'url("' + thumbnailUrl + '")');
          div.append(titleEl);
          $('#video-container').append(div);
        }

        // Retrieve the next page of videos.
        function nextPage() {
          requestVideoPlaylist(playlistId, nextPageToken);
        }

        // Retrieve the previous page of videos.
        function previousPage() {
          requestVideoPlaylist(playlistId, prevPageToken);
        }
    </script>
    <script src="https://apis.google.com/js/client.js?onload=googleApiClientReady"></script>
  </body>
</html>