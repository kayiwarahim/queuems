$(document).ready(function() {
        // Function to handle the beforeunload event
        function handleBeforeUnload() {
            // Perform the logout action using AJAX or redirect to the logout route
            $.ajax({
                url: '/logout', // Replace with the actual logout route if needed
                method: 'POST', // Use the appropriate HTTP method for logout
                data: {
                    _token: '{{ csrf_token() }}' // Add the CSRF token to the data
                },
                async: false, // Make the AJAX call synchronous
                success: function() {
                    // Logout successful (optional: you can show a message to the user)
                    console.log('User logged out.');
                },
                error: function(xhr, status, error) {
                    // Logout failed (optional: you can show an error message to the user)
                    console.error('Logout failed:', error);
                }
            });
        }

        // Attach the beforeunload event to the window object
        $(window).on('beforeunload', function() {
            handleBeforeUnload();
        });
    });