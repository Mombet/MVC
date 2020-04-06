<?php

    class IndexModel
    {
        private $message = 'Welcome to Home page, bitches';

        function __construct()
        {

        }

        public function welcomeMessage()
        {
            return $this->message;
        }
        
    }