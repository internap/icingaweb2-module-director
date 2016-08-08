<?php

namespace Icinga\Module\Director\Forms;

use Icinga\Module\Director\Web\Form\DirectorObjectForm;
use Icinga\Authentication\Auth;

class DirectorDictionaryfieldForm extends DirectorObjectForm
{
    public function setup()
    {
        $this->addElement('text', 'dictionaryfield_name', array(
            'label'       => $this->translate('Name'),
            'description' => $this->translate(
                'poop'
            ),
            'required'    => true,
        ));
        $this->addElement('select', 'dictionary_id', array(
            'label' => $this->translate('Dictionary'),
            'description' => $this->translate(
                'Dictionary poop'
            ),
            'multiOptions' => $this->optionalEnum($this->enumDictionaries())
        ));
        $this->addElement('select', 'datafield_id', array(
            'label' => $this->translate('Datafield'),
            'description' => $this->translate(
                'Datafield poop'
            ),
            'multiOptions' => $this->optionalEnum($this->enumDatafields())
        ));

        $this->optionalBoolean(
            'is_required',
            $this->translate('Required'),
            $this->translate('Whether to option is required')
        );

        $this->optionalBoolean(
            'allow_multiple',
            $this->translate('Allow Multiple'),
            $this->translate('Whether to the field is an array of xxx')
        );
        
        $this->addSimpleDisplayGroup(array('dictionaryfield_name', 'dictionary_id', 'datafield_id', 'is_required', 'allow_multiple'),
            'dictionaryfield', array(
            'legend' => $this->translate('Dictionary Field')
        ));

        $this->setButtons();
    }

    protected function enumDictionaries()
    {
        $db = $this->db->getDbAdapter();
        $select = $db->select()->from(
            'director_dictionary',
            array(
                'id',
                'dictionary_name'
            )
        )->order('dictionary_name');

        return $db->fetchPairs($select);
    }

    protected function enumDatafields()
    {
        $db = $this->db->getDbAdapter();
        $select = $db->select()->from(
            'director_datafield',
            array(
                'id',
                'caption'
            )
        )->order('caption');

        return $db->fetchPairs($select);
    }
}
