<?php

namespace KW\Application\Controllers\KW\EventDetail;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use KW\Application\Requests\EventDetail\KW\Upload as Request;
use KW\Infrastructure\Eloquents\EventDetail;

class UploadController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function postEventDetailImage(Request $request)
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
            return ['url' => $uploadedUrl];
        }
    }

    public function deleteEventDetailImage()
    {
        $disk = Storage::disk('s3');
        $disk->delete();
    }
}
