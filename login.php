<?php
include 'db.php'; // Include database connection

// Function to log suspicious input
function logInput($username, $password) {
    // Patterns to detect SQL injection
    $patterns = [
        "/'/",         // Single quote
        "/--/",        // SQL comment
        "/;/",         // Semi-colon
        "/UNION/i",    // UNION keyword
        "/SELECT/i",   // SELECT keyword
        "/DROP/i",     // DROP keyword
        "/INSERT/i",   // INSERT keyword
        "/UPDATE/i",   // UPDATE keyword
    ];

    $input = $username . " " . $password;
    $suspicious = false;

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $input)) {
            $suspicious = true;
            break;
        }
    }

    // Save logs
    $logFile = 'logs/sql_monitor.log';
    $logEntry = date('Y-m-d H:i:s') . " | IP: " . $_SERVER['REMOTE_ADDR'] . " | Username: $username | Suspicious: " . ($suspicious ? "Yes" : "No") . "\n";

    file_put_contents($logFile, $logEntry, FILE_APPEND);

    // If suspicious, block the request (optional)
    if ($suspicious) {
        die("Suspicious activity detected. Monitoring in progress.");
    }
}

// Function to log executed queries
function logQuery($query) {
    $logFile = 'logs/query_monitor.log';
    $logEntry = date('Y-m-d H:i:s') . " | Query: $query | IP: " . $_SERVER['REMOTE_ADDR'] . "\n";

    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

// Get input from POST request
$username = isset($_POST['username']) ? $_POST['username'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

// Log the input for monitoring
logInput($username, $password);

if (empty($username) || empty($password)) {
    die("Username or password cannot be empty.");
}

// Construct the vulnerable SQL query
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";

// Log the SQL query
logQuery($sql);

// Debugging: Output the SQL query (remove in production)
echo "Debug Query: $sql<br>";

// Execute the query
$result = $conn->query($sql);

// Check the result
if ($result && $result->num_rows > 0) {
    echo "Welcome, " . htmlspecialchars($username) . "!";
} else {
    echo "Invalid username or password.";
}

// Close the database connection
$conn->close();
?>
