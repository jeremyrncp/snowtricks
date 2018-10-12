<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 12/10/2018
 * Time: 15:16
 */

namespace App\Utils;

interface ObservatorInterface
{
    public function process(ObservableInterface $observable);
}
