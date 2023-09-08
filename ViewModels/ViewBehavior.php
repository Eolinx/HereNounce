<?php
namespace ViewModels;

use Quark\IQuarkModel;

use Quark\QuarkCollection;
use Quark\QuarkDate;
use Quark\QuarkModel;
use Quark\QuarkViewBehavior;

use Models\ISelectableModel;
use Models\User;

/**
 * Trait ViewBehavior
 *
 * @package ViewModels
 */
trait ViewBehavior {
	use QuarkViewBehavior;

	/**
	 * @return string
	 */
	public function ViewTheme () {
		return 'Default';
	}

	/**
	 * @param string $subject
	 * @param string $act
	 * @param string $type = 'success'
	 *
	 * @return string
	 */
	public function StatusAct ($subject, $act, $allowed = [], $type = 'success') {
		return $act != '' && (sizeof($allowed) == 0 || in_array($act, $allowed)) ? '
			<div class="quark-container">
				<div class="quark-status ' . $type . '">
					' . $this->CurrentLocalizationOf('view.status.act.' . $subject . '.' . $act) . '
				</div>
			</div>
		' : '';
	}

	/**
	 * @param QuarkModel|IQuarkModel $model = null
	 * @param string $property = ''
	 * @param string $label = ''
	 * @param callable $valueProcessor = null
	 * @param string $id = null
	 *
	 * @return string
	 */
	public function Property (QuarkModel $model = null, $property = '', $label = '', callable $valueProcessor = null, $id = null, $dataID = false) {
		$type = '';
		$field = $model->Field($property);

		if ($field instanceof QuarkDate)
			$type = 'date';

		return '
			<div class="quark-container app-model-property' . ($type == '' ? '' : ' ' . $type) . '"' . ($id === null ? '' : ' id="' . $id . '"') . ($dataID ? ' data-property="' . $property . '"' : '') . '>
				<div class="quark-column">
					<span>' . $this->CurrentLocalizationOf('label.model.' . $label) . '</span>
					' . ($valueProcessor == null ? $model->$property : $valueProcessor($model->$property)) . '
				</div>
			</div>
		';
	}

	/**
	 * @param QuarkModel|IQuarkModel $model = null
	 * @param string $name = ''
	 * @param string $label = ''
	 * @param bool $localized = false
	 * @param string $type = 'text'
	 * @param bool $clear = false
	 * @param string $name_self = null
	 *
	 * @return string
	 */
	public function Input (QuarkModel $model = null, $name = '', $label = '', $localized = false, $type = 'text', $clear = false, $name_self = null) {
		$_name = $name_self == null ? $name : $name_self;

		return '
			<label class="quark-input">
				<span>' . $this->CurrentLocalizationOf('label.model.' . $label) . '</span>
				<input type="' . $type . '" name="' . $name . '"' . ($localized ? ' class="localized" ' . $this->LanguageControlAttributes() : '') . ' value="' . ($clear || $model == null ? '' : ($localized ? $model->$_name->ControlValue() : $model->$_name)) . '"' . ($clear ? ' autocomplete="off"' : '') . ' />
				' . $this->FieldError($model, $_name) . '
			</label>
		';
	}

	/**
	 * @param QuarkModel|IQuarkModel $model = null
	 * @param string $name = ''
	 * @param string $label = ''
	 * @param bool $localized = false
	 * @param bool $clear = false
	 * @param string $name_self = null
	 *
	 * @return string
	 */
	public function Textarea (QuarkModel $model = null, $name = '', $label = '', $localized = false, $clear = false, $name_self = null) {
		$_name = $name_self == null ? $name : $name_self;

		return '
			<label class="quark-input">
				<span>' . $this->CurrentLocalizationOf('label.model.' . $label) . '</span>
				<textarea name="' . $name . '"' . ($localized ? ' class="localized" ' . $this->LanguageControlAttributes() : '') . ($clear ? ' autocomplete="off"' : '') . '>' . ($clear || $model == null ? '' : ($localized ? $model->$_name->ControlValue() : $model->$_name)) . '</textarea>
				' . $this->FieldError($model, $_name) . '
			</label>
		';
	}

