<?php
namespace App\Interfaces;

interface MasterData
{
    /**
     * @return array
     * @return object
     */
    
    public function getCategory(): object;
    public function getActiveCategory(): object;
    public function getRespondent(): object;
    public function getActiveRespondent(): object;
}