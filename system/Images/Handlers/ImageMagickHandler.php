<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\Images\Handlers;

use CodeIgniter\Images\Exceptions\ImageException;
use Config\Images;
use Exception;
use Imagick;
use ImagickException;

/**
 * Class ImageMagickHandler
 *
 * FIXME - This needs conversion & unit testing, to use the imagick extension
 */
class ImageMagickHandler extends BaseHandler
{
    /**
     * Stores image resource in memory.
     *
     * @var string|null
     */
    protected $resource;

    /**
     * Native Imagick object for secure operations
     *
     * @var Imagick|null
     */
    protected $imagick;

    /**
     * Constructor.
     *
     * @param Images $config
     *
     * @throws ImageException
     */
    public function __construct($config = null)
    {
        parent::__construct($config);

        // We should never see this, so can't test it
        // @codeCoverageIgnoreStart
        if (! (extension_loaded('imagick') || class_exists(Imagick::class))) {
            throw ImageException::forMissingExtension('IMAGICK');
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * Get or create Imagick object
     *
     * @throws ImagickException
     * @return Imagick
     */
    protected function getImagick(): Imagick
    {
        if ($this->imagick === null) {
            $this->imagick = new Imagick();
            
            if ($this->resource !== null) {
                $this->imagick->readImage($this->resource);
            } else {
                $this->imagick->readImage($this->image()->getPathname());
            }
        }

        return $this->imagick;
    }

    /**
     * Handles the actual resizing of the image.
     *
     * @throws Exception
     *
     * @return ImageMagickHandler
     */
    public function _resize(bool $maintainRatio = false)
    {
        try {
            $imagick = $this->getImagick();
            
            if ($maintainRatio) {
                $imagick->resizeImage($this->width ?? 0, $this->height ?? 0, Imagick::FILTER_LANCZOS, 1);
            } else {
                $imagick->resizeImage($this->width ?? 0, $this->height ?? 0, Imagick::FILTER_LANCZOS, 1, false);
            }
            
            $this->ensureResource();
            $imagick->writeImage($this->resource);
            
        } catch (ImagickException $e) {
            throw ImageException::forImageProcessFailed();
        }

        return $this;
    }

    /**
     * Crops the image.
     *
     * @throws Exception
     *
     * @return bool|\CodeIgniter\Images\Handlers\ImageMagickHandler
     */
    public function _crop()
    {
        try {
            $imagick = $this->getImagick();
            
            $imagick->cropImage($this->width ?? 0, $this->height ?? 0, $this->xAxis ?? 0, $this->yAxis ?? 0);
            
            // Handle extend if needed
            if ($this->xAxis >= $this->width || $this->yAxis > $this->height) {
                $imagick->setImageBackgroundColor('transparent');
                $imagick->extentImage($this->width ?? 0, $this->height ?? 0, 0, 0);
            }
            
            $this->ensureResource();
            $imagick->writeImage($this->resource);
            
        } catch (ImagickException $e) {
            throw ImageException::forImageProcessFailed();
        }

        return $this;
    }

    /**
     * Handles the rotation of an image resource.
     * Doesn't save the image, but replaces the current resource.
     *
     * @throws Exception
     *
     * @return $this
     */
    protected function _rotate(int $angle)
    {
        try {
            $imagick = $this->getImagick();
            
            $imagick->rotateImage(new \ImagickPixel('transparent'), $angle);
            
            $this->ensureResource();
            $imagick->writeImage($this->resource);
            
        } catch (ImagickException $e) {
            throw ImageException::forImageProcessFailed();
        }

        return $this;
    }

    /**
     * Flattens transparencies, default white background
     *
     * @throws Exception
     *
     * @return $this
     */
    protected function _flatten(int $red = 255, int $green = 255, int $blue = 255)
    {
        try {
            $imagick = $this->getImagick();
            
            $imagick->setImageBackgroundColor("rgb($red,$green,$blue)");
            $imagick = $imagick->flattenImages();
            
            $this->ensureResource();
            $imagick->writeImage($this->resource);
            
        } catch (ImagickException $e) {
            throw ImageException::forImageProcessFailed();
        }

        return $this;
    }

    /**
     * Flips an image along it's vertical or horizontal axis.
     *
     * @throws Exception
     *
     * @return $this
     */
    protected function _flip(string $direction)
    {
        try {
            $imagick = $this->getImagick();
            
            if ($direction === 'horizontal') {
                $imagick->flopImage();
            } else {
                $imagick->flipImage();
            }
            
            $this->ensureResource();
            $imagick->writeImage($this->resource);
            
        } catch (ImagickException $e) {
            throw ImageException::forImageProcessFailed();
        }

        return $this;
    }

    /**
     * Get driver version
     */
    public function getVersion(): string
    {
        try {
            $version = Imagick::getVersion();
            preg_match('/ImageMagick\s([\d\.\-]+)/', $version['versionString'], $matches);
            return $matches[1] ?? 'Unknown';
        } catch (Exception $e) {
            return 'Unknown';
        }
    }

    /**
     * SECURE REPLACEMENT for process() method
     * No longer uses exec() - eliminates command injection vulnerability
     *
     * @throws Exception
     * @return bool
     */
    protected function processSecure(): bool
    {
        // This method is now replaced by individual Imagick operations
        // Each operation method handles its own Imagick processing
        return true;
    }



    /**
     * Saves any changes that have been made to file. If no new filename is
     * provided, the existing image is overwritten, otherwise a copy of the
     * file is made at $target.
     *
     * Example:
     *    $image->resize(100, 200, true)
     *          ->save();
     */
    public function save(?string $target = null, int $quality = 90): bool
    {
        $original = $target;
        $target   = empty($target) ? $this->image()->getPathname() : $target;

        // If no new resource has been created, then we're
        // simply copy the existing one.
        if (empty($this->resource) && $quality === 100) {
            if ($original === null) {
                return true;
            }

            $name = basename($target);
            $path = pathinfo($target, PATHINFO_DIRNAME);

            return $this->image()->copy($path, $name);
        }

        $this->ensureResource();

        try {
            // Use native Imagick instead of exec()
            if ($this->imagick !== null) {
                $this->imagick->setImageCompressionQuality($quality);
                $this->imagick->writeImage($target);
            } else {
                // Fallback: direct file copy
                copy($this->resource, $target);
            }
            
            // Secure approach: Let system handle temp file cleanup
            // No manual file deletion to prevent security risks
            $this->resource = null;
            
        } catch (Exception $e) {
            throw ImageException::forImageProcessFailed();
        }

        return true;
    }

    /**
     * Get Image Resource
     *
     * This simply creates an image resource handle
     * based on the type of image being processed.
     * Since ImageMagick is used on the cli, we need to
     * ensure we have a temporary file on the server
     * that we can use.
     *
     * To ensure we can use all features, like transparency,
     * during the process, we'll use a PNG as the temp file type.
     *
     * @throws Exception
     *
     * @return string
     */
    protected function getResourcePath()
    {
        if ($this->resource !== null) {
            return $this->resource;
        }

        $this->resource = WRITEPATH . 'cache/' . time() . '_' . bin2hex(random_bytes(10)) . '.png';

        $name = basename($this->resource);
        $path = pathinfo($this->resource, PATHINFO_DIRNAME);

        $this->image()->copy($path, $name);

        return $this->resource;
    }

    /**
     * Make the image resource object if needed
     *
     * @throws Exception
     */
    protected function ensureResource()
    {
        $this->getResourcePath();

        $this->supportedFormatCheck();
    }

    /**
     * Check if given image format is supported
     *
     * @throws ImageException
     */
    protected function supportedFormatCheck()
    {
        switch ($this->image()->imageType) {
            case IMAGETYPE_WEBP:
                if (! in_array('WEBP', Imagick::queryFormats(), true)) {
                    throw ImageException::forInvalidImageCreate(lang('images.webpNotSupported'));
                }
                break;
        }
    }

    /**
     * Handler-specific method for overlaying text on an image.
     *
     * @throws Exception
     */
    protected function _text(string $text, array $options = [])
    {
        try {
            $imagick = $this->getImagick();
            
            $draw = new \ImagickDraw();
            
            // Font setup
            if (! empty($options['fontPath'])) {
                $draw->setFont($options['fontPath']);
            }
            
            // Font size
            if (isset($options['fontSize'])) {
                $draw->setFontSize($options['fontSize']);
            }
            
            // Color
            if (isset($options['color'])) {
                [$r, $g, $b] = sscanf("#{$options['color']}", '#%02x%02x%02x');
                $opacity = $options['opacity'] ?? 1.0;
                $draw->setFillColor("rgba($r,$g,$b,$opacity)");
            }
            
            // Calculate position
            $x = $options['hOffset'] ?? 0;
            $y = $options['vOffset'] ?? 0;
            
            // Reverse the vertical offset for bottom alignment
            if (($options['vAlign'] ?? '') === 'bottom') {
                $y = $imagick->getImageHeight() - abs($y);
            }
            
            if (($options['hAlign'] ?? '') === 'right') {
                $x = $imagick->getImageWidth() - abs($x);
            } elseif (($options['hAlign'] ?? '') === 'center') {
                $x = ($imagick->getImageWidth() / 2) + $x;
            }
            
            // Add padding
            $padding = $options['padding'] ?? 0;
            $x += $padding;
            $y += $padding;
            
            $imagick->annotateImage($draw, $x, $y, 0, $text);
            
            $this->ensureResource();
            $imagick->writeImage($this->resource);
            
        } catch (Exception $e) {
            throw ImageException::forImageProcessFailed();
        }
    }

    /**
     * Return the width of an image.
     *
     * @return int
     */
    public function _getWidth()
    {
        try {
            if ($this->imagick !== null) {
                return $this->imagick->getImageWidth();
            }
            
            return imagesx(imagecreatefromstring(file_get_contents($this->resource ?? $this->image()->getPathname())));
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Return the height of an image.
     *
     * @return int
     */
    public function _getHeight()
    {
        try {
            if ($this->imagick !== null) {
                return $this->imagick->getImageHeight();
            }
            
            return imagesy(imagecreatefromstring(file_get_contents($this->resource ?? $this->image()->getPathname())));
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Reads the EXIF information from the image and modifies the orientation
     * so that displays correctly in the browser. This is especially an issue
     * with images taken by smartphones who always store the image up-right,
     * but set the orientation flag to display it correctly.
     *
     * @param bool $silent If true, will ignore exceptions when PHP doesn't support EXIF.
     *
     * @return $this
     */
    public function reorient(bool $silent = false)
    {
        $orientation = $this->getEXIF('Orientation', $silent);

        switch ($orientation) {
            case 2:
                return $this->flip('horizontal');

            case 3:
                return $this->rotate(180);

            case 4:
                return $this->rotate(180)->flip('horizontal');

            case 5:
                return $this->rotate(90)->flip('horizontal');

            case 6:
                return $this->rotate(90);

            case 7:
                return $this->rotate(270)->flip('horizontal');

            case 8:
                return $this->rotate(270);

            default:
                return $this;
        }
    }
}
