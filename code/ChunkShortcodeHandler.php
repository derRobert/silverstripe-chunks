<?php

/**
 * Created by PhpStorm.
 * User: robert
 * Date: 05.03.17
 * Time: 15:02
 */
class ChunkShortcodeHandler extends Object
{
    private static $token_identifier = 't';

    public static function handle_chunk_shortcode($args, $token = null,$parser = null) {
        $ident=null;
        $needle = self::config()->token_identifier;
        if( $token ) {
            $ident = $token;
        } elseif ( array_key_exists($needle, $args) ) {
            $ident = $args[$needle];
        }
        if( $chunk = Chunk::get_by_token($ident) ) {
            return $chunk;
        }
        return false;
    }
}