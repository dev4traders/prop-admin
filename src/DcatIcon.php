<?php
declare(strict_types=1);

namespace Dcat\Admin;
enum DcatIcon: string {
	public const PREFIX = 'fa-';
	public const BASE   = 'fas ';

	case CALENDAR = 'calendar';
	case HOME = 'home';
	case HELP = 'help-circle';
	case SETTINGS = 'cog';
	case LOGOUT = 'power-off';
	case GLOBE = 'globe';
	case DOTS_VERTICAL_ROUNDED = 'ellipsis-v';
	case MENU = 'menu';
	case EMAIL = 'envelope';
	case HIDE = 'eye-slash';
	case PENCIL = 'pencil';
	case MOBILE = 'mobile';
	case INTERNET = 'edit';
	case LAPTOP = 'laptop';
	case TERMINAL = 'terminal';
	case USER = 'user';
	case MESSAGE_SQUARE = 'message-square';
    case TRASH = 'trash';
    case EYE = 'eye';

	public function _(bool $fullTag = FALSE, ?string $title = null) {
		return self::format($this, $fullTag, $title);
	}

	public static function __callStatic($name, $args) {
		$fullTag = FALSE;
        $title = null;

		if ( $args && count($args) > 0 ) {
			$fullTag = $args[0];
            $title = isset($args[1]) ? $args[1] : '';
		}
		$cases = static::cases();
		foreach ($cases as $case) {
			if ( $case->name === $name ) {
				return $case->_($fullTag, $title);
			}
		}
	}

	public static function format(DcatIcon $icon, bool $fullTag = FALSE, ?string $title = null)
	: string {
		$class = self::BASE . self::PREFIX . $icon->value;
        $title = !is_null($title) ? 'title="'.$title.'"' : '';

		if ( $fullTag ) {
			return '<i class="'.$class.'" $title></i>';
		}
		return $class;
	}
}
