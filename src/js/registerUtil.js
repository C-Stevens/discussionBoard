$(document).ready(function () {
    $("#registerButton").click(function() {
        // Display the login modal
        $('#registerModal').modal('show');
    });
    $("#registerForm").submit(function(event) {
        event.preventDefault(); // Prevent form from submitting normally so we can do it through jQuery instead
        $.post("util/register.php", $("#registerForm").serialize(), function(returnResult) {
            var returnResult = parseInt(returnResult); // Convert string return back to int
            switch(returnResult) {
                case 0: // Sucess
                    $.post("util/login.php", { // Log the user in for them since they just registered
                        email : $("#registerEmailField").val(),
                        password : $("#registerPasswordField").val()
                    }).done(function(returnResult) {
                        var ret = parseInt(returnResult);
                        if(ret === 0) { // Logged in successfully, reload page
                            location.reload();
                        }
                      });
                    break;
                case 1: // Invalid email/password combination
                    $("#registerErrorMessageText").text("Passwords do not match.");
                    $("#registerForm").addClass("error");
                    $('#registerModal').transition('bounce'); // Shake the login modal so the user knows there was an error
                    break;
                case 2: // Server didn't get all the data it needed
                    $("#registerErrorMessageText").text("Please fill out all fields.");
                    $("#registerForm").addClass("error");
                    $('#registerModal').transition('bounce');
                    break;
                case 3: // Server error on SQL jQuery
                    $("#registerErrorMessageText").text("The server encountered an error attempting to add a new user to the database.");
                    $("#registerForm").addClass("error");
                    $('#registerModal').transition('bounce');
                    break;
            };
        });
    });
});
