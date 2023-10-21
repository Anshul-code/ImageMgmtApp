<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ImageController extends Controller
{
    /**
     * List of images
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $data = Image::select('images.*')
                    ->with([
                        'category' => function($q) {
                            return $q->select('id','title');
                        },
                        'user' => function($q) {
                            return $q->select('id','name');
                        },
                    ])
                    ->when($request->user_id, function($q) use($request) {
                        return $q->where('user_id', $request->user_id);
                    })
                    ->when($request->categories, function($q) use($request) {
                        return $q->whereIn('category_id', explode(',', $request->categories));
                    })
                    ->latest()
                    ->paginate($request->per_page ?: 10);
                    

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Store new image
     *
     * @param \App\Http\Requests\StoreImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreImageRequest $request): JsonResponse
    {
        $user = auth('sanctum')->user();

        $data = $request->validated() + [
            'user_id' => $user->id  
        ];

        if($request->hasFile('file')) {
            $file = $request->file('file');
            $newFileName = Str::random() . '.' . $file->getClientOriginalExtension();
            $data['path'] = $file->storeAs('/uploads/' . $user->id, $newFileName, 'public');
            unset($data['file']);
        }

        $image = Image::create($data);

        return response()->json([
            'success' => true,
            'data'    => $image,
            'message' => __('Image saved.')
        ]);
    }

    /**
     * Increment Download count
     *
     * @param \App\Models\Image $image
     * @return \Illuminate\Http\JsonResponse
     */
    public function increaseDownloadCount(Image $image): JsonResponse
    {
        $image->update([
            'total_downloads' => $image->total_downloads + 1
        ]);

        return response()->json([
            'success' => true,
            'message' => __('Count updated.')
        ]);
    }
    
}
