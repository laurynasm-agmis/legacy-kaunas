<?php

include __DIR__.'/Game.php';

function play($seed)
{
    $aGame = new Game();

    $aGame->add("Chet");
    $aGame->add("Pat");
    $aGame->add("Sue");
    srand($seed);

    do {

        $aGame->roll(rand(0, 5) + 1);

        if (rand(0, 9) == 7) {
            $notAWinner = $aGame->wrongAnswer();
        } else {
            $notAWinner = $aGame->wasCorrectlyAnswered();
        }


    } while ($notAWinner);
}

play(rand());