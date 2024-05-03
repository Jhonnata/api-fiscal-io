<?php

namespace NumberInWords;

use CodeIgniter\HTTP\Exceptions\RedirectException;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

final class NumberInWordsTest extends CIUnitTestCase
{
    use FeatureTestTrait;


    /**
     * @throws RedirectException
     */
    public function testShouldANumberInFull(){
        $request = $this->get('/number-in-words', ['number'=>'96']);
        $this->assertTrue($request->getJSON() !== false);
        $request->assertJSONFragment(['text' => 'noventa e seis']);

        $request = $this->get('/number-in-words/2356');
        $this->assertTrue($request->getJSON() !== false);
        $request->assertJSONFragment(['text' => 'dois mil trezentos e cinquenta e seis']);

    }



}