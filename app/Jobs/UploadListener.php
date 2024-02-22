<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Events\UploadFileEvent;

class UploadListener implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UploadFileEvent $event)
    {
//        Log::info($event->attachment);
//        $attachments = Attachment::get($event->attachment->id);     ;
//        Log::info($attachments);
//        $file = new UploadedFile(
//            public_path($event->attachment->relativeUrl),
//            $event->attachment->original_name,
//            $event->attachment->mime,
//            1234,
//            0,
//            false
//        );
//
//        $webp = \Webp::make($file);
//        $path = public_path('/storage/' . $event->attachment->disk . '/' . $event->attachment->path . $event->attachment->name . '.webp');
//        if ($webp->save(($path))) {
//            Log::info('Файл сохранен');
//            if (File::delete(public_path($event->attachment->relativeUrl))) {
//                Log::info('Старый файл удален');
//
//            } else {
//                Log::info('Старый файл не удален');
//            }
//            $infoPath = pathinfo($path);
//            $file_name = $infoPath['basename'];
//            $file_mine = File::mimeType($path);
//            $filesize = filesize($path);
//            $extension = $infoPath['extension'];
//            $attachments = Attachment::get($event->attachment->id);
//            $attachments->update([
//                'size' => $filesize,
//                'mime' => $file_mine,
//                'original_name' => $file_name,
//                'extension' => $extension
//            ]);



//            if (File::delete(public_path($images->attachment[0]->relativeUrl))) {
//                Log::info('Старый файл удален');
//
//            } else {
//                Log::info('Старый файл не удален');
//            }
//            $infoPath = pathinfo($path);
//            $file_name = $infoPath['basename'];
//            $file_mine = File::mimeType($path);
//            $filesize = filesize($path);
//            $extension = $infoPath['extension'];
//
//            $images->attachment[0]->update([
//                'size' => $filesize,
//                'mime' => $file_mine,
//                'original_name' => $file_name,
//                'extension' => $extension
//            ]);
//        }
//        Log::info($file);
    }
}
