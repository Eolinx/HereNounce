<?php
namespace Services\Api;

use Quark\IQuarkAnyService;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkServiceWithCustomRequestProcessor;

use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkSession;

use Extensions\Helix\Helix;

/**
 * Class HelixService
 *
 * @package Services\Api
 */
class HelixService implements IQuarkAnyService, IQuarkServiceWithCustomRequestProcessor {
	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function RequestProcessor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Any (QuarkDTO $request, QuarkSession $session) {
		$helix = new Helix(APP_HELIX);

		return $helix->Proxy($request);
	}
}