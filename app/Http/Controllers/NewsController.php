<?php

namespace App\Http\Controllers;

use App\Contract\NewsRepositoryInterface;
use App\Models\News;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
        private $newsRepo;
    public function __construct(NewsRepositoryInterface $newsRepo)
    {        
        $this->newsRepo = $newsRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $filePath = $request->filePath;
        
        // get data from database
        try{
            $data = $this->newsRepo->exists();
            if(!$data)
            {
                $file = $filePath != '' ? $filePath : Storage::path(config('app.JsonFile'));
                $this->create($file);
            }

            $news = $this->newsRepo->getAll();
            
            return view('news', [
                'some_var' => 'some value',
            ])->with('news', $news);
            

        }catch(Exception $err){
            throw $err;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($filePath)
    {
        
        $saveData = [];
        // read the json file and store the data inside the table
        $newDetails = json_decode(file_get_contents($filePath),true);

        if($newDetails) 
        {
            foreach($newDetails as $key=>$news) 
            {
                // since response contains either one file or one attachment 
                if(isset($news['attachments']) || isset($news['files']) ) 
                {
                    $saveData[] = [
                        'title' => isset($news['attachments']) ? $news['attachments'][0]['title'] : 
                        (isset($news['files']) ? $news['files'][0]['title'] : ''),

                        'image'=> isset($news['attachments']) && isset($news['attachments'][0]['image_url']) ? 
                        $news['attachments'][0]['image_url'] :'',

                        'link' => isset($news['attachments']) ? $news['attachments'][0]['title_link']: 
                        (isset($news['files']) ? $news['files'][0]['permalink_public'] : ''),

                        'date' => isset($news['attachments']) && isset($news['attachments'][0]['ts']) ? date('Y-m-d',$news['attachments'][0]['ts']):
                        (isset($news['files']) ? date('Y-m-d',$news['files'][0]['created'])  : NULL),
                    ];
                }
            }
            return $this->newsRepo->create($saveData);
        }    
    }
}
