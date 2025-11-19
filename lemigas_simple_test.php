<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>TEST 1: PHP Working</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "✅ PHP is working!<br><br>";

echo "<h2>TEST 2: Database Connection</h2>";
$conn = new mysqli('localhost', 'root', '', 'lemigas_magang', 3306);

if ($conn->connect_error) {
    echo "❌ Database Error: " . $conn->connect_error . "<br>";
} else {
    echo "✅ Database connected!<br>";
    echo "Database: lemigas_magang<br><br>";
    
    echo "<h2>TEST 3: Check Tables</h2>";
    $tables = array('users', 'pendaftar', 'evaluasi');
    
    foreach ($tables as $table) {
        $check = $conn->query("SHOW TABLES LIKE '$table'");
        if ($check->num_rows > 0) {
            echo "✅ Table '$table' exists<br>";
        } else {
            echo "❌ Table '$table' NOT found<br>";
        }
    }
    
    echo "<br><h2>TEST 4: Check Data</h2>";
    $result = $conn->query("SELECT COUNT(*) as count FROM users");
    $row = $result->fetch_assoc();
    echo "Users count: " . $row['count'] . "<br>";
    
    $result = $conn->query("SELECT COUNT(*) as count FROM pendaftar");
    $row = $result->fetch_assoc();
    echo "Pendaftar count: " . $row['count'] . "<br>";
}

echo "<br><h2>✅ ALL TESTS COMPLETE</h2>";
echo "If all shows ✅ green, your setup is good!<br>";
echo "<a href='http://localhost/lemigas-magang/'>Go to Application</a>";
?>
