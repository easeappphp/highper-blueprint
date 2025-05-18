#!/usr/bin/env php
<?php
/**
 * Highper Server CLI Manager
 * 
 * This script provides CLI commands to start, stop, restart, and check status
 * of the Highper PHP server. It can be run directly or through systemd/supervisor.
 * 
 * Usage:
 * php highper-cli.php [command] [options]
 * 
 * Commands:
 *   start     - Start the server
 *   stop      - Stop the server
 *   restart   - Restart the server
 *   status    - Check server status
 *   help      - Display help information
 * 
 * Options:
 *   --host=HOST       - Host to bind to (default: 0.0.0.0)
 *   --port=PORT       - Port to bind to (default: 8080)
 *   --workers=N       - Number of worker processes (default: auto)
 *   --daemon          - Run in background mode
 *   --config=FILE     - Path to config file
 *   --log=FILE        - Path to log file
 *   --pid=FILE        - Path to PID file (default: ./highper-server.pid)
 */

// Server configuration
$defaultConfig = [
    'host' => '0.0.0.0',
    'port' => 8080,
    'workers' => null, // Auto-detect CPU count
    'daemon' => false,
    'config' => './config.php',
    'log' => './logs/highper-server.log',
    'pid' => './highper-server.pid',
];

// Parse command line arguments
$args = parseArguments($argv);
$command = $args['command'] ?? 'help';
$options = array_merge($defaultConfig, $args['options'] ?? []);

// Make sure log directory exists
if (!empty($options['log'])) {
    $logDir = dirname($options['log']);
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
}

// Execute the command
switch ($command) {
    case 'start':
        startServer($options);
        break;
    case 'stop':
        stopServer($options);
        break;
    case 'restart':
        restartServer($options);
        break;
    case 'status':
        serverStatus($options);
        break;
    case 'help':
    default:
        showHelp();
        break;
}

/**
 * Start the Highper server
 */
function startServer(array $options): void
{
    // Check if server is already running
    if (isServerRunning($options)) {
        echo "Server is already running. Use 'restart' to restart it.\n";
        return;
    }
    
    echo "Starting Highper server on {$options['host']}:{$options['port']}...\n";
    
    // Build the command to start the server
    $cmd = buildServerCommand($options);
    
    // Run in daemon mode if requested
    if ($options['daemon']) {
        echo "Starting in daemon mode...\n";
        startDaemon($cmd, $options);
    } else {
        // Run in foreground
        echo "Starting in foreground mode. Press Ctrl+C to stop.\n";
        passthru($cmd);
    }
}

/**
 * Stop the Highper server
 */
function stopServer(array $options): void
{
    echo "Stopping Highper server...\n";
    
    $pidFile = $options['pid'];
    
    if (!file_exists($pidFile)) {
        echo "PID file not found. Server is not running or was not started with this script.\n";
        return;
    }
    
    $pid = (int) trim(file_get_contents($pidFile));
    
    if ($pid <= 0) {
        echo "Invalid PID in file. Removing PID file.\n";
        unlink($pidFile);
        return;
    }
    
    // Check if process is running
    if (!posix_kill($pid, 0)) {
        echo "Process not found. Removing PID file.\n";
        unlink($pidFile);
        return;
    }
    
    // Try graceful shutdown first with SIGTERM
    posix_kill($pid, SIGTERM);
    
    // Wait for server to terminate
    $maxWaitTime = 10; // seconds
    $waited = 0;
    
    echo "Waiting for server to terminate";
    while (posix_kill($pid, 0) && $waited < $maxWaitTime) {
        echo ".";
        sleep(1);
        $waited++;
    }
    echo "\n";
    
    // If still running after timeout, force kill
    if (posix_kill($pid, 0)) {
        echo "Server did not terminate gracefully. Forcing shutdown...\n";
        posix_kill($pid, SIGKILL);
    } else {
        echo "Server terminated successfully.\n";
    }
    
    // Remove PID file
    if (file_exists($pidFile)) {
        unlink($pidFile);
    }
}

/**
 * Restart the Highper server
 */
function restartServer(array $options): void
{
    stopServer($options);
    sleep(1); // Brief pause to ensure ports are freed up
    startServer($options);
}

/**
 * Check server status
 */
