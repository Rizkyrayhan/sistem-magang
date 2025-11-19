<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html>
<head>
    <title>LEMIGAS Debug</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .box { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #007bff; }
        .success { border-left-color: #28a745; }
        .error { border-left-color: #dc3545; }
        .info { border-left-color: #17a2b8; }
        h2 { margin-top: 0; }
        code { background: #f8f9fa; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>🔧 LEMIGAS Debug Information</h1>

    <!-- Check 1: PHP Version -->
    <div class="box info">
        <h2>✅ PHP Version</h2>
        <p><code><?php echo phpversion(); ?></code></p>
    </div>

    <!-- Check 2: Server Info -->
    <div class="box info">
        <h2>✅ Server Information</h2>
        <p><strong>Server Software:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
        <p><strong>Document Root:</strong> <code><?php echo $_SERVER['DOCUMENT_ROOT']; ?></code></p>
        <p><strong>Script Filename:</strong> <code><?php echo $_SERVER['SCRIPT_FILENAME']; ?></code></p>
        <p><strong>Script Name:</strong> <code><?php echo $_SERVER['SCRIPT_NAME']; ?></code></p>
        <p><strong>Request URI:</strong> <code><?php echo $_SERVER['REQUEST_URI']; ?></code></p>
    </div>

    <!-- Check 3: Path Analysis -->
    <div class="box info">
        <h2>🔍 Path Analysis</h2>
        <?php
        $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
        $basePath = trim(dirname($scriptName), '/');
        $request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        
        echo "<p><strong>Script Name:</strong> <code>$scriptName</code></p>";
        echo "<p><strong>Base Path:</strong> <code>$basePath</code></p>";
        echo "<p><strong>Request:</strong> <code>$request</code></p>";
        
        if ($basePath !== '') {
            $request = preg_replace('#^' . preg_quote($basePath, '#') . '/#i', '', $request);
        }
        
        if ($request === '' || $request === false) {
            $request = 'landing';
        }
        
        echo "<p><strong>Final Route:</strong> <code>$request</code></p>";
        ?>
    </div>

    <!-- Check 4: File Existence -->
    <div class="box info">
        <h2>📁 File Existence Check</h2>
        <?php
        $files_to_check = array(
            'config.php',
            'index.php',
            '.htaccess',
            'src/helpers/helper.php',
            'src/controllers/AuthController.php',
            'src/controllers/DaftarController.php',
            'src/controllers/EvaluasiController.php',
            'views/landing.php',
            'views/auth/login.php',
            'views/admin/dashboard.php'
        );
        
        foreach ($files_to_check as $file) {
            $exists = file_exists($file);
            $status = $exists ? '✅' : '❌';
            $class = $exists ? 'success' : 'error';
            echo "<p class='$class'><code>$status $file</code></p>";
        }
        ?>
    </div>

    <!-- Check 5: Database Connection -->
    <div class="box info">
        <h2>💾 Database Connection</h2>
        <?php
        $conn = @new mysqli('localhost', 'root', '', 'lemigas_magang', 3306);
        
        if ($conn->connect_error) {
            echo "<p class='error'>❌ Connection Error: " . $conn->connect_error . "</p>";
        } else {
            echo "<p class='success'>✅ Database connected successfully</p>";
            
            // Check tables
            $tables = array('users', 'pendaftar', 'evaluasi');
            foreach ($tables as $table) {
                $check = $conn->query("SHOW TABLES LIKE '$table'");
                if ($check && $check->num_rows > 0) {
                    echo "<p class='success'>✅ Table <code>$table</code> exists</p>";
                } else {
                    echo "<p class='error'>❌ Table <code>$table</code> NOT found</p>";
                }
            }
        }
        ?>
    </div>

    <!-- Check 6: .htaccess Configuration -->
    <div class="box info">
        <h2>⚙️ .htaccess Configuration</h2>
        <?php
        if (file_exists('.htaccess')) {
            $htaccess_content = file_get_contents('.htaccess');
            
            echo "<p class='success'>✅ .htaccess file exists</p>";
            
            if (strpos($htaccess_content, 'RewriteEngine') !== false) {
                echo "<p class='success'>✅ RewriteEngine found</p>";
            } else {
                echo "<p class='error'>❌ RewriteEngine NOT found</p>";
            }
            
            if (preg_match('/RewriteBase\s+(.+)/i', $htaccess_content, $matches)) {
                echo "<p><strong>RewriteBase:</strong> <code>" . trim($matches[1]) . "</code></p>";
            }
            
            echo "<hr>";
            echo "<h3>Content Preview:</h3>";
            echo "<pre style='background: #f8f9fa; padding: 10px; overflow-x: auto; border-radius: 5px;'>" . htmlspecialchars(substr($htaccess_content, 0, 500)) . "...</pre>";
        } else {
            echo "<p class='error'>❌ .htaccess file NOT found</p>";
        }
        ?>
    </div>

    <!-- Check 7: mod_rewrite Status -->
    <div class="box info">
        <h2>🔧 Apache Modules</h2>
        <?php
        if (function_exists('apache_get_modules')) {
            $modules = apache_get_modules();
            if (in_array('mod_rewrite', $modules)) {
                echo "<p class='success'>✅ mod_rewrite is ENABLED</p>";
            } else {
                echo "<p class='error'>❌ mod_rewrite is DISABLED</p>";
            }
            echo "<p><strong>All modules:</strong></p>";
            echo "<pre style='background: #f8f9fa; padding: 10px; max-height: 200px; overflow-y: auto;'>";
            foreach ($modules as $module) {
                echo htmlspecialchars($module) . "\n";
            }
            echo "</pre>";
        } else {
            echo "<p class='error'>Cannot check modules (function not available)</p>";
        }
        ?>
    </div>

    <!-- Check 8: Routing Test -->
    <div class="box info">
        <h2>🛣️ Routing Test</h2>
        <?php
        $test_routes = array(
            'landing' => 'views/landing.php',
            'login' => 'views/auth/login.php',
            'admin/dashboard' => 'views/admin/dashboard.php'
        );
        
        foreach ($test_routes as $route => $file) {
            $exists = file_exists($file);
            $status = $exists ? '✅' : '❌';
            echo "<p><code>$status Route: $route → $file</code></p>";
        }
        ?>
    </div>

    <!-- Check 9: Session Test -->
    <div class="box info">
        <h2>📦 Session Test</h2>
        <?php
        echo "<p>";
        if (session_status() === PHP_SESSION_ACTIVE) {
            echo "✅ Session is active";
        } else if (session_status() === PHP_SESSION_NONE) {
            echo "⚠️ Session not started";
        } else {
            echo "⚠️ Session disabled";
        }
        echo "</p>";
        echo "<p><strong>Session ID:</strong> <code>" . session_id() . "</code></p>";
        echo "<p><strong>Session Status:</strong> <code>" . session_status() . "</code></p>";
        ?>
    </div>

    <!-- Recommendations -->
    <div class="box info">
        <h2>📋 Recommendations</h2>
        <ul>
            <li>If <strong>mod_rewrite is disabled</strong>: Enable it in Apache configuration or use alternative routing</li>
            <li>If <strong>files are missing</strong>: Copy missing files to correct location</li>
            <li>If <strong>database connection fails</strong>: Check MySQL is running and credentials are correct</li>
            <li>If <strong>.htaccess has issues</strong>: Check RewriteBase matches your folder name</li>
        </ul>
    </div>

</body>
</html>
