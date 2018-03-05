<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/globalHead.html'); ?>
    <title>Discussion Board &mdash; Make Post</title>
    <style>
        #postReset {
            margin-right: 5px;
        }
        #postSubmit {
            margin-left: 5px;
        }
    </style>
    <script>
        $(document).ready(function() {
            function clearPostForm() { // Method to reset post form and put focus in the titel field
                $("#postTitle").val('');
                $("#postContent").val('');
                $("#postTitle").focus();
            }
            
           // $("#notLoggedInError").hide(); // Initial state
            $.get('util/getLoginState.php', function(returnCode) {
                if(returnCode != 1) {
                    // Disable input fields
                    $("#titleField").addClass("disabled");
                    $("#contentField").addClass("disabled");
                    $("#postReset").addClass("disabled");
                    $("#postSubmit").addClass("disabled");
                    // Show error box
                    $("#notLoggedInError").show();
                } else {
                    $("#postTitle").focus();
                }
            });
            $("#loginLink").click(function() {
                $('.ui.modal').modal('show');
            });
            $("#postReset").click(function() {
                clearPostForm();
            });
            $("#postForm").submit(function(event) {
                $("#postForm").addClass("loading");
                event.preventDefault(); // Supress native submit button behavior
                $.post("util/makePost.php", $("#postForm").serialize(), function(returnResult) {
                    var returnResult = parseInt(returnResult); // Convert string return back to int
                    switch(returnResult) {
                        case 0: // Success
                            $('.segment').dimmer('show');
                            setTimeout(function() { // Leave the message up for 2 second for the user to read
                                $('.segment').dimmer('hide');
                            }, 2000);
                            clearPostForm();
                            break;
                        case 1: // Couldn't add to database
                            $("#postErrorText").text("Could not insert post into database.");
                            $("#postForm").addClass("error");
                            $("#postErrorContainer").transition('shake');
                            break;
                        case 2: // Incomplete POST form
                            $("#postErrorText").text("Please fill out all fields.");
                            $("#postForm").addClass("error");
                            $("#postErrorContainer").transition('shake');
                            break;
                        case 3: // User not logged in
                            $("#postErrorText").text("You must be logged in to create posts.");
                            $("#postForm").addClass("error");
                            $("#postErrorContainer").transition('shake');
                            break;
                    };
                });
                $("#postForm").removeClass("loading");
            });
        });
    </script>
</head>
<body>

<?php
    include('includes/menu.php');
    drawMenu();
?>

<div id="mainContainer">

    <div class="ui negative icon message" id="notLoggedInError" style="display: none">
        <i class="warning icon"></i>
        <div class="content">
            <div class="header">You must log in before you can do that!</div>
            <p>If you'd like to contribute, please <a href="#" id="loginLink">log in</a>.</p>
        </div>
    </div>
    
    <h1 class="ui dividing header">Create a New Discussion</h1>
    <div class="ui blurring segment">
        <form method="POST" class="ui form" id="postForm">
            <div class="ui error message" id="postErrorContainer">
                <div class="header">An error occured</div>
                <p id="postErrorText"></p>
            </div>
            <div class="field" id="titleField">
                <label>Title</label>
                <input type="text" name="title" id="postTitle" placeholder="Discussion title" required>
            </div>
            <div class="field" id="contentField">
                <label>Content</label>
                <textarea name="content" id="postContent" placeholder="What's on your mind?" rows="20" required></textarea>
            </div>
            <div class="ui two buttons">
                <div class="fluid ui button" id="postReset">Reset</div>
                <button class="fluid ui primary button" id="postSubmit" name="postSubmit" type="submit">Post</button>
            </div>
        </form>
        
        <div class="ui inverted dimmer">
            <div class="content">
                <div class="center">
                    <h2 class="ui icon header">
                        <i class="green check icon"></i>
                        Post successful!
                    </h2>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
