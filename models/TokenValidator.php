<?php

namespace app\models;

abstract class TokenValidator {

    const SPACE = 'space';
    const WORD = 'word';
    const NUMERIC = 'numeric';
    const PUNCTUATION = 'punct';
    const PUNCTUATION_A = 'punct_a';
    const HASHTAG = 'hash';
    const MENTIONS = 'mentions';
    const URL = 'url';
    const EMOTICONS = 'emoticons';

    static protected $REGEX_ARRAY = array(
        self::SPACE => "([\s]+)",
        self::WORD => "([\a-zãÃáÁàÀâÂéẽẼÉèÈêÊĩĨíÍìÌîÎõÕóÓòÒôÔũŨúÚùÙûÛçÇ]+)",
        self::NUMERIC => "([\+\-]?[\d,\.\\/\\(\\)]+)",
        self::PUNCTUATION => "([\\[\\]\\^\\$\\.\\|\\?\\*\\+\\(\\)\\\\~`\\!@#%&\\-_+={}'\\\"<>:;,]+)",
        self::PUNCTUATION_A => "([\\[\\]\\^\\$\\.\\|\\?\\*\\+\\(\\)\\\\~`\\!@#%&\\-_+={}'\\\"<>:;,])",
        self::HASHTAG => "(\#.*)",
        self::MENTIONS => "(\@.*)",
        self::URL => "(http[s]?:\\/(?:[a-z]|[0-9]|[$-_@.&amp;+]|[!*\(\),]|(?:%[0-9a-f][0-9a-f]))+)",
        self::EMOTICONS => "(?:[:=;][oO\-]?[D\\)\\]\\(\\]\/\\OpP])",
    );

    public static function is(string $subject, $pattern) {

        if(!is_array($pattern)) $pattern = array($pattern);
        foreach($pattern as $key => $p){
            if(!isset(self::$REGEX_ARRAY[$p])) continue;
            $pattern[$key] = self::$REGEX_ARRAY[$p];
        }

        $pattern = "/^".implode("|", $pattern).'$/';
        $matches = array();
        $r = preg_match($pattern, $subject, $matches);
        return !empty($matches);
    }

    public static function splitPunctuarion(string $subject){

        $matches = array();
        preg_match("/".self::$REGEX_ARRAY[self::WORD].self::$REGEX_ARRAY[self::PUNCTUATION].'?'.self::$REGEX_ARRAY[self::WORD]."/", $subject, $matches);
        if(empty($matches)) return array($subject);

        $word = array($matches[0]);
        $puncts = explode($word[0], $subject);

        $lp = array();
        preg_match_all("/".self::$REGEX_ARRAY[self::PUNCTUATION_A]."/", $puncts[0], $lp);

        $rp = array();
        preg_match_all("/".self::$REGEX_ARRAY[self::PUNCTUATION_A]."/", $puncts[1], $rp);
        return array_merge($word, $lp[0], $rp[0]);
    }

    public static function splitSpaces(string $subject){
        return preg_split("/".self::$REGEX_ARRAY[self::SPACE]."/", $subject);
    }
}
