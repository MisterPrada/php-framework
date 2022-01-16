<?php
namespace DynamicFields\Fields;

class FieldOptions {
    /**
     * Dom INPUT element id attribute.
     *
     * @var string
     */
    private string $domId = '';

    public function __construct( string $domId ) {
        $this->domId = $domId;
    }

    public function getDomId() : string {
        return $this->domId;
    }
}