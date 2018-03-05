<?php
    session_start();
    if(!$_SESSION['isAdmin']) { // If the user isn't an admin, dont allow them to access this page directly
        header('Location: index.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/globalHead.html'); ?>
    <title>Discussion Board &mdash; About</title>
    <script>
        $(document).ready(function() {
            $('#userList').accordion();
        });
        
        function convertBool(bool) {
            /* Convert bool to text "true" or "false" */
            var bool = parseInt(bool);
            if(bool === 0) {
                return "false";
            } else {
                return "true";
            }
        }
        
        function createUserEntry(row) {
            console.log(row);
            console.log(row['userID']);
            /* Make a DOM object to create a user entry for display on the page.
                Accepts a single JSON object for parsing.
            */
            var $user = $("<div/>", {
                "userID" : row['userID']
            });
            
            var $titleContainer = $("<div/>", {
                "class" : "title"
            });
            var $titleIcon = $("<i/>", {
                "class" : "dropdown icon"
            });
            $titleContainer.append($titleIcon);
            $titleContainer.append(row['displayName']);
            
            var $contentContainer = $("<div/>", {
                "class" : "content"
            });
            var $detailList = $("<ul/>", {
                "class" : "ui list"
            });
            $detailList.append($("<li/>", {
                "text" : "userID : "+row['userID']
            }));
                $detailList.append($("<li/>", {
                "text" : "Email : "+row['email']
            }));
                $detailList.append($("<li/>", {
                "text" : "Display name : "+row['displayName']
            }));
                $detailList.append($("<li/>", {
                "text" : "Admin status : "+convertBool(row['isAdmin'])
            }));
            $contentContainer.append($detailList);
            $contentContainer.append($("<a/>", {
                "class" : "ui red button",
                "text" : "Delete User & Posts",
                "href" : "util/adminUtils.php?request=deleteUser&userID="+row['userID']
            }));
            $contentContainer.append($("<a/>", {
                "class" : "ui button",
                "text" : "Make Admin",
                "href" : "util/adminUtils.php?request=makeAdmin&userID="+row['userID'],
            }));
            
            $user.append($titleContainer);
            $user.append($contentContainer);
            
            return $user;
        }
    </script>
</head>
<body>

<?php 
    include('includes/menu.php');
    drawMenu("admintools");
?>

<div id="mainContainer">
    <div class="ui segment">
        <h1 class="ui dividing header">Admin Tools</h1>
        <h3>User List</h3>
        <div class="ui styled fluid accordion" id="userList"></div>
        <script>
            $.getJSON("/util/adminUtils.php", {
                "request" : "getUserList"
            }).done(function(data) {
                    $.each(data, function(i, row) {
                        $("#userList").append(createUserEntry(row));
                    });
              });
        </script>
            
        </div>
    </div>
</div>

</body>
</html>
