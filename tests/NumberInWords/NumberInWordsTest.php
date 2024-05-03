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


        $request = $this->get('/number-in-words/2356');
        $this->assertTrue($request->getJSON() !== false);
        $request->assertJSONFragment(['text' => 'dois mil trezentos e cinquenta e seis']);

        $request = $this->get('/number-in-words/356');
        $this->assertTrue($request->getJSON() !== false);
        $request->assertJSONFragment(['text' => 'trezentos e cinquenta e seis']);

        $request = $this->get('/number-in-words', ['number'=>'96']);
        $this->assertTrue($request->getJSON() !== false);
        $request->assertJSONFragment(['text' => 'noventa e seis']);

        $request = $this->get('/number-in-words/11');
        $this->assertTrue($request->getJSON() !== false);
        $request->assertJSONFragment(['text' => 'onze']);

        $request = $this->get('/number-in-words/5');
        $this->assertTrue($request->getJSON() !== false);
        $request->assertJSONFragment(['text' => 'cinco']);

    }

    public function testShouldADecimalPositiveNumber(){
        $request = $this->get('/number-in-words', ['number'=>'9.6']);
        $this->assertTrue($request->getJSON() !== false);
        $request->assertJSONFragment(['text' => 'nove vírgula seis']);
    }

    public function testShouldNotANegativeNumber(){
        $request = $this->get('/number-in-words', ['number'=>'-9.6']);
        $request->assertStatus(400);
        $this->assertTrue($request->getJSON() !== false);
    }

    public function testShouldNotAString(){
        $request = $this->get('/number-in-words', ['number'=>'noventa  e seis']);
        $request->assertStatus(400);
        $this->assertTrue($request->getJSON() !== false);
    }

}