<?php

namespace KW\Application\Controllers\KW\EventDetail;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use KW\Application\Requests\EventDetail\Upload as Request;
use KW\Infrastructure\Eloquents\EventDetail;

class UploadController extends Controller
{
    public function getEventDetailImages()
    {
        $disk = Storage::disk('s3');
        $files = $disk->files('/');
        return $files;
    }
    /**
     * @param Request $request
     * @param $eventDetail
     */
    public function postEventDetailImage(Request $request, $eventDetail)
    {
        $disk =  Storage::disk('s3');

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $directory = $request->json('event_detail_id');
            $directories = Storage::directories($directory);
            if(!isset($directories[$directory])) {
                $directory = Storage::makeDirectory($directory);
            }
            $path = $disk->putFile('event-details/'. $directory, $uploadedFile, 'public');
            $uploadedUrl = $disk->url($path);

//            $eventDetail->images()->create(['url' => $uploadedUrl]);
        }
    }

    public function getEventDetailImage()
    {
        $disk =  Storage::disk('s3');
        $files = $disk->files('/event-details/1');
//        try {
//            $contents = $disk->get($filename);
//            $mimeType = $disk->mimeType($filename);
//        } catch (\Exception $e) {
//            return response(['message' => $e->getMessage()], 404);
//        }
//        return response($contents)->header('Content-Type', $mimeType);
    }

    public function deleteEventDetailImage()
    {
        $disk = Storage::disk('s3');
        $disk->delete($this->getEventDetailImage());
    }
}
