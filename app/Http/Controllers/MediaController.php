<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Media;
use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Facades\MediaCrawlerFactory;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Validation\ValidationException;

class MediaController extends Controller
{
    /**
     * Get data from url source and return to client
     *
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     */
    public function getDataFromUrl(Request $request)
    {
        $this->validate($request, [
            'playlist_id' => 'required',
            'url' => 'required',
        ]);

        $playlist = Playlist::findOrFail($request->playlist_id);

        try {
            $media = MediaCrawlerFactory::make($request->url)->getMedia();

            $playlist->addMedia($media);

            return response(['status' => 1, 'data' => $media]);
        } catch (Exception $e) {
            return response(['status' => 0, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Check if media is still active in source website and return new download url
     *
     * @param $id
     * @return mixed
     */
    public function fetchNewDownloadUrl($id)
    {
        $media = Media::findOrFail($id);

        try {
            MediaCrawlerFactory::make($media->source_url)->getMedia();

            return response(['status' => 1, 'url' => $media->download_url]);
        } catch (ConnectException $e) {
            return response(['status' => 0, 'error' => 'Please try again.']);
        } catch (Exception $e) {
            $media->delete();

            return response(['status' => 0, 'error' => 'This media has been deleted.']);
        }
    }

    /**
     * Search media by keyword
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $keyword = $request->get('keyword', '');

        $media = Media::with('artists')
            ->when($keyword, function ($query, $keyword) {
                $query->filterByKeyword($keyword);
            })
            ->get();

        return view('result', compact('media'));
    }
}
