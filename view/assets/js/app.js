

$(document).on('change', '#repair_assets', function (e) {
    e.preventDefault();

    let asset_id = $(this).data('asset_id');
    let update_assets_status = $(this).val();

    console.log(update_assets_status);

    Swal.fire({
        title: 'Are you sure?',
        text: `${update_assets_status} this`, // Corrected template literal
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'backend/end-points/controller.php',
                type: 'POST',
                data: {
                    asset_id: asset_id,
                    update_assets_status: update_assets_status,
                    requestType: 'update_assets_status'
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 200) {
                        Swal.fire(
                            'Success!',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function () {
                    Swal.fire(
                        'Error!',
                        'There was a problem with the request.',
                        'error'
                    );
                }
            });
        }
    });
});


$("#frmUpdatePassword").submit(function (e) {
    e.preventDefault();
    $('.spinner').show();

    let password = $("#password").val();
    let cpassword = $("#cpassword").val();
    let email = $("#email").val();
    let fullname = $("#fullname").val();
    let nickname = $("#nickname").val();

    var fileInput = $("input[name='user_image']")[0];

    // Check if file is selected
    if (fileInput.files.length > 0) {
        var userImage = fileInput.files[0]; // <-- this is the uploaded file

        console.log("Filename:", userImage.name);
        console.log("File type:", userImage.type);
        console.log("File size (bytes):", userImage.size);
    } else {
        console.log("No file selected.");
    }
    // Check for empty fields
    if (!password || !cpassword || !email || !fullname || !nickname) {
        alertify.error("Password fields cannot be empty!");
        $('.spinner').hide();
        return;
    }

    // Check if passwords match
    if (password !== cpassword) {
        alertify.error("Passwords do not match!");
        $('.spinner').hide();
        return;
    }

    var formData = new FormData(this);
    formData.append('requestType', 'UpdatePassword');

    $.ajax({
        type: "POST",
        url: "backend/end-points/controller.php",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json", // Expect JSON response
        beforeSend: function () {
            $("#submitBtn").prop("disabled", true).text("Processing...");
        },
        success: function (response) {
            console.log(response); // Debugging

            if (response.status === 200) {
                alertify.success(response.message);
                setTimeout(function () { location.reload(); }, 1000);
            } else {
                $('.spinner').hide();
                alertify.error(response.message);
            }
        },
        complete: function () {
            $("#submitBtn").prop("disabled", false).text("Save Changes");
        }
    });
});

















// Close modal functionality
$('.togglerUpdateRecieved').click(function () {
    let recieved_id = $(this).data('recieved_id');
    let recieved_assets_name = $(this).data('recieved_assets_name');
    let recieved_description = $(this).data('recieved_description');
    let recieved_supplier_name = $(this).data('recieved_supplier_name');
    let recieved_supplier_company = $(this).data('recieved_supplier_company');
    let recieved_assets_qty = $(this).data('recieved_assets_qty');

    $("#update_log_id").val(recieved_id);
    $("#update_asset_name").val(recieved_assets_name);
    $("#update_asset_description").val(recieved_description);
    $("#update_asset_supplier_name").val(recieved_supplier_name);
    $("#update_asset_supplier_company").val(recieved_supplier_company);
    $("#update_asset_qty").val(recieved_assets_qty);
    $('#updateLogsModal').fadeIn();
});


$('.updateLogsModalClose').click(function (e) {
    e.preventDefault();
    $('#updateLogsModal').fadeOut();
});

// Close Modal when clicking outside the modal content
$("#updateLogsModal").click(function (event) {
    if ($(event.target).is("#updateLogsModal")) {
        $("#updateLogsModal").fadeOut();
    }
});



$("#updateLogsFrm").submit(function (e) {
    e.preventDefault();
    $('.spinner').show();
    $('#btnUpdateLogs').prop('disabled', true);

    var formData = new FormData(this);
    formData.append('requestType', 'updateLogs');
    $.ajax({
        type: "POST",
        url: "backend/end-points/controller.php",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json", // Expect JSON response
        beforeSend: function () {
            $("#submitBtn").prop("disabled", true).text("Processing...");
        },
        success: function (response) {
            console.log(response); // Debugging

            if (response.status === 200) {
                alertify.success(response.message);
                setTimeout(function () { location.reload(); }, 1000);
            } else {
                $('.spinner').hide();
                $('#btnUpdateLogs').prop('disabled', false);
                alertify.error(response.message);
            }
        },
        complete: function () {
            $("#submitBtn").prop("disabled", false).text("Submit");
        }
    });
});




