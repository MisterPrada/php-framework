<?php
namespace DynamicFields\Fields;

use DynamicFields\Fields\FieldOptions;

class TextField extends BaseField {
    private ?string $value = null;
    private string $defaultValue = '';
    private array $attributes = [];

    /**
     * @return string The Object Type Name
     * @throws Exception if Method not implemented
     */
    public function getTypeName() : string {
        return 'TextField';
    }

    /**
     * Set new TextField value
     *
     * @param string|null $value New TextField value
     * @return $this
     */
    public function setValue( ?string $value ) : self {
        $this->value = empty($value) ? null : $value;
        return $this;
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
     * @param string|null $defaultValue New TextField default value
     * @return $this
     */
    public function setDefaultValue( ?string $defaultValue ) : self {
        $this->defaultValue = $defaultValue ?? '';
        return $this;
    }

    /**
     * Get current TextField default value
     *
     * @return string Current TextField default value;
     */
    public function getDefaultValue() : string {
        return $this->defaultValue;
    }


    /**
     * @param string $key Attribute name
     * @param string $value Attribute value
     * @return $this
     */
    public function addAttribute( string $key, string $value ) : self {
        if ( $key === 'id' ) {
            return $this;
        }

        $this->attributes[$key] = "{$key}=\"$value\"";

        return $this;
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