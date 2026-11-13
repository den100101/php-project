<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = (int)(getenv('DB_PORT') ?: 3306);
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASSWORD') ?: '';
    $name = getenv('DB_NAME') ?: 'defaultdb';

    $sslCa = getenv('DB_SSL_CA') ?: '/etc/secrets/ca.pem';

    error_log('DB_SSL_CA: ' . ($sslCa ?: 'NOT SET'));
    error_log('Certificate exists: ' . (file_exists($sslCa) ? 'YES' : 'NO'));
    error_log('Certificate readable: ' . (is_readable($sslCa) ? 'YES' : 'NO'));
    error_log('Certificate is file: ' . (is_file($sslCa) ? 'YES' : 'NO'));

    if (!is_file($sslCa) || !is_readable($sslCa)) {
        throw new RuntimeException('Aiven CA certificate is missing or unreadable.');
    }

    $conn = mysqli_init();
    $conn->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10);
    $conn->ssl_set(null, null, $sslCa, null, null);

    $conn->real_connect(
        $host,
        $user,
        $pass,
        $name,
        $port,
        null,
        MYSQLI_CLIENT_SSL
    );

    $conn->set_charset('utf8mb4');
} catch (Throwable $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    http_response_code(500);
    exit('Database connection failed. Please contact the administrator.');
}
