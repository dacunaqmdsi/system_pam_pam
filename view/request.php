<?php include "components/header.php";
$conn = mysqli_connect("localhost", "root", "", "pam");
?>
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Supply Request</h2>
    <div class="flex items-center space-x-3">
        <?php
        $userImage = !empty($On_Session[0]['profile_picture']) ? $On_Session[0]['profile_picture'] : null;
        ?>
        <div class="w-10 h-10 rounded-full overflow-hidden flex items-center justify-center bg-gray-200 text-gray-600">
            <?php if ($userImage) : ?>
                <img src="../uploads/images/<?php echo $userImage; ?>" alt="User Avatar" class="w-full h-full object-cover">
            <?php else : ?>
                <span class="material-icons text-3xl">account_circle</span>
            <?php endif; ?>
        </div>
        <div>
            <?php
            $notificationCount = $db->GetValue("SELECT COUNT(request_id) FROM request WHERE is_viewed = 0 AND request_user_id = " . intval($_SESSION['id']));
            ?>
            <a href="approved_request.php" class="relative inline-block cursor-pointer" title="Notifications">
                <span class="material-icons text-gray-600 text-2xl">notifications</span>
                <?php if ($notificationCount > 0) : ?>
                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1">
                        <?php echo $notificationCount; ?>
                    </span>
                <?php endif; ?>
            </a>



            <!-- icon
            darren
            list of na approved..

            descending order. -->
        </div>
        <span class="text-gray-700 font-medium">
            <?php echo ucfirst($On_Session[0]['fullname']); ?>
        </span>
    </div>
</div>
<div class="relative mb-4 w-full max-w-md">
    <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
        <i class="material-icons text-lg">search</i>
    </span>
    <input type="text" id="searchInput" placeholder="Search users..." class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-400 focus:border-red-400 transition">
</div>
<script>
    function ajax_fn(url, elementId) {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(elementId).innerHTML = "";
                document.getElementById(elementId).innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }

    function save_price(r_item_id) {
        var r_finance_price = document.getElementById('r_finance_price' + r_item_id).value;
        ajax_fn('procurement_receipt_save.php?r_item_id=' + r_item_id + '&r_finance_price=' + r_finance_price, 'tmp');

    }
</script>
<? //include('request_add.php'); 
?>
<div id="mainC">
    <!-- <button onclick="ajax_fn('request_add.php','mainC');" class="bg-red-500 text-white py-2 px-4 text-sm rounded-lg flex items-center hover:bg-red-600 transition duration-300 mb-4">
    <span class="material-icons mr-2 text-base">add</span>
    Add Assets
