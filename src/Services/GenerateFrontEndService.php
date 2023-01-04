<?php

namespace MSA\LaravelGrapes\Services;

use simplehtmldom\HtmlDocument;

class GenerateFrontEndService {

    private $langs;

    public function __construct()
    {
        $this->langs = config('laravel-grapes.languages');
    }

    public function generatePage($page)
    {
        $slug = $page->slug === '/' ? 'home-page' : $page->slug;
        $page_data = $page->page_data;
        $html      = $this->htmlInitialization($page_data['gjs-html'], $slug);
        $styles    = $page_data['gjs-css'];

        $this->generateStyleSheet($styles, $slug);
        $this->createBladeFile($slug, $html);
        $this->generateRoute($slug, $page->slug);

    }

    public function updateRouteName($old_slug, $new_slug)
    {
        $routes = __DIR__.'./../../routes/frontend.php';

        $old_method = $this->getControllerMethodName($old_slug);

        $new_method = $this->getControllerMethodName($new_slug);

        if ($old_slug === '/') {
            file_put_contents($routes, str_replace(
                "Route::get('/', [FrontendController::class, '".$old_method."']);\n",
                "Route::get('".$new_slug."', [FrontendController::class, '".$new_method."']);\n",
                file_get_contents($routes)
            ));
        }
        else {
            file_put_contents($routes, str_replace(
                "Route::get('".$old_slug."', [FrontendController::class, '".$old_method."']);\n",
                "Route::get('".$new_slug."', [FrontendController::class, '".$new_method."']);\n",
                file_get_contents($routes)
            ));
        }

        $this->updateControllerMethod($old_slug, $new_slug, $new_method, $old_method);
    }

    protected function getControllerMethodName($slug)
    {
        $method = $slug === '/' ? 'home-page' : $slug;

        $slug_remove_dash = explode('-', $method);

        foreach ($slug_remove_dash as $key => $value) {
            $slug_remove_dash[$key] = ucwords($value);
        }

        return $method_name = implode($slug_remove_dash);
    }

    protected function updateControllerMethod($old_view, $new_view, $new_method, $old_method)
    {
        $controller = __DIR__.'./../Http/Controllers/FrontendController.php';

        $new_target_view = $new_view === '/' ? 'home-page' : $new_view;

        $old_target_view = $old_view === '/' ? 'home-page' : $old_view;

        $old_method_content = "\n    public function ".$old_method."() \n    {\n       return view('laravel-grapes::pages/".$old_target_view."');\n    }\n";

        $new_method_content = "\n    public function ".$new_method."() \n    {\n       return view('laravel-grapes::pages/".$new_target_view."');\n    }\n";

        $content = file_get_contents($controller);

        file_put_contents($controller, str_replace(
            $old_method_content,
            $new_method_content,
            file_get_contents($controller)
        ));

        $old_view_name = __DIR__.'./../../resources/views/pages/'.$old_target_view.'.blade.php';
        $new_view_name = __DIR__.'./../../resources/views/pages/'.$new_target_view.'.blade.php';
        $old_style_sheet_name = public_path('css/laravel-grapes-frontend/'.$old_target_view.'.css');
        $new_style_sheet_name = public_path('css/laravel-grapes-frontend/'.$new_target_view.'.css');

        if (file_exists($old_view_name)) {
            $this->renameFile($old_view_name, $new_view_name);
            $this->updateBladeStyleFile($new_target_view, $old_target_view);
        }
        if (file_exists($old_style_sheet_name)) {
            $this->renameFile($old_style_sheet_name, $new_style_sheet_name);
        }
    }

    private function updateBladeStyleFile($new, $old)
    {
        $blade = __DIR__.'./../../resources/views/pages/'.$new.'.blade.php';

        file_put_contents($blade, str_replace(
            "<link rel='stylesheet' href='{{asset('css/laravel-grapes-frontend/".$old.".css')}}'/>",
            "<link rel='stylesheet' href='{{asset('css/laravel-grapes-frontend/".$new.".css')}}'/>",
            file_get_contents($blade)
        ));
    }

    private function createBladeFile($slug, $html)
    {
        $file_name = $slug.'.blade.php';

        $dir_path = __DIR__.'./../../resources/views/pages/';

        if (!is_dir($dir_path)) {
            mkdir($dir_path);
        }

        $file = fopen($dir_path.$file_name, 'w');

        fwrite($file,"@extends('laravel-grapes::layouts.master')\n\n@push('page-style')\n   <link rel='stylesheet' href='{{asset('css/laravel-grapes-frontend/".$slug.".css')}}'/>\n@endpush\n@section('content')\n ".$html."\n\n@endsection");

        fclose($file);
    }

