<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use DB;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
          $post= Post::orderBy('created_at','desc')->get();
        // $post= Post::all();
        // $post=DB::select('SELECT * FROM posts');
        // $post= Post::orderBy('created_at','desc')->paginate(1);

        return view('posts.index',compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'title'=>'required',
            'body'=>'required',
            'cover_image'=>'image|nullable|max:1999'
        ]);
        //  Handle File Upload
        if($request->hasFile('cover_image')){
            // Get file name with extension
            $fileNameWithExt=$request->file('cover_image')->getClientOriginalName();
            // get file name without extension
            $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            // get file extension
            $extension=$request->file('cover_image')->getClientOriginalExtension();
            // filename to store
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;
            // upload the image
            $path=$request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
        }else{
            $fileNameToStore="Noimage.jpg";
        }
            // Create post
            $post=new Post;
            $post->title=$request->input('title');
            $post->body=$request->input('body');
            $post->user_id=auth()->user()->id;
            $post->cover_image=$fileNameToStore;
            $post->save();
            return redirect('/posts')->with('success','Post created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        // return Post::find($id);
        $post=Post::find($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post=Post::find($id);
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error','Unauthorized Page');
        }
        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required'
        ]);
        if($request->hasFile('cover_image')){
            // Get file name with extension
            $fileNameWithExt=$request->file('cover_image')->getClientOriginalName();
            // get file name without extension
            $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            // get file extension
            $extension=$request->file('cover_image')->getClientOriginalExtension();
            // filename to store
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;
            // upload the image
            $path=$request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
        }
            // Create post
            $post=Post::find($id);
            $post->title=$request->input('title');
            $post->body=$request->input('body');
            if($request->hasFile('cover_image')){
                $post->cover_image=$fileNameToStore;
            }
            $post->save();
            return redirect('/posts')->with('success','Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post=Post::find($id);
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error','Unauthorized Page');
        }
        if($post->cover_image !='Noomage.jpg'){
            // Delete image
            Storage::delete('public/storage/cover_images/'.$post->cover_image);
        }
        $post->forcedelete();
        return redirect('/posts')->with('success','Post Deleted');
    }
}
