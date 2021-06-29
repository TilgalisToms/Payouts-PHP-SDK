<?php

namespace PaypalPayoutsSDK\Traits;

use PaypalPayoutsSDK\Core\PayPalHttpClient;
use PaypalPayoutsSDK\Core\SandboxEnvironment;

/**
 * Trait PaypalClientAwareTrait
 */
trait PaypalClientAwareTrait
{

    /** @var PayPalHttpClient */
    protected $client;

    /** @var SandboxEnvironment */
    protected $environment;

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @return PayPalHttpClient
     */
    public function getClient(string $clientId, string $clientSecret): PayPalHttpClient
    {
        $this->environment = new SandboxEnvironment($clientId, $clientSecret);
        $this->client = new PayPalHttpClient($this->environment);

        return $this->client;
    }
}