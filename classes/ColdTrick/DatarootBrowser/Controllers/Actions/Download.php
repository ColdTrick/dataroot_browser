<?php

namespace ColdTrick\DatarootBrowser\Controllers\Actions;

use Elgg\Controllers\DownloadAction;
use Elgg\Exceptions\Http\BadRequestException;
use Elgg\Exceptions\Http\PageNotFoundException;
use Elgg\Filesystem\MimeTypeDetector;
use Elgg\Project\Paths;

/**
 * Download a file found in the dataroot
 */
class Download extends DownloadAction {
	
	protected ?string $file = null;
	
	/**
	 * {@inheritdoc}
	 */
	protected function sanitize(): void {
		$this->file = ltrim(Paths::sanitize(get_input('file'), false), '/');
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function validate(): void {
		if (empty($this->file)) {
			throw new BadRequestException(elgg_echo('error:missing_data'));
		}
		
		$path = $this->getFilePath();
		if (!file_exists($path) || is_dir($path)) {
			throw new PageNotFoundException(elgg_echo('notfound'));
		}
	}
	
	/**
	 * Get the file path in dataroot
	 *
	 * @return string
	 */
	protected function getFilePath(): string {
		return elgg_get_data_path() . $this->file;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getFilename(): string {
		return basename($this->getFilePath());
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getContents(): mixed {
		$contents = file_get_contents($this->getFilePath());
		if (empty($contents)) {
			throw new PageNotFoundException(elgg_echo('notfound'));
		}
		
		return $contents;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getMimeType(): string {
		$mtd = new MimeTypeDetector();
		
		return $mtd->getType($this->getFilePath());
	}
}
