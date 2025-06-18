<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\Commands\Server;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use RuntimeException;

/**
 * Launch the PHP development server
 *
 * Not testable, as it throws phpunit for a loop :-/
 *
 * @codeCoverageIgnore
 */
class Serve extends BaseCommand
{
    /**
     * Group
     *
     * @var string
     */
    protected $group = 'CodeIgniter';

    /**
     * Name
     *
     * @var string
     */
    protected $name = 'serve';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Launches the CodeIgniter PHP-Development Server.';

    /**
     * Usage
     *
     * @var string
     */
    protected $usage = 'serve';

    /**
     * Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The current port offset.
     *
     * @var int
     */
    protected $portOffset = 0;

    /**
     * The max number of ports to attempt to serve from
     *
     * @var int
     */
    protected $tries = 10;

    /**
     * Options
     *
     * @var array
     */
    protected $options = [
        '--php'  => 'The PHP Binary [default: "PHP_BINARY"]',
        '--host' => 'The HTTP Host [default: "localhost"]',
        '--port' => 'The HTTP Host Port [default: "8080"]',
    ];

    /**
     * Validates the host input
     * 
     * @param string $host
     * @return string|false
     */
    protected function validateHost(string $host)
    {
        // Allow localhost
        if ($host === 'localhost') {
            return $host;
        }

        // Validate IP address
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            return $host;
        }

        // Validate hostname
        if (preg_match('/^[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}$/', $host)) {
            return $host;
        }

        return false;
    }

    /**
     * Validates the port number
     * 
     * @param int $port
     * @return int|false
     */
    protected function validatePort(int $port)
    {
        return filter_var($port, FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 1024,
                'max_range' => 65535
            ]
        ]);
    }

    /**
     * Validates and prepares the PHP binary path
     * 
     * @param string|null $php
     * @return string
     * @throws RuntimeException
     */
    protected function validatePhpBinary(?string $php = null)
    {
        $php = $php ?? PHP_BINARY;

        // Basic security check for the PHP binary path
        if (!is_file($php) || !is_executable($php)) {
            throw new RuntimeException('Invalid PHP binary path: ' . $php);
        }

        return $php;
    }

    /**
     * Validates the document root
     * 
     * @param string $docroot
     * @return string|false
     */
    protected function validateDocRoot(string $docroot)
    {
        if (!is_dir($docroot)) {
            return false;
        }

        // Ensure the path is absolute and normalized
        $realPath = realpath($docroot);
        if ($realPath === false) {
            return false;
        }

        return $realPath;
    }

    /**
     * Run the server
     */
    public function run(array $params)
    {
        try {
            // Validate PHP binary
            $php = $this->validatePhpBinary(CLI::getOption('php'));
            if ($php === false) {
                throw new RuntimeException('Invalid PHP binary specified');
            }

            // Validate host
            $host = CLI::getOption('host') ?? 'localhost';
            $host = $this->validateHost($host);
            if ($host === false) {
                throw new RuntimeException('Invalid host specified');
            }

            // Validate port
            $port = (int) (CLI::getOption('port') ?? 8080) + $this->portOffset;
            $port = $this->validatePort($port);
            if ($port === false) {
                throw new RuntimeException('Invalid port specified');
            }

            // Validate document root
            $docroot = FCPATH;
            $docroot = $this->validateDocRoot($docroot);
            if ($docroot === false) {
                throw new RuntimeException('Invalid document root');
            }

            // Validate rewrite file
            $rewriteFile = __DIR__ . '/rewrite.php';
            if (!is_file($rewriteFile) || !is_readable($rewriteFile)) {
                throw new RuntimeException('Rewrite file not found or not readable');
            }

            // Additional validation for security
            if (!preg_match('/^[a-zA-Z0-9\.\-]+$/', $host)) {
                throw new RuntimeException('Host contains invalid characters');
            }

            if (!is_numeric($port) || $port < 1024 || $port > 65535) {
                throw new RuntimeException('Port must be a number between 1024 and 65535');
            }

            // Validate and escape all command components
            $php = escapeshellcmd($php);
            $host = escapeshellarg($host . ':' . $port);
            $docroot = escapeshellarg($docroot);
            $rewrite = escapeshellarg($rewriteFile);

            // Build command with escaped components
            $command = sprintf('%s -S %s -t %s %s', $php, $host, $docroot, $rewrite);

            // Validate descriptor spec
            $descriptorspec = [
                0 => ['pipe', 'r'],  // stdin
                1 => ['pipe', 'w'],  // stdout
                2 => ['pipe', 'w'],  // stderr
            ];

            // Validate pipes array
            $pipes = [];

            // Execute with validated components
            $process = proc_open($command, $descriptorspec, $pipes);
            if (!is_resource($process)) {
                throw new RuntimeException('Failed to start the server process');
            }

            // Get process status
            $status = proc_get_status($process);
            if ($status === false) {
                throw new RuntimeException('Failed to get server process status');
            }

            // Close process properly
            $exitCode = proc_close($process);
            
            // Handle server startup failure
            if ($exitCode !== 0 && $this->portOffset < $this->tries) {
                $this->portOffset++;
                $this->run($params);
            } elseif ($exitCode !== 0) {
                throw new RuntimeException('Server failed to start after ' . $this->tries . ' attempts');
            }

        } catch (RuntimeException $e) {
            CLI::error($e->getMessage());
            exit(1);
        }
    }
}
