<?php

namespace Icinga\Module\Director\Objects;

use Icinga\Module\Director\Data\Db\DbObject;

class DirectorDictionaryfield extends DbObject
{
    protected $table = 'director_dictionaryfield';

    protected $keyName = array('dictionary_id', 'datafield_id');

    protected $defaultProperties = array(
        'dictionary_id'         => null,
        'datafield_id'          => null,
        'dictionaryfield_name' => null,
        'is_required'           => null,
        'allow_multiple'        => null
    );
}
