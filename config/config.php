<?php

$this->dispatcher->connect('alyssa.send_sms', array('sfAlyssaSms', 'notify'));
