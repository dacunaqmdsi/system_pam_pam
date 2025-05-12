<?php
include('dbconnect.php');
date_default_timezone_set('Asia/Manila');
$getDateToday = date('Y-m-d H:i:s');


class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }




    public function all_user_request()
    {
        $query = "
        SELECT 
            users.fullname,
            COUNT(*) AS totalRequest
        FROM `request`
        LEFT JOIN users ON users.id = request.request_user_id
        
        GROUP BY users.fullname
    ";

        $result = $this->conn->query($query);

        if ($result) {
            $requestData = [];

            while ($row = $result->fetch_assoc()) {
                // Append the data to the array
                $requestData[] = [
                    'fullname' => $row['fullname'],
                    'totalRequest' => $row['totalRequest']
                ];
            }

            // Return the data as JSON
            echo json_encode($requestData);
        } else {
            error_log('Database query failed: ' . $this->conn->error);
            echo json_encode(['error' => 'Failed to retrieve monthly sales data']);
        }
    }





    public function all_item_request()
    {
        $query = "
        SELECT 
            assets.name,
            COUNT(*) AS totalRequest
        FROM `request_item`
        LEFT JOIN assets ON assets.id = request_item.r_item_asset_id
        
        GROUP BY assets.name
    ";

        $result = $this->conn->query($query);

        if ($result) {
            $requestData = [];

            while ($row = $result->fetch_assoc()) {
                // Append the data to the array
                $requestData[] = [
                    'name' => $row['name'],
                    'totalRequest' => $row['totalRequest']
                ];
            }

            // Return the data as JSON
            echo json_encode($requestData);
        } else {
            error_log('Database query failed: ' . $this->conn->error);
            echo json_encode(['error' => 'Failed to retrieve monthly sales data']);
        }
    }









    public function getDataAnalytics()
    {
        $query = "
            SELECT 
                (SELECT COUNT(*) FROM `users` WHERE status='1') AS totalUser,
                (SELECT COUNT(*) FROM `request`) AS request,
                (SELECT COUNT(*) FROM `assets`) AS totalAssets
        ";

        $result = $this->conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row;
        }
    }



    public function AddAssets(
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
    ) {


        $checkAssetCode = $this->conn->prepare("SELECT asset_code FROM assets WHERE asset_code = ?");
        $checkAssetCode->bind_param("s", $assets_code);
        $checkAssetCode->execute();
        $checkAssetCodeResult = $checkAssetCode->get_result();

        if ($checkAssetCodeResult->num_rows > 0) {
            return "Asset code already exists. Please use a different code.";
        }

        $query = $this->conn->prepare(
            "INSERT INTO `assets` (`asset_code`, `name`, `category_id`, `subcategory_id`, `office_id`, 
                    `price`, `condition_status`, `status`, `image`, `description`, `variety`,
                    `size`, `brand`, `unit`, `paper_type`, `thickness`, `qty`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $query->bind_param(
            "sssssssssssssssss",
            $assets_code,
            $assets_name,
            $assets_category,
            $assets_subcategory,
            $assets_Office,
            $assets_price,
            $assets_condition,
            $assets_status,
            $assets_imageName,
            $assets_description,
            $variety_json,
            $size,
            $brand,
            $unit,
            $paper_type,
            $thickness,
            $qty
        );
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }

    public function AddAssets2(
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
    ) {


        $checkAssetCode = $this->conn->prepare("SELECT asset_code FROM assets_item WHERE asset_code = ?");
        $checkAssetCode->bind_param("s", $assets_code);
        $checkAssetCode->execute();
        $checkAssetCodeResult = $checkAssetCode->get_result();

        if ($checkAssetCodeResult->num_rows > 0) {
            return "Asset code already exists. Please use a different code.";
        }

        $query = $this->conn->prepare(
            "INSERT INTO `assets_item` (`asset_code`, `name`, `category_id`, `subcategory_id`, `office_id`, 
                    `price`, `condition_status`, `status`, `image`, `description`, `variety`,
                    `size`, `brand`, `unit`, `paper_type`, `thickness`, `qty`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $query->bind_param(
            "sssssssssssssssss",
            $assets_code,
            $assets_name,
            $assets_category,
            $assets_subcategory,
            $assets_Office,
            $assets_price,
            $assets_condition,
            $assets_status,
            $assets_imageName,
            $assets_description,
            $variety_json,
            $size,
            $brand,
            $unit,
            $paper_type,
            $thickness,
            $qty
        );
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }







    public function UpdateAssets($assets_id, $assets_imageName, $assets_code, $assets_name, $assets_Office, $assets_category, $assets_subcategory, $assets_condition, $assets_status, $assets_description, $assets_price, $variety_json, $update_qty)
    {
        // Start base query
        $sql = "UPDATE `assets` 
                SET `asset_code` = ?, `name` = ?, `category_id` = ?, `subcategory_id` = ?, `office_id` = ?, 
                    `price` = ?, `condition_status` = ?, `status` = ?, `description` = ?, `variety` = ?, `update_qty` = ?";

        // Check if image is not empty, include in the query
        $params = [
            $assets_code,
            $assets_name,
            $assets_category,
            $assets_subcategory,
            $assets_Office,
            $assets_price,
            $assets_condition,
            $assets_status,
            $assets_description,
            $variety_json,
            $update_qty
        ];

        $types = "sssssssssss";

        if (!empty($assets_imageName)) {
            $sql .= ", `image` = ?";
            $params[] = $assets_imageName;
            $types .= "s";
        }

        // Add WHERE clause
        $sql .= " WHERE `id` = ?";
        $params[] = $assets_id;
        $types .= "i";

        // Prepare the query
        $query = $this->conn->prepare($sql);

        // Bind parameters dynamically
        $query->bind_param($types, ...$params);

        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }


    public function UpdateMaintenance($system_logoName, $system_name)
    {
        // Start base query
        $sql = "UPDATE `system_maintenance` 
            SET `system_name` = ?";
        $params = [$system_name];

        $types = "s";

        if (!empty($system_logoName)) {
            $sql .= ", `system_image` = ?";
            $params[] = $system_logoName;
            $types .= "s";
        }
        $sql .= " WHERE `system_id` = ?";
        $params[] = 1;
        $types .= "i";
        $query = $this->conn->prepare($sql);
        $query->bind_param($types, ...$params);

        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }


    public function fetch_maintenance()
    {
        $query = $this->conn->prepare("SELECT * FROM `system_maintenance` LIMIT 1");

        if ($query->execute()) {
            $result = $query->get_result();
            // Fetch a single row as an associative array
            $data = $result->fetch_assoc();

            // Return the single record
            return $data;
        } else {
            return false;
        }
    }




    public function fetch_all_office()
    {
        $query = $this->conn->prepare("SELECT * FROM `offices`");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function fetch_all_assets()
    {
        $query = $this->conn->prepare("SELECT assets.*,categories.category_name,categories.id as cat_id,subcategories.subcategory_name,subcategories.id as sub_id,offices.office_name,offices.id as off_id
        FROM `assets`
        LEFT JOIN categories ON categories.id = assets.category_id 
        LEFT JOIN subcategories ON subcategories.id = assets.subcategory_id 
        LEFT JOIN offices ON offices.id = assets.office_id

        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function fetch_all_assets_2($id)
    {
        if ($id == 10) {
            // Show assets where category_id is 1, 2, 4, or 5
            $query = $this->conn->prepare("SELECT assets.*, categories.category_name, categories.id as cat_id,
            subcategories.subcategory_name, subcategories.id as sub_id, offices.office_name, offices.id as off_id
            FROM `assets`
            LEFT JOIN categories ON categories.id = assets.category_id
            LEFT JOIN subcategories ON subcategories.id = assets.subcategory_id
            LEFT JOIN offices ON offices.id = assets.office_id WHERE assets.category_id=1 OR assets.category_id=2
            OR assets.category_id=4 OR assets.category_id=5 ");
        } elseif (empty($id) || $id == 0) {
            // Show all assets
            $query = $this->conn->prepare("SELECT assets.*, categories.category_name, categories.id as cat_id,
                    subcategories.subcategory_name, subcategories.id as sub_id, offices.office_name, offices.id as off_id
                FROM `assets`
                LEFT JOIN categories ON categories.id = assets.category_id
                LEFT JOIN subcategories ON subcategories.id = assets.subcategory_id
                LEFT JOIN offices ON offices.id = assets.office_id");
        } else {
            // Show assets with exact matching category ID (e.g., 3 or any other specific ID)
            $query = $this->conn->prepare("SELECT assets.*, categories.category_name, categories.id as cat_id,
                    subcategories.subcategory_name, subcategories.id as sub_id, offices.office_name, offices.id as off_id
                FROM `assets`
                LEFT JOIN categories ON categories.id = assets.category_id
                LEFT JOIN subcategories ON subcategories.id = assets.subcategory_id
                LEFT JOIN offices ON offices.id = assets.office_id
                WHERE categories.id = ?");
            $query->bind_param("i", $id);
        }

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }

        return false;
    }



    public function under_maintinance_list()
    {
        $query = $this->conn->prepare("SELECT assets.*,categories.category_name,categories.id as cat_id,subcategories.subcategory_name,subcategories.id as sub_id,offices.office_name,offices.id as off_id
        FROM `assets`
        LEFT JOIN categories ON categories.id = assets.category_id 
        LEFT JOIN subcategories ON subcategories.id = assets.subcategory_id 
        LEFT JOIN offices ON offices.id = assets.office_id
        where `status` = 'Under Maintenance' OR `status` = 'Disposed'

        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


    public function fetch_all_assets_procurment()
    {
        $query = $this->conn->prepare("SELECT assets.*,categories.type, categories.category_name,categories.id as cat_id,subcategories.subcategory_name,subcategories.id as sub_id,offices.office_name,offices.id as off_id
        FROM `assets`
        LEFT JOIN categories ON categories.id = assets.category_id 
        LEFT JOIN subcategories ON subcategories.id = assets.subcategory_id 
        LEFT JOIN offices ON offices.id = assets.office_id
        where (condition_status = 'New' OR condition_status = 'Good') AND(`status` = 'Available' OR `status` = 'Disposed')

        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }



    public function AddCart($add_id, $asset_id, $qty, $variety, $specification, $specification_array)
    {
        // Check if the asset already exists in the cart
        $checkQuery = $this->conn->prepare("SELECT cart_qty FROM request_cart WHERE cart_user_id = ? AND cart_asset_id = ? AND cart_variety = ? AND specification = ? AND specification_array = ? ");
        $checkQuery->bind_param("iisss", $add_id, $asset_id, $variety, $specification, $specification_array);
        $checkQuery->execute();
        $result = $checkQuery->get_result();

        if ($result->num_rows > 0) {
            // Item exists, update the quantity
            $updateQuery = $this->conn->prepare("UPDATE request_cart SET cart_qty = cart_qty + $qty WHERE cart_user_id = ? AND cart_asset_id = ? AND cart_variety = ? AND specification = ? AND specification_array = ?");
            $updateQuery->bind_param("iiss", $add_id, $asset_id, $variety, $specification, $specification_array);
            return $updateQuery->execute();
        } else {
            // Item does not exist, insert a new row
            $insertQuery = $this->conn->prepare("INSERT INTO request_cart (cart_user_id, cart_asset_id, cart_qty, cart_variety, specification, specification_array) VALUES (?, ?, ?,?, ?, ?)");
            $insertQuery->bind_param("iiisss", $add_id, $asset_id, $qty, $variety, $specification, $specification_array);
            return $insertQuery->execute();
        }
    }



    // public function confirmRequest($add_id,$supplier_name,$supplier_company,$designation) {

    //         // Item does not exist, insert a new row
    //         $insertQuery = $this->conn->prepare("INSERT INTO request (request_user_id, request_supplier_name, request_supplier_company,request_designation) VALUES (?,?,?,?)");
    //         $insertQuery->bind_param("isss", $add_id, $supplier_name,$supplier_company,$designation);
    //         return $insertQuery->execute();

    // }

    public function confirmRequest($add_id, $supplier_name, $supplier_company, $designation, $role)
    {
        // Generate a unique invoice number
        do {
            $request_invoice = 'REQ-' . time() . rand(1000, 9999);
            $checkQuery = $this->conn->prepare("SELECT COUNT(*) FROM `request` WHERE `request_invoice` = ?");
            $checkQuery->bind_param("s", $request_invoice);
            $checkQuery->execute();
            $checkQuery->bind_result($count);
            $checkQuery->fetch();
            $checkQuery->close();
        } while ($count > 0); // Repeat until a unique invoice is found

        // Prepare the insert query
        $query = $this->conn->prepare(
            "INSERT INTO `request` (`request_invoice`,`request_user_id`, `request_supplier_name`,`request_supplier_company`, `request_designation`, `request_role`) 
            VALUES ( ?, ?,?, ?, ?, ?)"
        );
        $query->bind_param("sissss", $request_invoice, $add_id, $supplier_name, $supplier_company, $designation, $role);

        if ($query->execute()) {
            return [
                'id' => $this->conn->insert_id,
                'invoice' => $request_invoice,
                'request_user_id' => $add_id,
            ]; // Return both the inserted ID and the invoice number
        } else {
            return ['error' => 'Error: ' . $query->error];
        }
    }



    public function addpurchase_item($request_id, $add_id, $cart_id, $asset_id, $price, $cart_qty, $cart_variety, $r_specification, $r_specification_array)
    {
        // Insert purchase item
        $query = $this->conn->prepare("
            INSERT INTO `request_item` (`r_request_id`, `r_item_asset_id`, `r_item_qty`, `r_item_variety`, `r_item_price`, `r_specification`, `r_specification_array`) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $query->bind_param("iiisdss", $request_id, $asset_id, $cart_qty, $cart_variety, $price, $r_specification, $r_specification_array);

        if (!$query->execute()) {
            return 'Error: ' . $query->error;
        }
        $query->close(); // Close statement



        // Fetch all cart items for the given product and branch
        $cartQuery = $this->conn->prepare("
            SELECT cart_id  
            FROM request_cart 
            WHERE cart_asset_id = ? AND cart_user_id = ?
        ");
        $cartQuery->bind_param("ii", $asset_id, $add_id);
        $cartQuery->execute();
        $result = $cartQuery->get_result();
        $cartQuery->close(); // Close statement after use

        if ($result->num_rows > 0) {
            // Delete each cart entry
            while ($row = $result->fetch_assoc()) {
                $deleteQuery = $this->conn->prepare("
                    DELETE FROM request_cart WHERE cart_id = ?
                ");
                $deleteQuery->bind_param("i", $row['cart_id']);
                $deleteQuery->execute();
                $deleteQuery->close(); // Close each delete query
            }
        }

        return 'success';
    }



    public function fetch_all_request_for_admin()
    {
        $query = $this->conn->prepare("
            SELECT 
                request.request_id,
                request.request_invoice,
                request.request_designation,
                request.request_date,
                request.request_user_id,
                request.request_status,
                request.request_supplier_name,
                request.request_supplier_company,
              
                
                -- User Fields
                users.id AS user_id,
                users.fullname AS user_fullname,
                users.email AS user_email,
                users.user_id,
                users.role,
                users.designation as user_designation
            FROM `request`
            LEFT JOIN users ON users.id = request.request_user_id
            WHERE request.status='1'
            ORDER BY request.request_id DESC
        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function fetch_all_request_for_admin2($request_id)
    {
        $query = $this->conn->prepare("
        SELECT 
            request.request_id,
            request.request_invoice,
            request.request_designation,
            request.request_date,
            request.request_user_id,
            request.request_status,
            request.request_supplier_name,
            request.request_supplier_company,

            -- User Fields
            users.id AS user_id,
            users.fullname AS user_fullname,
            users.email AS user_email,
            users.user_id,
            users.role,
            users.designation as user_designation
        FROM `request`
        LEFT JOIN users ON users.id = request.request_user_id
        WHERE request.status = '1' AND request.request_id = ?
        ORDER BY request.request_id DESC
    ");

        $query->bind_param("i", $request_id); // assuming request_id is an integer

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        } else {
            // Optional: handle errors
            return false;
        }
    }


    public function fetch_all_request_for_admin_sort($role)
    {
        $query = $this->conn->prepare("
            SELECT 
                request.request_id,
                request.request_invoice,
                request.request_designation,
                request.request_date,
                request.request_user_id,
                request.request_status,
                request.request_supplier_name,
                request.request_supplier_company,
                
                -- User Fields
                users.id AS user_id,
                users.fullname AS user_fullname,
                users.email AS user_email,
                users.user_id AS user_user_id,
                users.role AS user_role,
                users.designation AS user_designation,
                
                -- Request Item Fields
                request_item.r_item_id,
                request_item.r_finance_price,
                request_item.r_item_qty,
                request_item.r_item_price,
                request_item.r_item_variety,
                assets.name AS asset_name
    
            FROM `request`
            LEFT JOIN users ON users.id = request.request_user_id
            LEFT JOIN request_item ON request_item.r_request_id = request.request_id
            LEFT JOIN assets ON assets.id = request_item.r_item_asset_id
            
            WHERE request.status = '1' AND users.role = ?
            ORDER BY request.request_id DESC
        ");

        $query->bind_param("s", $role);  // Bind the role as string

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }

        return null;
    }



    public function fetch_all_request_for_finance()
    {
        $query = $this->conn->prepare("
            SELECT 
                request.request_id,
                request.request_invoice,
                request.request_designation,
                request.request_date,
                request.request_user_id,
                request.request_status,
                request.request_supplier_name,
                request.request_supplier_company,
              
                
                -- User Fields
                users.id AS user_id,
                users.fullname AS user_fullname,
                users.email AS user_email,
                users.user_id,
                users.designation as user_designation,
                users.role
            FROM `request`
            LEFT JOIN users ON users.id = request.request_user_id
            WHERE request.status='1'
            ORDER BY request.request_id DESC
        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function fetch_all_request_for_head($role)
    {
        $str = "";
        switch ($role) {
            case "Head Library":
                $str = " AND ( request.request_role='Head Library' OR  request.request_role='Library')";
                break;
            case "Head IACEPO & NSTP":
                $str = " AND ( request.request_role='Head IACEPO & NSTP' OR  request.request_role='IACEPO & NSTP')";
                break;
            case "Head Basic Education":
                $str = " AND ( request.request_role='Head Basic Education' OR  request.request_role='Basic Education')";
                break;
        }

        $query = $this->conn->prepare("
            SELECT 
                request.request_id,
                request.request_invoice,
                request.request_designation,
                request.request_date,
                request.request_role,
                request.request_user_id,
                request.request_status,
                request.request_supplier_name,
                request.request_supplier_company,
    
                users.id AS user_id,
                users.fullname AS user_fullname,
                users.email AS user_email,
                users.user_id,
                users.designation AS user_designation,
                users.role
            FROM `request`
            LEFT JOIN users ON users.id = request.request_user_id
            WHERE request.status='1'
            $str
            ORDER BY request.request_id DESC
        ");

        if ($query->execute()) {
            return $query->get_result();
        }

        return false;
    }

    public function fetch_all_request_for_head2($role, $request_id = null)
    {
        $str = "";
        switch ($role) {
            case "Head Library":
                $str = " AND (request.request_role='Head Library' OR request.request_role='Library')";
                break;
            case "Head IACEPO & NSTP":
                $str = " AND (request.request_role='Head IACEPO & NSTP' OR request.request_role='IACEPO & NSTP')";
                break;
            case "Head Basic Education":
                $str = " AND (request.request_role='Head Basic Education' OR request.request_role='Basic Education')";
                break;
        }

        // Base query
        $sql = "
        SELECT 
            request.request_id,
            request.request_invoice,
            request.request_designation,
            request.request_date,
            request.request_role,
            request.request_user_id,
            request.request_status,
            request.request_supplier_name,
            request.request_supplier_company,

            users.id AS user_id,
            users.fullname AS user_fullname,
            users.email AS user_email,
            users.user_id,
            users.designation AS user_designation,
            users.role
        FROM `request`
        LEFT JOIN users ON users.id = request.request_user_id
        WHERE request.status = '1'
        $str
    ";

        // Add request_id filter if provided
        if ($request_id !== null) {
            $sql .= " AND request.request_id = ?";
        }

        $sql .= " ORDER BY request.request_id DESC";

        $query = $this->conn->prepare($sql);

        // Bind request_id if needed
        if ($request_id !== null) {
            $query->bind_param("i", $request_id); // i = integer
        }

        if ($query->execute()) {
            return $query->get_result();
        }

        return false;
    }





    public function fetch_all_request_report()
    {
        $query = $this->conn->prepare("
            SELECT 
                request.request_id,
                request.request_invoice,
                request.request_designation,
                request.request_date,
                request.request_user_id,
                request.request_status,
                request.request_supplier_name,
                request.request_supplier_company,
                
                -- User Fields
                users.id AS user_id,
                users.fullname AS user_fullname,
                users.email AS user_email,
                users.user_id,
                users.designation AS user_designation,
                
                -- Assets Fields
                assets.id AS assets_id,
                assets.name AS assets_name,
                assets.price AS assets_price,

                 -- Request item Fields
                request_item.r_item_qty AS request_qty,
                request_item.r_item_variety AS request_variety,
                request_item.r_finance_price AS finance_
                
            FROM `request`
            LEFT JOIN users ON users.id = request.request_user_id
            LEFT JOIN request_item ON request_item.r_request_id = request.request_id 
            LEFT JOIN assets ON assets.id = request_item.r_item_asset_id
            ORDER BY request.request_id DESC
        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function fetch_all_request_report_detailed($month = null, $year = null, $requestRole = null)
    {
        $baseSQL = "
            SELECT 
                request.request_id,
                request.request_invoice,
                request.request_designation,
                request.request_date,
                request.request_user_id,
                request.request_status,
                request.request_supplier_name,
                request.request_supplier_company,
                request.request_role,
                
                -- User Fields
                users.id AS user_id,
                users.fullname AS user_fullname,
                users.email AS user_email,
                users.user_id,
                users.designation AS user_designation,
                
                -- Assets Fields
                assets.id AS assets_id,
                assets.name AS assets_name,
                assets.price AS assets_price,
    
                -- Request item Fields
                request_item.r_item_qty AS request_qty,
                request_item.r_item_variety AS request_variety,
                request_item.r_finance_price AS finance_
    
            FROM `request`
            LEFT JOIN users ON users.id = request.request_user_id
            LEFT JOIN request_item ON request_item.r_request_id = request.request_id 
            LEFT JOIN assets ON assets.id = request_item.r_item_asset_id
        ";

        $conditions = [];
        $params = [];
        $types = "";

        if ($month !== null) {
            $conditions[] = "MONTH(request.request_date) = ?";
            $params[] = $month;
            $types .= "i";
        }

        if ($year !== null) {
            $conditions[] = "YEAR(request.request_date) = ?";
            $params[] = $year;
            $types .= "i";
        }

        // Add condition for request_role if provided
        if ($requestRole !== null) {
            $conditions[] = "request.request_role = ?";
            $params[] = $requestRole;
            $types .= "s"; // Assuming request_role is a string
        }

        if (!empty($conditions)) {
            $baseSQL .= " WHERE " . implode(" AND ", $conditions);
        }

        $baseSQL .= " ORDER BY request.request_id DESC";

        $query = $this->conn->prepare($baseSQL);

        if (!empty($params)) {
            $query->bind_param($types, ...$params);
        }

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }

        return false;
    }



    public function fetch_all_request_report_monthly()
    {
        $query = $this->conn->prepare("
        SELECT 
            request.request_id,
            request.request_invoice,
            request.request_designation,
            request.request_date,
            request.request_user_id,
            request.request_status,
            request.request_supplier_name,
            request.request_supplier_company,
            
            -- User Fields
            users.id AS user_id,
            users.fullname AS user_fullname,
            users.email AS user_email,
            users.user_id,
            users.designation AS user_designation,
            
            -- Assets Fields
            assets.id AS assets_id,
            assets.name AS assets_name,
            assets.price AS assets_price,
    
            -- Request item Fields
            request_item.r_item_qty AS request_qty,
            request_item.r_item_variety AS request_variety
            
        FROM `request`
        LEFT JOIN users ON users.id = request.request_user_id
        LEFT JOIN request_item ON request_item.r_request_id = request.request_id 
        LEFT JOIN assets ON assets.id = request_item.r_item_asset_id
        GROUP BY MONTH(request.request_date)
        ORDER BY MONTH(request.request_date), request.request_id DESC
    ");


        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }



    public function fetch_all_request($userID)
    {
        $query = $this->conn->prepare("
            SELECT 
                request.request_id,
                request.request_invoice,
                request.request_designation,
                request.request_date,
                request.request_user_id,
                request.request_status,
                request.request_supplier_name,
                request.request_supplier_company,
              
                
                -- User Fields
                users.id AS user_id,
                users.fullname AS user_fullname,
                users.email AS user_email,
                users.user_id,
                users.role,
                users.designation as user_designation
               
                
            FROM `request`
            LEFT JOIN users ON users.id = request.request_user_id
            where request.request_user_id=$userID AND request.status='1'
            ORDER BY request.request_id DESC
        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function fetch_all_request2($userID, $request_id = null)
    {
        // Base query
        $sql = "
        SELECT 
            request.request_id,
            request.request_invoice,
            request.request_designation,
            request.request_date,
            request.request_user_id,
            request.request_status,
            request.request_supplier_name,
            request.request_supplier_company,

            -- User Fields
            users.id AS user_id,
            users.fullname AS user_fullname,
            users.email AS user_email,
            users.user_id,
            users.role,
            users.designation AS user_designation

        FROM `request`
        LEFT JOIN users ON users.id = request.request_user_id
        WHERE request.request_user_id = ? AND request.status = '1'
    ";

        // Append filter for request_id if provided
        if ($request_id !== null) {
            $sql .= " AND request.request_id = ?";
        }

        $sql .= " ORDER BY request.request_id DESC";

        $query = $this->conn->prepare($sql);

        // Bind parameters safely
        if ($request_id !== null) {
            $query->bind_param("ii", $userID, $request_id); // both integers
        } else {
            $query->bind_param("i", $userID);
        }

        if ($query->execute()) {
            return $query->get_result();
        }

        return false;
    }





    public function fetch_request_receipt($request_id)
    {
        $query = $this->conn->prepare("SELECT 
                request.request_id,
                request.request_invoice,
                request.request_designation,
                request.request_date,
                request.request_user_id,
                request.request_status,
                request.request_supplier_name,
                request.request_supplier_company,
                -- User Fields
                users.id AS userid,
                users.fullname AS user_fullname,
                users.email AS user_email,
                users.user_id,
                users.designation as user_designation
            FROM `request`
            LEFT JOIN users ON users.id = request.request_user_id
            WHERE request.request_id = ?
            ORDER BY request.request_id DESC
        ");

        $query->bind_param("i", $request_id);

        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                // Return the result as an associative array
                return $result->fetch_assoc();  // Fetching only the first row
            } else {
                return null;  // No records found
            }
        } else {
            return null;  // Query execution failed
        }
    }




    public function fetch_request_item($request_id)
    {
        $query = $this->conn->prepare("SELECT 
                -- User Fields
                request_item.r_request_id,
                request_item.r_item_id,
                request_item.r_finance_price,
                request_item.r_item_qty,
                request_item.r_item_price,
                request_item.r_item_variety,
                request.request_status,
                assets.name,
                request_item.r_specification_array
            FROM `request_item`
            LEFT JOIN assets ON assets.id = request_item.r_item_asset_id
            LEFT JOIN request ON request.request_id = request_item.r_request_id
            WHERE request_item.r_request_id = ?
            ORDER BY request_item.r_request_id DESC
        ");

        $query->bind_param("i", $request_id);

        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                // Fetch all rows as an associative array
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }






    public function UpdateReqStatus($request_id, $action)
    {

        // Update the request status
        $updateStatusQuery = $this->conn->prepare(
            "UPDATE `request` SET `request_status` = ? WHERE `request_id` = ?"
        );
        $updateStatusQuery->bind_param("ss", $action, $request_id);

        if ($updateStatusQuery->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $updateStatusQuery->error;
        }
    }











    public function fetch_all_subcategory()
    {
        $query = $this->conn->prepare("SELECT * FROM `subcategories`");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


    public function remove_from_cart($cart_id)
    {
        $query = $this->conn->prepare("DELETE FROM `request_cart` WHERE cart_id = ?");

        $query->bind_param("i", $cart_id);

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }





    public function fetch_all_category()
    {
        $query = $this->conn->prepare("SELECT * FROM `categories`");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function fetch_all_user()
    {
        $query = $this->conn->prepare("SELECT * FROM `users`");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


    public function fetch_all_receive_logs()
    {
        $query = $this->conn->prepare("SELECT * FROM `recieved_logs`
        LEFT JOIN users ON users.id = recieved_logs.recieved_user_id
        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


    public function updateLogs($log_id, $received_by, $asset_name, $asset_description, $asset_supplier_name, $asset_supplier_company, $asset_qty)
    {
        $sql = "UPDATE recieved_logs 
                SET recieved_supplier_name = ?, 
                    recieved_supplier_company = ?, 
                    recieved_assets_name = ?, 
                    recieved_description = ?, 
                    recieved_assets_qty = ?, 
                    recieved_user_id = ? 
                WHERE recieved_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssiii", $asset_supplier_name, $asset_supplier_company, $asset_name, $asset_description, $asset_qty, $received_by, $log_id);

        if ($stmt->execute()) {
            $stmt->close();
            return 'success';
        } else {
            $error = 'Error: ' . $stmt->error;
            $stmt->close();
            return $error;
        }
    }


    public function Adduser($userId, $user_imageName, $user_fullname, $user_nickname, $user_email, $user_type, $user_password, $user_designation, $email_official)
    {

        $hashed_password = $user_password;
        // Insert Data into Database
        $sql = "INSERT INTO users (user_id, email, password, fullname, nickname, role, designation, profile_picture, email_official) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssss", $userId, $user_email, $hashed_password, $user_fullname, $user_nickname, $user_type, $user_designation, $user_imageName, $email_official);
        if ($stmt->execute()) {
            $stmt->close();
            return 'success';
        } else {
            $error = 'Error: ' . $stmt->error;
            $stmt->close();
            return $error;
        }
    }


    public function UpdatePassword($user_id, $password, $email, $fullname, $nickname, $user_imageName)
    {
        // Properly hash the password
        $hashed_password = $password;

        // Prepare SQL query
        $sql = "UPDATE users SET password = ?, email = ?, fullname = ?, nickname = ?, profile_picture = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return 'Error in preparing statement: ' . $this->conn->error;
        }

        // Bind parameters: 5 strings and 1 integer
        $stmt->bind_param("sssssi", $hashed_password, $email, $fullname, $nickname, $user_imageName, $user_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $stmt->close();
                return 'success';
            } else {
                $stmt->close();
                return 'No rows updated — user ID might not exist, or data is identical.';
            }
        } else {
            $stmt->close();
            return 'Error executing statement: ' . $stmt->error;
        }
    }



    public function recordLogs($received_by, $asset_name, $asset_description, $asset_supplier_name, $asset_supplier_company, $asset_qty, $recieved_number)
    {

        $sql = "INSERT INTO recieved_logs (recieved_supplier_name, recieved_supplier_company, recieved_assets_name, recieved_description, recieved_assets_qty, recieved_user_id, recieved_number) 
                VALUES ( ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssiis", $asset_supplier_name, $asset_supplier_company, $asset_name, $asset_description, $asset_qty, $received_by, $recieved_number);
        if ($stmt->execute()) {
            $stmt->close();
            return 'success';
        } else {
            $error = 'Error: ' . $stmt->error;
            $stmt->close();
            return $error;
        }
    }


    public function count_notification()
    {
        // Count pending requests
        $pendingQuery = $this->conn->prepare("
            SELECT  
            COUNT(CASE WHEN request.request_status = 'pending' THEN 1 END) AS PendingCounts
        FROM request
        LEFT JOIN users ON users.user_id = request.request_user_id
        WHERE request.status = '1'
        ");

        // Count assets under maintenance
        $maintenanceQuery = $this->conn->prepare("
            SELECT COUNT(*) AS UnderMaintenanceCounts 
            FROM assets 
            WHERE status = 'Under Maintenance'
        ");

        $pendingCount = 0;
        $maintenanceCount = 0;

        if ($pendingQuery->execute()) {
            $pendingResult = $pendingQuery->get_result()->fetch_assoc();
            $pendingCount = $pendingResult['PendingCounts'];
        }

        if ($maintenanceQuery->execute()) {
            $maintenanceResult = $maintenanceQuery->get_result()->fetch_assoc();
            $maintenanceCount = $maintenanceResult['UnderMaintenanceCounts'];
        }

        // Return combined result
        echo json_encode([
            'PendingCounts' => $pendingCount,
            'UnderMaintenanceCounts' => $maintenanceCount
        ]);
    }















    public function ArchiveRequest($request_id)
    {
        $status = 0;

        $query = $this->conn->prepare(
            "UPDATE `request` SET `status` = ? WHERE `request_id` = ?"
        );
        $query->bind_param("is", $status, $request_id);

        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }




    public function RestoreUser($userId)
    {
        $status = 1;

        $query = $this->conn->prepare(
            "UPDATE `users` SET `status` = ? WHERE `id` = ?"
        );
        $query->bind_param("is", $status, $userId);

        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }


    public function update_assets_status($asset_id, $update_assets_status)
    {

        $query = $this->conn->prepare(
            "UPDATE `assets` SET `status` = ? WHERE `id` = ?"
        );
        $query->bind_param("si", $update_assets_status, $asset_id);

        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }






    public function DeleteUser($userId)
    {
        $status = 0;

        $query = $this->conn->prepare(
            "UPDATE `users` SET `status` = ? WHERE `id` = ?"
        );
        $query->bind_param("is", $status, $userId);

        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }


    public function deleteAssets($assets_id)
    {
        $query = $this->conn->prepare(
            "DELETE FROM `assets` WHERE `id` = ?"
        );
        $query->bind_param("i", $assets_id);

        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }
















    public function updateUser($userId, $update_id, $user_imageName, $user_fullname, $user_nickname, $user_email, $user_type, $user_password, $user_designation)
    {
        // Start building the SQL query
        $sql = "UPDATE users SET user_id=?, email = ?, fullname = ?, nickname = ?, role = ?, designation = ?";
        $params = [$userId, $user_email, $user_fullname, $user_nickname, $user_type, $user_designation];
        $types = "ssssss"; // Data types: string (s)

        // Check if profile picture is provided
        if (!empty($user_imageName)) {
            $sql .= ", profile_picture = ?";
            $params[] = $user_imageName;
            $types .= "s";
        }


        // Check if password is provided (update only if not empty)
        if (!empty($user_password)) {
            $hashed_password = $user_password;
            $sql .= ", password = ?";
            $params[] = $hashed_password;
            $types .= "s";
        }

        // Add WHERE condition
        $sql .= " WHERE id = ?";
        $params[] = $update_id;
        $types .= "i"; // ID is an integer

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            $stmt->close();
            return 'success';
        } else {
            $error = 'Error: ' . $stmt->error;
            $stmt->close();
            return $error;
        }
    }



    public function fetch_all_cart($id)
    {
        $query = $this->conn->prepare("
            SELECT c.cart_id, 
                a.asset_code, 
                a.id as asset_id, 
                a.name, 
                a.price,
                c.cart_qty,
                c.cart_variety,
                c.specification,
                c.specification_array
            FROM request_cart c 
            JOIN assets a ON c.cart_asset_id = a.id
            WHERE c.cart_user_id = ?
        ");

        $query->bind_param("i", $id);
        $query->execute();
        $result = $query->get_result();

        $cartItems = [];

        while ($row = $result->fetch_assoc()) {
            $cartItems[] = [
                'cart_id' => $row['cart_id'],
                'asset_id' => $row['asset_id'],
                'asset_code ' => $row['asset_code'],
                'name' => ucfirst($row['name']),
                'price' => $row['price'],
                'cart_qty' => $row['cart_qty'],
                'cart_variety' => ucfirst($row['cart_variety']),
                'specification' => $row['specification'],
                'specification_array' => $row['specification_array']
            ];
        }

        return $cartItems;
    }



    public function check_account($id)
    {
        $id = intval($id);
        $query = "SELECT * FROM users WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }

        return $items;
    }
}
