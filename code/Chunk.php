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

    public function getName() {
        return $this->Token;
    }

    public function getCMSFields()
    {
        $f = parent::getCMSFields();

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
            return $chunk->outputObject();
        }
        return false;
    }

    public function outputObject() {
        $type = $this->Type;
        if (!$this->hasField($type)) {
            user_error("Chunks do not have property '$type' defined");
        }
        return $this->dbObject($type);
    }


    public function forTemplate()
    {
        if ($type = $this->Type) {
            return $this->dbObject($type)->forTemplate();
        }
        return false;
    }

    /**
     * Parse the shortcode and render as a string, probably with a template
     *
     * @param array $arguments the list of attributes of the shortcode
     * @param string $content the shortcode content
     * @param ShortcodeParser $parser the ShortcodeParser instance
     * @param string $shortcode the raw shortcode being parsed
     *
     * @return string
     **/
    public static function parse_shortcode($arguments, $content, $parser, $shortcode)
    {
        return ChunkShortcodeHandler::handle_chunk_shortcode($arguments, $content, $parser, $shortcode);
    }

    /**
     * @return array
     */
    public function getShortcodableRecords() {
        return Chunk::get()->map('ID', 'Token')->toArray();
    }



}