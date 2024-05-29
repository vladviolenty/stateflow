<?php

namespace Flow\Core\Interfaces;

interface DatabaseInitInterface
{
    public function initDatabase(\mysqli $mysqli): void;
}