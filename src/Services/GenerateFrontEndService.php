<?php

namespace MSA\LaravelGrapes\Services;

use simplehtmldom\HtmlDocument;

class GenerateFrontEndService {

    public function generatePage($page)
    {
        $page_data = $page->page_data;
        $html      = $this->htmlInitialization($page_data['gjs-html']);
        $styles    = $page_data['gjs-css'];

        $slug = $page->slug === '/' ? 'home-page' : $page->slug;
        $this->generateStyleSheet($styles, $slug);
        $this->createBladeFile($slug, $html);
        $this->generateRoute($slug, $page->slug);

    }

    private function createBladeFile($slug, $html)
    {
        $file_name = $slug.'.blade.php';

        $dir_path = __DIR__.'./../../resources/views/pages/';

        if (!is_dir($dir_path)) {
            mkdir($dir_path);
        }

        $file = fopen($dir_path.$file_name, 'w');

        fwrite($file,"@extends('lg::layouts.master')\n\n@push('page-style')\n   <link rel='stylesheet' href='{{asset('css/lg-frontend/".$slug.".css')}}'/>\n@endpush\n@section('content')\n ".$html."\n\n@endsection");

        fclose($file);
    }

    private function generateStyleSheet($styles, $file_name)
    {
        if (!is_dir(public_path('css'))) {
            mkdir(public_path('css'));
        }

        if (!is_dir(public_path('css/lg-frontend'))) {
            mkdir(public_path('css/lg-frontend'));
        }

        $css_file_path = public_path('css/lg-frontend/'.$file_name.'.css');

        $file = fopen($css_file_path, 'w');

        fwrite($file, $styles);

        fclose($file);
    }

    protected function generateRoute($slug, $route)
    {
        $routes = __DIR__.'./../../routes/frontend.php';

        $slug_remove_dash = explode('-', $slug);

        foreach ($slug_remove_dash as $key => $value) {
            $slug_remove_dash[$key] = ucwords($value);
        }

        $method_name = implode($slug_remove_dash);

        if ($route === '/') {
            file_put_contents($routes, file_get_contents($routes)."Route::get('/', [FrontendController::class, '".$method_name."']);\n");
        }

        if(!str_contains(file_get_contents($routes), $route)) {
            file_put_contents($routes, file_get_contents($routes)."Route::get('".$route."', [FrontendController::class, '".$method_name."']);\n");
        }

        $this->addControllerMethod($method_name, $slug);

    }

    protected function addControllerMethod($method_name, $slug)
    {
        $controller = __DIR__.'./../Http/Controllers/FrontendController.php';

        $target_view = $slug === '/' ? 'home-page' : $slug;

        $method = "\n    public function ".$method_name."() \n    {\n       return view('lg::pages/".$target_view."');\n    }\n";

        $content = file_get_contents($controller);

        if (!str_contains($content, 'public function '.$method_name.'()')) {

            $content_array = explode("\n", $content);

            $final_content_array = array_slice($content_array, 0, count($content_array)-2, true);

            $new_method_array = explode("\n", $method);

            $final_contents = array_merge($final_content_array, $new_method_array);

            file_put_contents($controller, implode("\n", $final_contents)."\n}");
        }

    }

    public function destroyPage($page)
    {
        $slug = $page->slug === '/' ? 'home-page' : $page->slug;
        $this->removeView($slug);
        $this->removeStyleSheet($slug);
        $this->removeRoute($page->slug);
    }

    protected function removeView($slug)
    {
        $file_name = $slug === '/' ? 'home-page.blade.php' : $slug.'.blade.php';
        $view = __DIR__.'./../../resources/views/'.$file_name;
        if (file_exists($view)) {
            unlink($view);
        }
    }

    protected function removeStyleSheet($slug)
    {
        $file_name = $slug.'.css';
        $style_sheet = public_path('css/lg-frontend/'.$file_name);
        if(file_exists($style_sheet)) {
            unlink($style_sheet);
        }
    }

    protected function removeRoute($route)
    {
        $routes = __DIR__.'./../../routes/frontend.php';

        $method = $route === '/' ? 'home-page' : $route;

        $slug_remove_dash =  explode('-', $method);

        foreach ($slug_remove_dash as $key => $value) {
            $slug_remove_dash[$key] = ucwords($value);
        }

        $method_name = implode($slug_remove_dash);

        if ($route === '/') {
            file_put_contents($routes, str_replace(
                "Route::get('/', [FrontendController::class, '".$method_name."']);\n",
                '',
                file_get_contents($routes)
            ));
        }
        else {
            file_put_contents($routes, str_replace(
                "Route::get('".$route."', [FrontendController::class, '".$method_name."']);\n",
                '',
                file_get_contents($routes)
            ));
        }

        $this->removeControllerMethod($method_name, $method);
    }

    protected function removeControllerMethod($method_name, $view)
    {
        $controller = __DIR__.'./../Http/Controllers/FrontendController.php';

        $method = "\n    public function ".$method_name."() \n    {\n       return view('lg::/pages".$view."');\n    }\n";

        file_put_contents($controller, str_replace($method, '', file_get_contents($controller)));
    }

    protected function htmlInitialization($html_string)
    {
        $html = new HtmlDocument();

        $html->load($html_string);

        $text_blocks = $html->find('text');

        $this->formatingAuthShortcodes($html);
        $this->formatingCsrf($html);

        // for pro version
        $all_text = $this->formatingTextBlocks($text_blocks);

        $str = $html->save();
        return $str;
    }

    protected function formatingAuthShortcodes($html)
    {
        $auth_shortcodes = $html->find('[auth_shortcode]');

        foreach ($auth_shortcodes as $auth_shortcode) {

            $code = $auth_shortcode->getAttribute('auth_shortcode');

            $guard = $auth_shortcode->getAttribute('guard');


            $original_text = $auth_shortcode->text();

            if ($code === '[auth_email_shortcode]') {
                $auth_shortcode->innertext = ' @if(auth("'.$guard.'")->user()) {{auth()->user()->email}} @else '.$original_text.' @endif ';
            }

            if ($code === '[auth_link_shortcode]') {
                $auth_shortcode->outertext = ' @if(auth("'.$guard.'")->user()) '.$auth_shortcode.' @endif ';
            }

            if ($code === '[none_auth_link_shortcode]') {
                $auth_shortcode->outertext = ' @if(!auth("'.$guard.'")->user()) '.$auth_shortcode.' @endif ';
            }

            $auth_shortcode->removeAttribute('guard');

            $auth_shortcode->removeAttribute('auth_shortcode');
        }
    }

    protected function formatingCsrf($html)
    {
        $comments =  $html->find('comment');

        foreach ($comments as $key => $value) {

            if($value->innertext === '- @csrf -')
            {
                $value->outertext = str_replace(['<!--- ', ' --->'], '',$value->outertext);
            }
        }
    }

    // for pro version
    protected function formatingTextBlocks($text_blocks)
    {
        $all_text = [];

        foreach ($text_blocks as $block) {
            $text = $block->text();
            $block->innertext  = '{{__("'.$text.'")}}';
            array_push($all_text, $text);
        }

        $this->generateLanguageFile($all_text);
    }

    // for pro version
    protected function generateLanguageFile($all_text)
    {

    }

}
