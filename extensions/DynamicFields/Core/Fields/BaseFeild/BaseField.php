<?php
namespace DynamicFields\Fields;

require_once __DIR__ . '/FieldOptions/FieldOptions.php';

use Exception;
use DynamicFields\Fields\FieldOptions;

/**
 * BaseFeild is base abstract class for custom fields implementations
 */
abstract class BaseField {
    private string $key = '';
    private ?string $label = '';
    private string $witdh = '100%';

    public function __construct( string $key, ?string $label = null )
    {
        if ( empty($key) ) {
            throw new Exception('The field key must not be empty!');
        }

        $this->key = $key;
        $this->label = $label;
    }

    /**
     * Setup new field label
     *
     * @param string|null $label
     * @return void
     */
    public function setLabel( ?string $label ) : void {
        $this->label = $label;
    }

    /**
     * Get the field label
     *
     * @return string Field label
     */
    public function getLabel() : string {
        return $this->label ?? $this->key;
    }


    /**
     * Set field Width
     * 
     * @example 100%, 100px, etc...
     *
     * @param string $width - new field width
     * @return void
     */
    public function setWidth( string $width ) {
        $this->witdh = $width;
    }

    /**
     * Get field Width
     *
     * @return string
     */
    public function getWidth() : string {
        return $this->witdh;
    }


    /**
     * Rendreing method
     * 
     * Override this method for change rendering method
     */
    public function getRendreingMethod() : int {
        return FieldRenderingMethod::METHOD_BUFFER;
    }

    /**
     * Rendering field DOM
     *
     * @param FieldOptions $fieldAttributs Field Attribute Map for Embedding in Dom
     * @return string|null
     */
    public function renderDom( FieldOptions $fieldAttributs ) : ?string {
        throw new Exception('BaseField implementation should override method renderDom!');
    }


    /**
     * Rendering field CSS
     * WARNING: the CSS text should not contain <style> tags
     *
     * @return string|null String with CSS text or null
     */
    public function renderCss() : ?string {
        return null;
    }


    /**
     * Rendering field CSS
     * WARNING: the JS script should not contain <script> tags and must be
     * wrapped in a self-calling function to avoid variables name collisions
     * 
     * @example [BEGIN] "use strict"; (function(){ console.log('Example'); })(); [END]
     * 
     * @return string|null String with JS text or null
     */
    public function renderJs() : ?string {
        return null;
    }
}

/**
 * Custom Dynamic Fields Rendering Method
 */
final class FieldRenderingMethod {
    /**
     * Rendering function should return STRING
     */
    public const METHOD_STRING = 0x01;

    /**
     * Rendering function can return null. All output 
     */
    public const METHOD_BUFFER = 0x02;
}