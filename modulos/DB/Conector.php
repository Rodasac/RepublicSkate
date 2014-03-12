<?php

class Conector extends PDO {
    protected $dsn = null;
    protected $user = null;
    protected $pass = null;
    protected $driver_options = null;

    public function __construct($dsn, $user, $pass, $driver_options = array()){
        $this->dsn = $dsn;
        $this->user = $user;
        $this->pass = $pass;
        $this->driver_options = $driver_options;

        parent::__construct($dsn, $this->user, $this->pass,
            $this->driver_options);
    }
} 