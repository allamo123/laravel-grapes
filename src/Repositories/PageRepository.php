<?php

namespace MSA\LaravelGrapes\Repositories;

use MSA\LaravelGrapes\Interfaces\PageRepositoryInterface;
use MSA\LaravelGrapes\Models\Page;
use MSA\LaravelGrapes\Services\GenerateFrontEndService;

class PageRepository implements PageRepositoryInterface
{
    private $generate_frontend_service;

    public function __construct(GenerateFrontEndService $generate_frontend_service)
    {
        $this->generate_frontend_service = $generate_frontend_service;
    }

    public function getAllPages()
    {
        $pages = Page::select('id', 'name', 'slug')->get();
        return $pages;
    }

    public function getPageById($id)
    {
        return Page::findOrFail($id);
    }

    public function deletePage($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        $this->generate_frontend_service->destroyPage($page);
    }

    public function createPage(array $pageDetails)
    {
        return Page::create($pageDetails);
    }

    public function UpdatePage(array $newPageDetails, $id)
    {
        $page = Page::findOrFail($id);

        $old_slug = $page->slug;

        $page->update($newPageDetails);

        $this->generate_frontend_service->updateRouteName($old_slug, $page->slug);

        return [
            'success' => true,
            'page'    => $page
        ];
    }

    public function UpdatePageContent(array $newPageContent, $id)
    {
        $page = Page::findOrfail($id);
        $page->update($newPageContent);
        $this->generate_frontend_service->generatePage($page);
        return $page;
    }
}
