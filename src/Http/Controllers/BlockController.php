<?php

namespace MSA\LaravelGrapes\Http\Controllers;

use Illuminate\Http\Request;
use MSA\LaravelGrapes\Http\Requests\BlockStoreRequest;
use MSA\LaravelGrapes\Http\Requests\BlockUpdateRequest;
use MSA\LaravelGrapes\Http\Controllers\Controller;
use MSA\LaravelGrapes\Interfaces\BlockRepositoryInterface;

class BlockController extends Controller
{
    private BlockRepositoryInterface $BlockRepository;

    public function __construct(BlockRepositoryInterface $BlockRepository)
    {
        $this->BlockRepository = $BlockRepository;
    }

    public function allBlocks()
    {
        $blocks = $this->BlockRepository->getAllBlocks();

        return response()->json([
            'success' => true,
            'block'   => $blocks
        ]);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(BlockStoreRequest $request)
    {
        $block = $this->BlockRepository->createBlock($request->validated());

        return response()->json([
            'success' => true,
            'new_block'   => $block
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(BlockUpdateRequest $request, $id)
    {
        $block = $this->BlockRepository->updateBlock($request->validated(), $id);

        return response()->json([
            'success' => true,
            'block'   => $block,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $block = $this->BlockRepository->deleteBlock($id);

        return response()->json([
            'success' => true,
            'block'   => $block
        ]);
    }
}
