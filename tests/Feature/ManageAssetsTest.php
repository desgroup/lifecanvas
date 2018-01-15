<?php

namespace Tests\Feature;

use App\Asset;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use TimezonesTableSeeder;
use Illuminate\Http\UploadedFile;

class ManageAssetsTest extends TestCase
{   use DatabaseMigrations;

    /** @test */
    function an_authenticated_user_can_upload_an_image_with_a_new_byte()
    {
        ini_set('memory_limit', '1024M'); // TODO-KGW Need to address the memory issue, this test breaks with the default

        $this->signIn();

        $seeder = new TimezonesTableSeeder();
        $seeder->run();

        $place = create('App\Place', ['user_id' => auth()->id()]);
        $byte = make('App\Byte', ['user_id' => auth()->id(), 'place_id' => $place->id]);
        $form = $byte->toArray();

        copy(dirname(__FILE__) . '/Data/test2.jpg', dirname(__FILE__) . '/Data/test.jpg');

        $file = prepareFileUpload(dirname(__FILE__) . '/Data/test.jpg', 'test.jpg');

        $form['image'] = UploadedFile::createFromBase($file, true);

        $this->post('/bytes', $form);
        //dd(Asset::first()->file_name);

        $this->assertEquals(1, Asset::count());
        $this->get('/bytes/1')
            ->assertSee($byte->title)
            ->assertSee(Asset::first()->file_name);
    }
}

function prepareFileUpload($path, $originalName, $size = null)
{
    TestCase::assertFileExists($path);

    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    $mime = finfo_file($finfo, $path);

    return new \Symfony\Component\HttpFoundation\File\UploadedFile ($path, $originalName, $mime, $size, null, true);
}
