<?php

namespace MSA\LaravelGrapes\Http\Controllers;

use Illuminate\Http\Request;
use MSA\LaravelGrapes\Http\Requests\PageStoreRequest;
use MSA\LaravelGrapes\Http\Requests\PageUpdateRequest;
use MSA\LaravelGrapes\Http\Requests\PageUpdateContentRequest;
use MSA\LaravelGrapes\Http\Controllers\Controller;
use MSA\LaravelGrapes\Interfaces\PageRepositoryInterface;

class PageController extends Controller
{
    private PageRepositoryInterface $PageRepository;

    public function __construct(PageRepositoryInterface $PageRepository)
    {
        $this->PageRepository = $PageRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $pages = $this->PageRepository->getAllPages();

        return view('lg::builder_root', compact('pages'));
    }

    public function allPages()
    {
        $pages = $this->PageRepository->getAllPages();
        return response()->json($pages);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(PageStoreRequest $request)
    {
        $page = $this->PageRepository->createPage($request->validated());

        return response()->json([
            'success' => true,
            'page'    => $page
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $page = $this->PageRepository->getPageById($id);

        return response()->json(json_decode($page->page_data));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(PageUpdateRequest $request, $id)
    {
        $page = $this->PageRepository->UpdatePage($request->validated(), $id);
        return response()->json($page);
    }

    public function updateContent(PageUpdateContentRequest $request, $id)
    {
        $this->PageRepository->UpdatePageContent($request->validated(), $id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->PageRepository->deletePage($id);
    }
}
