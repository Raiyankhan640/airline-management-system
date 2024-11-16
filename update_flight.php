<?php
include '../db_connection.php';

// Fetch all flights
$query = "SELECT * FROM flight";
$result = $conn->query($query);
$flights = [];
while ($row = $result->fetch_assoc()) {
    $flights[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Flights</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-100 to-purple-200 min-h-screen">
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold text-center mb-6">Manage Flights</h2>
        <table class="min-w-full table-auto bg-white shadow-lg rounded-lg">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Flight Number</th>
                    <th class="px-4 py-2 border">Departure Time</th>
                    <th class="px-4 py-2 border">Arrival Time</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($flights as $flight): ?>
                    <tr>
                        <td class="px-4 py-2 border"><?= $flight['flight_number']; ?></td>
                        <td class="px-4 py-2 border"><?= $flight['departure_time']; ?></td>
                        <td class="px-4 py-2 border"><?= $flight['arrival_time']; ?></td>
                        <td class="px-4 py-2 border"><?= $flight['status']; ?></td>
                        <td class="px-4 py-2 border">
                            <a href="edit_flight.php?flight_number=<?= $flight['flight_number']; ?>"
                               class="text-blue-500 hover:text-blue-700">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
