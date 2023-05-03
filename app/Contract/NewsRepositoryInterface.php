<?php
namespace App\Contract;
interface NewsRepositoryInterface
{
    public function create($data);
    public function getAll();
}