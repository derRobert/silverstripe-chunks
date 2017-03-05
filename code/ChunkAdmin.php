<?php

/**
 * Created by PhpStorm.
 * User: robert
 * Date: 05.03.17
 * Time: 12:27
 */
class ChunkAdmin extends ModelAdmin
{

    private static $singular_name = 'Chunk';
    private static $plural_name = 'Chunks';

    private static $url_segment = 'chunks';
    private static $menu_title = 'Chunks';

    private static $managed_models = array(
        'Chunk'
    );

}