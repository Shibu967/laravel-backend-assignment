<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function datatable(Request $request);
    public function store(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
}
