<?php


namespace App\Http\Util;


class EntityChanges
{
    /*
     * @var string
     */
    private $field;
    /*
     * @var string
     */
    private $oldValue;
    /*
     * @var string
     */
    private $value;

    /**
     * EntityChanges constructor.
     * @param string $field
     * @param $oldValue
     * @param $value
     */
    public function __construct(string $field, $oldValue, $value)
    {
        $this->field = $field;
        $this->oldValue = $oldValue;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function field(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function oldValue(): string
    {
        return $this->oldValue;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
          'field' => $this->field,
          'oldValue' => $this->oldValue,
          'value' => $this->value
        ];
    }
}
