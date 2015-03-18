<?php namespace Atomx;

use Exception;
use GuzzleHttp\Message\Response;
/*
 * TODO: Ability to sync back from atomx to DA
 */

class AtomxClient extends ApiClient {
    protected $apiBase = 'http://api.atomx.com/v1/';
    protected $id;

    /**
     * @var TokenStore Store the token for the application
     */
    private $tokenStore;
    private $shouldSendToken = true;

    function __construct(TokenStore $tokenStore, $id = null)
    {
        parent::__construct();

        $this->tokenStore = $tokenStore;
        $this->id = $id;
    }

    protected function handleResponse(Response $response)
    {
        // TODO: Handle an invalid token/not logged in message
        // Probably disable exceptions and interpret the status code ourselves
        return json_decode(parent::handleResponse($response), true);
    }


    public function get($url, $options = [])
    {
        return parent::get($url, ['query' => $options]);
    }


    public function put($url, $fields = [])
    {
        return parent::put($url, ['json' => $fields]);
    }

    protected function getDefaultOptions()
    {
        $options = [];

        if ($this->shouldSendToken)
            $options['cookies'] = ['auth_tkt' => $this->getToken()];

        if (!is_null($this->id))
            $options['query'] = ['id' => $this->id];

        return $options;
    }

    private function login()
    {
        $this->shouldSendToken = false;

        $response = $this->get('login', [
            'email'    => $this->tokenStore->getUsername(),
            'password' => $this->tokenStore->getPassword()
        ]);

        $this->shouldSendToken = true;

        if ($response['success'] !== true)
            throw new Exception('Unable to login into Atomx API. Error: ' . $response['error']);


        $token = $response['auth_tkt'];

        $this->tokenStore->storeToken($token);

        return $token;
    }

    private function getToken()
    {
        $token = $this->tokenStore->getToken();

        if ($token !== null) {
            return $token;
        }

        return $this->login();
    }
}
