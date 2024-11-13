<?php 
include '../db_connection.php';

// Fetch all available flights from the flight table
$sql = "SELECT flight_id, flight_number, departure_time, arrival_time, status FROM flight";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Flights</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <div class="max-w-5xl mx-auto p-4">
        <h1 class="text-3xl font-bold text-center text-green-600 mb-8">Available Flights</h1>

        <div class="mb-6">
            <form action="user.php" method="GET" class="flex justify-center space-x-4">
                <input type="text" name="search" placeholder="Search by flight number or status" 
                       class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" />
                <button type="submit" 
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Search</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead>
                    <tr class="bg-green-100 text-left text-gray-600 uppercase text-sm">
                        <th class="py-3 px-4 border-b">Flight ID</th>
                        <th class="py-3 px-4 border-b">Flight Number</th>
                        <th class="py-3 px-4 border-b">Departure Time</th>
                        <th class="py-3 px-4 border-b">Arrival Time</th>
                        <th class="py-3 px-4 border-b">Status</th>
                        <th class="py-3 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='border-b hover:bg-gray-50'>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["flight_id"]) . "</td>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["flight_number"]) . "</td>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["departure_time"]) . "</td>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["arrival_time"]) . "</td>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["status"]) . "</td>
                                <td class='py-3 px-4'>
                                    <a href='flight_details.php?id=" . urlencode($row["flight_id"]) . "' 
                                       class='text-blue-500 hover:underline'>View Details</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='py-4 text-center text-gray-500'>No flights available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>

<?php
$conn->close();
?>