	/**
	 * @param QuarkModel|IQuarkModel $model = null
	 * @param string $name = ''
	 * @param string $label = ''
	 * @param array|QuarkCollection|ISelectableModel[] $options = []
	 * @param string $class = null
	 * @param callable $additional = null
	 * @param string $name_self = null
	 *
	 * @return string
	 */
	public function Select (QuarkModel $model = null, $name = '', $label = '', $options = [], $class = null, callable $additional = null, $name_self = null) {
		$_name = $name_self == null ? $name : $name_self;

		$opts = '';

		if ($additional == null)
			$additional = function ($option = null) {};

		if ($options instanceof QuarkCollection) {
			$opt = null;

			$opts .= '<option value=""' . ($model != null && $model->$_name->value == null ? ' selected="selected"' : '') . '>' . $this->CurrentLocalizationOf('label.model.' . $label . '.options.') . '</option>';

			foreach ($options as $option) {
				$opt = $option->SelectControlOption();

				$opts .= '<option value="' . $opt->Key() . '"' . ($model != null && $model->$_name->value == $opt->Key() ? ' selected="selected"' : '') . $additional($option) . '>' . $opt->Value() . '</option>';
			}

			unset($opt);
		}
		else {
			foreach ($options as $i => &$option)
				$opts .= '<option value="' . $option . '"' . ($model != null && $model->$_name == $option ? ' selected="selected"' : '') . $additional($option) . '>' . $this->CurrentLocalizationOf('label.model.' . $label . '.options.' . $option) . '</option>';

			unset($i, $option);
		}
		return '
			<label class="quark-input">
				<span>' . $this->CurrentLocalizationOf('label.model.' . $label) . '</span>
				<select name="' . $name . '"' . ($class === null ? '' : ' class="' . $class . '"') . '>
					' . $opts . '
				</select>
				' . $this->FieldError($model, $_name) . '
			</label>
		';
	}

	/**
	 * @param QuarkModel|IQuarkModel $model = null
	 * @param string $name = ''
	 * @param string $label = ''
	 * @param string $name_self = null
	 *
	 * @return string
	 */
	public function Flag (QuarkModel $model = null, $name = '', $label = '', $name_self = null) {
		$_name = $name_self == null ? $name : $name_self;

		return '
			<label class="quark-input">
				<span>' . $this->CurrentLocalizationOf('label.model.' . $label) . '</span>
				<input type="checkbox" name="' . $name . '"' . ($model->$name ? ' checked="checked"' : '') . ' />
				' . $this->FieldError($model, $_name) . '
			</label>
		';
	}

	public function Toggle (QuarkModel $model = null, $name = '', $label = '') {

	}

	/**
	 * @param QuarkModel|IQuarkModel $model = null
	 * @param string $name = ''
	 * @param string $label = ''
	 * @param bool $preview = false
	 * @param string $name_self = null
	 *
	 * @return string
	 */
	public function File (QuarkModel $model = null, $name = '', $label = '', $preview = false, $name_self = null) {
		$_name = $name_self == null ? $name : $name_self;

		return '
			<label class="quark-input upload">
				<span>' . $this->CurrentLocalizationOf('label.model.' . $label) . '</span>
				<div class="quark-container">
					<div class="quark-column upload-preview"' . ($model->$_name == null ? '' : 'style="background-image: url(' . $model->$_name->URL() . ');"') . '></div>
					<div class="quark-column">
						<a class="quark-link upload-trigger" quark-url="' . $this->Link('/api/upload') . '" quark-name="file" quark-signature="' . $this->Signature(false) . '">Upload</a>
						<a class="quark-link upload-remove">Remove</a>
					</div>
				</div>
				<input type="hidden" name="' . $name . '" value="' . $model->$_name->resource . '" />
				' . $this->FieldError($model, $_name) . '
			</label>
		';
	}

	/**
	 * @param string $model = ''
	 *
	 * @return string
	 */
	public function UnknownModel ($model = '') {
		return $this->CurrentLocalizationOf('view.static.unknown.' . $model);
	}

	/**
	 * @param string $id
	 * @param string $key
	 * @param array $vars = []
	 *
	 * @return string
	 */
	public function Dialog ($id, $key, $vars = []) {
		return str_replace('quark-message', 'quark-status', $this->Fragment(QuarkViewDialogFragment::WithClass(
			'app-dialog',
			$id,
			$this->TemplatedCurrentLocalizationOf('view.dialog.header.' . $key, $vars),
			$this->TemplatedCurrentLocalizationOf('view.dialog.content.' . $key, $vars),
			$this->CurrentLocalizationOf('view.dialog.message.wait'),
			$this->CurrentLocalizationOf('view.dialog.message.success'),
			$this->CurrentLocalizationOf('view.dialog.message.error'),
			$this->CurrentLocalizationOf('view.dialog.action.confirm'),
			$this->CurrentLocalizationOf('view.dialog.action.close')
		)));
	}

	/**
	 * @param QuarkModel|User $user = null
	 * @param string $id = ''
	 *
	 * @return string
	 */
	public function UserWidget (QuarkModel $user = null, $id = '', $actionLogout = false) {
		return $user == null ? '' : ('
			<div class="quark-container app-user"' . ($id == '' ? '' : ' id="' . $id . '"') .'>
				<div class="quark-column app-user-avatar" style="background-image: url(' . $user->avatar->URL() . ');"></div>
				<div class="quark-column app-user-meta">
					<div class="quark-container app-user-meta-name">' . $user->name . '</div>
					<div class="quark-container app-user-meta-actions">
						' . ($actionLogout ? '<a class="quark-link" href="' . $this->Link('/user/logout', true) . '">Log out</a>' : '') . '
					</div>
				</div>
			</div>
		');
	}

	/**
	 * @return string
	 */
	public function Side () {
		return '';
	}
}