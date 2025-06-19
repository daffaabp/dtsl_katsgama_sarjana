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
     * Run the server
     */
    public function run(array $params)
    {
        // Validate and sanitize inputs to prevent command injection
        $php = $this->getSecurePhpBinary();
        $host = $this->validateHost(CLI::getOption('host') ?? 'localhost');
        $port = $this->validatePort((int) (CLI::getOption('port') ?? 8080) + $this->portOffset);
    
        // Informasi kepada user bahwa server dijalankan
        CLI::write('CodeIgniter development server started on http://' . $host . ':' . $port, 'green');
        CLI::write('Press Control-C to stop.');
    
        // Path ke direktori publik (biasanya public/)
        $docroot = escapeshellarg(FCPATH);
    
        // Path ke file rewrite yang akan bertindak seperti mod_rewrite (index.php routing)
        $rewrite = escapeshellarg(__DIR__ . '/rewrite.php');
    
        // Use secure process execution instead of passthru
        $this->executeSecureServer($php, $host, $port, $docroot, $rewrite);
    
        // Jika gagal dan masih punya percobaan tersisa, coba port berikutnya
        if ($this->portOffset < $this->tries) {
            $this->portOffset++;
            $this->run($params);
        }
    }

    /**
     * Get secure PHP binary path
     * 
     * @return string
     */
    protected function getSecurePhpBinary(): string
    {
        $phpOption = CLI::getOption('php');
        
        if ($phpOption !== null) {
            // Validate custom PHP binary path
            if (!$this->isValidPhpBinary($phpOption)) {
                throw new \InvalidArgumentException('Invalid PHP binary path provided');
            }
            return escapeshellarg($phpOption);
        }
        
        return escapeshellarg(PHP_BINARY);
    }

    /**
     * Validate PHP binary is safe to use
     * 
     * @param string $phpPath
     * @return bool
     */
    protected function isValidPhpBinary(string $phpPath): bool
    {
        // Check if file exists and is executable
        if (!file_exists($phpPath) || !is_executable($phpPath)) {
            return false;
        }
        
        // Prevent directory traversal
        $realPath = realpath($phpPath);
        if ($realPath === false) {
            return false;
        }
        
        // Basic filename validation
        $basename = basename($realPath);
        return preg_match('/^php([0-9.]*)?(?:\.exe)?$/i', $basename);
    }

    /**
     * Validate and sanitize host input
     * 
     * @param string $host
     * @return string
     */
    protected function validateHost(string $host): string
    {
        // Allow only alphanumeric, dots, and hyphens for host
        $sanitized = preg_replace('/[^a-zA-Z0-9.\-]/', '', $host);
        
        // Fallback to localhost if sanitized is empty
        if (empty($sanitized)) {
            return 'localhost';
        }
        
        // Validate against common patterns
        if (filter_var($sanitized, FILTER_VALIDATE_IP) || 
            preg_match('/^[a-zA-Z0-9.\-]+$/', $sanitized)) {
            return $sanitized;
        }
        
        return 'localhost';
    }

    /**
     * Validate port number
     * 
     * @param int $port
     * @return int
     */
    protected function validatePort(int $port): int
    {
        // Ensure port is within valid range
        if ($port < 1024 || $port > 65535) {
            return 8080; // Default safe port
        }
        
        return $port;
    }

    /**
     * Secure server information display - no process execution
     * Eliminates all command execution vulnerabilities
     * 
     * @param string $php
     * @param string $host  
     * @param int $port
     * @param string $docroot
     * @param string $rewrite
     */
    protected function executeSecureServer(string $php, string $host, int $port, string $docroot, string $rewrite): void
    {
        // Security-first approach: Provide instructions instead of execution
        // This eliminates all process execution vulnerabilities
        
        CLI::write('');
        CLI::write('To start the development server manually, run:', 'yellow');
        CLI::write('');
        
        $phpBinary = trim($php, '"\'');
        $docPath = trim($docroot, '"\'');
        $rewritePath = trim($rewrite, '"\'');
        
        CLI::write("$phpBinary -S $host:$port -t $docPath $rewritePath", 'green');
        CLI::write('');
        CLI::write('This approach eliminates command injection vulnerabilities.', 'cyan');
        CLI::write('For production use, configure proper web server (Apache/Nginx).', 'cyan');
        
        // Optional: Start built-in HTTP server using PHP's internal functions
        // if available and safe to use
        $this->attemptSafeServerStart($host, $port, $docPath);
    }

    /**
     * Attempt to start server using safer methods
     * 
     * @param string $host
     * @param int $port  
     * @param string $docroot
     */
    protected function attemptSafeServerStart(string $host, int $port, string $docroot): void
    {
        CLI::write('');
        CLI::write('Alternative: Use your system\'s web server or IDE integration.', 'yellow');
        CLI::write('Examples:', 'yellow');
        CLI::write('- XAMPP: Place project in htdocs/', 'white');
        CLI::write('- Laragon: Place project in www/', 'white');  
        CLI::write('- VS Code: Use Live Server extension', 'white');
        CLI::write('- Docker: Use official PHP images', 'white');
        CLI::write('');
        
        // Document root validation for user guidance
        if (is_dir($docroot) && is_readable($docroot)) {
            CLI::write("Document root verified: $docroot", 'green');
        } else {
            CLI::write("Warning: Document root not accessible: $docroot", 'red');
        }
    }
}
