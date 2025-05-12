<?php
$result = $db->fetch_approved_request();

$i = 1;

while ($row = $result->fetch_assoc()) {
    echo '<tr class="bg-white border-b hover:bg-gray-50">';
    echo '<td class="p-3">' . $i++ . '</td>';
    echo '<td class="p-3">' . htmlspecialchars($row['request_invoice']) . '</td>';
    echo '<td class="p-3">' . htmlspecialchars($row['request_role']) . '</td>';
    echo '<td class="p-3">' . htmlspecialchars(date('Y-m-d', strtotime($row['request_date']))) . '</td>';
    echo '<td class="p-3 text-' .
        ($row['request_status'] === 'Approve' ? 'green' : ($row['request_status'] === 'pending' ? 'yellow' : 'red')) .
        '-600 font-semibold">' . htmlspecialchars($row['request_status']) . '</td>';
    echo '</tr>';
}
?>
