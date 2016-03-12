<?php 

namespace Visualnet\MenuBundle\Listener;

use Symfony\Component\EventDispatcher\Event;

class Menu
{

    public function onFooAction(Event $event)
    {
        echo "przykładowy wynik";
    }
}