<?php
/**
 * Help welcome template.
 *
 * @package Aheto
 */

use Aheto\Admin\System_Info;

$system = new System_Info;
$system->render();
