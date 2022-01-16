<?php
namespace DynamicFields\Fields;

use DynamicFields\Fields\FieldOptions;

class TextField extends BaseField {
    private ?string $value = '';
    private string $defaultValue = '';
    private array $attributes = [];

    /**
     * Set new TextField value
     *
     * @param string|null $value New TextField value
     * @return void
     */
    public function setValue( ?string $value ) : void {
        $this->value = $value;
    }

    /**
     * Get current TextField value
     *
     * @return string Current TextField value;
     */
    public function getValue() : string {
        return $this->value ?? $this->defaultValue;
    }


    /**
     * Set new TextField default value
     *
     * @param string|null $value New TextField default value
     * @return void
     */
    public function setDefaultValue( ?string $defaultValue ) : void {
        $this->defaultValue = $defaultValue ?? '';
    }

    /**
     * Get current TextField default value
     *
     * @return string Current TextField default value;
     */
    public function getDefaultValue() : string {
        return $this->defaultValue;
    }


    public function addAttribute( string $key, string $value ) : bool {
        if ( $key === 'id' ) {
            return false;
        }

        $this->attributes[$key] = "{$key}=\"$value\"";

        return true;
    }

    /// Overrided methods

    public function renderDom( FieldOptions $fieldOptions ) : ?string {
        $domId = $fieldOptions->getDomId();

        $textFeildClassList = ['js-text-field', "js-text-field-{$domId}"];
        if ( isset($this->attributes['class']) ) {
            $textFeildClassList[] = $this->attributes['class'];
        }

        $textFieldAttributes = array_values($this->attributes);
        ?>
            <div>
                <label for="<?= $domId ?>">
                    <?= $this->getLabel() ?>
                </label>
                
                <input
                    type="text"
                    id="<?= $domId ?>"
                    class="<?= implode(' ', $textFeildClassList) ?>"
                    value="<?= $this->getValue() ?>"
                    <?= print implode(' ', $textFieldAttributes) ?>
                >
            </div>
        <?php
        return null;
    }
}