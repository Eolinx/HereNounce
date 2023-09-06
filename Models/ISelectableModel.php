<?php
namespace Models;

use Quark\QuarkKeyValuePair;

/**
 * Interface ISelectableModel
 *
 * @package Models
 */
interface ISelectableModel {
	/**
	 * @return QuarkKeyValuePair
	 */
	public function SelectControlOption();
}