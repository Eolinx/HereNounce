<?php
namespace Services\Api;

use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\IQuarkSignedPostService;

use Quark\QuarkDTO;
use Quark\QuarkFile;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;

use Quark\Extensions\CDN\CDNResource;

/**
 * Class UploadService
 *
 * @package Services\Api
 */
class UploadService implements IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication, IQuarkSignedPostService, IQuarkServiceWithCustomProcessor {
	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return string
	 */
	public function AuthorizationProvider (QuarkDTO $request) {
		return APP_SESSION;
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return bool|mixed
	 */
	public function AuthorizationCriteria (QuarkDTO $request, QuarkSession $session) {
		return $session->User() != null;
	}

	/**
	 * @param QuarkDTO $request
	 * @param $criteria
	 *
	 * @return mixed
	 */
	public function AuthorizationFailed (QuarkDTO $request, $criteria) {
		return array('status' => 403);
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return mixed
	 */
	public function SignatureCheckFailedOnPost (QuarkDTO $request) {
		return array('status' => 403);
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		if (!isset($request->file) || !($request->file instanceof QuarkModel))
			return array('status' => 400);

		/**
		 * @var QuarkModel|QuarkFile $_file
		 */
		$_file = $request->file;

		/**
		 * @var QuarkFile $file
		 */
		$file = $_file->Model();

		if (!($file instanceof QuarkFile) || !in_array($file->type, $this->_allowed))
			return array('status' => 400);

		$resource = new CDNResource(APP_CDN);

		if (!$resource->Commit($file))
			return array('status' => 500);

		return array(
			'status' => 200,
			'resource' => $resource->Extract()
		);
	}

	/**
	 * @var string[] $_allowed
	 */
	private $_allowed = array(
		'image/png',
		'image/jpeg',
		'image/gif',
		'image/webp'
		/*'audio/x-m4a',
		'audio/mpeg',
		'video/mp4'*/
	);
}