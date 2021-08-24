<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class VideoStreamingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function store(Request $request)
    {
        try {
            $file = $request->file('video');
            $path = Storage::disk('public')->path("video/{$file->getClientOriginalName()}");
            $pathinfo = pathinfo($path);
            if ($request->has('completed') && $request->boolean('completed')) {
                $video = new Video();
                $video->name = $pathinfo['filename'];
                $video->full_name = $pathinfo['basename'];
                $video->uid = Str::random(20);
                $video->save();
                return response()->json(['uploaded' => true]);
            }

            if (File::exists($path)) {
                File::append($path, $file->get());
            } else {
                File::put($path, $file->get());
            }

            return response()->json(['uploaded' => true]);

        } catch (Exception $e) {
            return response()->json(['uploaded' => false, 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function fileVideo($uid)
    {
        try {
            $video = Video::where('uid', $uid)->first();
            if (is_null($video)) throw new Exception("Video Data Not Found");

            $path = Storage::disk('public')->path("video/{$video->full_name}");
            if (!File::exists($path)) throw new Exception("File Video Not Found");
            return response()->file($path);

        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function streamVideo($uid)
    {
        try {
            $video = Video::where('uid', $uid)->first();
            if (is_null($video)) throw new Exception("Video Data Not Found");

            $path = Storage::disk('public')->path("video/{$video->full_name}");
            if (!File::exists($path)) throw new Exception("File Video Not Found");
            $response = new BinaryFileResponse($path, 200, [
                'Content-Type' => 'video/mp4',
            ]);
            $response->setContentDisposition('attachment', $video->name,
                str_replace('%', '', Str::ascii($video->name)));

            return $response;

        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
