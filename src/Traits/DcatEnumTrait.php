<?php

namespace Dcat\Admin\Traits;

use ReflectionEnum;
use Dcat\Admin\DcatEnum;
use Exception;
use Exceptions\UndefinedCaseError;

/**
 * @implements \Dcat\Admin\DcatEnum;
 */
trait DcatEnumTrait
{
    protected static function ensureImplementsInterface(): void
    {
        throw_unless(class_implements(static::class, DcatEnum::class), new \Exception(sprintf('Enum %s must implement BackedEnum', static::class)));
    }

    // public static function options(): array
    // {
    //     static::ensureImplementsInterface();
    //     return array_map(fn($enum) => $enum->toArray(), self::cases());
    // }

    public static function names(): array
    {
        static::ensureImplementsInterface();
        return array_map(fn($enum) => $enum->name, self::cases());
    }

    public static function values(): array
    {
        static::ensureImplementsInterface();
        return array_map(fn($enum) => $enum->value, self::cases());
    }

    public static function mapCases(): array
    {
        static::ensureImplementsInterface();
        $array = [];

        foreach (self::cases() as $enum) {
            $array[$enum->name] = $enum->label();
        }

        return $array;
    }

    public static function map(): array
    {
        static::ensureImplementsInterface();
        $array = [];

        foreach (self::cases() as $enum) {
            $array[$enum->value] = $enum->label();
        }

        return $array;
    }

    public static function options(): array
    {
        static::ensureImplementsInterface();
        $array = [];

        foreach (self::cases() as $enum) {
            $array[$enum->name] = $enum->value;
        }

        return $array;
    }

    public static function labels(): array
    {
        static::ensureImplementsInterface();
        return array_map(fn($enum) => self::getLabel($enum->name), self::cases());
    }

    public static function labelFor(self $value): string
    {
        static::ensureImplementsInterface();
        $lang_key = sprintf(
            '%s.%s.%s',
            'enums',
            static::class,
            $value->value
        );

        return app('translator')->has($lang_key) ? __($lang_key) : $value->value;
    }

    public function label(): string
    {
        return static::labelFor($this);
    }

    public static function fromCase(string $case)
    {
        return (new ReflectionEnum(self::class))->getCase($case)->getValue()->value;
    }

    // public function toArray(): array
    // {
    //     static::ensureImplementsInterface();
    //     return [
    //         'name'  => $this->name,
    //         'value' => $this->value,
    //         'label' => $this->label()
    //     ];
    // }

    // public function toJson($options = 0): array
    // {
    //     static::ensureImplementsInterface();
    //     return $this->toArray();
    // }

    public function isA($value): bool
    {
        static::ensureImplementsInterface();
        return $this == $value;
    }

    public function isAn(string $value): bool
    {
        static::ensureImplementsInterface();
        return $this->isA($value);
    }

    public function isNot(string $value): bool
    {
        static::ensureImplementsInterface();
        return !$this->isA($value);
    }

    public function isAny(array $values): bool
    {
        static::ensureImplementsInterface();
        return in_array($this, $values);
    }

    public function isNotAny(array $values): bool
    {
        static::ensureImplementsInterface();
        return !$this->isAny($values);
    }

    public function __invoke()
    {
        return $this instanceof DcatEnum ? $this->value : $this->name;
    }

    /** Return the enum's value or name when it's called ::STATICALLY(). */
    public static function __callStatic($name, $args)
    {
        $cases = static::cases();

        foreach ($cases as $case) {
            if ($case->name === $name) {
                return $case instanceof DcatEnum ? $case->value : $case->name;
            }
        }

        $enum = static::class;
        throw new Exception("Undefined constant $enum::$name");
    }    
}
