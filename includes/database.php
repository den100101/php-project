
<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = (int)(getenv('DB_PORT') ?: 3306);
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$name = getenv('DB_NAME') ?: 'db_website';

try {
    $conn = mysqli_init();

    $sslCa = getenv('DB_SSL_CA');

    if (!empty($sslCa) && file_exists($sslCa)) {
        $conn->ssl_set(null, null, $sslCa, null, null);
    }

    $conn->real_connect(
        $host,
        $user,
        $pass,
        $name,
        $port,
        null,
        !empty($sslCa) && file_exists($sslCa)
            ? MYSQLI_CLIENT_SSL
            : 0
    );

    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log('Database connection failed: ' . $e->getMessage());

    http_response_code(500);
    exit('Database connection failed. Please contact the administrator.');
}
