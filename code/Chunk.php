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
        'Token' => 'Varchar(255)',
        'Type'  => "Enum('Text,Html','Text')",
        'Text'  => 'Text',
        'Html'  => 'HTMLText',
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

        $fieldText = $f->dataFieldByName('Text');
        if( class_exists('DisplayLogicFormField') ) {
            $fieldText->displayIf('Type')->isEqualTo('Text')->end();
            $f->replaceField('Html',
                DisplayLogicWrapper::create(
                    HtmlEditorField::create('Html', 'Html')
                )->displayIf('Type')->isEqualTo('Html')->end()
            );
        }
        return $f;
    }

    public function scaffoldFormFields($_params = null)
    {
        $fields = parent::scaffoldFormFields($_params);
        if ($typeField = $fields->dataFieldByName('Type')) {
            $typeField->setSource(array(
                'Text' => _t('Chunk.db_Text', 'Text'),
                'Html' => _t('Chunk.db_Html', 'Html'),
            ));
        }
        return $fields;
    }

    /**
     * @param string $token
     * @return bool|DBField
     */
    public static function by_token($token)
    {
        if ($chunk = Chunk::get()->find('Token', $token)) {
            $type = $chunk->Type;
            if (!$chunk->hasField($type)) {
                user_error("Chunks do not have property '$type' defined");
            }
            return $chunk->dbObject($type);
        }
        return false;
    }

    public function forTemplate()
    {
        if ($type = $this->Type) {
            return $this->dbObject($type)->forTemplate();
        }
        return false;
    }


}