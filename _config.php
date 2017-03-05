<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 05.03.17
 * Time: 15:05
 */
ShortcodeParser::get('default')->register('chunk', array('ChunkShortcodeHandler', 'handle_chunk_shortcode'));