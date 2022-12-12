<?php

namespace MSA\LaravelGrapes\Interfaces;

interface PageRepositoryInterface
{
    public function getAllPages();
    public function getPageById($id);
    public function deletePage($id);
    public function createPage(array $pageDetails);
    public function UpdatePage(array $newPageDetails, $id);
    public function UpdatePageContent(array $newPageContent, $id);
}
