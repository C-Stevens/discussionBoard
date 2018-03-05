<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('includes/globalHead.html'); ?>
    <script src="https://cdn.jsdelivr.net/momentjs/2.18.1/moment.min.js"></script>
    <title>Discussion Board &mdash; Main</title>
    <style>
        .post {
            margin-bottom: 0px !important; /* Use !important to override semantic's default margin */
        }
        #mainHeader {
            font-size: 3em;
            font-weight: normal;
        }
    </style>
    <script>
        function createPostFromJSON(row) {
            /*
                Making DOM elements in jQuery to create a complicated html element.
                See documentation to view what this output looks like in human-readable
                html.
            */
            var $post = $("<div/>", { // Post container
                "postID" : row['postID'],
                "class" : "ui stacked segment"
            });
            var $postHeaderContainer = $("<div/>", { // Post header
                "class" : "post ui clearing basic segment"
            });
            
            // Create all "right side" header details
            var $postHeaderRight = $("<h4/>", {
                "class" : "ui right floated header"
            });
            $postHeaderRight.append($("<a/>", {
                "href" : "util/bumpPostRating.php?postID="+row['postID']+"&direction=down",
                "text" : "-"
            }));
            $postHeaderRight.append("&nbsp;"+row['rating']+"&nbsp");
            $postHeaderRight.append($("<a/>", {
                "href" : "util/bumpPostRating.php?postID="+row['postID']+"&direction=up",
                "text" : "+"
            }));
            var $postSubheaderRight = $("<div/>", {
                "class" : "sub header",
                "style" : "text-align: center"
            });
            /* Disabled, as reply function was removed due to lack of time.
            $postSubheaderRight.append($("<a/>", {
                "href" : "#",
                "text" : "Reply"
            }));
            */
            $postHeaderRight.append($postSubheaderRight);
            // End "right side" header elements
            
            // Create all "left side" header details
            var $postHeaderLeft = $("<h3/>", {
                "class" : "ui left floated header",
                "text" : row["title"]
            });

            var $parsedTimestamp = moment(row['postTime']); // Use Moment.js to display dateTime in a more human-friendly way
            $postHeaderLeft.append($("<div/>", {
                "class" : "sub header",
                "text" : row['author']+" — "+$parsedTimestamp.format("MMMM Do, YYYY [at] h:mm a")
            }));
            // End "left side" header elements
            
            // Add left and right header elements to the header container
            $postHeaderContainer.append($postHeaderRight);
            $postHeaderContainer.append($postHeaderLeft);
            
            var $postContentContainer = $("<div/>", {
                "class" : "ui basic attached basic segment"
            });
            var $postContent = $("<p/>");
            $postContent.append(row['content']);
            $postContentContainer.append($postContent);
            
            // Add both containers to the post
            $post.append($postHeaderContainer);
            $post.append($postContentContainer);
            
            return $post;
        }
    </script>
</head>
<body>

<!-- Menu bar -->
<?php
    include("includes/menu.php");
    drawMenu("home"); // Set Home tab active
?>

<!-- Page Contents -->
<div id="mainContainer">
    <h1 class="ui block header" id="mainHeader">
        <i class="huge comments icon"></i>
        <div class="content">
            Have something to talk about?
            <div class="sub header">Let's talk about that. <a href="post.php">Share your thoughts.</a></div>
        </div>
    </h1>
    <h2 class="ui dividing header">Most Recent Discussions</h1>
        <div id="recentDiscussions"></div>
    
    <script>
        $.getJSON("/util/getPosts.php", {
            "request" : "recent"
        }).done(function(data) {
                $.each(data, function(i, row) {
                    $("#recentDiscussions").append(createPostFromJSON(row));
                });
           });
    </script>
</div>



<?php //include("includes/footer.html"); ?>

  </body>
</html>
