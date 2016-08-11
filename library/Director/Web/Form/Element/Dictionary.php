<?php

namespace Icinga\Module\Director\Web\Form\Element;

class Dictionary extends FormElement
{
    public $helper = 'formDictionary';
    private $structure = null;

    public function isValid($value, $context = null)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        return $this->validateNode($this->structure, $value);
    }

    protected function validateNode($structure, $value)
    {
        foreach ($structure as $key => $node) {
            if (!key_exists($key, $value)) {
                $this->addError(sprintf("Key '%s' is missing", $key));
                return false;
            } elseif (is_array($value[$key]) && !$this->validateNode($node, $value[$key])) {
                $this->addError(sprintf("Value for key %s: '%value%' is invalid", $key));
                return false;
            }
        }
        return true;
    }

    public function setDefaultValue($value)
    {
        $this->structure = $value;
        $this->setValue($value);
    }

    public function setValue($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        if ($value instanceof \stdClass) {
            $value = json_decode(json_encode($value), true);
        }
        return parent::setValue($value);
    }

    protected function _getErrorMessages()
    {
        $translator = $this->getTranslator();
        $messages   = $this->getErrorMessages();
        $value      = $this->getValue();
        foreach ($messages as $key => $message) {
            if (null !== $translator) {
                $message = $translator->translate($message);
            }
            $messages[$key] = str_replace('%value%', json_encode($value), $message);
        }
        return $messages;

    }

    public function getValue()
    {
        $value = parent::getValue();
        return $value;
    }
}

