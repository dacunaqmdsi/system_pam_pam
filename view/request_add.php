<?php include "components/header.php"; ?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Assets</h2>
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



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const assetCodeInput = document.getElementById('add_assets_code');
        const assetTypeSelect = document.getElementById('add_assets_description');

        let nextId = 1;

        // Fetch the next ID from the server
        fetch('manager_assets_query2.php')
            .then(response => response.json())
            .then(data => {
                nextId = data.next_id || 1;
                updateAssetCode(); // Generate initial code
            })
            .catch(error => console.error('Error fetching next ID:', error));

        function updateAssetCode() {
            const selectedType = assetTypeSelect.value;
            let prefix = '';

            if (selectedType === 'Assets') {
                prefix = 'AST';
            } else if (selectedType === 'Office Supplies') {
                prefix = 'OFF';
            }

            const paddedId = String(nextId).padStart(4, '0'); // e.g. 0001
            assetCodeInput.value = prefix ? prefix + paddedId : '';
        }

        assetTypeSelect.addEventListener('change', updateAssetCode);
    });
</script>

<div align="right"><a href="request">BACK</a></div>

<!-- Modal for Adding Promo -->
<div id="">
    <div class="bg-white rounded-lg shadow-lg w-[40rem] max-h-[80vh] overflow-y-auto p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Assets</h3>
        <form id="addAssetFrm">

            <!-- Spinner -->
            <div class="spinner" id="spinner" style="display:none;">
                <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                    <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>



            <div class="mb-4">
                <label for="add_assets_img" class="block text-sm font-medium text-gray-700">Assets Image</label>
                <input type="file" id="add_assets_img" name="assets_img" class="w-full p-2 border rounded-md">
            </div>

            <?php
            $randomNumber = rand(1, 999);
            // $assetId = 'AST' . str_pad($randomNumber, 5, '0', STR_PAD_LEFT);
            ?>
            <div class="mb-4">
                <label for="add_assets_code" class="block text-sm font-medium text-gray-700">Asset ID</label>
                <input type="text" id="add_assets_code" name="assets_code" value="" class="w-full p-2 border rounded-md bg-gray-100" readonly required>
            </div>


            <div class="mb-4">
                <label for="add_assets_name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="add_assets_name" name="assets_name" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="add_assets_name" class="block text-sm font-medium text-gray-700">QTY</label>
                <input type="number" id="qty" name="qty" class="w-full p-2 border rounded-md" required>
            </div>



            <div class="mb-4">
                <label for="add_assets_description" class="block text-sm font-medium text-gray-700">Type</label>
                <select class="w-full p-2 border rounded-md" id="add_assets_description" name="assets_description" onchange="filterCategories()" required>
                    <option value="">Select Type</option>
                    <option value="Assets">Assets</option>
                    <option value="Office Supplies">Office Supplies</option>
                </select>
            </div>

            <div hidden class="mb-4">
                <label for="add_assets_price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="text" id="add_assets_price" name="assets_price" class="w-full p-2 border rounded-md">
            </div>


            <div class="mb-4">
                <label for="add_assets_Office" class="block text-sm font-medium text-gray-700">Office</label>
                <select name="assets_Office" id="add_assets_Office" class="w-full p-2 border rounded-md" required>
                    <option value="">Select Office</option>
                    <?php
                    $fetch_all_subcategory = $db->fetch_all_office();
                    if ($fetch_all_subcategory->num_rows > 0):
                        while ($subcategory = $fetch_all_subcategory->fetch_assoc()):
                    ?>

                            <option value="<?= $subcategory['id'] ?>"><?= $subcategory['office_name'] ?></option>

                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="p-2 text-center">No record found.</td>
                        </tr>
                    <?php endif; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="add_assets_category" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="assets_category" id="add_assets_category" class="w-full p-2 border rounded-md" required>
                    <option value="">Select Category</option>
                    <?php
                    $fetch_all_category = $db->fetch_all_category();
                    if ($fetch_all_category->num_rows > 0):
                        while ($category = $fetch_all_category->fetch_assoc()):
                    ?>
                            <option value="<?= $category['id'] ?>" data-type="<?= $category['type'] ?>">
                                <?= $category['category_name'] ?>
                            </option>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <option disabled>No record found.</option>
                    <?php endif; ?>
                </select>

            </div>

            <script>
                function show_p(id) {
                    const paperFields = [
                        document.getElementById("size").parentElement,
                        document.getElementById("brand").parentElement,
                        document.getElementById("unit").parentElement,
                        document.getElementById("paper_type").parentElement,
                        document.getElementById("thickness").parentElement
                    ];

                    if (id == 36) {
                        paperFields.forEach(field => field.hidden = false);
                    } else {
                        paperFields.forEach(field => field.hidden = true);
                    }
                }
            </script>



            <div class="mb-4">
                <label for="add_assets_subcategory" class="block text-sm font-medium text-gray-700">Subcategory</label>
                <select name="assets_subcategory" id="add_assets_subcategory" class="w-full p-2 border rounded-md" required>
                    <option value="">Select Subcategory</option>
                    <?php
                    $fetch_all_subcategory = $db->fetch_all_subcategory();
                    if ($fetch_all_subcategory->num_rows > 0):
                        while ($subcategory = $fetch_all_subcategory->fetch_assoc()):
                    ?>

                            <option data-category_id="<?= $subcategory['category_id'] ?>" value="<?= $subcategory['id'] ?>"><?= $subcategory['subcategory_name'] ?></option>

                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="p-2 text-center">No record found.</td>
                        </tr>
                    <?php endif; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="size">Size</label>
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
                <label for="brand">Brand</label>
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
                <label for="unit">Quantity (Unit)</label>
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
                <label for="paper_type">Paper Type</label>
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
                <label for="thickness">Thickness</label>
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


            <div class="mb-4">
                <label for="add_assets_condition" class="block text-sm font-medium text-gray-700">Condition</label>
                <select name="assets_condition" id="add_assets_condition" class="w-full p-2 border rounded-md" required>
                    <option value="New">New</option>
                    <option value="Good">Good</option>
                    <option value="Needs Repair">Needs Repair</option>
                    <option value="Damaged">Damaged</option>
                </select>
            </div>


            <div class="mb-4">
                <label for="add_assets_status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="assets_status" id="add_assets_status" class="w-full p-2 border rounded-md" required>
                    <option value="Available">Available</option>
                    <option value="Assigned">Assigned</option>
                    <option value="Under Maintenance">Under Maintenance</option>
                    <option value="Disposed">Disposed</option>
                </select>
            </div>




            <div class="mb-4">
                <label for="assets_variety_name" class="block text-sm font-medium text-gray-700">Specification</label>
                <input type="text" id="assets_variety_name" name="assets_variety_name" class="w-full p-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="assets_variety_value" class="block text-sm font-medium text-gray-700">More Specification</label>
                <div id="variety-values-container">
                    <input type="text" name="assets_variety_value[]" class="w-full p-2 mb-2 border rounded-md">
                </div>
                <button type="button" class="add-variety-value mt-2 text-blue-500">Add Another Specification</button>
            </div>

                <input type="text" hidden value="1" name="is_item"/>


            <div class="flex justify-end gap-2">
                <button type="button" class="addUserModalClose bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded-md">Cancel</button>
                <button id="btnAddAssets" type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md">Add new</button>
            </div>
        </form>
    </div>
</div>



<script>
    function filterCategories() {
        var selectedType = document.getElementById('add_assets_description').value;

        $("#add_assets_category option").each(function() {
            var categoryType = $(this).data("type");

            if (!categoryType || categoryType == selectedType) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        $("#add_assets_category").val(""); // Reset category select
    }
</script>


<script>
    $(document).ready(function() {

        $("#add_assets_category").change(function() {
            var selectedCategory = $(this).val();

            $("#add_assets_subcategory option").each(function() {
                var subcategoryCategoryId = $(this).data("category_id");

                if (!subcategoryCategoryId || subcategoryCategoryId == selectedCategory) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            $("#add_assets_subcategory").val("");
        });
    });


    $(document).ready(function() {
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#userTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>







</div>



<?php include "components/footer.php"; ?>