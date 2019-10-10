<?php

namespace Server\src\Server;

class Server
{
    public $address;

    public $port;

    public function __construct($address = '127.0.0.1', $port = '1235')
    {
        $this->address = $address;
        $this->port = $port;
    }

    public function serverStart()
    {
        set_time_limit(0);

        $sock = socket_create(AF_INET, SOCK_STREAM, 0);
        socket_bind($sock, $this->address, $this->port) or die('Could not bind to address');
        socket_listen($sock);

        while ($client = socket_accept($sock)) {
            $userString = socket_read($client, 1024);

            $incoming = explode("\r\n", $userString);
            $fetchArray = explode(" ", $incoming[0]);

            $file = $fetchArray[1];
            print_r($fetchArray);
            echo "\n";
            echo $file . "\n";

            if ($file == "/") {
                $file = "index.html";
            } else {
                $fileArray = [];
                $fileArray = explode("/", $file);
                $file = $fileArray[1];
            }

            echo $file . "\n";

            $output = '';
            $Header = "HTTP/1.1 200 OK \r\n" .
                "Date: Fri, 31 Dec 1999 23:59:59 GMT \r\n" .
                "Content-Type: text/html \r\n\r\n";

            $content = file_get_contents($file);
            $output = $Header . $content;
            print_r($output);

            socket_write($client, $output, strlen($output));
            socket_close($client);
            socket_close($sock);
        }
    }
}
