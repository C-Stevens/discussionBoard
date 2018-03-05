<?php
session_start();

function drawMenu($activeTab) {
    // Echo static content
    print   '<div class="ui inverted vertical masthead center aligned segment">
                <div class="ui container">
                    <div class="ui large secondary inverted pointing menu">
                        <a class="toc item">
                        <i class="sidebar icon"></i>
                        </a>
    ';
                // Set the requsted tab as active
                print '<a class="'.($activeTab === "home" ? 'active ' : '').'item" href="index.php">Home</a>';
                print '<a class="'.($activeTab === "about" ? 'active ' : '').'item" href="about.php">About</a>';
                print '<a class="'.($activeTab === "contact" ? 'active ' : '').'item" href="contact.php">Contact</a>';
            if($_SESSION['isAdmin']) { // Add a tab to access admin tools if the user is an admin
                print '<a class="'.($activeTab === "admintools" ? 'active ' : '').'item" href="admin.php">Admin tools</a>';
            }

                print '<div class="right item">';
                    if($_SESSION['loggedIn']) { // If the user is logged in, display their name and a log out button
                        print $_SESSION['displayName'];
                        print "<a class='ui inverted button' href='util/logout.php'>Log out</a>";
                    } else { // If the user isn't logged in, display a login and a sign up button
                        print "<a class='ui inverted button' id='loginButton'>Login</a>";
                        print "<a class='ui inverted button' id='registerButton'>Sign up</a>";
                    }
    // Print all closing tags
    print            '</div>
                </div>
            </div>
        </div>
    ';
    
    include('includes/modal.html'); // Since every page with a menu will need to handle login tasks, they all need the modal mode
}