$("#recordLogsFrm").submit(function (e) {
    e.preventDefault();
    $('.spinner').show();
    $('#btnRecordLogs').prop('disabled', true);

    var formData = new FormData(this);
    formData.append('requestType', 'recordLogs');
    $.ajax({
        type: "POST",
        url: "backend/end-points/controller.php",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json", // Expect JSON response
        beforeSend: function () {
            $("#submitBtn").prop("disabled", true).text("Processing...");
        },
        success: function (response) {
            console.log(response); // Debugging

            if (response.status === 200) {
                alertify.success(response.message);
                setTimeout(function () { location.reload(); }, 1000);
            } else {
                $('.spinner').hide();
                $('#btnRecordLogs').prop('disabled', false);
                alertify.error(response.message);
            }
        },
        complete: function () {
            $("#submitBtn").prop("disabled", false).text("Submit");
        }
    });
});


$("#supplierFrm").submit(function (e) {
    e.preventDefault();
    $('.spinner').show();
    $('#btnSupplier').prop('disabled', true);

    var formData = new FormData(this);
    formData.append('requestType', 'addSupplier');

    $.ajax({
        type: "POST",
        url: "backend/end-points/controller.php",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        beforeSend: function () {
            $("#btnSupplier").prop("disabled", true).text("Processing...");
        },
        success: function (response) {
            console.log(response);

            if (response.status === 200) {
                alertify.success(response.message);
                setTimeout(function () { location.reload(); }, 1000);
            } else {
                $('.spinner').hide();
                $('#btnSupplier').prop('disabled', false);
                alertify.error(response.message);
            }
        },
        complete: function () {
            $("#btnSupplier").prop("disabled", false).text("Add Supplier");
        }
    });
});

















$('.togglerUpdateAssets').click(function (e) {
    e.preventDefault();

    let id = $(this).data('id');
    let asset_code = $(this).data('asset_code');
    let name = $(this).data('name');
    let qty = $(this).data('qty');
    let description = $(this).data('description');
    let price = $(this).data('price');
    let category_id = $(this).data('category_id');
    let subcategory_id = $(this).data('subcategory_id');
    let condition_status = $(this).data('condition_status');
    let office_id = $(this).data('office_id');
    let status = $(this).data('status');
    let variety = $(this).data('variety'); // This is the variety data, which might already be an object

    console.log(id);
    console.log(variety);

    // Check if the variety data is already an object or a string
    let parsedVariety = (typeof variety === 'string') ? JSON.parse(variety) : variety;

    // Set values in the modal form
    $("#assets_id").val(id);
    $("#update_assets_code").val(asset_code);
    $("#update_assets_name").val(name);
    $("#update_qty").val(qty);
    $("#update_assets_description").val(description);
    $("#update_assets_price").val(price);
    $("#update_assets_category").val(category_id);
    $("#update_assets_subcategory").val(subcategory_id);
    $("#update_assets_condition").val(condition_status);
    $("#update_assets_Office").val(office_id);
    $("#update_assets_status").val(status);

    // Display the variety name in the input field
    if (parsedVariety && parsedVariety.name) {
        $("#update_assets_variety_name").val(parsedVariety.name);
    }

    // Clear the previous variety values
    $(".update_assets_variety_values").empty();

    // Display the variety values as input fields
    if (parsedVariety && parsedVariety.values) {
        parsedVariety.values.forEach((value, index) => {
            let newInputGroup = $('<div class="input-group mb-2 flex items-center"></div>');
            let inputField = $('<input type="text" name="assets_variety_value[]" class="w-full p-2 border rounded-md" value="' + value + '" required>');
            let removeButton = $('<button type="button" class="remove-btn p-1 bg-transparent text-red-500 text-lg font-bold border-none">X</button>');

            // Append the input field and remove button into the input group
            newInputGroup.append(inputField);
            newInputGroup.append(removeButton);

            // Add the new input group to the container
            $('.update_assets_variety_values').append(newInputGroup);

            // Attach click event to the remove button
            removeButton.click(function () {
                newInputGroup.remove();  // Remove the entire input group (input + button)
            });
        });
    }

    // Show the modal
    $('#updateAssetsModal').fadeIn();
});



