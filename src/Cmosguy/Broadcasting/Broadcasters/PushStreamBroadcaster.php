<?php

namespace Cmosguy\Broadcasting\Broadcasters;


use GuzzleHttp\Client;
use Illuminate\Contracts\Broadcasting\Broadcaster;

class PushStreamBroadcaster implements Broadcaster
{
    /**
     * @var Client
     */
    private $client;

    /**
     * PushStreamBroadcaster constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    /**
     * Broadcast the given event.
     *
     * @param  array $channels
     * @param  string $event
     * @param  array $payload
     * @return void
     */
    public function broadcast(array $channels, $event, array $payload = array())
    {

        foreach ($channels as $channel) {
            $payload = [
                'text' => array_merge(['eventtype' => $event], $payload)
            ];
            $response = $this->client->request('POST', '/pub?id=' . $channel, ['json' => $payload]);
        }
    }
}
