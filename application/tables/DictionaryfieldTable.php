<?php

namespace Icinga\Module\Director\Tables;

use Icinga\Module\Director\Web\Table\QuickTable;

class DictionaryfieldTable extends QuickTable
{
    protected $searchColumns = array(
        'dictionaryfield_name',
    );

    public function getColumns()
    {
        return array(
            'dictionary_id'         => 'l.dictionary_id',
            'datafield_id'          => 'l.datafield_id',
            'dictionaryfield_name' => 'l.dictionaryfield_name',
            'is_required'           => 'l.is_required',
            'allow_multiple'        => 'l.allow_multiple',
        );
    }

    protected function getActionUrl($row)
    {
        return $this->url(
            'director/data/dictionaryfield',
            array(
                'dictionary_id' => $row->dictionary_id,
                'datafield_id' => $row->datafield_id,
            )
        );
    }

    public function getTitles()
    {
        $view = $this->view();
        return array(
            'dictionaryfield_name' => $view->translate('Dictionary Field Name'),
        );
    }

    public function getBaseQuery()
    {
        $db = $this->connection()->getConnection();

        $query = $db->select()->from(
            array('l' => 'director_dictionaryfield'),
            array()
        )->order('dictionaryfield_name ASC');

        return $query;
    }
}
