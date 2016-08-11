<?php

namespace Icinga\Module\Director\DataType;

use Icinga\Module\Director\Forms\DirectorDictionarySubForm;
use Icinga\Module\Director\Hook\DataTypeHook;
use Icinga\Module\Director\Web\Form\QuickForm;

class DataTypeDictionary extends DataTypeHook
{
    public function getFormElement($name, QuickForm $form)
    {
        $defaultValue = $this->getDefaultValue($this->getSetting('dictionary_id'), $form->getDb()->getDbAdapter());

        $element =$form->createElement('dictionary', $name, array(
            'label'       => 'DB Query',
            'rows'        => 5,
        ));

        $element->setDefaultValue($defaultValue);

        return $element;
    }

    public static function getFormat()
    {
        return 'json';
    }

    protected function getDefaultValue($dictionary_id, $db)
    {
        $result = array();

        $select = $db->select()
            ->from(array('dictionaryfield' => 'director_dictionaryfield'),
                array(
                    'varname' => 'datafield.varname',
                    'datatype' => 'datafield.datatype',
                    'setting_name' => 'setting.setting_name',
                    'setting_value' => 'setting.setting_value'
                ))
            ->where('dictionaryfield.dictionary_id = ?', $dictionary_id)
            ->joinLeft(
                array('datafield' => 'director_datafield'),
                'dictionaryfield.datafield_id = datafield.id',
                array()
            )
            ->joinLeft(
                array('setting' => 'director_datafield_setting'),
                'setting.datafield_id = datafield.id',
                array()
            )
            ->order('varname ASC');


        foreach ($db->fetchAll($select) as $field) {
            $result[$field->varname] = $this->getDefaultValueForField($field, $db);
        }
        return $result;
    }

    protected function getDefaultValueForField($field, $db) {
        switch ($field->datatype) {
            case 'Icinga\Module\Director\DataType\DataTypeArray':
                return [];
            case 'Icinga\Module\Director\DataType\DataTypeString':
                return "";
            case 'Icinga\Module\Director\DataType\DataTypeDictionary':
                if ($field->setting_name === 'dictionary_id' && $field->setting_value) {
                    return $this->getDefaultValue($field->setting_value, $db);
                }
                return null;
            default:
                return null;
        }
    }

    public static function addSettingsFormFields(QuickForm $form)
    {
        $db = $form->getDb();

        $form->addElement('select', 'dictionary_id', array(
            'label'    => 'Dictionary name',
            'required' => true,
            'multiOptions' => array(null => '- please choose -') +
                $db->enumDictionary(),
        ));
        return $form;
    }
}
