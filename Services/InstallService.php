<?php
namespace Services;

use Quark\DataProviders\MySQL;
use Quark\IQuarkTask;

use Quark\Quark;
use Quark\QuarkCLIViewBehavior;
use Quark\QuarkFile;
use Quark\QuarkINIIOProcessor;
use Quark\QuarkURI;

/**
 * Class InstallService
 *
 * @package Services
 */
class InstallService implements IQuarkTask {
	use QuarkCLIViewBehavior;

	/**
	 * @param int $argc
	 * @param array $argv
	 *
	 * @return mixed
	 */
	public function Task ($argc, $argv) {
		$this->ShellView(
			'HereNounce Installation',
			'Welcome to HereNounce installation'
		);

		echo "\r\n", 'Enter node hostname: ';
		$hostname = \readline();

		echo "\r\n", 'Enter local Helix port (default 8001): ';
		$helix = (int)\readline();

		echo "\r\n", 'Enter MySQL connection URI: ';
		$mysql = \readline();

		echo "\r\n", 'Applying settings... ';
		$source = new QuarkFile(__DIR__ . '/../.devops/docker/filesystem/app/runtime/application.ini', true);

		$ini = new QuarkINIIOProcessor();
		$settings = $source->Decode($ini);

		$settings->Quark->WebHost = 'http://' . $hostname;
		$settings->DataProviders->APP_DB = $mysql;
		$settings->{'Extension:APP_CDN'}->WebHost = 'http://' . $hostname . '/cdn';
		$settings->{'Extension:APP_HELIX'}->Port = $helix;

		$target = new QuarkFile(__DIR__ . '/../runtime/application.ini');

		if (!$target->Encode($ini, $settings)->SaveContent()) {
			echo 'FAILURE';
			return;
		}
		echo 'OK', "\r\n";

		$dbURI = QuarkURI::FromURI($settings->DataProviders->APP_DB);
		Quark::Config()->DataProvider(APP_DB)->URI($dbURI);

		echo 'Populating database... ';
		$sql = new QuarkFile(__DIR__ . '/../.devops/db/initial.sql', true);

		/**
		 * @var MySQL $db
		 */
		$db = Quark::Config()->DataProvider(APP_DB);
		$db->Connect($dbURI);
		$ok = $db->Query(preg_replace('#/\*([^/*]*)\*/;#Uis', '', $sql->Content()), array(
			MySQL::OPTION_QUERY_MULTIPLE => true
		));
		/*$ok = $db->Query($sql->Content(), array(
			MySQL::OPTION_QUERY_MULTIPLE => true
		))*/;

		if (!$ok) {
			echo 'FAILURE. Check application.log for details.';
			return;
		}
		echo 'OK', "\r\n";

		echo "\r\n", $this->ShellLineSuccess('Installation complete!');
	}
}