$('.add-variety-value').on('click', function () {
    // Create the new input field
    const newInput = $('<input type="text" name="assets_variety_value[]" class="w-full p-2 mb-2 border rounded-md" required>');

    // Create the remove button
    const removeButton = $('<button type="button" class="remove-btn p-1 bg-transparent text-red-500 text-lg font-bold border-none">X</button>');

    // Append the new input field and the remove button inside a wrapper div
    const inputWrapper = $('<div class="input-wrapper mb-2 flex items-center"></div>');
    inputWrapper.append(newInput);
    inputWrapper.append(removeButton);

    // Append the input wrapper (containing both input and remove button) to the container
    $('#variety-values-container').append(inputWrapper);

    // Attach the click event for the remove button
    removeButton.on('click', function () {
        inputWrapper.remove();  // Remove the whole input wrapper (input and button)
    });
});



$('.add-variety-value').on('click', function () {
    // Create a wrapper div for each new input field
    const newInputGroup = $('<div class="input-group mb-2 flex items-center"></div>');

    // Create the input field
    const newInputField = $('<input type="text" name="assets_variety_value[]" class="w-full p-2 mb-2 border rounded-md" required>');

    // Create the remove button
    const removeButton = $('<button type="button" class="remove-btn p-1 bg-transparent text-red-500 text-lg font-bold border-none">X</button>');

    // Append the input field and remove button into the input group
    newInputGroup.append(newInputField);
    newInputGroup.append(removeButton);

    // Append the new input group to the variety values container
    $('#update_assets_variety_values').append(newInputGroup);

    // Attach the click event to remove the input group
    removeButton.on('click', function () {
        newInputGroup.remove(); // Remove the entire input group (input + button)
    });
});






// Close modal functionality
$('.updateUserModalClose').click(function () {
    $('#updateAssetsModal').fadeOut();
});


$('.addUserModalClose').click(function (e) {
    e.preventDefault();
    $('#updateAssetsModal').fadeOut();
});

// Close Modal when clicking outside the modal content
$("#updateAssetsModal").click(function (event) {
    if ($(event.target).is("#updateAssetsModal")) {
        $("#updateAssetsModal").fadeOut();
    }
});




$('#addAssetsButton').click(function (e) {
    e.preventDefault();
    $('#addAssetsModal').fadeIn();
});

$('.addUserModalClose').click(function (e) {
    e.preventDefault();
    $('#addAssetsModal').fadeOut();
});

// Close Modal when clicking outside the modal content
$("#addAssetsModal").click(function (event) {
    if ($(event.target).is("#addAssetsModal")) {
        $("#addAssetsModal").fadeOut();
    }
});








$('#CreateRequestButton').click(function (e) {
    e.preventDefault();
    $('#CreateRequestModal').fadeIn();
});

$('.addUserModalClose').click(function (e) {
    e.preventDefault();
    $('#CreateRequestModal').fadeOut();
});

// Close Modal when clicking outside the modal content
$("#CreateRequestModal").click(function (event) {
    if ($(event.target).is("#CreateRequestModal")) {
        $("#CreateRequestModal").fadeOut();
    }
});










$('#adduserButton').click(function (e) {
    e.preventDefault();
    $('#addUserModal').fadeIn();
});

$('.addUserModalClose').click(function (e) {
    e.preventDefault();
    $('#addUserModal').fadeOut();
});

// Close Modal when clicking outside the modal content
$("#addUserModal").click(function (event) {
    if ($(event.target).is("#addUserModal")) {
        $("#addUserModal").fadeOut();
    }
});








$('.togglerUpdateUser').click(function (e) {
    var id = $(this).data('id');
    var user_id = $(this).data('user_id');
    var user_fullname = $(this).data('fullname');
    var user_nickname = $(this).data('nickname');
    var user_email = $(this).data('email');
    var user_role = $(this).data('role');
    var user_designation = $(this).data('designation');


    console.log(user_id);

    $('#update_id').val(id)
    $('#update_user_id').val(user_id)
    $('#update_user_fullname').val(user_fullname)
    $('#update_user_nickname').val(user_nickname)
    $('#update_user_email').val(user_email)
    $('#update_user_type').val(user_role)
    $('#update_user_designation').val(user_designation)


    e.preventDefault();
    $('#updateUserModal').fadeIn();
});

$('.UpdateBranchModalClose').click(function (e) {
    e.preventDefault();
    $('#updateUserModal').fadeOut();
});

