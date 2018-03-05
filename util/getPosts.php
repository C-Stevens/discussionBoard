<?php
include("db.php");
/* Will return posts from the database in two ways based on the request:
        * "recent" : Displays the most recent 10 posts.
        * "today" : Displays all the posts made today.
    The number of results returned can be specified for either way by supplying 'num=<some integer>' in the request.
*/
if(!empty($_GET)) {
    if($_GET['request'] === "recent") {
        // Get 10 most recent posts, unless the GET requests a different number of posts in 'num'
       $sql="SELECT * FROM posts ORDER BY postTime DESC LIMIT ".(isset($_GET['num']) && !empty($_GET['num']) ? $_GET['num'] : '10').";";
    } else if($_GET['request'] === "today") {
        // Get all the last 24 hours of posts, unless the GET requests a different number of posts in 'num'
        $sql="SELECT * FROM posts WHERE postTime > DATE_SUB(NOW(), INTERVAL 1 DAY)".(isset($_GET['num']) && !empty($_GET['num']) ? 'LIMIT '.$_GET['num'] : '').";";
    }
} else {
    print "No request specified.";
    exit;
}



$result=mysqli_query($db, $sql);
if(mysqli_num_rows($result) == 0) {
	echo "No posts yet.";
	exit;
}

$data = array();
while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) { // Put each datarow into a PHP array
    // Use nl2br() to insert a <br \> everywhere a \r\n newline (from form textarea) is found,
    // then replace every \r\n with nothing (remove them), leaving only html breaks.
    $row['content'] = str_replace(array("\r\n","\n\r","\n","\r"), '', nl2br($row['content']));
    
    // Lookup the displayName of the poster based on what userID is stored as the author of this post.
    $userLookupSql = "SELECT displayName FROM users WHERE userID=".$row['author'].";";
    $userLookupResult = mysqli_query($db, $userLookupSql);
    $userLookupRow = mysqli_fetch_array($userLookupResult,MYSQLI_ASSOC);
    $row['author'] = $userLookupRow['displayName'];

    // Append row to results
    $data[] = $row;
}
// JSON encode and return the array of results
print json_encode($data);
