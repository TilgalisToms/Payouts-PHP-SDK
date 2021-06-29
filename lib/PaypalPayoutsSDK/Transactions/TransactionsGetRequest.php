<?php

namespace PaypalPayoutsSDK\Transactions;

use PayPalHttp\HttpRequest;

/**
 * Class TransactionsGetRequest
 * @package PaypalPayoutsSDK\Transactions
 * @description https://developer.paypal.com/docs/api/transaction-search/v1/#definition-transaction_detail
 */
class TransactionsGetRequest extends HttpRequest
{
    protected const ENDPOINT = "/v1/reporting/transactions";

    protected const STATUS_TYPES = [
        'D',//denied
        'P',//pending
        'S',//success
        'V'//reverse success
    ];

    private $vars = [];

    /**
     * TransactionsGetRequest constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ENDPOINT, "GET");
        $this->headers["Content-Type"] = "application/json";
    }

    /**
     * @param string $key
     * @param string $value
     */
    private function setVar(string $key, string $value)
    {
        $this->vars[$key] = $key.'='.urlencode($value);
        $this->path = self::ENDPOINT . '?' . implode('&', $this->vars);
    }

    /**
     * @param string $transactionId
     * @return TransactionsGetRequest
     */
    public function setTransactionId(string $transactionId): TransactionsGetRequest
    {
        $this->setVar('transaction_id', $transactionId);

        return $this;
    }

    /**
     * @param string $transactionStatus
     * @return TransactionsGetRequest
     * @throws \Exception
     */
    public function setTransactionStatus(string $transactionStatus): TransactionsGetRequest
    {
        if (!in_array($transactionStatus, self::STATUS_TYPES)) {
            throw new \Exception('Status code'. $transactionStatus . ' is not supported!');
        }

        $this->setVar('transaction_status', $transactionStatus);

        return $this;
    }

    /**
     * @param string $transactionCurrency
     * @return TransactionsGetRequest
     * @throws \Exception
     */
    public function setTransactionCurrency(string $transactionCurrency): TransactionsGetRequest
    {
        if (strlen($transactionCurrency) !== 3) {
            throw new \Exception('Code '. $transactionCurrency . ' is not ISO-4217!');
        }

        $this->setVar('transaction_currency', $transactionCurrency);

        return $this;
    }

    /**
     * @param string $startDate
     * @return TransactionsGetRequest
     * @throws \Exception
     */
    public function setStartDate(string $startDate): TransactionsGetRequest
    {
        $pattern = '^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])[T,t]([0-1][0-9]|2[0-3]):[0-5][0-9]:([0-5][0-9]|60)([.][0-9]+)?([Zz]|[+-][0-9]{2}:[0-9]{2})$';
        if (!preg_match($pattern, $startDate)) {
            throw new \Exception('Date format '. $startDate . ' is wrong!');
        }

        $this->setVar('start_date', $startDate);

        return $this;
    }

    /**
     * @param string $endDate
     * @return TransactionsGetRequest
     * @throws \Exception
     */
    public function setEndDate(string $endDate): TransactionsGetRequest
    {
        $pattern = '^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])[T,t]([0-1][0-9]|2[0-3]):[0-5][0-9]:([0-5][0-9]|60)([.][0-9]+)?([Zz]|[+-][0-9]{2}:[0-9]{2})$';
        if (!preg_match($pattern, $endDate)) {
            throw new \Exception('Date format '. $endDate . ' is wrong!');
        }

        $this->setVar('end_date', $endDate);

        return $this;
    }
}
