<?php

namespace app\services;

abstract class TokenValidator {

    const SPACE = 'space';
    const WORD = 'word';
    const NUMERIC = 'numeric';
    const PUNCTUATION = 'punct';
    const PUNCTUATION_A = 'punct_a';
    const PUNCTUATION_Q = 'punct_q';
    const HASHTAG = 'hash';
    const MENTIONS = 'mentions';
    const URL = 'url';
    const EMOTICONS = 'emoticons';

    static protected $REGEX_ARRAY = array(
        self::SPACE => "([\s]+)",
        self::WORD => "([a-zA-ZãÃáÁàÀâÂéẽẼÉèÈêÊĩĨíÍìÌîÎõÕóÓòÒôÔũŨúÚùÙûÛçÇ]+)",
        self::NUMERIC => "([\+\-]?[\d]([\d,\\.\\/]+)?)",
        self::PUNCTUATION => "([\\[\\]\\^\\$\\.\\|\\?\\*\\+\\(\\)\\\\~`\\!@#%&\\-_+={}'\\\"<>:;,]+)",
        self::PUNCTUATION_A => "([\\[\\]\\^\\$\\.\\|\\?\\*\\+\\(\\)\\\\~`\\!@#%&\\-_+={}'\\\"<>:;,])",
        self::PUNCTUATION_Q => "([\\[\\]\\^\\$\\.\\|\\?\\*\\+\\(\\)\\\\~`\\!@#%&\\-_+={}'\\\"<>:;,])?",
        self::HASHTAG => "(\#.*)",
        self::MENTIONS => "(\@.*)",
        self::URL => "(http[s]?:\/\/.*)",
        self::EMOTICONS => "(?:[:=;][oO\-]?[D\\)\\]\\(\\]\/\\OpP])",
    );

    public static function is(string $subject, $pattern, $junction = '|') {

        if(!is_array($pattern)) $pattern = array($pattern);
        foreach($pattern as $key => $p){
            if(!isset(self::$REGEX_ARRAY[$p])) continue;
            $pattern[$key] = self::$REGEX_ARRAY[$p];
        }

        $pattern = "/^".implode($junction, $pattern).'$/';
        $matches = array();
        $r = preg_match($pattern, $subject, $matches);
        return !empty($matches);
    }

    public static function splitPunctuarion(string $subject){

        $matches = array();
        $r = preg_match("/".self::$REGEX_ARRAY[self::WORD].self::$REGEX_ARRAY[self::PUNCTUATION_Q].self::$REGEX_ARRAY[self::WORD]."/", $subject, $matches);

        if($r === 0 || $r === false){
            if(self::is($subject, TokenValidator::PUNCTUATION)){
                $matches = array();
                $r = preg_match_all("/".self::$REGEX_ARRAY[self::PUNCTUATION_A]."/", $subject, $matches);
                return $r === 0 || $r === false ?  array($subject) : $matches[0];
            }

            $matches = array($subject);
        }

        $word = array($matches[0]);
        $puncts = explode($word[0], $subject);
        $lp = array();
        preg_match_all("/".self::$REGEX_ARRAY[self::PUNCTUATION_A]."/", $puncts[0], $lp);

        $rp = array();
        preg_match_all("/".self::$REGEX_ARRAY[self::PUNCTUATION_A]."/", $puncts[1], $rp);
        return array_merge($word, $lp[0], $rp[0]);
    }

    public static function splitPunctuarionFromNumeric(string $subject){

        $matches = array();
        $r = preg_match("/".self::$REGEX_ARRAY[self::NUMERIC]."/", $subject, $matches);

        if($r === 0 || $r === false){
            if(self::is($subject, TokenValidator::PUNCTUATION)){
                $matches = array();
                $r = preg_match_all("/".self::$REGEX_ARRAY[self::PUNCTUATION_A]."/", $subject, $matches);
                return $r === 0 || $r === false ?  array($subject) : $matches[0];
            }

            $matches = array($subject);
        }

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
