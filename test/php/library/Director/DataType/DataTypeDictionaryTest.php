<?php

namespace Tests\Icinga\Module\Director\DataType;

use Icinga\Module\Director\DataType\DataTypeDictionary;
use Icinga\Module\Director\Test\BaseTestCase;
use Icinga\Module\Director\Web\Form\DirectorObjectForm;


class DataTypeDictionaryTest extends BaseTestCase
{
    private $dataType;

    public function setUp()
    {
        parent::setUp();
        $this->dataType = new DataTypeDictionary();
    }

    public function testGetFormElement() {
        $this->dataType->setSettings([
           'dictionary_id' => 123
        ]);

        $quickForm = new TestQuickForm($this);
        $quickForm->setDb($this->getDb());

        $element = $this->dataType->getFormElement('testName', $quickForm);

        var_dump($element);

        $this->assertTrue(true);
    }
}

class TestQuickForm extends DirectorObjectForm {
    public function __construct($options)
    {
        parent::__construct($options);
        $this->addPrefixPaths(array(
            array(
                'prefix'    => 'Icinga\\Module\\Director\\Web\\Form\\Element\\',
                'path'      => '/usr/share/icingaweb2/modules/director/library/Director/Web/Form/Element',
                'type'      => static::ELEMENT
            )
        ));
    }
}
