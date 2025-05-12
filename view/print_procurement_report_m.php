<?php


include "components/header.php";
$fetch_all_user = $db->fetch_all_request_report_monthly();
$maintenance = $db->fetch_maintenance();

date_default_timezone_set('Asia/Manila');


$today = date('M. d, Y');
?>

<script>
    document.getElementById('dropDownsearchInput').addEventListener('change', function() {
        const selectedDepartment = this.value; // Get the selected value from the dropdown
        const printLinks = document.querySelectorAll('#printLink'); // Select all print links

        printLinks.forEach(function(link) {
            const requestMonth = link.closest('tr').querySelector('td').textContent.split(',')[0]; // Get the request month from the first column
            const requestYear = link.closest('tr').querySelector('td').textContent.split(' ')[1]; // Get the request year from the first column

            // Dynamically set the href attribute for each print link based on the selected department
            link.href = `print_procurement_report_m_detailed?month=${requestMonth}&year=${requestYear}&department=${selectedDepartment}`;
        });
    });
</script>
<div id="printArea">
    <!-- Header -->
    <div class="text-center mb-6">
        <img src="../assets/logo/<?= $maintenance['system_image'] ?>" alt="School Logo" class="mx-auto w-20 mb-2"> <!-- Optional -->
        <h1 class="text-xl font-bold uppercase text-red-700">Westmead International School</h1>
        <p class="text-sm">122 Gulod Labac, Batangas City, Batangas</p><?= $maintenance['system_image'] ?>
        <p class="text-sm">Email: westmead@gmail.com | Phone: (043) 425-7608</p>
        <h2 class="mt-4 text-lg font-semibold underline">Procurement Report</h2>
    </div>

    <!-- Report Metadata -->
    <div class="mb-6 text-sm">
        <p><strong>Date:</strong> <?= $today ?></p>
        <p><strong>Full Name:</strong> <?= $On_Session[0]['fullname'] ?></p>
        <p><strong>ID No:</strong> <?= $On_Session[0]['user_id'] ?></p>
        <p><strong>Office Designation:</strong> <?= $On_Session[0]['designation'] ?></p>
    </div>


    <div align="right">
        <select id="department" class="pl-4 pr-4 py-2  border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-400 focus:border-red-400 transition">
            <option value="">ALL Departments</option>
            <option value="Finance">Finance</option>
            <option value="Library">Library</option>
            <option value="Basic Education">Basic Education</option>
            <option value="IACEPO & NSTP">IACEPO & NSTP</option>
            <option value="WASTFI HEAD">WASTFI HEAD</option>
        </select>
    </div>

    <table class="w-full text-sm border border-gray-500 border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="border border-gray-400 p-2">Request Date (Monthly)</th>
                <th class="border border-gray-400 p-2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($fetch_all_user->num_rows > 0):
                while ($user = $fetch_all_user->fetch_assoc()):
                    $request_month = date('n', strtotime($user['request_date'])); // numeric month (1–12)
                    $request_year = date('Y', strtotime($user['request_date']));
                    $request_date = date('F, Y', strtotime($user['request_date'])); // Full Month, Year
            ?>
                    <tr class="border">
                        <td class="border border-gray-300 p-2 text-center"><?= $request_date ?></td>
                        <td class="border border-gray-300 p-2 text-center">
                            <a style="color:blue;" href="javascript:void(0);" class="print-link" data-month="<?= $request_month ?>" data-year="<?= $request_year ?>">Print</a>
                        </td>
                    </tr>
                <?php
                endwhile;
            else:
                ?>
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-4">No records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        // Listen for changes on the department dropdown
        document.getElementById('department').addEventListener('change', function() {
            updatePrintLinks();
        });

        // Function to update the print links with the selected department
        function updatePrintLinks() {
            var department = document.getElementById('department').value;

            var printLinks = document.querySelectorAll('.print-link');
            printLinks.forEach(function(link) {
                var month = link.getAttribute('data-month');
                var year = link.getAttribute('data-year');

                // Update the href attribute with the department and other parameters
                link.setAttribute('href', 'print_procurement_report_m_detailed?month=' + month + '&year=' + year + '&department=' + department);
            });
        }

        // Call the function initially to set up the links
        updatePrintLinks();
    </script>

    <!-- Footer Signatures -->
    <div class="mt-12 grid grid-cols-3 gap-4 text-center text-sm">
        <div>
            <p class="border-t border-gray-600 pt-2">Prepared by</p>
        </div>
        <div>
            <p class="border-t border-gray-600 pt-2">Noted by</p>
        </div>
        <div>
            <p class="border-t border-gray-600 pt-2">Approved by</p>
        </div>
    </div>
</div>

<hr>
<div class="text-center my-4">
    <button id="printButton" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Print Report
    </button>
</div>
<script>
    $('#printButton').on('click', function() {
        var printContents = $('#printArea').html();
        var printWindow = window.open('', '', 'height=800,width=1000');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Print Report</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
                    <style>
                        body { padding: 20px; font-family: sans-serif; }
                        table { border-collapse: collapse; width: 100%; }
                        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
                    </style>
                </head>
                <body onload="window.print(); setTimeout(() => window.close(), 100);">
                    ${printContents}
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.focus();
    });
</script>
<?php include "components/footer.php"; ?>