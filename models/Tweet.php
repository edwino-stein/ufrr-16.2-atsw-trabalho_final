<?php

namespace app\models;

use yii\helpers\BaseInflector;

class Tweet {

    const URL_TOKENS_REGEX = '(http[s]?:\\/(?:[a-z]|[0-9]|[$-_@.&amp;+]|[!*\(\),]|(?:%[0-9a-f][0-9a-f]))+)';
    const TOKENS_REGEX = array(
        '(<[^>]+>)', //HTML tags
        '(?:@[\w_]+)', //@-mentions
        "(?:\#+[\w_]+[\w\'_\-]*[\w_]+)", //hash-tags
        '(?:[:=;][oO\-]?[D\\)\\]\\(\\]\/\\OpP])', //emoticons
        '(?:(?:\d+,?)+(?:\.?\d+)?)', //numbers
        '(?:[a-zA-Z_\-áÁàÀâÂéÉèÈêÊíÍìÌîÎóÓòÒôÔúÚùÙûÛçÇ]+)', //words
        '(?:\S)' //anything else
    );

    protected static function initFromArray(Tweet $obj, array $data){
        $objMap = array_keys(get_class_vars(self::class));
        foreach ($data as $key => $value) {
            $property = lcfirst(BaseInflector::camelize($key));
            if(!in_array($property, $objMap)) continue;
            if(method_exists($obj, 'set'.ucfirst($property))){
                $setter = 'set'.ucfirst($property);
                $obj->$setter($value);
                continue;
            }
            $obj->$property = $value;
        }
    }

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var array
     * @TODO: fazer uma model pra user
     */
    protected $user;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var int
     */
    protected $favoriteCount;

    /**
     * @var int
     */
    protected $retweetCount;

    /**
     * @var string
     */
    protected $lang;

    /**
     * @var array
     */
    protected $entities = array();

    protected $originalData;

    public function __construct($data = null){
        if(is_array($data)) self::initFromArray($this, $data);
        $this->originalData = $data;
    }

    public function getTokens(bool $lowercase = false){

        $pattern = '/'.self::URL_TOKENS_REGEX.'|'.implode('|', self::TOKENS_REGEX).'/';
        $patternEspecial = '/'.self::TOKENS_REGEX[1].'|'.self::TOKENS_REGEX[2].'|'.self::TOKENS_REGEX[3].'/';

        $matches = array();
        $result = preg_match_all($pattern, $this->getText(), $matches);
        $tokens = array();

        foreach ($matches[0] as $value){

            if(preg_match(self::URL_TOKENS_REGEX, $value) >= 1) continue;
            if(preg_match($patternEspecial, $value) >= 1){
                $tokens[] = $value;
                continue;
            }

            $tokens[] = \Normalizer::normalize($lowercase ?  strtolower($value) : $value);
        }

        return $tokens;
    }

    /* *************** GETTERS *************** */

    public function getCreatedAt(){
        return $this->createdAt;
    }

    public function getId(){
        return $this->id;
    }

    public function getText(){
        return $this->text;
    }

    public function getFavoriteCount(){
        return $this->favoriteCount;
    }

    public function getRetweetCount(){
        return $this->retweetCount;
    }

    public function getLang(){
        return $this->lang;
    }

    public function getEntities(){
        return $this->entities;
    }

    public function getUser(bool $simple = true){
        return $simple ? array(
            'id' => $this->user['id'],
            'name' => $this->user['name'],
            'screen_name' => $this->user['screen_name'],
            'location' => $this->user['location'],
            'description' => $this->user['description'],
            'url' => $this->user['url'],
            'profile_image_url' => $this->user['profile_image_url'],
            'profile_image_url_https' => $this->user['profile_image_url']
        ) : $this->user;
    }

    public function getOriginalData(){
        return $this->originalData;
    }

    /* *************** SETTERS *************** */

    public function setCreatedAt($createdAt){
        try {
            $this->createdAt = new \DateTime($createdAt);
        }
        catch (Exception $e) {
            $this->createdAt = null;
        }
        return $this;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function setText($text){
        $this->text = $text;
        return $this;
    }

    public function setFavoriteCount($favoriteCount){
        $this->favoriteCount = $favoriteCount;
        return $this;
    }

    public function setRetweetCount($retweetCount){
        $this->retweetCount = $retweetCount;
        return $this;
    }

    public function setLang($lang){
        $this->lang = $lang;
        return $this;
    }

    public function setEntities(array $entities){
        $this->entities = $entities;
        return $this;
    }

    public function setUser(array $user){
        $this->user = $user;
        return $this;
    }

    public function toArray(bool $simple = true) : array {
        return $simple ? array(
            'created_at' => $this->getCreatedAt(),
            'id' => $this->getId(),
            'text' => $this->getText(),
            'retweet_count' => $this->getFavoriteCount(),
            'favorite_count' => $this->getFavoriteCount(),
            'lang' => $this->getLang(),
            'entities' => $this->getEntities(),
            'user' => $this->getUser(true)
        ) : $this->getOriginalData();
    }
}
