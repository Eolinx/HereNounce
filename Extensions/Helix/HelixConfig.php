<?php
namespace Extensions\Helix;

use Quark\IQuarkExtension;
use Quark\IQuarkExtensionConfig;

/**
 * Class HelixConfig
 *
 * @package Extensions\Helix
 */
class HelixConfig implements IQuarkExtensionConfig {
	const DEFAULT_ENDPOINT = 'http://127.0.0.1:8011';

	/**
	 * @var string $_name = ''
	 */
	private $_name = '';

	/**
	 * @var string $_endpoint = self::DEFAULT_ENDPOINT
	 */
	private $_endpoint = self::DEFAULT_ENDPOINT;

	/**
	 * @param string $endpoint = self::DEFAULT_ENDPOINT
	 *
	 * @return string
	 */
	public function Endpoint ($endpoint = self::DEFAULT_ENDPOINT) {
		if (func_num_args() != 0)
			$this->_endpoint = $endpoint;

		return $this->_endpoint;
	}

	/**
	 * @param string $name
	 */
	public function Stacked ($name) {
		$this->_name = $name;
	}

	/**
	 * @return string
	 */
	public function ExtensionName () {
		return $this->_name;
	}

	/**
	 * @param object $ini
	 *
	 * @return mixed
	 */
	public function ExtensionOptions ($ini) {
		if (isset($ini->Endpoint))
			$this->Endpoint($ini->Endpoint);
	}

	/**
	 * @return IQuarkExtension
	 */
	public function ExtensionInstance () {
		return new Helix($this->_name);
	}
}