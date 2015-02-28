<?php

//require_once '../Game.php';
require_once '../GameRunner.php';

class FakeGame extends Game
{
    public  $output;
    protected function outputMsg($str)
    {
        $this->output = $str;
    }
}

class GameTest extends PHPUnit_Framework_TestCase
{
    public function setUp() {
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
                throw new RuntimeException($errstr . " on line " . $errline . " in file " . $errfile);
            });
    }

    public function tearDown() {
        restore_error_handler();
    }

    public function testNoOutputIsCreatedWhenGameIsCreated()
    {
        ob_start();

        $game = new Game();

        $stdOut = ob_get_contents();

        ob_end_clean();
        $this->assertEquals('', $stdOut);
    }


    public function testPlayerIsAdded()
    {
        ob_start();

        $game = new Game();

        $game->add("Player");

        $actual = ob_get_contents();
        $expected = "Player was added\nThey are player number 1\n";

        ob_end_clean();

        $this->assertEquals($expected, $actual);
    }

    public function testGameRollWithZeroReturnsNull()
    {
        $game = new Game();

        $game->add("Player");

        $out = $game->roll(0);

        $this->assertNull($out);
    }

    public function testGameCrashesWhenRolledWithoutPlayer()
    {
        $this->setExpectedException('RuntimeException');

        $game = new Game();

        $game->roll(0);
    }

//    public function testGameRollOutput()
//    {
//        $game = new Game();
//        $game->add("Player");
//
//        ob_start();
//
//        $out = $game->roll(0);
//
//        $stdOut = ob_get_contents();
//
//        ob_end_clean();
//
//        $this->assertEquals('blala', $stdOut);
//    }

    public function testPlayLotsOfGames()
    {
        ob_start();

        for ($i = 0; $i < 1000; $i++) {
            play($i);
        }

        $actual = ob_get_contents();
        ob_end_clean();

        $expected = file_get_contents('./output.txt');

        $this->assertEquals($expected, $actual);
    }

    public function testOutputsCorrectMsg()
    {
        $game = new FakeGame();
        $game->add("Chet");
        $game->roll(1);

        $game->wasCorrectlyAnswered();

        $this->assertEquals("Answer was correct!!!!", $game->output);
    }
}


