<?php

use App\Activity;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $byteIds = App\Byte::pluck('id')->toArray();

        foreach ($byteIds as $byteId) {
            $comments = factory(App\Comment::class, rand(0,10))->create(['byte_id' => $byteId]);

            //dd($comment->toArray());
            foreach ($comments as $comment) {
                Activity::create([
                    'type' => 'created_comment',
                    'user_id' => $comment->user_id,
                    'subject_id' => $comment->id,
                    'subject_type' => get_class($comment)
                ]);
            }
        }
    }
}
