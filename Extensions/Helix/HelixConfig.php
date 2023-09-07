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
	const DEFAULT_PORT = 8001;

	/**
	 * @var string $_name = ''
	 */
	private $_name = '';

	/**
	 * @var int $_port = self::DEFAULT_PORT
	 */
	private $_port = self::DEFAULT_PORT;

	/**
	 * @param int $port = self::DEFAULT_PORT
	 *
	 * @return int
	 */
	public function Port ($port = self::DEFAULT_PORT) {
		if (func_num_args() != 0)
			$this->_port = $port;

		return $this->_port;
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
		if (isset($ini->Port))
			$this->Port((int)$ini->Port);
	}

	/**
	 * @return IQuarkExtension
	 */
	public function ExtensionInstance () {
		return new Helix($this->_name);
	}
}