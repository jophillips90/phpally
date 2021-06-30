<?php

use CidiLabs\PhpAlly\Rule\VideosHaveAutoGeneratedCaptions;

class VideosHaveAutoGeneratedCaptionsTest extends PhpAllyTestCase {

    public function testCheckTwoIssues()
    {
        $html = '<embed type="video/webm" src="https://www.youtube.com/watch?v=liJVSwOiiwg" width="400" height="300">';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'vimeoApiKey' => 'test',
            'youtubeApiKey' => 'test',
            'kalturaApiKey' => 'test',
            'kalturaUsername' => 'test'
        ];

        $rule = new VideosHaveAutoGeneratedCaptions($dom, $options);

        // $ruleMock = $this->getMockBuilder(VideosHaveAutoGeneratedCaptions::class)
        //     ->setConstructorArgs([$dom, $options])
        //     ->setMethods(array('getCaptionState'))
        //     ->getMock();

        // $ruleMock->expects($this->once())
        //     ->method('getCaptionState')
        //     ->will($this->returnValue(0));

        $this->assertEquals(1, $rule->check());
    }

    public function testCaptionsMissingHasCaptions()
    {
        $html = '<embed type="video/webm" src="https://www.youtube.com/watch?v=qfJthDvcZ08" width="400" height="300">';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'vimeoApiKey' => 'test',
            'youtubeApiKey' => 'test',
            'kalturaApiKey' => 'test',
            'kalturaUsername' => 'test'
        ];
        $rule = new VideosHaveAutoGeneratedCaptions($dom, $options);

        $this->assertEquals(0, $rule->check(), 'Youtube Test should return 0 failed tests to indicate no missing captions');
    }
}