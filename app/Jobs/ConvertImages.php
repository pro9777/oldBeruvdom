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

class ConvertImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $images;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($images)
    {
        $this->images = $images;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->images as $img) {
            if (!empty($img) && $img->extension != 'webp' && File::exists(public_path($img->relativeUrl))) {

                $file = new UploadedFile(
                    public_path($img->relativeUrl),
                    $img->original_name,
                    $img->mime,
                    1234,
                    0,
                    false
                );

                $webp = \Webp::make($file);
                $path = public_path('/storage/' . $img->disk . '/' . $img->path . $img->name . '.webp');
                Log::info('Путь до файда = ' . $path);
                if (!is_file($path)) {
                    if ($webp->save(($path))) {
                        if (File::exists($path)) {
                            Log::info('Файл сохранен');
                            if (File::delete(public_path($img->relativeUrl))) {
                                Log::info('Старый файл удален');

                            } else {
                                Log::info('Старый файл не удален');
                            }
                            $infoPath = pathinfo($path);
                            $file_mine = File::mimeType($path);
                            $filesize = filesize($path);
                            $extension = $infoPath['extension'];
                            $original_name = explode('.', $img->original_name);

                            $img->update([
                                'size' => $filesize,
                                'mime' => $file_mine,
                                'original_name' => $original_name[0] . '.webp',
                                'extension' => $extension
                            ]);

                        }

                    } else {


                        Log::info('Ошибка при сохранении файла');
                    }
                } else {
                    $infoPath = pathinfo($path);
                    $file_mine = File::mimeType($path);
                    $filesize = filesize($path);
                    $extension = $infoPath['extension'];
                    $original_name = explode('.', $img->original_name);

                    $img->update([
                        'size' => $filesize,
                        'mime' => $file_mine,
                        'original_name' => $original_name[0] . '.webp',
                        'extension' => $extension
                    ]);
                    Log::info('Не нашел путь до файла = ' . $path);
                }

            }
        }

    }

}
