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
        'Typ'       => "Enum('Line,MultiLine,Html','Line')",
        'Token'     => 'Varchar(255)',
        'Line'      => 'Varchar(255)',
        'MultiLine' => 'Text',
        'Html'      => 'HTMLText',
    );

    private static $default_sort = '"Token"';

    private static $summary_fields = array(
        'ID',
        'Token',
    );

    public function getCMSFields() {
        $f = parent::getCMSFields();
        $f->removeByName('Html');
        $f->addFieldToTab('Root.Main', TextField::create('Token', 'Kürzel')->setDescription('Eindeutiges Kürzel für das Layout - sollte immer abgesprochen/kommuniziert werden und sich möglichst nicht ändern.'));
        $f->addFieldToTab('Root.Main', DropdownField::create('Typ', 'Typ', $this->dbObject('Typ')->enumValues()));

        $f->dataFieldByName('EinzeiligerText')->displayIf('Typ')->isEqualTo('einzeiliger Text')->end();
        $f->dataFieldByName('MehrzeiligerText')->displayIf('Typ')->isEqualTo('mehrzeiliger Text')->end();

        $f->removeByName('Subsites');
        $subsites_map = Subsite::get()->map('ID', 'Title');
        $f->addFieldToTab('Root.Main', CheckboxSetField::create('Subsites', 'Nur für Subsite:', $subsites_map));


        $f->addFieldToTab('Root.Main',
            DisplayLogicWrapper::create(
                HtmlEditorField::create('Html', 'Html')
            )->displayIf('Typ')->isEqualTo('Html')->end()
        );

        return $f;
    }

}