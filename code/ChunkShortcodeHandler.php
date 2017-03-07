<?php

/**
 * Created by PhpStorm.
 * User: robert
 * Date: 05.03.17
 * Time: 15:02
 */
class ChunkShortcodeHandler extends Object
{
    /**
     * Use by Shortcode
     * e.g.[chunk t=MyToken]
     * can be set by configuration:
     * ChunkShortcodeHandler:
     *   token_identifier: token # or whatever
     *
     *
     * @var string
     */
    private static $token_identifier = 't';

    public static function handle_chunk_shortcode($args, $token = null,$parser = null) {
        $ident=null;
        $needle = self::config()->token_identifier;
        if( is_array($args) && isset($args['id']) ) {
            return Chunk::get()->byID((int)$args['id']);
        } else {
            if ($token) {
                $ident = $token;
            } elseif (array_key_exists($needle, $args)) {
                $ident = $args[$needle];
            }
            if ($chunk = Chunk::by_token($ident)) {
                return $chunk;
            }
        }
        return false;
    }


}