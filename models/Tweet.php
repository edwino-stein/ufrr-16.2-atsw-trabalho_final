<?php

namespace app\models;

use yii\helpers\BaseInflector;
use app\models\TokenValidator;

class Tweet {

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

        $subjects = TokenValidator::splitSpaces($this->getText());
        $tokens = array();

        foreach ($subjects as $s) {

            if(TokenValidator::is($s, array(TokenValidator::PUNCTUATION))){
                $tokens[] = $s;
                continue;
            }

            if(TokenValidator::is($s, array(TokenValidator::URL, TokenValidator::EMOTICONS))){
                $tokens[] = $s;
                continue;
            }

            if(TokenValidator::is($s, array(TokenValidator::HASHTAG, TokenValidator::MENTIONS))){

                $type = $s[0];
                $s = TokenValidator::splitPunctuarion(substr($s, 1));
                $s[0] = \Normalizer::normalize($s[0]);
                if(!is_string($s[0])) continue;

                $tokens[] = $type.array_shift($s);
                foreach ($s as $w) {
                    $w = \Normalizer::normalize($lowercase ?  strtolower($w) : $w);
                    if(!is_string($w)) continue;
                    $tokens[] = $w;
                }

                continue;
            }

            if(TokenValidator::is($s, array(TokenValidator::NUMERIC))){
                $tokens[] = $s;
                continue;
            }

            $s = TokenValidator::splitPunctuarion($s);
            foreach ($s as $w) {
                $w = \Normalizer::normalize($lowercase ?  strtolower($w) : $w);
                if(!is_string($w)) continue;
                $tokens[] = $w;
            }
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
