<?php
namespace App\Repository;

use App\Contract\NewsRepositoryInterface;
use App\Models\News;

class NewsRepository implements NewsRepositoryInterface
{
    public $news;
    public function __construct(News $news)
    {
        $this->news = $news;
    }
    public function create($data)
    {
       return $this->news->insert($data);
    }

    public function getAll()
    {
       return $this->news->get();
    }
}