</button> -->
    <?php if ($_SESSION['role'] == "Administrator" || $_SESSION['role'] == "Head Finance") { ?>
        <a href="request_add">Add Item</a>

    <? } ?>
    <!-- User Table Card -->
    <div class="max-w-9xl mx-auto grid grid-cols-12 gap-4">
        <?php if ($_SESSION['role'] == "Head Library" || $_SESSION['role'] == "Head Basic Education" || $_SESSION['role'] == "Head IACEPO & NSTP") { ?>
        <?php } else { ?>
            <div class="col-span-8 bg-white p-4 rounded-xl shadow-md">
                <h2 class="text-xl font-bold mb-4">Item list</h2>
                <div class="flex space-x-2 mb-4">
                    <button class="px-4 py-2 bg-blue-500 text-white rounded" id="filterAll">All</button>
                    <?php
                    $fetch_all_category = $db->fetch_all_category();
                    if ($fetch_all_category->num_rows > 0) :
                        while ($category = $fetch_all_category->fetch_assoc()) :
                            $category_name = $category['category_name'];
                            if ($category_name == "Furniture") {
                                $category_name .= " (Assets)";
                            } else if ($category_name == "Appliances") {
                                $category_name .= " (Assets)";
                            } else {
                                $category_name .= " (Off. Supplies)";
                            }
                    ?>
                            <button class="px-4 py-2 bg-gray-200 rounded category-filter" data-category_id='<?= $category['id'] ?>'><?= $category_name ?></button>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p class="p-2 text-center">No record found.</p>
                    <?php endif; ?>
                </div>
                <div class="grid grid-cols-3 gap-4 overflow-y-auto max-h-[600px]" id="assetsContainer">
                    <?php
                    $fetch_all_assets = $db->fetch_all_assets_procurment2();
                    if ($fetch_all_assets->num_rows > 0) :
                        while ($assets = $fetch_all_assets->fetch_assoc()) :
                    ?>
                            <div class="border p-4 rounded-xl shadow-md asset-item" data-category_id='<?= $assets['category_id'] ?>'>
                                <?php if (!empty($assets['image'])) : ?>
                                    <!-- <div class="cursor-pointer togglerViewCart"
                                        data-asset_id='<?= $assets['id'] ?>'
                                        data-name='<?= ucfirst($assets['name']) ?>'
                                        data-variety='<?= $assets['variety'] ?>'>
                                        <img src="../uploads/images/<?php echo htmlspecialchars($assets['image']); ?>"
                                            alt="Profile Picture"
                                            class="rounded-md mb-2 w-full h-40 object-cover">
                                    </div> -->
                                <?php else : ?>
                                    <!-- <i class="material-icons text-gray-500" style="font-size: 3rem;">image</i> -->
                                <?php endif; ?>
                                <h3 class="font-bold"><?php echo htmlspecialchars(ucfirst($assets['name'])); ?></h3>
                                <button class="mt-2 w-full  text-white py-2 rounded togglerViewCart" data-asset_id='<?= $assets['id'] ?>' data-name='<?= ucfirst($assets['name']) ?>' data-variety='<?= $assets['variety'] ?>'>
                                    <!-- <span class="material-icons align-middle mr-1">add</span> -->
                                </button>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p class="p-2 text-center">No record found.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-span-4 bg-white p-4 rounded-xl shadow-md">
                <h2 class="text-xl font-bold mb-4">Request Summary</h2>
                <div id="cartItemsList" class="mb-2">
                    <!-- Cart items will be injected here -->
                </div>
                <p hidden class="font-bold">Total: <span id="cartTotalPrice">₱0.00</span></p>
                <button class="mt-4 w-full bg-green-500 text-white py-2 rounded " id="confirmRequest">Send Request</button>
            </div>
        <?php } ?>
    </div>


    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true
            });
        });
    </script>


    <!-- User Table Card -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6 mt-6">
        <div class="overflow-x-auto">
            <table id="" class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Invoice</th>
                        <th class="p-3">Request By</th>
                        <!-- <th class="p-3">Designation</th> -->
                        <th class="p-3">Request Date</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include "backend/end-points/request_list.php"; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div id="cartModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center" style="display:none;">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <form id="frmAddTocart">
                <h2 class="text-xl font-bold mb-4" id="asset_name">Shopping Cart</h2>
                <div id="cartItems" class="mb-4">

                    <input type="text" hidden id="add_id" name="add_id">


                    <div hidden class="relative mb-4">
                        <input type="text" id="asset_id" name="asset_id" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">
                        <label for="asset_id" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 left-2 z-10 bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-blue-600">Asset ID</label>
                    </div>

                    <div class="relative mb-4">
                        <input type="text" id="qty" name="qty" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">
                        <label for="qty" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 left-2 z-10 bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-blue-600">Quantity</label>
                    </div>
                    <div class="relative mb-4">
                        <input type="text" id="varietyName" hidden>
                        <select id="variety" name="variety" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                            <option value="" disabled selected hidden>--Select--</option>
                            <option value="option1">Option 1</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </select>
                        <label for="variety" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 left-2 z-10 bg-white px-2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-blue-600">Specification</label>
                    </div>


                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Specification (Size)</label>
                        <select name="size" id="size" class="w-full p-2 border rounded-md">
                            <option value="">Select Size if any</option>
                            <option value="Short">Short</option>
                            <option value="Long">Long</option>
                            <option value="A4">A4</option>
                            <option value="A3">A3</option>
                            <option value="Letter">Letter</option>
                            <option value="Legal">Legal</option>
                            <option value="Tabloid">Tabloid</option>

                            <!-- Additional general sizes -->
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                            <option value="Extra Large">Extra Large</option>

                            <!-- Optional specialized formats -->
                            <option value="Executive">Executive</option>
                            <option value="Folio">Folio</option>
                            <option value="Statement">Statement</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Specification (Brand)</label>
                        <select name="brand" id="brand" class="w-full p-2 border rounded-md">
                            <option value="">Select Brand if any</option>
                            <option value="Hardcopy">Hardcopy</option>
                            <option value="Brand1">Brand1</option>
                            <option value="Brand2">Brand2</option>
                            <option value="Brand3">Brand3</option>
                            <!-- Add more brands as required -->
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Specification (Unit)</label>
                        <select name="unit" id="unit" class="w-full p-2 border rounded-md">
                            <option value="">Select Unit if any</option>
                            <option value="PC">Piece (PC)</option>
                            <option value="Ream">Ream</option>
                            <option value="Box">Box</option>
                            <option value="Pack">Pack</option>
                            <!-- Add more units as required -->
                        </select>
                    </div>


                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Specification (Paper Type)</label>
                        <select name="paper_type" id="paper_type" class="w-full p-2 border rounded-md">
                            <option value="">Select Paper Type if any</option>
                            <option value="Copier">Copier</option>
                            <option value="Multipurpose">Multipurpose</option>
                            <option value="Digital">Digital</option>
                            <option value="Glossy">Glossy</option>
                            <option value="Matte">Matte</option>
                            <!-- Add more paper types as required -->
                        </select>
                    </div>


                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Specification (Thickness)</label>
                        <select name="thickness" id="thickness" class="w-full p-2 border rounded-md">
                            <option value="">Select Thickness if any</option>
                            <option value="70gsm">70gsm</option>
                            <option value="80gsm">80gsm</option>
                            <option value="90gsm">90gsm</option>
                            <option value="100gsm">100gsm</option>
                            <option value="120gsm">120gsm</option>
                            <!-- Add more thickness options as required -->
                        </select>
                    </div>




                    <div hidden class="relative mb-4">
                        <input type="text" id="specification" name="specification" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">
                        <label for="qty" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 left-2 z-10 bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-blue-600">More spefication details</label>
                    </div>


                    <div hidden class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Specification</label>
                        <input type="text" id="specification_name" name="specification_name" class="w-full p-2 border rounded-md">
                    </div>

                    <div hidden class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">More Specification</label>
                        <div id="specification-values-container">
                            <input type="text" name="specification_name_value[]" class="w-full p-2 mb-2 border rounded-md">
                        </div>
                        <button type="button" class="add-specification-value mt-2 text-blue-500">Add Another Specification</button>
                    </div>


                </div>
                <button type="submit" id="BtnaddToCart" class="px-4 py-2 bg-green-500 text-white rounded">Add to cart</button>
                <button type="button" id="closeCartModal" class="px-4 py-2 bg-red-500 text-white rounded">Close</button>
            </form>
        </div>
    </div>

