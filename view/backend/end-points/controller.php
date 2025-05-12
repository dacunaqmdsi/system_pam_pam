<?php
include('../class.php');


$db = new global_class();



$product_Category = $product_Promo = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['requestType'] == 'Adduser') {

        $uploadDir = "../../../uploads/images/";

        function generateUniqueFilename($file, $prefix)
        {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            return $prefix . '_' . uniqid() . '.' . $ext;
        }

        function handleFileUpload($file, $uploadDir, $prefix)
        {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            $maxFileSize = 10 * 1024 * 1024; // 10MB

            if ($file['error'] !== UPLOAD_ERR_OK) {
                return null;
            }

            // Ensure the temp file exists before checking MIME type
            if (!file_exists($file['tmp_name'])) {
                return null;
            }

            if (!in_array(mime_content_type($file['tmp_name']), $allowedTypes)) {
                return null;
            }

            if ($file['size'] > $maxFileSize) {
                return null;
            }

            $fileName = generateUniqueFilename($file, $prefix);
            $destination = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $fileName;
            }
            return null;
        }

        $user_image = $_FILES['user_image'] ?? null;

        // NEW FILE NAME with Prefix
        $user_imageName = $user_image ? handleFileUpload($user_image, $uploadDir, "Profile") : null;

        $userId = htmlspecialchars(trim($_POST['add_user_id']));
        $user_fullname = htmlspecialchars(trim($_POST['user_fullname']));
        $user_nickname = htmlspecialchars(trim($_POST['user_nickname']));
        // $user_email = filter_var(trim($_POST['user_email']), FILTER_SANITIZE_EMAIL);
        $user_email = htmlspecialchars(trim($_POST['user_email']));
        $email_official = htmlspecialchars(trim($_POST['email_official']));

        $user_password = trim($_POST['user_password']);
        // $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
        $hashed_password = $user_password;

        $user_type = $_POST['user_type'];
        $user_designation = $_POST['user_designation'];

        // if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        //     echo json_encode(["status" => 400, "message" => "Invalid email format"]);
        //     exit;
        // }

        $result = $db->Adduser($userId, $user_imageName, $user_fullname, $user_nickname, $user_email, $user_type, $user_password, $user_designation, $email_official);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "User successfully registered"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else if ($_POST['requestType'] == 'UpdateUser') {

        $uploadDir = "../../../uploads/images/";

        function generateUniqueFilename($file, $prefix)
        {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            return $prefix . '_' . uniqid() . '.' . $ext;
        }

        function handleFileUpload($file, $uploadDir, $prefix)
        {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            $maxFileSize = 10 * 1024 * 1024; // 10MB

            if ($file['error'] !== UPLOAD_ERR_OK) {
                return null;
            }

            // Ensure the temp file exists before checking MIME type
            if (!file_exists($file['tmp_name'])) {
                return null;
            }

            if (!in_array(mime_content_type($file['tmp_name']), $allowedTypes)) {
                return null;
            }

            if ($file['size'] > $maxFileSize) {
                return null;
            }

            $fileName = generateUniqueFilename($file, $prefix);
            $destination = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $fileName;
            }
            return null;
        }

        $user_image = $_FILES['user_image'] ?? null;


        // NEW FILE NAME with Prefix
        $user_imageName = $user_image ? handleFileUpload($user_image, $uploadDir, "Profile") : null;


        $user_fullname = htmlspecialchars(trim($_POST['user_fullname']));
        $user_nickname = htmlspecialchars(trim($_POST['user_nickname']));
        $user_email = trim($_POST['user_email']);

        $user_password = trim($_POST['user_password']);
        $hashed_password =  $user_password;

        $user_type = $_POST['user_type'];
        $user_designation = $_POST['user_designation'];
        $update_id = $_POST['update_id'];
        $userId = $_POST['update_user_id'];

        $result = $db->updateUser($userId, $update_id, $user_imageName, $user_fullname, $user_nickname, $user_email, $user_type, $user_password, $user_designation);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "User successfully registered"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else if ($_POST['requestType'] == 'DeleteUser') {


        $userId = $_POST['userId'];

        $result = $db->DeleteUser($userId);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Delete Successfully"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else if ($_POST['requestType'] == 'UpdateReqStatus') {


        $request_id = $_POST['request_id'];
        $action = $_POST['action'];

        $result = $db->UpdateReqStatus($request_id, $action);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "$action Successful"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else if ($_POST['requestType'] == 'CreateRequest') {


        $add_user_id = htmlspecialchars(trim($_POST['add_user_id']));
        $user_fullname = htmlspecialchars(trim($_POST['user_fullname']));
        $user_designation = htmlspecialchars(trim($_POST['user_designation']));
        $cat_assets_id = htmlspecialchars(trim($_POST['cat_assets_id']));
        $supplier_name = htmlspecialchars(trim($_POST['supplier_name']));
        $assets_quantity = htmlspecialchars(trim($_POST['assets_quantity']));
        $supplier_company = htmlspecialchars(trim($_POST['supplier_company']));

        $result = $db->CreateRequest($add_user_id, $cat_assets_id, $assets_quantity, $supplier_name, $supplier_company);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Successfully Added"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else if ($_POST['requestType'] == 'AddAssets') {
        $uploadDir = "../../../uploads/images/";

        function generateUniqueFilename($file, $prefix)
        {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            return $prefix . '_' . uniqid() . '.' . $ext;
        }

        function handleFileUpload($file, $uploadDir, $prefix)
        {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            $maxFileSize = 10 * 1024 * 1024; // 10MB

            if ($file['error'] !== UPLOAD_ERR_OK || !file_exists($file['tmp_name'])) {
                return null;
            }

            if (!in_array(mime_content_type($file['tmp_name']), $allowedTypes)) {
                return null;
            }

            if ($file['size'] > $maxFileSize) {
                return null;
            }

            $fileName = generateUniqueFilename($file, $prefix);
            $destination = $uploadDir . $fileName;

            return move_uploaded_file($file['tmp_name'], $destination) ? $fileName : null;
        }

        // Handle file upload
        $assets_image = $_FILES['assets_img'] ?? null;
        $assets_imageName = $assets_image ? handleFileUpload($assets_image, $uploadDir, "Assets") : null;

        // Sanitize and collect form input values
        $assets_code = htmlspecialchars(trim($_POST['assets_code'] ?? ''));
        $assets_name = htmlspecialchars(trim($_POST['assets_name'] ?? ''));
        $qty = htmlspecialchars(trim($_POST['qty'] ?? ''));
        $assets_Office = htmlspecialchars(trim($_POST['assets_Office'] ?? ''));
        $assets_category = htmlspecialchars(trim($_POST['assets_category'] ?? ''));
        $assets_subcategory = htmlspecialchars(trim($_POST['assets_subcategory'] ?? ''));
        $assets_condition = htmlspecialchars(trim($_POST['assets_condition'] ?? ''));
        $assets_status = htmlspecialchars(trim($_POST['assets_status'] ?? ''));
        $assets_description = htmlspecialchars(trim($_POST['assets_description'] ?? ''));
        $assets_price = htmlspecialchars(trim($_POST['assets_price'] ?? ''));

        // Optional fields
        $size = htmlspecialchars(trim($_POST['size'] ?? ''));
        $brand = htmlspecialchars(trim($_POST['brand'] ?? ''));
        $unit = htmlspecialchars(trim($_POST['unit'] ?? ''));
        $paper_type = htmlspecialchars(trim($_POST['paper_type'] ?? ''));
        $thickness = htmlspecialchars(trim($_POST['thickness'] ?? ''));

        $assets_variety_name = htmlspecialchars(trim($_POST['assets_variety_name'] ?? ''));
        $assets_variety_values = $_POST['assets_variety_value'] ?? [];

        $variety_json = (!empty($assets_variety_name) && !empty($assets_variety_values))
            ? json_encode(['name' => $assets_variety_name, 'values' => $assets_variety_values], JSON_UNESCAPED_UNICODE)
            : null;

        // Determine which method to call based on is_item
        $is_item = $_POST['is_item'] ?? false;

        $result = $is_item
            ? $db->AddAssets2(
                $assets_imageName,
                $assets_code,
                $assets_name,
                $assets_Office,
                $assets_category,
                $assets_subcategory,
                $assets_condition,
                $assets_status,
                $assets_description,
                $assets_price,
                $variety_json,
                $size,
                $brand,
                $unit,
                $paper_type,
                $thickness,
                $qty
            )
            : $db->AddAssets(
                $assets_imageName,
                $assets_code,
                $assets_name,
                $assets_Office,
                $assets_category,
                $assets_subcategory,
                $assets_condition,
                $assets_status,
                $assets_description,
                $assets_price,
                $variety_json,
                $size,
                $brand,
                $unit,
                $paper_type,
                $thickness,
                $qty
            );

        echo json_encode([
            "status" => $result === "success" ? 200 : 400,
            "message" => $result === "success" ? "Successfully Added" : $result
        ]);
    } else if ($_POST['requestType'] == 'UpdateAssets') {

        $uploadDir = "../../../uploads/images/";

        function generateUniqueFilename($file, $prefix)
        {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            return $prefix . '_' . uniqid() . '.' . $ext;
        }

        function handleFileUpload($file, $uploadDir, $prefix)
        {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            $maxFileSize = 10 * 1024 * 1024; // 10MB

            if ($file['error'] !== UPLOAD_ERR_OK) {
                return null;
            }

            // Ensure the temp file exists before checking MIME type
            if (!file_exists($file['tmp_name'])) {
                return null;
            }

            if (!in_array(mime_content_type($file['tmp_name']), $allowedTypes)) {
                return null;
            }

            if ($file['size'] > $maxFileSize) {
                return null;
            }

            $fileName = generateUniqueFilename($file, $prefix);
            $destination = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $fileName;
            }
            return null;
        }

        $assets_image = $_FILES['assets_img'] ?? null;

        // NEW FILE NAME with Prefix
        $assets_imageName = $assets_image ? handleFileUpload($assets_image, $uploadDir, "Assets") : null;

        $assets_id = htmlspecialchars(trim($_POST['assets_id']));
        $assets_code = htmlspecialchars(trim($_POST['assets_code']));
        $assets_name = htmlspecialchars(trim($_POST['assets_name']));
        $update_qty = htmlspecialchars(trim($_POST['update_qty']));
        $assets_Office = htmlspecialchars(trim($_POST['assets_Office']));
        $assets_category = htmlspecialchars(trim($_POST['assets_category']));
        $assets_subcategory = htmlspecialchars(trim($_POST['assets_subcategory']));
        $assets_condition = htmlspecialchars(trim($_POST['assets_condition']));
        $assets_status = htmlspecialchars(trim($_POST['assets_status']));
        $assets_description = htmlspecialchars(trim($_POST['assets_description']));
        $assets_price = htmlspecialchars(trim($_POST['assets_price']));


        $assets_variety_name = htmlspecialchars(trim($_POST['assets_variety_name'] ?? ''));
        $assets_variety_values = isset($_POST['assets_variety_value']) ? $_POST['assets_variety_value'] : [];

        if (!empty($assets_variety_name) && !empty($assets_variety_values)) {
            $variety_json = json_encode([
                'name' => $assets_variety_name,
                'values' => $assets_variety_values
            ], JSON_UNESCAPED_UNICODE);
        } else {
            $variety_json = null;
        }



        $result = $db->UpdateAssets($assets_id, $assets_imageName, $assets_code, $assets_name, $assets_Office, $assets_category, $assets_subcategory, $assets_condition, $assets_status, $assets_description, $assets_price, $variety_json, $update_qty);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Successfully Added"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else if ($_POST['requestType'] == 'DeleteAssets') {


        $assets_id = $_POST['assets_id'];

        $result = $db->DeleteAssets($assets_id);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Delete Successfully"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else if ($_POST['requestType'] == 'UpdateMaintenance') {

        $uploadDir = "../../../assets/logo/";

        function generateUniqueFilename($file, $prefix)
        {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            return $prefix . '_' . uniqid() . '.' . $ext;
        }

        function handleFileUpload($file, $uploadDir, $prefix)
        {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            $maxFileSize = 10 * 1024 * 1024; // 10MB

            if ($file['error'] !== UPLOAD_ERR_OK) {
                return null;
            }

            // Ensure the temp file exists before checking MIME type
            if (!file_exists($file['tmp_name'])) {
                return null;
            }

            if (!in_array(mime_content_type($file['tmp_name']), $allowedTypes)) {
                return null;
            }

            if ($file['size'] > $maxFileSize) {
                return null;
            }

            $fileName = generateUniqueFilename($file, $prefix);
            $destination = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $fileName;
            }
            return null;
        }

        $system_logo = $_FILES['system_logo'] ?? null;

        $system_logoName = $system_logo ? handleFileUpload($system_logo, $uploadDir, "Assets") : null;

        $system_name = htmlspecialchars($_POST['system_name']);

        $result = $db->UpdateMaintenance($system_logoName, $system_name);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Successfully Added"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else if ($_POST['requestType'] == 'AddCart') {

        session_start();
        $add_id = intval($_SESSION['id']);
        $asset_id = $_POST['asset_id'];
        $qty = $_POST['qty'];
        $variety = $_POST['variety'];
        $specification = $_POST['specification'];


        // Build Specification JSON
        $specification_name = htmlspecialchars(trim($_POST['specification_name'] ?? ''));
        $specification_values = isset($_POST['specification_name_value']) ? $_POST['specification_name_value'] : [];

        if (!empty($specification_name) && !empty($specification_values)) {
            $specification_array = json_encode([
                'name' => $specification_name,
                'values' => $specification_values
            ], JSON_UNESCAPED_UNICODE);
        } else {
            $specification_array = null; // or '' depending on your DB setup
        }


        $result = $db->AddCart($add_id, $asset_id, $qty, $variety, $specification, $specification_array);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Successfully Added"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else if ($_POST['requestType'] == 'confirmRequest') {
        session_start();
        $add_id = intval($_SESSION['id']);
        $supplier_name = '';
        $supplier_company = '';
        $designation = '';
        $role = $_SESSION['role'];
        // $cart_items = $_POST['cart_items'];



        $request_result = $db->confirmRequest($add_id, $supplier_name, $supplier_company, $designation, $role);

        if (isset($request_result['id']) && isset($request_result['invoice'])) {
            $request_id = $request_result['id'];
            $request_invoice = $request_result['invoice'];
            $request_user_id = $request_result['request_user_id'];

            echo json_encode([
                "status" => 200,
                "message" => "Inventory record successfully added",
                "request_id" => $request_id,
                "invoice" => $request_invoice,
            ]);

            // Process cart items only if purchase record was successfully inserted
            if (!empty($_POST['cart_items']) && is_array($_POST['cart_items'])) {
                foreach ($_POST['cart_items'] as $item) {
                    if (isset($item['asset_id']) && isset($item['cart_qty']) && isset($item['cart_id'])) {
                        $cart_id = $item['cart_id'];
                        $asset_id = $item['asset_id'];
                        $price = $item['price'];
                        $cart_qty = $item['cart_qty'];
                        $cart_variety = $item['cart_variety'];
                        $r_specification = $item['specification'];
                        $r_specification_array = $item['specification_array'];

                        // Pass the valid purchase ID
                        $db->addpurchase_item($request_id, $add_id, $cart_id, $asset_id, $price, $cart_qty, $cart_variety,  $r_specification, $r_specification_array);
                    }
                }
            } else {
                echo json_encode(["status" => 400, "message" => "No valid cart items found"]);
            }
        } else {
            echo json_encode(["status" => 400, "message" => $purchase_result['error'] ?? "Failed to add request record"]);
        }
    } else if ($_POST['requestType'] == 'remove_from_cart') {


        $cart_id = $_POST['cart_id'];


        $result = $db->remove_from_cart($cart_id);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Successfully Added"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else if ($_POST['requestType'] == 'recordLogs') {


        session_start();
        $received_by = intval($_SESSION['id']);
        $recieved_number = $_POST['recieved_number'];
        $asset_name = $_POST['asset_name'];
        $asset_description = $_POST['asset_description'];
        $asset_supplier_name = $_POST['asset_supplier_name'];
        $asset_supplier_company = $_POST['asset_supplier_company'];
        $asset_qty = $_POST['asset_qty'];

        $result = $db->recordLogs($received_by, $asset_name, $asset_description, $asset_supplier_name, $asset_supplier_company, $asset_qty, $recieved_number);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Successfully Added"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else if ($_POST['requestType'] == 'updateLogs') {

        session_start();
        $received_by = intval($_SESSION['id']);
        $log_id = $_POST['update_log_id'];
        $asset_name = $_POST['update_asset_name'];
        $asset_description = $_POST['update_asset_description'];
        $asset_supplier_name = $_POST['update_asset_supplier_name'];
        $asset_supplier_company = $_POST['update_asset_supplier_company'];
        $asset_qty = $_POST['update_asset_qty'];

        $result = $db->updateLogs($log_id, $received_by, $asset_name, $asset_description, $asset_supplier_name, $asset_supplier_company, $asset_qty);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Successfully Added"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else if ($_POST['requestType'] == 'ArchiveRequest') {


        $request_id = $_POST['request_id'];

        $result = $db->ArchiveRequest($request_id);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Successful"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else if ($_POST['requestType'] == 'RestoreUser') {


        $userId = $_POST['userId'];

        $result = $db->RestoreUser($userId);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Successful"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else if ($_POST['requestType'] == 'update_assets_status') {


        $asset_id = $_POST['asset_id'];
        $update_assets_status = $_POST['update_assets_status'];

        $result = $db->update_assets_status($asset_id, $update_assets_status);

        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Successful"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else if ($_POST['requestType'] == 'UpdatePassword') {
        session_start();
        $user_id = $_SESSION['id'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $fullname = $_POST['fullname'];
        $nickname = $_POST['nickname'];


        $uploadDir = "../../../uploads/images/";

        function generateUniqueFilename($file, $prefix)
        {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            return $prefix . '_' . uniqid() . '.' . $ext;
        }

        function handleFileUpload($file, $uploadDir, $prefix)
        {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            $maxFileSize = 10 * 1024 * 1024; // 10MB

            if ($file['error'] !== UPLOAD_ERR_OK) {
                return null;
            }

            // Ensure the temp file exists before checking MIME type
            if (!file_exists($file['tmp_name'])) {
                return null;
            }

            if (!in_array(mime_content_type($file['tmp_name']), $allowedTypes)) {
                return null;
            }

            if ($file['size'] > $maxFileSize) {
                return null;
            }

            $fileName = generateUniqueFilename($file, $prefix);
            $destination = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $fileName;
            }
            return null;
        }

        $user_image = $_FILES['user_image'] ?? null;

        // NEW FILE NAME with Prefix
        $user_imageName = $user_image ? handleFileUpload($user_image, $uploadDir, "Profile") : null;


        $result = $db->UpdatePassword($user_id, $password, $email, $fullname, $nickname, $user_imageName);


        if ($result == "success") {
            echo json_encode(["status" => 200, "message" => "Update Successfully"]);
        } else {
            echo json_encode(["status" => 400, "message" => $result]);
        }
    } else {

        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
    }
}