// Close Modal when clicking outside the modal content
$("#updateUserModal").click(function (event) {
    if ($(event.target).is("#updateUserModal")) {
        $("#updateUserModal").fadeOut();
    }
});








$("#frmAddTocart").submit(function (e) {
    e.preventDefault();

    let variety = $("#variety").val();
    let qty = $("#qty").val();
    let varietyName = $("#varietyName").val();

    if (!qty || qty <= 0) {
        alertify.error("Enter a valid quantity");
        return;
    }

    console.log(variety);

    if (!variety) {
        const capitalizedVarietyName = varietyName.charAt(0).toUpperCase() + varietyName.slice(1);
        alertify.error(`Select ${capitalizedVarietyName} is required`);
        return;
    }

    $('#BtnaddToCart').prop('disabled', true);

    var formData = new FormData(this);
    formData.append('requestType', 'AddCart');

    $.ajax({
        type: "POST",
        url: "backend/end-points/controller.php",
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            $('#BtnaddToCart').prop('disabled', false);

            if (response.status == 200) {
                location.reload();
            } else {
                alertify.error(response.message);
            }
        }
    });
});







$("#frmMaintenance").submit(function (e) {
    e.preventDefault();

    $('.spinner').show();
    $('#BtnMaintenance').prop('disabled', true);

    var formData = new FormData(this);
    formData.append('requestType', 'UpdateMaintenance');

    $.ajax({
        type: "POST",
        url: "backend/end-points/controller.php",
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            $('.spinner').hide();
            $('#BtnMaintenance').prop('disabled', false);

            if (response.status == 200) {
                alertify.success('Update Successful');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                alertify.error('Sending failed, please try again.');
            }
        }
    });
});












$("#updateUserForm").submit(function (e) {
    e.preventDefault();

    $('.spinner').show();
    $('#btnUpdateUser').prop('disabled', true);

    var formData = new FormData(this);
    formData.append('requestType', 'UpdateUser');

    $.ajax({
        type: "POST",
        url: "backend/end-points/controller.php",
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            $('.spinner').hide();
            $('#btnUpdateUser').prop('disabled', false);

            if (response.status == 200) {
                alertify.success('Update Successful');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                alertify.error('Sending failed, please try again.');
            }
        }
    });
});





$("#addAssetFrm").submit(function (e) {
    e.preventDefault();
    $('.spinner').show();
    $('#btnAddAssets').prop('disabled', true);

    var formData = new FormData(this);
    formData.append('requestType', 'AddAssets');
    $.ajax({
        type: "POST",
        url: "backend/end-points/controller.php",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json", // Expect JSON response
        beforeSend: function () {
            $("#submitBtn").prop("disabled", true).text("Processing...");
        },
        success: function (response) {
            console.log(response); // Debugging

            if (response.status === 200) {
                alertify.success(response.message);
                setTimeout(function () { location.reload(); }, 1000);
            } else {
                $('.spinner').hide();
                $('#btnAddAssets').prop('disabled', false);
                alertify.error(response.message);
            }
        },
        complete: function () {
            $("#submitBtn").prop("disabled", false).text("Submit");
        }
    });
});






$("#updateAssetFrm").submit(function (e) {
    e.preventDefault();


    $('.spinner').show();
    $('#btnUpdateAssets').prop('disabled', true);

    var formData = new FormData(this);
    formData.append('requestType', 'UpdateAssets');
    $.ajax({
        type: "POST",
        url: "backend/end-points/controller.php",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json", // Expect JSON response
        beforeSend: function () {
            $("#btnUpdateAssets").prop("disabled", true).text("Processing...");
        },
        success: function (response) {
            console.log(response); // Debugging

            if (response.status === 200) {
                alertify.success(response.message);
                setTimeout(function () { location.reload(); }, 1000);
            } else {
                $('.spinner').hide();
                $('#btnUpdateAssets').prop('disabled', false);
                alertify.error(response.message);
            }
        },
        complete: function () {
            $("#btnUpdateAssets").prop("disabled", false).text("Submit");
        }
    });
});









