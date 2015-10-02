<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
	
    
    public function index() {
    	$posts = Post::all();

    	return view('post.view')->with('posts', $posts);
    }
    
    public function teste()
    {
    	return view('admin.users.index');
    }
}
