<?php

/**
 * Created by PhpStorm.
 * User: robert
 * Date: 05.03.17
 * Time: 12:10
 */
class Chunk extends DataObject
{

    private static $db = array(
        'Token'     => 'Varchar(255)',
        'Type'      => "Enum('Line,MultiLine,Html','Line')",
        'Line'      => 'Varchar(255)',
        'MultiLine' => 'Text',
        'Html'      => 'HTMLText',
    );

    private static $default_sort = '"Token"';

    private static $summary_fields = array(
        'ID',
        'Token',
    );

    public function getCMSFields()
    {
        $f = parent::getCMSFields();
        $f->removeByName('Html');

        $f->dataFieldByName('Line')
            ->displayIf('Type')->isEqualTo('Line')->end();
        $f->dataFieldByName('MultiLine')
            ->displayIf('Type')->isEqualTo('MultiLine')->end();

        $f->replaceField('Html',
            DisplayLogicWrapper::create(
                HtmlEditorField::create('Html', 'Html')
            )->displayIf('Type')->isEqualTo('Html')->end()
        );
        return $f;
    }

    public function scaffoldFormFields($_params = null)
    {
        $fields = parent::scaffoldFormFields($_params);
        if ($typeField = $fields->dataFieldByName('Type')) {
            $typeField->setSource(array(
                'Line'      => _t('Chunk.db_Line', 'Line'),
                'MultiLine' => _t('Chunk.db_MultiLine', 'MultiLine'),
                'Html'      => _t('Chunk.db_Html', 'Html'),
            ));
        }
        return $fields;
    }


}