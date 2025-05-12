
$("#frmLogin").submit(function (e) {
  e.preventDefault();

  let email = $("#email").val().trim();
  let password = $("#password").val().trim();

  // Validate email
  if (!email) {
    alertify.error("username is required");
    return;
  }

  // Validate Password
  if (!password) {
    alertify.error("Password is required");
    return;
  }



  $('.spinner').show();
  $('#btnLoginGuidance').prop('disabled', true);

  var formData = $(this).serializeArray();
  formData.push({ name: 'requestType', value: 'Login' });
  var serializedData = $.param(formData);

  // Perform the AJAX request
  $.ajax({
    type: "POST",
    url: "backend/end-points/controller.php",
    data: serializedData,
    success: function (response) {
      var data = JSON.parse(response);
      console.log(response);

      if (data.status === "success") {
        alertify.success('Login Successful');

        // Redirect to the correct page dynamically
        setTimeout(function () {
          window.location.href = data.redirect;
        }, 2000);

      } else if (data.status === "error") {
        console.log(data);
        $('.spinner').hide();
        $('#btnLoginGuidance').prop('disabled', false);
        alertify.error(data.message);
      } else {
        $('.spinner').hide();
        $('#btnLoginGuidance').prop('disabled', false);
        console.error(response);
        alertify.error(data.message);
      }
    },
    error: function () {
      $('.spinner').hide();
      $('#btnLoginGuidance').prop('disabled', false);
      alertify.error('Server error, please try again later.');
    }
  });
});















$("#frmForgotPassword").submit(function (e) {
  e.preventDefault();

  $('#spinner').show();
  $('#btnForgotPassword').prop('disabled', true);

  var formData = $(this).serializeArray();
  formData.push({ name: 'requestType', value: 'ForgotPassword' });
  var serializedData = $.param(formData);

  // Perform the AJAX request
  $.ajax({
    type: "POST",
    url: "backend/end-points/controller.php",
    data: serializedData,
    success: function (response) {
      console.log(response);
      var data = JSON.parse(response);
      console.log(data);
      if (data.status === "EmailNotExists") {
        alertify.error(data.message);
        $('#spinner').hide();
        $('#btnForgotPassword').prop('disabled', false);
      } else if (data.status === "EmailExist") {
        sendforgotEmail(data.data.id, data.data.fullname, data.data.email);
      } else {
        $('#spinner').hide();
        $('#btnForgotPassword').prop('disabled', false);
        console.error(response);
        alertify.error('Registration failed, please try again.');
      }
    },
    error: function () {
      $('#spinner').hide();
      $('#btnForgotPassword').prop('disabled', false);
      alertify.error('An error occurred. Please try again.');
    }
  });
});


function sendforgotEmail(userID, fullName, Email) {
  $('#btnRegister').prop('disabled', true);
  $('#spinner').show();

  $.ajax({
    type: "POST",
    url: "ForgotPasswordMailer.php",
    data: {
      userID: userID,
      fullName: fullName,
      Email: Email
    },
    dataType: "json",  // Set the expected response data type to JSON
    success: function (emailResponse) {
      console.log("Response from server:", emailResponse);

      // Check if the response indicates success
      if (emailResponse.status == "success") {  // Update to match the 'success' status from your PHP response
        alertify.success('Your new password has been sent to your email successfully!');
        setTimeout(function () {
          window.location.href = "index";
        }, 2000);
      } else {
        alertify.error('There was an issue sending the email. Please try again.');
      }
    },
    complete: function () {
      $('#spinner').hide();
      $('#btnRegister').prop('disabled', false);
    }
  });


}