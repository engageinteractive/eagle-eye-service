<?php

namespace Engage\EagleEyeService;

class Reward
{
    protected $api;
    protected $key;

    public function setBrand($identifier, $credentials)
    {
        $credentials = $credentials[$identifier];

        $auth = new Auth($credentials['username'], $credentials['password']);

        $this->key = $credentials['key'];
        $this->api = new Client($auth);
    }

    public function sendWalletReward($wallet, $campaignName)
    {
        $data = [
            'pushMessage' => [
                'campaignName' => $campaignName,
                'title' => null,
                'message' => $wallet['message'],
                'data' => [
                    'screen' => 'WALLET',
                    'screenTitle' => '',
                    'resource' => $wallet['key'],
                ]
            ],
            'segments' => [
                [
                    'segmentType' => 'MATCHING',
                    'lower' => $wallet['email']
                ]
            ],
        ];

        $params = [
            'accountKey' => $this->key,
            'sendPush'   => 'true'
        ];

        return $this->api->post('https://api.podifi.com/qualifi/report/consumer', $data, $params);
    }
}
