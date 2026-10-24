<?php
namespace Dev\OneSignalChannel\Channels;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request as Psr7Request;
use GuzzleHttp\Psr7\Response as Psr7Response;

abstract class OneSignalBaseClient
{

    /**
     *
     * @var string
     */
    const API_URL = "https://onesignal.com/api/v1";

    /**
     *
     * @var string
     */
    const ENDPOINT_NOTIFICATIONS = "/notifications";

    /**
     *
     * @var Client
     */
    protected $client;

    /**
     *
     * @var array
     */
    protected $header;

    /**
     *
     * @var string
     */
    protected $appId;

    /**
     *
     * @var string
     */
    protected $restApiKey;

    /**
     *
     * @var string
     */
    protected $userAuthKey;

    /**
     *
     * @var array
     */
    protected $additionalParams;

    /**
     *
     * @var bool
     */
    protected $requestAsync = false;

    /**
     *
     * @var int
     */
    private $maxRetries = 2;

    /**
     *
     * @var int
     */
    private $retryDelay = 500;

    /**
     *
     * @var Callable
     */
    private $requestCallback;

    /**
     * Turn on, turn off async requests
     *
     * @param bool $on
     * @return $this
     */
    private function async($on = true)
    {
        $this->requestAsync = $on;
        return $this;
    }

    /**
     * Callback to execute after OneSignal returns the response
     *
     * @param Callable $requestCallback
     * @return $this
     */
    private function callback(Callable $requestCallback)
    {
        $this->requestCallback = $requestCallback;
        return $this;
    }

    public function __construct($appId, $restApiKey, $userAuthKey)
    {
        $this->appId = $appId;
        $this->restApiKey = $restApiKey;
        $this->userAuthKey = $userAuthKey;

        $this->client = new Client([
            'handler' => $this->createGuzzleHandler()
        ]);
        $this->headers = [
            'headers' => []
        ];
        $this->additionalParams = [];
    }

    private function createGuzzleHandler()
    {
        return tap(HandlerStack::create(new CurlHandler()), function (HandlerStack $handlerStack) {
            $handlerStack->push(Middleware::retry(function ($retries, Psr7Request $request, Psr7Response $response = null, RequestException $exception = null) {
                if ($retries >= $this->maxRetries) {
                    return false;
                }

                if ($exception instanceof ConnectException) {
                    return true;
                }

                if ($response && $response->getStatusCode() >= 500) {
                    return true;
                }

                return false;
            }), $this->retryDelay);
        });
    }

    private function requiresAuth()
    {
        $this->headers['headers']['Authorization'] = 'Basic ' . $this->restApiKey;
    }

    private function requiresUserAuth()
    {
        $this->headers['headers']['Authorization'] = 'Basic ' . $this->userAuthKey;
    }

    private function usesJSON()
    {
        $this->headers['headers']['Content-Type'] = 'application/json';
    }

    private function addParams($params = [])
    {
        $this->additionalParams = $params;

        return $this;
    }

    private function setParam($key, $value)
    {
        $this->additionalParams[$key] = $value;

        return $this;
    }

    /**
     * Send a notification with custom parameters defined in
     * https://documentation.onesignal.com/reference#section-example-code-create-notification
     *
     * @param array $parameters
     * @return mixed
     */
    private function sendNotificationCustom($parameters = [])
    {
        $this->requiresAuth();
        $this->usesJSON();

        if (isset($parameters['api_key'])) {
            $this->headers['headers']['Authorization'] = 'Basic ' . $parameters['api_key'];
        }

        // Make sure to use app_id
        if (! isset($parameters['app_id'])) {
            $parameters['app_id'] = $this->appId;
        }

        // Make sure to use included_segments
        if (empty($parameters['included_segments']) && empty($parameters['include_player_ids'])) {
            $parameters['included_segments'] = [
                'all'
            ];
        }

        $parameters = array_merge($parameters, $this->additionalParams);

        $this->headers['body'] = json_encode($parameters);
        $this->headers['buttons'] = json_encode($parameters);
        $this->headers['verify'] = false;
        return $this->post(self::ENDPOINT_NOTIFICATIONS);
    }

    private function post($endPoint)
    {
        if ($this->requestAsync === true) {
            $promise = $this->client->postAsync(self::API_URL . $endPoint, $this->headers);
            return (is_callable($this->requestCallback) ? $promise->then($this->requestCallback) : $promise);
        }
        return $this->client->post(self::API_URL . $endPoint, $this->headers);
    }

    private function put($endPoint)
    {
        if ($this->requestAsync === true) {
            $promise = $this->client->putAsync(self::API_URL . $endPoint, $this->headers);
            return (is_callable($this->requestCallback) ? $promise->then($this->requestCallback) : $promise);
        }
        return $this->client->put(self::API_URL . $endPoint, $this->headers);
    }

    private function get($endPoint)
    {
        return $this->client->get(self::API_URL . $endPoint, $this->headers);
    }

    private function delete($endPoint)
    {
        if ($this->requestAsync === true) {
            $promise = $this->client->deleteAsync(self::API_URL . $endPoint, $this->headers);
            return (is_callable($this->requestCallback) ? $promise->then($this->requestCallback) : $promise);
        }
        return $this->client->delete(self::API_URL . $endPoint, $this->headers);
    }

    protected function sendNotificationUsingTags($message, $tags, $headings = null, $subtitle = null, $customize)
    {
        $contents = array(
            "en" => $message
        );

        $params = array(
            'app_id' => $this->appId,
            'contents' => $contents,
            'filters' => $tags
        );

        if (isset($headings)) {
            $params['headings'] = array(
                "en" => $headings
            );
        }

        if (isset($subtitle)) {
            $params['subtitle'] = array(
                "en" => $subtitle
            );
        }

        if ($customize && count($customize) > 0)
            $params = array_merge($params, $customize);

        return $this->sendNotificationCustom($params);
    }
}
