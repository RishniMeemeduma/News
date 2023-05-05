<?php

namespace Tests\Unit;

use App\Models\News;
use Tests\CreatesApplication;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\NewsController;
use Illuminate\Contracts\Console\Kernel;
use App\Contract\NewsRepositoryInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewsTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    private $news;

    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        // Set up the application instance
        $app = $this->createApplication();
        $app->make(Kernel::class)->bootstrap();
    }


    public function test_news_controller_getData()
    {
        // Arrange
        $testJson =json_encode([
            [
                "files" => [
                    [
                        "id" => "FS736B40M",
                        "created" => 1577961017,
                        "name" => "Test1",
                        "title" => "Test1",
                        "permalink" => "https://slack-files.com/TDYBV1K0R-FS736B40M-35b3b621ca",
                    ]
                ],
            ],
            [
                "attachments" => [
                    [
                        "id" => "FS736B40M",
                        "ts" => 1577961017,
                        "title" => "Test2",
                        "title_link" => "https://slack-files.com/TDYBV1K0R-FS736B40M-35b3b621ca",
                        "image_url"=> "https://slack-files.com/TDYBV1K0R-FS736B40M-35b3b621ca"
                    ]
                ],
            ],
        ]);

        // Upload Json file
        Storage::fake('local');
        $filePath = UploadedFile::fake()->createWithContent('test.json', $testJson);
        Storage::disk('local')->put('test.json', $filePath);
        $dataExists = DB::table('news')->exists();
        $expectedRowCount = !$dataExists?  2 : DB::table('news')->count() +2;

        // Act
        // Call controller
        // $newsRepoInterface = app(NewsRepositoryInterface::class);
        // $controller = new NewsController($newsRepoInterface);
        // $data = $controller->getData($filePath);

        $user = User::factory()->create();
        $response = $this->withoutMiddleware()->post('/test_news', ['filePath' => $filePath]);
                
        // Assert
        // check whether the data has added to the database
        // $this->assertInstanceOf(View::class, $response);
        $this->assertEquals($expectedRowCount, DB::table('news')->count());
        $response->assertStatus(200);
        $response->assertViewIs('news');
        $response->assertViewHas('news');

        // Clean up
        unlink($filePath);
    }

    public function test_if_the_json_file_is_not_available()
    {
        $newsRepoInterface = app(NewsRepositoryInterface::class);
        $controller = new NewsController($newsRepoInterface);

        $response = $this->withoutMiddleware()->post('/test_news', ['filePath' => 'new_test.json']);
        $response->assertStatus(200);
        $response->assertViewIs('news');
        $response->assertViewHas('error');
    }

}
