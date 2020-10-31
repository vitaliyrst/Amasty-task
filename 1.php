<?php

class First
{
    public function getClassName()
    {
        echo get_class($this);
    }

    public function getLetter()
    {
        echo 'A';
    }
}

class Second extends First
{
    public function getLetter()
    {
        echo 'B';
    }
}

$first = new First();
$first->getClassName();
$first->getLetter();

$second = new Second();
$second->getClassName();
$second->getLetter();
