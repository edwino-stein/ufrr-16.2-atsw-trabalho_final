<?php
namespace app\services;

use yii\base\Component;
use yii\base\UnknownMethodException;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterApi extends Component {

    const URL_ACCOUNT_VERIFY_CREDENTIALS = 'account/verify_credentials';
    const URL_STATUSES_TIMELINE = 'statuses/home_timeline';
    const URL_SEARCH_TWEETS = 'search/tweets';

    /**
     * @var string
     */
    protected $consumerKey;

    /**
     * @var string
     */
    protected $consumerSecret;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var string
     */
    protected $accessTokenSecret;

    /**
     * @var Abraham\TwitterOAuth\TwitterOAuth
     */
    protected $connection = null;

    /**
     * @var bool
     */
    protected $decodeJsonAsArray = true;

    /**
     * @var string|null
     */
    protected $tweetModelClass;

    public function __construct(array $config = []){
        $this->setConsumerKey($config['consumerKey'] ?? '')
             ->setConsumerSecret($config['consumerSecret'] ?? '')
             ->setAccessToken($config['accessToken'] ?? '')
             ->setAccessTokenSecret($config['accessTokenSecret'] ?? '');

        $this->tweetModelClass = $config['tweetModelClass'] ?? null;
    }

    public function __invoke(){
        return $this->getConnection();
    }

    public function initConnection(){
        $this->connection = new TwitterOAuth(
            $this->consumerKey,
            $this->consumerSecret,
            $this->accessToken,
            $this->accessTokenSecret
        );

        $this->connection->setDecodeJsonAsArray($this->decodeJsonAsArray);
    }

    public function getConnection(){
        if($this->connection === null) $this->initConnection();
        return $this->connection;
    }

    public function setConsumerKey(string $consumerKey) : TwitterApi {
        $this->consumerKey = $consumerKey;
        return $this;
    }

    public function setConsumerSecret(string $consumerSecret) : TwitterApi {
        $this->consumerSecret = $consumerSecret;
        return $this;
    }

    public function setAccessToken(string $accessToken) : TwitterApi {
        $this->accessToken = $accessToken;
        return $this;
    }

    public function setAccessTokenSecret(string $accessTokenSecret) : TwitterApi {
        $this->accessTokenSecret = $accessTokenSecret;
        return $this;
    }

    public function __call($name, $params){

        $connection = $this->getConnection();
        if(method_exists($connection, $name))
            return call_user_func_array([$connection, $name], $params);

        throw new UnknownMethodException('Calling unknown method: ' . get_class($connection) . "::$name()");
    }

    public function searchTweets(string $query, array $options = array(), &$metadata = null) : array {

        $options['q'] = $query;
        $result = $this->getConnection()->get(self::URL_SEARCH_TWEETS, $options);

        if($metadata !== null) $metadata = $result['search_metadata'] ?? array();
        if($this->tweetModelClass !== null){
            $modelClass = $this->tweetModelClass;
            $tweets = array();
            foreach ($result['statuses'] as $data) $tweets[] = new $modelClass($data);
            return $tweets;
        }
        else{
            return $result['statuses'];
        }
    }
}
