<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/24/14
 * Time: 12:37 PM
 */

interface IResultPublish{
    public function registerObserver(IPublish $publisher);
    public function unregisterObserver(IPublish $publisher);
    public function populateResult();
}