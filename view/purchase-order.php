<?php include "components/header.php"; ?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Supply Request</h2>
    <div class="flex items-center space-x-3">
        <?php
        $userImage = !empty($On_Session[0]['profile_picture']) ? $On_Session[0]['profile_picture'] : null;
        ?>
        <div class="w-10 h-10 rounded-full overflow-hidden flex items-center justify-center bg-gray-200 text-gray-600">
            <?php if ($userImage): ?>
                <img src="../uploads/images/<?php echo $userImage; ?>" alt="User Avatar" class="w-full h-full object-cover">
            <?php else: ?>
                <span class="material-icons text-3xl">account_circle</span>
            <?php endif; ?>
        </div>
        <span class="text-gray-700 font-medium">
            <?php echo ucfirst($On_Session[0]['fullname']); ?>
        </span>
    </div>
</div>


<div class="w-full max-w-md space-y-3">
    <!-- Search Input -->
    <div class="relative">
        <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
            <i class="material-icons text-lg">search</i>
        </span>
        <input type="text" id="searchInput" placeholder="Search users..."
            class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-400 focus:border-red-400 transition">
    </div>

    <!-- Department Filter Dropdown -->
    <select id="dropDownsearchInput" class="pl-4 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-400 focus:border-red-400 transition">
        <option value="">ALL Departments</option>
        <option value="Finance">Finance</option>
        <option value="Library">Library</option>
        <option value="Basic Education">Basic Education</option>
        <option value="IACEPO & NSTP">IACEPO & NSTP</option>
        <option value="WASTFI HEAD">WASTFI HEAD</option>
    </select>

    <br><br>

    <a href="#" id="sortLink" class="pl-10 pr-4 py-2 w-full inline-block text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-400 focus:border-red-400 transition">ALL REQUEST
</a>

    <script>
        document.getElementById('sortLink').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default link behavior
            const selectedDept = document.getElementById('dropDownsearchInput').value;
            const url = `purchase-sort${selectedDept ? '?department=' + encodeURIComponent(selectedDept) : ''}`;
            window.location.href = url;
        });
    </script>
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


    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="userTable" class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-100 text-gray-700">
                <tr>

                    <th class="p-3">#</th>
                    <th class="p-3">Invoice</th>
                    <th class="p-3">Department</th>
                    <th class="p-3">Request By</th>
                    <!-- <th class="p-3">Supplier Name</th> -->

                    <!-- <th class="p-3">Designation</th> -->
                    <th class="p-3">Request Date</th>
                    <th class="p-3">Status</th>


                    <th class="p-3 text-center">Actions</th>




                </tr>
            </thead>
            <tbody>
                <?php include "backend/end-points/request_list_purchase.php"; ?>
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

                <input hidden type="text" id="add_id" name="add_id">

                <!-- <div class="relative mb-4" >
                <input type="text" id="search_user_fullname" name="search_user_fullname" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">
                <label for="search_user_fullname" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 left-2 z-10 bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-blue-600">Fullname</label>
                <div id="employeeSuggestions" class="absolute left-0 bg-white border border-gray-300 rounded-md shadow-md w-full hidden mt-1 z-50"></div>
            </div>


            <div class="relative mb-4" >
                <input readonly type="text" id="add_user_id" name="add_user_id" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">
                <label for="add_user_id" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 left-2 z-10 bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-blue-600">Employee ID</label>
            </div>

            <div class="mb-4">
                <label for="add_user_designation" class="block text-sm font-medium text-gray-700">Office Designation</label>
                <input readonly type="text" id="add_user_designation" name="user_designation" class="w-full p-2 border rounded-md" required>
            </div> -->

                <div class="relative mb-4" hidden>
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
                    <label for="variety" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 left-2 z-10 bg-white px-2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-blue-600">Variety</label>
                </div>

                <div class="relative mb-4">
                    <input type="text" id="specification" name="specification" placeholder="Specification" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                </div>
            </div>
            <button type="submit" id="BtnaddToCart" class="px-4 py-2 bg-green-500 text-white rounded">Add to cart</button>
            <button type="button" id="closeCartModal" class="px-4 py-2 bg-red-500 text-white rounded">Close</button>
        </form>
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

                    alertify.success("Request submitted successfully!");
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




        // SEARCH FUNCTIONALITY
        $("#searchInput").on("keyup", function() {
            filterTable();
        });

        // DROPDOWN FILTER FUNCTIONALITY
        $("#dropDownsearchInput").on("change", function() {
            filterTable();
        });

        function filterTable() {
            var searchValue = $("#searchInput").val().toLowerCase();
            var departmentValue = $("#dropDownsearchInput").val().toLowerCase();

            $("#userTable tbody tr").filter(function() {
                var rowText = $(this).text().toLowerCase();
                var matchesSearch = rowText.indexOf(searchValue) > -1;
                var matchesDepartment = departmentValue === "all departments" || rowText.indexOf(departmentValue) > -1;

                $(this).toggle(matchesSearch && matchesDepartment);
            });
        }
    });
</script>


<?php include "components/footer.php"; ?>



<script src="assets/js/filter_assets_category.js"></script>