function serverStatus(array $options): void
{
    $pidFile = $options['pid'];
    
    if (!file_exists($pidFile)) {
        echo "Server is NOT running (no PID file found).\n";
        return;
    }
    
    $pid = (int) trim(file_get_contents($pidFile));
    
    if ($pid <= 0) {
        echo "Server is NOT running (invalid PID in file).\n";
        return;
    }
    
    if (posix_kill($pid, 0)) {
        echo "Server is running with PID $pid on {$options['host']}:{$options['port']}.\n";
        
        // Try to get more details if available
        $processInfo = getProcessInfo($pid);
        if ($processInfo) {
            echo "Process details:\n";
            echo "  Started: " . date('Y-m-d H:i:s', $processInfo['start_time']) . "\n";
            echo "  CPU usage: {$processInfo['cpu']}%\n";
            echo "  Memory usage: {$processInfo['memory']} MB\n";
        }
    } else {
        echo "Server is NOT running (PID $pid not found).\n";
        echo "PID file exists but process is not running. Consider removing stale PID file.\n";
    }
}

/**
 * Show help information
 */
function showHelp(): void
{
    echo <<<EOT
Highper Server CLI Manager

Usage:
  php highper-cli.php [command] [options]

Commands:
  start     - Start the server
  stop      - Stop the server
  restart   - Restart the server
  status    - Check server status
  help      - Display this help information

Options:
  --host=HOST       - Host to bind to (default: 0.0.0.0)
  --port=PORT       - Port to bind to (default: 8080)
  --workers=N       - Number of worker processes (default: auto)
  --daemon          - Run in background mode
  --config=FILE     - Path to config file
  --log=FILE        - Path to log file
  --pid=FILE        - Path to PID file (default: ./highper-server.pid)

Examples:
  php highper-cli.php start
  php highper-cli.php start --port=9000 --daemon
  php highper-cli.php stop
  php highper-cli.php status

EOT;
}

/**
 * Parse command line arguments
 */
function parseArguments(array $argv): array
{
    $result = [
        'command' => null,
        'options' => [],
    ];
    
    // Skip script name
    array_shift($argv);
    
    if (empty($argv)) {
        return $result;
    }
    
    // First argument is the command
    $result['command'] = array_shift($argv);
    
    // Parse remaining arguments as options
    foreach ($argv as $arg) {
        if (strpos($arg, '--') === 0) {
            $arg = substr($arg, 2);
            
            if (strpos($arg, '=') !== false) {
                list($key, $value) = explode('=', $arg, 2);
                $result['options'][$key] = $value;
            } else {
                $result['options'][$arg] = true;
            }
        }
    }
    
    return $result;
}

/**
 * Build the command to start the server
 */
function buildServerCommand(array $options): string
{
    // Base command to run PHP with the correct script
    $cmd = 'php ';
    
    // Include the path to the main server script
    $serverScript = __DIR__ . '/vendor/easeappphp/highper/src/Http/Server/Server.php';
    
    // If custom config is specified, include it
    if (!empty($options['config']) && file_exists($options['config'])) {
        $cmd .= " --config={$options['config']}";
    }
    
    // Add the host and port options
    $cmd .= " --host={$options['host']} --port={$options['port']}";
    
    // Add workers if specified
    if (!empty($options['workers'])) {
        $cmd .= " --workers={$options['workers']}";
    }
    
    // Add the server script path
    $cmd .= " $serverScript";
    
    return $cmd;
}

/**
 * Start the server as a daemon process
 */
function startDaemon(string $cmd, array $options): void
{
    // Append log redirection
    $logFile = $options['log'];
    $cmd .= " > $logFile 2>&1 & echo $!";
    
    // Execute the command
    $pid = exec($cmd);
    
    if (!$pid) {
        echo "Failed to start daemon process.\n";
        exit(1);
    }
    
    // Save PID to file
    file_put_contents($options['pid'], $pid);
    
    echo "Server started with PID $pid.\n";
}

/**
 * Check if the server is running
 */
function isServerRunning(array $options): bool
{
    $pidFile = $options['pid'];
    
    if (!file_exists($pidFile)) {
        return false;
    }
    
    $pid = (int) trim(file_get_contents($pidFile));
    
    if ($pid <= 0) {
        return false;
    }
    
    // Check if process exists
    return posix_kill($pid, 0);
}

/**
 * Get process information
 */
function getProcessInfo(int $pid): ?array
{
    // Try to get process stats using ps command
    $cmd = "ps -p $pid -o %cpu,%mem,lstart | tail -n 1";
    $output = [];
    exec($cmd, $output, $returnVal);
    
    if ($returnVal !== 0 || empty($output)) {
        return null;
    }
    
    $stats = preg_split('/\s+/', trim($output[0]), -1, PREG_SPLIT_NO_EMPTY);
    
    if (count($stats) < 6) {
        return null;
    }
    
    // Parse the start time
    $startTimeStr = implode(' ', array_slice($stats, 2));
    $startTime = strtotime($startTimeStr);
    
    return [
        'cpu' => (float) $stats[0],
        'memory' => (float) $stats[1],
        'start_time' => $startTime,
    ];
}
