<?php

declare(strict_types=1);

namespace App\WebSocket;

use Amp\Websocket\Message;
use EaseAppPHP\HighPer\Framework\WebSocket\WebSocketConnection;
use EaseAppPHP\HighPer\Framework\WebSocket\WebSocketHandlerInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class ChatHandler implements WebSocketHandlerInterface
{
    /**
     * @var ContainerInterface The container
     */
    protected ContainerInterface $container;
    
    /**
     * @var LoggerInterface The logger
     */
    protected LoggerInterface $logger;
    
    /**
     * @var array<WebSocketConnection> The connected clients
     */
    protected array $clients = [];

    /**
     * Create a new chat handler
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger = $container->get(LoggerInterface::class);
    }

    /**
     * Handle a new WebSocket connection
     *
     * @param WebSocketConnection $connection
     * @return void
     */
    public function onConnect(WebSocketConnection $connection): void
    {
        // Log the connection
        $this->logger->info('New WebSocket connection', [
            'connection_id' => $connection->getId(),
        ]);
        
        // Add the connection to the clients list
        $this->clients[$connection->getId()] = $connection;
        
        // Notify all clients about the new connection
        $this->broadcast([
            'type' => 'system',
            'message' => "User {$connection->getId()} has joined the chat",
        ]);
    }

    /**
     * Handle a WebSocket message
     *
     * @param WebSocketConnection $connection
     * @param Message $message
     * @return void
     */
    public function onMessage(WebSocketConnection $connection, Message $message): void
    {
        // Get the message content
        $content = $message->buffer();
        
        // Try to decode as JSON
        try {
            $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            // If not JSON, treat as plain text
            $data = [
                'type' => 'message',
                'message' => $content,
            ];
        }
        
        // Log the message
        $this->logger->info('WebSocket message received', [
            'connection_id' => $connection->getId(),
            'message' => $data,
        ]);
        
        // Add sender information
        $data['sender'] = $connection->getId();
        $data['timestamp'] = time();
        
        // Broadcast the message to all clients
        $this->broadcast($data);
    }

    /**
     * Handle a WebSocket disconnection
     *
     * @param WebSocketConnection $connection
     * @return void
     */
    public function onDisconnect(WebSocketConnection $connection): void
    {
        // Log the disconnection
        $this->logger->info('WebSocket connection closed', [
            'connection_id' => $connection->getId(),
        ]);
        
        // Remove the connection from the clients list
        unset($this->clients[$connection->getId()]);
        
        // Notify all clients about the disconnection
        $this->broadcast([
            'type' => 'system',
            'message' => "User {$connection->getId()} has left the chat",
        ]);
    }

    /**
     * Broadcast a message to all connected clients
     *
     * @param array $data
     * @return void
     */
    protected function broadcast(array $data): void
    {
        // Encode the data as JSON
        $message = json_encode($data);
        
        // Send to all connected clients
        foreach ($this->clients as $client) {
            if ($client->isOpen()) {
                $client->send($message);
            }
        }
    }
}