    private function generateStyleSheet($styles, $file_name)
    {
        if (!is_dir(public_path('css'))) {
            mkdir(public_path('css'));
        }

        if (!is_dir(public_path('css/laravel-grapes-frontend'))) {
            mkdir(public_path('css/laravel-grapes-frontend'));
        }

        $css_file_path = public_path('css/laravel-grapes-frontend/'.$file_name.'.css');

        $file = fopen($css_file_path, 'w');

        fwrite($file, $styles);

        fclose($file);
    }

    protected function generateRoute($slug, $route)
    {
        $routes = __DIR__.'./../../routes/frontend.php';

        $method_name = $this->getControllerMethodName($slug);

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

        $method = "\n    public function ".$method_name."() \n    {\n       return view('laravel-grapes::pages/".$target_view."');\n    }\n";

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
        $this->removeRoute($slug);
    }

    protected function removeView($slug)
    {
        $file_name = $slug === '/' ? 'home-page.blade.php' : $slug.'.blade.php';
        $view = __DIR__.'./../../resources/views/pages'.$file_name;
        if (file_exists($view)) {
            unlink($view);
        }
    }

    protected function renameFile($file, $newName)
    {
        rename($file, $newName);
    }

    protected function removeStyleSheet($slug)
    {
        $file_name = $slug.'.css';
        $style_sheet = public_path('css/laravel-grapes-frontend/'.$file_name);
        if(file_exists($style_sheet)) {
            unlink($style_sheet);
        }
    }

    protected function removeRoute($route)
    {
        $routes = __DIR__.'./../../routes/frontend.php';

        $method_name = $this->getControllerMethodName($route);

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

        $this->removeControllerMethod($method_name, $route);
    }

    protected function removeControllerMethod($method_name, $view)
    {
        $controller = __DIR__.'./../Http/Controllers/FrontendController.php';

        $method = "\n    public function ".$method_name."() \n    {\n       return view('laravel-grapes::pages/".$view."');\n    }\n";

        file_put_contents($controller, str_replace($method, '', file_get_contents($controller)));
    }

    protected function htmlInitialization($html_string, $slug)
    {
        $html = new HtmlDocument();

        $html->load($html_string);

        $text_blocks = $html->find('text');

        $this->formatingAuthShortcodes($html);
        $this->formatingCsrf($html);

        // for pro version
        $all_text = $this->formatingTextBlocks($text_blocks, $slug);

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
    protected function formatingTextBlocks($text_blocks, $page_name)
    {
        $trans_content = [];

        foreach ($text_blocks as $block) {

            $text = $block->text();

            if (! array_key_exists('en', $trans_content)) {
                $trans_content['en'] = [];
            }

            $trans_content['en'][$text] = $text;

            $block->innertext  = '{{__("'.$page_name.'.'.$text.'")}}';

            foreach ($this->langs as $lang) {

                $lang_attr = $block->getAttribute($lang);

                if (! array_key_exists($lang,  $trans_content)) {
                    $trans_content[$lang] = [];
                }

                if ($lang_attr) {
                    $trans_content[$lang][$text] = $lang_attr;
                }
                else {
                    $trans_content[$lang][$text] = $text;
                }
            }
        }

        $this->generateLanguageFile($trans_content, $page_name);
    }

    // for pro version
    protected function generateLanguageFile($trans_content, $page_name)
    {

        foreach ($trans_content as $lang => $value) {

            $lang_path = lang_path($lang);

            if (! is_dir($lang_path)) {
                mkdir($lang_path);
            }

            $lang_file = $lang_path.'/'.$page_name.'.php';

            $lang_target_file = fopen($lang_file, 'w');

            fwrite($lang_target_file, "<?php \n\n\nreturn [\n    ".var_export($trans_content[$lang], true)."\n];");

            fclose($lang_target_file);

            file_put_contents($lang_file, str_replace(
                'array (',
                '',
                file_get_contents($lang_file)
            ));

            file_put_contents($lang_file, str_replace(
                ')',
                '',
                file_get_contents($lang_file)
            ));
        }
    }

}
