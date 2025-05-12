<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Forgot Password - Procurement & Assets Management System</title>
    <link rel="icon" type="image/png" href="../assets/logo/<?= $maintenance['system_image'] ?>">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            background-color: #991b1c;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .card {
            background: white;
            border: 1px solid #991b1c;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            width: 360px;
        }

        .card-header {
            background-color: #991b1c;
            color: white;
            font-size: 24px;
            font-weight: bold;
            padding: 0.75rem;
            text-align: center;
            border-radius: 8px 8px 0 0;
            margin: -2rem -2rem 1.5rem -2rem;
        }

        .btn-custom {
            background-color: #991b1c;
            border-color: #991b1c;
            color: white;
        }

        .btn-custom:hover {
            background-color: #7e1617;
            border-color: #7e1617;
        }

        #status_message {
            display: block;
            text-align: center;
            margin-bottom: 10px;
            color: #991b1c;
        }
    </style>

    <script>
        function send_email() {
            const email = document.getElementById('email').value.trim();
            const statusSpan = document.getElementById('status_message');
            const submitButton = document.getElementById('submit_button');

            // Email validation
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailPattern.test(email)) {
                alert('Please enter a valid email address.');
                return;
            }

            statusSpan.textContent = 'Do not close this window. Sending email...';
            submitButton.disabled = true;

            let myForm = new FormData();
            myForm.append('email', email);

            $.ajax({
                url: '../email/forgot.php',
                type: "POST",
                data: myForm,
                contentType: false,
                processData: false,
                success: function(response) {
                    statusSpan.textContent = '';
                    submitButton.disabled = false;
                    if (response.trim() === 'success') {
                        alert('Password reset email has been sent.');
                        location.reload();
                    } else {
                        alert('Failed to send email: ' + response);
                    }
                },
                error: function() {
                    statusSpan.textContent = '';
                    submitButton.disabled = false;
                    alert('Error processing request. Please try again.');
                }
            });
        }
    </script>
</head>

<body>
    <div class="card">
        <div class="card-header">
            Forgot Password
        </div>
        <div class="card-body">
            <p class="text-center text-gray-700 mb-4 text-sm">Enter the email address associated with your account and we’ll send you a link to reset your password.</p>

            <span id="status_message"></span>

            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                <input id="email" type="text" name="email"
                    class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required autofocus placeholder="Enter your email">
            </div>

            <button type="button" id="submit_button" onclick="send_email();"
                class="w-full py-3 px-4 rounded-lg shadow-md text-sm font-semibold text-white bg-red-800 hover:bg-red-900 transition duration-200">
                Submit
            </button>

            <div class="text-center mt-4">
                <a href="../" class="text-sm text-red-700 hover:underline">Back to Login</a>
            </div>
        </div>
    </div>
</body>

</html>