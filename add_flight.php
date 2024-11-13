<?php include '../db_connection.php';

// Fetch all airlines
$query_airlines = "SELECT airline_id, airline_name FROM airline";
$result_airlines = $conn->query($query_airlines);
$airlines = [];
while ($row = $result_airlines->fetch_assoc()) {
    $airlines[] = $row;
}

// Fetch all routes
$query_routes = "SELECT route_id, CONCAT(airport1.airport_name, ' to ', airport2.airport_name) AS route_name
                 FROM route
                 JOIN airport AS airport1 ON route.origin_airport_id = airport1.airport_id
                 JOIN airport AS airport2 ON route.destination_airport_id = airport2.airport_id";
$result_routes = $conn->query($query_routes);
$routes = [];
while ($row = $result_routes->fetch_assoc()) {
    $routes[] = $row;
}

// Fetch all airplanes (for airplane_id selection)
$query_airplanes = "SELECT airplane_id, model AS airplane_model FROM airplane";
$result_airplanes = $conn->query($query_airplanes);
$airplanes = [];
while ($row = $result_airplanes->fetch_assoc()) {
    $airplanes[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $flight_number = $_POST['flight_number'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $status = $_POST['status'];
    $route_id = $_POST['route_id'];
    $airline_id = $_POST['airline_id'];
    $airplane_id = $_POST['airplane_id'];

    if (!isset($airplane_id) || empty($airplane_id)) {
        echo "Error: Airplane ID is required.";
    } else {
        $insertQuery = "INSERT INTO flight (flight_number, departure_time, arrival_time, status, route_id, airplane_id)
        VALUES ('$flight_number', '$departure_time', '$arrival_time', '$status', '$route_id', '$airplane_id')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "<script>alert('Airline added successfully!');</script>";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Flight</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-100 to-purple-200 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg w-full">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Add New Flight</h2>
        <p class="text-center text-gray-600 mb-6">Fill out the details below to add a new flight to the system.</p>

        <form action="add_flight.php" method="POST" class="space-y-4">
            <div>
                <label for="flight_number" class="block text-sm font-medium text-gray-700">Flight Number</label>
                <input type="text" name="flight_number" id="flight_number" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>

            <div>
                <label for="departure_time" class="block text-sm font-medium text-gray-700">Departure Time</label>
                <input type="datetime-local" name="departure_time" id="departure_time" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>

            <div>
                <label for="arrival_time" class="block text-sm font-medium text-gray-700">Arrival Time</label>
                <input type="datetime-local" name="arrival_time" id="arrival_time" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    <option value="Scheduled">Scheduled</option>
                    <option value="Delayed">Delayed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>

            <div>
                <label for="route_id" class="block text-sm font-medium text-gray-700">Route</label>
                <select name="route_id" id="route_id" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Select Route</option>
                    <?php foreach ($routes as $route): ?>
                        <option value="<?= $route['route_id']; ?>"><?= $route['route_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="airline_id" class="block text-sm font-medium text-gray-700">Airline</label>
                <select name="airline_id" id="airline_id" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Select Airline</option>
                    <?php foreach ($airlines as $airline): ?>
                        <option value="<?= $airline['airline_id']; ?>"><?= $airline['airline_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="airplane_id" class="block text-sm font-medium text-gray-700">Airplane</label>
                <select name="airplane_id" id="airplane_id" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Select Airplane</option>
                    <?php foreach ($airplanes as $airplane): ?>
                        <option value="<?= $airplane['airplane_id']; ?>"><?= $airplane['airplane_model']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">
                Add Flight
            </button>
        </form>

        <!-- Go Back Button -->
        <div class="text-center mt-4">
            <a href="admin.php" class="text-blue-500 hover:underline">Go Back</a>
        </div>

        <!-- Footer -->
        <footer class="mt-6 text-center text-gray-500 text-sm">
            &copy; <?= date('Y'); ?> Airline Management System. All Rights Reserved.
        </footer>
    </div>
</body>

</html>