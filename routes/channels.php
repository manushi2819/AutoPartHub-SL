<?php

Broadcast::channel('auction.{id}', function ($user, $id) {
    return true;
});