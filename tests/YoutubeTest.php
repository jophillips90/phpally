<?php

use CidiLabs\PhpAlly\Video\Youtube;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class YoutubeTest extends PhpAllyTestCase {

    public function testCaptionsMissing()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": []
        }';

        $youtube = new Youtube($client, 'en', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $this->assertEquals($youtube->captionsMissing($response), 0);
    }

    public function testCaptionsMissingHasCaptions()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": [
                {
                    "snippet": {
                        "trackKind": "asr",
                        "language": "es"
                    }
                },
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "es-419"
                    }
                }
            ]
        }';

        $youtube = new Youtube($client, 'en', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $this->assertEquals($youtube->captionsMissing($response), 2);
    }

    public function testCaptionsLanguageFail(){
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": [
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "es"
                    }
                },
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "es-419"
                    }
                }
            ]
        }';

        $youtube = new Youtube($client, 'en', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $this->assertEquals($youtube->captionsLanguage($response), 0);
    }

    public function testCaptionsLanguageSuccess(){
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": [
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "en"
                    }
                },
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "es-419"
                    }
                }
            ]
        }';

        $youtube = new Youtube($client, 'en', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $this->assertEquals($youtube->captionsLanguage($response), 2);
    }

    public function testCaptionsLanguageEmpty(){
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": []
        }';

        $youtube = new Youtube($client, 'en', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $this->assertEquals($youtube->captionsLanguage($response), 2);
    }

    public function testCaptionsNoLanguage(){
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": [
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "en"
                    }
                },
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "es-419"
                    }
                }
            ]
        }';

        $youtube = new Youtube($client, '', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $this->assertEquals($youtube->captionsLanguage($response), 2);
    }

    public function testCaptionsAutoGeneratedFailure(){
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": [
                {
                    "snippet": {
                        "trackKind": "asr",
                        "language": "en"
                    }
                }
            ]
        }';

        $youtube = new Youtube($client, 'en', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $this->assertEquals($youtube->captionsAutoGenerated($response), 0);
    }

    public function testCaptionsAutoGeneratedSuccess(){
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": [
                {
                    "snippet": {
                        "trackKind": "asr",
                        "language": "ru"
                    }
                },
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "es-419"
                    }
                }
            ]
        }';

        $youtube = new Youtube($client, 'en', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $this->assertEquals($youtube->captionsAutoGenerated($response), 2);
    }

}