<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 05.03.17
 * Time: 14:55
 */
class ChunkExtension extends DataExtension {


    public function Chunk($token) {
        if( $chunk = Chunk::get_by_token($token) ) {
            return $chunk;
        }
        return false;
    }
}