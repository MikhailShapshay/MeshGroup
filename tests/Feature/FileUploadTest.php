<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ParseExcelJob;

class FileUploadTest extends TestCase
{
    use RefreshDatabase;

    public function testFileUpload()
    {
        Queue::fake();

        $response = $this->postJson('/api/upload', [
            'file' => UploadedFile::fake()->create('test.xlsx')
        ]);

        $response->assertStatus(200);
        Queue::assertPushed(ParseExcelJob::class);
    }
}
