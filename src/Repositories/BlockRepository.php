<?php

namespace MSA\LaravelGrapes\Repositories;

use MSA\LaravelGrapes\Interfaces\BlockRepositoryInterface;
use MSA\LaravelGrapes\Models\CustomeBlock;

class BlockRepository implements BlockRepositoryInterface {

    // public function getAllBlocks();
    // public function createBlock(array $block);
    // public function updateBlock(array $block, $id);
    // public function deleteBlock($id);

    public function getAllBlocks()
    {
        return CustomeBlock::all();
    }


    public function createBlock(array $block)
    {
        $new_block = CustomeBlock::create([
            'name' => $block['name'],
            'block_data' => json_encode($block['block_data'], true),
        ]);

        return $new_block;
    }


    public function updateBlock(array $BlockData, $id)
    {
        $block = CustomeBlock::findOrFail($id);
        $block->update($BlockData);
        return $block;
    }

    public function deleteBlock($id)
    {
        $block = CustomeBlock::findOrFail($id);
        $block->delete();

        return $block;
    }
}
