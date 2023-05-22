<?php

namespace App\Services\Contracts;

interface ACSServiceInterface
{
    public function filter();

    public function customStore($request);

    public function customUpdate($id, $request);
}