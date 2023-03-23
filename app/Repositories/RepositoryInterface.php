<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface RepositoryInterface
{
    public function findAll();

    public function findById(int $id);

    public function create(Request $request);

    public function removeById(int $id);

    public function update(Request $request);
}
