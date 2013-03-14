var isUserLoggedIn = false;

// triggered when search/load button is clicked 
// performs task based on the user query and login status 
function processSearch() {
    //  http://youtu.be/FD44KytW4UU
    //  http://www.youtube.com/watch?v=FD44KytW4UU
    var query = $('#query').val();
    
    if(( query.search("youtu.be/") !== -1 ) || ( query.search("youtube.com/watch")  !== -1 )) {
        window.location = 'index.php?ytUrl=' + query;
    } else if( isUserLoggedIn ) {
        // as of now search only works when user is logged in
        yTSearch();
    } else {
        alert("Please login into your Google account to search");
    }
}