$("#adduserForm").submit(function (e) {
    e.preventDefault();


    $('.spinner').show();
    $('#btnAdduser').prop('disabled', true);

    var formData = new FormData(this);
    formData.append('requestType', 'Adduser');
    $.ajax({
        type: "POST",
        url: "backend/end-points/controller.php",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json", // Expect JSON response
        beforeSend: function () {
            $("#submitBtn").prop("disabled", true).text("Processing...");
        },
        success: function (response) {
            console.log(response); // Debugging

            if (response.status === 200) {
                alertify.success(response.message);
                setTimeout(function () { location.reload(); }, 1000);
            } else {
                $('.spinner').hide();
                $('#btnAdduser').prop('disabled', false);
                alertify.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", xhr.responseText); // Log detailed error response
            alertify.error("Something went wrong. Please try again.");
        },
        complete: function () {
            $("#submitBtn").prop("disabled", false).text("Submit");
        }
    });
});







$(document).on('click', '.togglerDeleteAssets', function (e) {
    e.preventDefault();
    var assets_id = $(this).data('id');

    console.log(assets_id);

    Swal.fire({
        title: 'Are you sure?',
        text: 'Delete This Record',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "backend/end-points/controller.php",
                type: 'POST',
                data: { assets_id: assets_id, requestType: 'DeleteAssets' },
                dataType: 'json',  // Expect a JSON response
                success: function (response) {
                    if (response.status === 200) {
                        Swal.fire(
                            'Deleted!',
                            response.message,  // Show the success message from the response
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,  // Show the error message from the response
                            'error'
                        );
                    }
                },
                error: function () {
                    Swal.fire(
                        'Error!',
                        'There was a problem with the request.',
                        'error'
                    );
                }
            });
        }
    });
});





$(document).on('click', '.togglerDeleteUser', function (e) {
    e.preventDefault();
    var userId = $(this).data('id');

    console.log(userId);

    Swal.fire({
        title: 'Are you sure?',
        text: 'Deactivate This',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "backend/end-points/controller.php",
                type: 'POST',
                data: { userId: userId, requestType: 'DeleteUser' },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 200) {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function () {
                    Swal.fire(
                        'Error!',
                        'There was a problem with the request.',
                        'error'
                    );
                }
            });
        }
    });
});










$(document).on('click', '.togglerRestoreUser', function (e) {
    e.preventDefault();
    var userId = $(this).data('id');

    console.log(userId);

    Swal.fire({
        title: 'Are you sure?',
        text: 'Activate This',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "backend/end-points/controller.php",
                type: 'POST',
                data: { userId: userId, requestType: 'RestoreUser' },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 200) {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function () {
                    Swal.fire(
                        'Error!',
                        'There was a problem with the request.',
                        'error'
                    );
                }
            });
        }
    });
});





$(document).on('change', '.togglerRequest', function (e) {
    e.preventDefault();

    var request_id = $(this).data('request_id');
    console.log(request_id);
    var action = $(this).val(); // Get action type (Approve/Decline)

    // Modify your confirmation text and success message based on the selected action
    var confirmText = action === 'Approve' ? 'Approve this request?' :
        action === 'Decline' ? 'Decline this request?' :
            action === 'Ongoing' ? 'Mark this request as ongoing?' :
                action === 'Recieved' ? 'Mark this request as received?' : '';

    var successMessage = action === 'Approve' ? 'Request Approved!' :
        action === 'Decline' ? 'Request Declined!' :
            action === 'Ongoing' ? 'Request is now ongoing!' :
                action === 'Recieved' ? 'Request marked as received!' : '';

    Swal.fire({
        title: 'Are you sure?',
        text: confirmText,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, proceed!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "backend/end-points/controller.php",
                type: 'POST',
                data: { request_id: request_id, action: action, requestType: 'UpdateReqStatus' },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 200) {
                        Swal.fire(
                            'Success!',
                            successMessage,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                }
            });
        }
    });
});








// LOGOUT HERE
$(document).on('click', '.btnLogout', function (e) {
    e.preventDefault();
    var assets_id = $(this).data('id');

    console.log(assets_id);

    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to logout',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'logout.php';

        }
    });
});













// Archive HERE
$(document).on('click', '.btnArchive', function (e) {
    e.preventDefault();
    var request_id = $(this).data('request_id');

    console.log(request_id);

    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to archive this',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
    }).then((result) => {
        $.ajax({
            url: "backend/end-points/controller.php",
            type: 'POST',
            data: { request_id: request_id, requestType: 'ArchiveRequest' },
            dataType: 'json',
            success: function (response) {
                if (response.status === 200) {
                    Swal.fire(
                        'Success!',
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        response.message,
                        'error'
                    );
                }
            }
        });
    });
});
