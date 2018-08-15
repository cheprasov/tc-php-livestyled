<?php

namespace Tests\Functional;

use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @param string $url
     * @param string $method
     * @return array
     */
    protected function curlGet($url, $method = 'GET')
    {
        $url = TEST_URL . $url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        $outputParts = explode("\r\n\r\n", $output, 2);
        $headers = [];
        foreach (explode("\r\n", $outputParts[0]) as $header) {
            $pos = strpos($header, ':');
            if ($pos === false) {
                $headers['HTTP'] = trim($header);
            } else {
                $key = trim(substr($header, 0, $pos));
                $value = trim(substr($header, $pos + 1));
                $headers[$key] = $value;
            }
        }

        return [
            'headers' => $headers,
            'content' => $outputParts[1],
        ];
    }

    public function providerTestRestRequest()
    {
        return [
            'line_' . __LINE__ => [
                'path' => 'users/',
                'expect' => '[{"id":"1","first_name":"Aman","last_name":"Ramkumar"},{"id":"2","first_name":"Leni","last_name":"Martin"},{"id":"3","first_name":"Louis","last_name":"Dalbe"}]',
            ],
            'line_' . __LINE__ => [
                'path' => 'users/1',
                'expect' => '{"id":"1","first_name":"Aman","last_name":"Ramkumar"}',
            ],
            'line_' . __LINE__ => [
                'path' => 'users/2/',
                'expect' => '{"id":"2","first_name":"Leni","last_name":"Martin"}',
            ],
            'line_' . __LINE__ => [
                'path' => 'users/3',
                'expect' => '{"id":"3","first_name":"Louis","last_name":"Dalbe"}',
            ],
            'line_' . __LINE__ => [
                'path' => 'users/4',
                'expect' => '{"error":"Unable to find user"}',
                'http' => 'HTTP/1.1 404 Not Found',
            ],
            'line_' . __LINE__ => [
                'path' => 'users/foo',
                'expect' => '{"error":"Wrong user id"}',
                'http' => 'HTTP/1.1 400 Bad Request',
            ],
        ];
    }

    /**
     * @dataProvider providerTestRestRequest
     */
    public function testRestRequest($path, $expect, $http = 'HTTP/1.1 200 OK')
    {
        $data = $this->curlGet($path);
        $this->assertSame($expect, $data['content']);

        $this->assertSame($http, $data['headers']['HTTP']);
        $this->assertSame('*', $data['headers']['Access-Control-Allow-Origin']);
        $this->assertSame('application/json', $data['headers']['Content-Type']);
    }

    public function testNotFoundRequest()
    {
        $data = $this->curlGet('foo/bar');
        $this->assertSame('Not Found', $data['content']);

        $this->assertSame('HTTP/1.1 404 Not Found', $data['headers']['HTTP']);
        $this->assertSame('*', $data['headers']['Access-Control-Allow-Origin']);
        $this->assertSame('text/html; charset=UTF-8', $data['headers']['Content-Type']);
    }

    public function testOptionsRequest()
    {
        $data = $this->curlGet('users/1', 'OPTIONS');
        $this->assertSame('HTTP/1.1 204 No Content', $data['headers']['HTTP']);
        $this->assertSame('POST, GET, OPTIONS', $data['headers']['Access-Control-Allow-Methods']);
        $this->assertSame('true', $data['headers']['Access-Control-Allow-Credentials']);
        $this->assertSame('X-Requested-With, X-HTTP-Method-Override, Content-Type, Accept', $data['headers']['Access-Control-Allow-Headers']);
    }
}
