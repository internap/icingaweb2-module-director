<?php

namespace Tests\Icinga\Module\Director\DataType;

use Icinga\Module\Director\DataType\DataTypeDictionary;
use Icinga\Module\Director\Test\BaseTestCase;

class DataTypeDictionaryTest extends BaseTestCase
{
    private $dataType;

    public function setUp()
    {
        parent::setUp();
        $this->dataType = new DataTypeDictionary();
    }


}
