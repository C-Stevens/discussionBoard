$(document).ready(function () {
    $("#loginButton").click(function() {
        // Display the login modal
        $('#loginModal').modal('show');
    });
    $("#loginForm").submit(function(event) {
        event.preventDefault(); // Prevent form from submitting normally so we can do it through jQuery instead
        $.post("util/login.php", $("#loginForm").serialize(), function(returnResult) {
            var returnResult = parseInt(returnResult); // Convert string return back to int
            switch(returnResult) {
                case 0: // Sucess
                    location.reload(); // Reload page to update header
                    break;
                case 1: // Invalid email/password combination
                    $("#loginErrorMessageText").text("Invalid email/password combination.");
                    $("#loginForm").addClass("error");
                    $('#loginModal').transition('bounce'); // Shake the login modal so the user knows there was an error
                    break;
                case 2: // Server didn't get all the data it needed
                    $("#loginErrorMessageText").text("Please fill out all fields.");
                    $("#loginForm").addClass("error");
                    $('#loginModal').transition('bounce');
                    break;
            };
        });
    });
});