</div>
<!-- MODAL REQUEST SECION -->
<div id="sendRequestModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white rounded-lg p-6 shadow-lg w-96">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Request Details</h2>
        <div class="relative mb-4">
            <input type="text" id="supplierName" name="supplierName" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">
            <label for="supplierName" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 left-2 z-10 bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-blue-600">Supplier Name</label>
        </div>

        <div class="relative mb-4">
            <input type="text" id="supplierCompany" name="supplierCompany" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">
            <label for="supplierCompany" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 left-2 z-10 bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-blue-600">Supplier Company</label>
        </div>
        <div class="relative mb-4">
            <select id="designation" name="designation" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <option value="" disabled selected hidden>--Select--</option>
                <option value="Finance's Office">Finance's Office</option>
                <option value="VPAA">VPAA</option>
                <option value="HRDO">HRDO</option>
                <option value="WASTFI">WASTFI</option>
                <option value="Library">Library</option>
                <option value="Computer Lab">Computer Lab</option>
            </select>
            <label for="designation" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 left-2 z-10 bg-white px-2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-blue-600">Designation</label>
        </div>
        <div class="flex justify-end space-x-2">
            <button id="confirmRequest" class="bg-green-500 text-white p-2 rounded-md">Confirm</button>
            <button id="closeRequestModal" class="bg-gray-500 text-white p-2 rounded-md">Cancel</button>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        let globalCartItems = []; // Store cart items globally

        function fetch_cart() {
            $.ajax({
                url: "backend/end-points/fetch_cart.php",
                type: 'GET',
                success: function(data) {
                    try {
                        globalCartItems = JSON.parse(data); // Store globally

                        if (!Array.isArray(globalCartItems) || globalCartItems.length === 0) {
                            $("#cartItemsList").html("<p>Your cart is empty.</p>");
                            $("#cartTotalPrice").text("₱0.00");
                            return;
                        }

                        let totalItems = 0;
                        let totalPrice = 0;

                        let cartItemsHtml = globalCartItems.map((item, index) => {
                            let price = parseFloat(item.price) || 0;
                            let specification = item.specification;
                            let specification_array = item.specification_array;
                            let size = item.size;
                            let brand = item.brand;
                            let unit = item.unit;
                            let paper_type = item.paper_type;
                            let thickness = item.thickness;






                            let subtotal = price * (item.cart_qty || 0);
                            totalItems += item.cart_qty;
                            totalPrice += subtotal;
                            return `
                    <div class="cart-item flex justify-between items-center p-4 border-b border-gray-300" id="cart-item-${item.cart_id}">
                        <p class="text-sm text-gray-700">${item.name} (${item.cart_variety}) x${item.cart_qty} - ₱${subtotal.toFixed(2)}</p>
                        <button class="remove-btn text-red-500 hover:text-red-700 focus:outline-none" data-cart_id="${item.cart_id}">
                            <span class="material-icons">close</span>
                        </button>
                    </div>
                `;

                        }).join("");

                        $("#cartItemsList").html(cartItemsHtml);
                        $("#cartTotalPrice").text(`₱${totalPrice.toFixed(2)}`);

                        $(".remove-btn").on("click", function() {
                            let cart_id = $(this).data("cart_id");
                            remove_from_cart(cart_id);
                        });
                    } catch (error) {
                        console.error("Error parsing cart data:", error);
                        $("#cartItemsList").html("<p>Error loading cart items.</p>");
                    }
                },
            });
        }

        function remove_from_cart(cart_id) {
            $.ajax({
                url: "backend/end-points/controller.php",
                type: 'POST',
                data: {
                    cart_id: cart_id,
                    requestType: "remove_from_cart"
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status === 200) {
                        location.reload();
                    } else {
                        console.error("Error removing item from cart");
                    }
                },
            });
        }
        setInterval(fetch_cart, 3000);
        fetch_cart();
        $("#confirmRequest").click(function() {
            let supplierName = $("#supplierName").val().trim();
            let supplierCompany = $("#supplierCompany").val().trim();
            let designation = $("#designation").val();

            // if (!supplierName || !supplierCompany || !designation) {
            //     alertify.error("Please fill in all the details before confirming.");
            //     return;
            // }

            if (globalCartItems.length === 0) {
                alertify.error("Your cart is empty. Please add items before confirming.");
                return;
            }

            // 🔒 Native confirmation prompt
            let confirmRequest = confirm("Are you sure you want to request these items?");
            if (!confirmRequest) {
                return; // User cancelled
            }
            // Create data object instead of FormData
            let requestData = {
                supplier_name: "",
                supplier_company: "",
                designation: "",
                requestType: "confirmRequest",
                cart_items: globalCartItems // Pass as array
            };

            // Send data via AJAX without FormData
            $.ajax({
                url: "backend/end-points/controller.php",
                type: "POST",
                data: $.param(requestData), // Convert object to URL-encoded string
                success: function(response) {

                    alertify.success("Successfully Processed Request!");
                    $("#sendRequestModal").hide();
                    $("#cartItemsList").html("<p>Your cart is empty.</p>");
                    $("#cartTotalPrice").text("₱0.00");
                    globalCartItems = []; // Clear cart

                    location.reload()


                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    alert("Failed to submit the request.");
                }
            });
        });
        $("#btnSendRequest").click(function(e) {
            e.preventDefault();
            $("#sendRequestModal").fadeIn();
        });
        $("#closeRequestModal").click(function() {
            $("#sendRequestModal").fadeOut();
        });
        $("#sendRequestModal").click(function(event) {
            if ($(event.target).is("#sendRequestModal")) {
                $("#sendRequestModal").fadeOut();
            }
        });
        // closeRequestModal

        $(".togglerViewCart").click(function() {
            let asset_id = $(this).data('asset_id');
            let name = $(this).data('name');
            let variety = $(this).data('variety'); // Expecting an object with name and values

            $("#varietyName").val(variety.name);

            console.log(variety);

            if (variety && variety.name && Array.isArray(variety.values)) {
                let selectElement = $("#variety");
                selectElement.empty(); // Clear existing options

                // Add placeholder option
                selectElement.append(`<option value="" disabled selected hidden>-- Select ${variety.name} --</option>`);

                // Append variety values as options
                variety.values.forEach(value => {
                    selectElement.append(`<option value="${value}">${value}</option>`);
                });
            }

            $("#asset_id").val(asset_id);
            $("#asset_name").text(name);
            $("#cartModal").fadeIn();
        });




        $("#closeCartModal").click(function() {
            $("#cartModal").fadeOut();
        });

        $("#cartModal").click(function(event) {
            if ($(event.target).is("#cartModal")) {
                $("#cartModal").fadeOut();
            }
        });
        // Trigger change event when asset is selected
        $("#add_cat_assets_id").change(function() {
            // Get selected option's data attributes
            var selectedCategoryId = $(this).find("option:selected").data("category_id");
            var selectedSubcategoryId = $(this).find("option:selected").data("subcategory_id");

            // Set the category and subcategory based on selected asset
            $("#add_category_item").val(selectedCategoryId).prop("disabled", true);
            $("#add_assets_subcategory").val(selectedSubcategoryId).prop("disabled", true);

            // Show matching subcategories when asset is selected
            $("#add_assets_subcategory option").each(function() {
                if ($(this).data("category_id") == selectedCategoryId) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
        // Prevent manual change to category and subcategory
        $("#add_category_item, #add_assets_subcategory").prop("disabled", true);
        // Trigger category change to filter subcategories dynamically
        $("#add_category_item").change(function() {
            var selectedCategoryId = $(this).val();

            // Reset and filter subcategories based on category selection
            $("#add_assets_subcategory option").each(function() {
                if ($(this).data("category_id") == selectedCategoryId || $(this).val() == "") {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            // Reset subcategory selection when category changes
            $("#add_assets_subcategory").val("");
        });
    });
    $(document).ready(function() {
        function fetchSuggestions(query) {
            if (query.length >= 1) {
                $.ajax({
                    url: "backend/end-points/employee_list.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        if (!Array.isArray(data) || data.length === 0) {
                            $("#employeeSuggestions").hide();
                            return;
                        }

                        console.log("Received Data:", data);
                        let suggestions = data.map(user => `
                    <div class='suggestion-item p-2 hover:bg-gray-200 cursor-pointer' 
                         data-id='${user.id}' 
                         data-user_id='${user.user_id}' 
                         data-designation='${user.designation}' 
                         data-fullname='${user.fullname}'>
                         ${user.fullname} - ${user.designation}
                    </div>`).join("");

                        $("#employeeSuggestions").html(suggestions).show();
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        $("#employeeSuggestions").hide();
                    }
                });
            } else {
                $("#employeeSuggestions").hide();
            }
        }

        $("#search_user_fullname").on("input", function() {
            let query = $(this).val().trim(); // Trim whitespace
            // console.log("User Input:", query);
            fetchSuggestions(query);
        });


        $(document).on("click", ".suggestion-item", function() {
            let id = $(this).data("id");
            let selectedfullname = $(this).data("fullname");
            let selecteduser_id = $(this).data("user_id");
            let selecteddesignation = $(this).data("designation");

            console.log(selecteduser_id);

            $("#search_user_fullname").val(selectedfullname);
            $("#add_id").val(id);
            $("#add_user_id").val(selecteduser_id);
            $("#add_user_designation").val(selecteddesignation);
            $("#employeeSuggestions").hide();
        });


        $(document).click(function(e) {
            if (!$(e.target).closest("#stock_in_prod_code, #employeeSuggestions").length) {
                $("#employeeSuggestions").hide();
            }
        });





        // SEARCH FUNTIONALITIES
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#userTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });

    $('.add-specification-value').on('click', function() {
        // Create the new input field
        const newInput = $('<input type="text" name="specification_name_value[]" class="w-full p-2 mb-2 border rounded-md" required>');

        // Create the remove button
        const removeButton = $('<button type="button" class="remove-btn p-1 bg-transparent text-red-500 text-lg font-bold border-none ml-2">X</button>');

        // Append the new input field and the remove button inside a wrapper div
        const inputWrapper = $('<div class="input-wrapper mb-2 flex items-center"></div>');
        inputWrapper.append(newInput);
        inputWrapper.append(removeButton);

        // Append the input wrapper to the correct container
        $('#specification-values-container').append(inputWrapper);

        // Attach the click event for the remove button
        removeButton.on('click', function() {
            inputWrapper.remove(); // Remove the entire wrapper
        });
    });
</script>
<?php include "components/footer.php"; ?>
<script src="assets/js/filter_assets_category.js"></script>