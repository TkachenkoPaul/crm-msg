<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReplyRequest;
use App\Http\Requests\UpdateReplyRequest;
use App\Models\Attachment;
use App\Models\Messages;
use App\Models\Reply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReplyRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreReplyRequest $request,$id): RedirectResponse
    {
        function human_filesize($bytes, $dec = 2): string
        {
            $size   = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            $factor = floor((strlen($bytes) - 1) / 3);
            return sprintf("%.{$dec}f", $bytes / pow(1024, $factor)) . @$size[$factor];
        }
        $reply = new Reply();
        $reply->admin_id = auth()->user()->id;
        $reply->message_id = $id;
        $reply->text = $request->input('reply');
        $reply->save();
        if ($request->has('images')) {
            Messages::findOrFail($id)->update(['photo' => 1]);
            foreach ($request->file('images') as $image) {
                $img = Image::make($image->path());
                $name = date('Y-m-d-H-i-s').'-'.$image->getClientOriginalName();
                $pathToSave = public_path('storage/images/'.$name);
                $path = 'public/images/'.$name;
                $img->save($pathToSave, 50);
                clearstatcache();
                $file = new Attachment();
                $file->reply_id = $reply->id;;
                $file->admin_id = auth()->user()->id;
                $file->path = $path;
                $file->name = $name;
                $file->size = human_filesize($img->filesize());
                $file->save();
            }
        }
        return redirect()->back();
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReplyRequest  $request
     * @param  \App\Models\Reply  $reply
     * @return Response
     */
    public function update(UpdateReplyRequest $request, Reply $reply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply  $reply
     * @return RedirectResponse
     */
    public function destroy(Reply $reply,$id)
    {
        $reply->with('attachment')->findOrFail($id)->delete();
        return redirect()->back()->with('message','?????????????????????? ????????????!');
    }
}
