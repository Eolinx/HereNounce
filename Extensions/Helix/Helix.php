<?php
namespace Extensions\Helix;

use Quark\IQuarkExtension;
use Quark\Quark;
use Quark\QuarkDTO;
use Quark\QuarkHTTPClient;
use Quark\QuarkJSONIOProcessor;

/**
 * Class Helix
 *
 * @package Extensions\Helix
 */
class Helix implements IQuarkExtension {
	/**
	 * @var HelixConfig $_config
	 */
	private $_config;

	/**
	 * @param string $config
	 */
	public function __construct ($config) {
		$this->_config = Quark::Config()->Extension($config);
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return QuarkDTO
	 */
	public function Proxy (QuarkDTO $request) {
		$path = str_replace('--helix/', '', $request->URI()->path);
		$response = QuarkDTO::ForResponse(new QuarkJSONIOProcessor(), QuarkDTO::STATUS_400_BAD_REQUEST);

		if (preg_match('#^/api/network#is', $path))
			$response = $this->APINetwork();

		$response->Raw('');

		return $response;
	}

	public function APINetwork () {
		$response = QuarkHTTPClient::To(
			'http://localhost:' . $this->_config->Port() . '/api/network',
			QuarkDTO::ForGET(),
			new QuarkDTO(new QuarkJSONIOProcessor())
		);

		Quark::Trace($response);

		return $response;
	}
}