<?php

namespace Tests\Icinga\Module\Director\Web\Form\Element;

use Icinga\Module\Director\Test\BaseTestCase;
use Icinga\Module\Director\Web\Form\Element\Dictionary;

class DictionaryTest extends BaseTestCase
{
    protected $dictionaryInstance;

    public function setUp() {
        parent::setUp();
        $this->dictionaryInstance = new Dictionary('fake_name');
    }

    public function testValidDictionary() {
        $this->dictionaryInstance->setDefaultValue([
            'key_one' => 0,
            'key_two' => ''
        ]);

        $this->dictionaryInstance->isValid([
            'key_one' => 42,
            'key_two' => 'foobar'
        ]);

        $this->assertFalse($this->dictionaryInstance->hasErrors());
    }

    public function testDictionaryWithMissingKey() {
        $this->dictionaryInstance->setDefaultValue([
            'key_one' => 0,
            'key_two' => '',
            'key_three' => ''
        ]);

        $this->dictionaryInstance->isValid([
            'key_one' => 42,
            'key_two' => 'foobar'
        ]);

        $this->assertTrue($this->dictionaryInstance->hasErrors());
        $errors = $this->dictionaryInstance->getMessages();
        $this->assertEquals(1, count($errors));
        $this->assertEquals('Key \'key_three\' is missing', $errors[0]);
    }

    public function testDictionaryWithMissingSubkey() {
        $this->dictionaryInstance->setDefaultValue([
            'key_one' => 0,
            'key_two' => [
                'sub_key_one' => ''
            ]
        ]);

        $this->dictionaryInstance->isValid([
            'key_one' => 0,
            'key_two' => []
        ]);

        $this->assertTrue($this->dictionaryInstance->hasErrors());
        $errors = $this->dictionaryInstance->getMessages();
        $this->assertEquals(1, count($errors));
        $this->assertEquals('Key \'key_two.sub_key_one\' is missing', $errors[0]);
    }

    public function testDictionaryWithKeyTypeMismatch() {
        $this->dictionaryInstance->setDefaultValue([
            'key_one' => 0
        ]);

        $this->dictionaryInstance->isValid([
            'key_one' => 'oh no a string'
        ]);

        $this->assertTrue($this->dictionaryInstance->hasErrors());
        $errors = $this->dictionaryInstance->getMessages();
        $this->assertEquals(1, count($errors));
        $this->assertEquals('Type mismatch, \'key_one\' is expected to be a \'integer\', \'string\' given', $errors[0]);
    }

    public function testDictionaryValidationWithRawJson() {
        $this->dictionaryInstance->setDefaultValue([
            'key_one' => 0,
            'key_two' => ''
        ]);

        $this->dictionaryInstance->isValid('{"key_one" : 42,"key_two" : "foobar"}');

        $this->assertFalse($this->dictionaryInstance->hasErrors());
    }
}