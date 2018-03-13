<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PostDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreatePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Repositories\PostRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\Auth; // add by dandisy
use Illuminate\Support\Facades\Storage; // add by dandisy

class PostController extends AppBaseController
{
    /** @var  PostRepository */
    private $postRepository;

    public function __construct(PostRepository $postRepo)
    {
        $this->middleware('auth');
        $this->postRepository = $postRepo;
    }

    /**
     * Display a listing of the Post.
     *
     * @param PostDataTable $postDataTable
     * @return Response
     */
    public function index(PostDataTable $postDataTable)
    {
        return $postDataTable->render('admin.posts.index');
    }

    /**
     * Show the form for creating a new Post.
     *
     * @return Response
     */
    public function create()
    {
        // add by dandisy
        

        // edit by dandisy
        //return view('admin.posts.create');
        return view('admin.posts.create');
    }

    /**
     * Store a newly created Post in storage.
     *
     * @param CreatePostRequest $request
     *
     * @return Response
     */
    public function store(CreatePostRequest $request)
    {
        $input = $request->all();

        $input['created_by'] = Auth::user()->id;

        $post = $this->postRepository->create($input);

        Flash::success('Post saved successfully.');

        return redirect(route('admin.posts.index'));
    }

    /**
     * Display the specified Post.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('admin.posts.index'));
        }

        return view('admin.posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified Post.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        // add by dandisy
        

        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('admin.posts.index'));
        }

        // edit by dandisy
        //return view('admin.posts.edit')->with('post', $post);
        return view('admin.posts.edit')
            ->with('post', $post);
    }

    /**
     * Update the specified Post in storage.
     *
     * @param  int              $id
     * @param UpdatePostRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePostRequest $request)
    {
        $input = $request->all();

        $input['updated_by'] = Auth::user()->id;

        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('admin.posts.index'));
        }

        $post = $this->postRepository->update($input, $id);

        Flash::success('Post updated successfully.');

        return redirect(route('admin.posts.index'));
    }

    /**
     * Remove the specified Post from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('admin.posts.index'));
        }

        $this->postRepository->delete($id);

        Flash::success('Post deleted successfully.');

        return redirect(route('admin.posts.index'));
    }
}
