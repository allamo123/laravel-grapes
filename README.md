<p align="center"><img src="./laravel-grapes-logo.png" width="300"></p>
<p align="center">
<img alt="GitHub" src="https://img.shields.io/github/license/allamo123/laravel-grapes?color=%23000&style=mit">
<img alt="Total Download" src="https://img.shields.io/packagist/dm/msa/laravel-grapes">
<img alt="GitHub release (latest by date including pre-releases)" src="https://img.shields.io/github/v/release/allamo123/laravel-grapes?include_prereleases">
</p>
<p align="left"><img src="./screenshots/screenshot_01.png"></p>

<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
        <a href="#about-laravel-grapes">About Laravel Grapes</a>
    </li>
    <li>
        <a href="#regular-version-vs-pro-version">Diffrence Between Regular Version And Pro Version</a>
    </li>
    <li>
        <a href="#installation-steps">Installation Steps</a>
    </li>
    <li>
        <a href="#usage">Usage</a>
        <ul>
            <li>
                <a href="#1-options-panel">Options Panel</a>
                <ul>
                    <li><a href="#view-components">View Components</a></li>
                    <li><a href="#preview">Preview</a></li>
                    <li><a href="#full-screen">Full Screen</a></li>
                    <li><a href="#view-code">View Code</a></li>
                    <li><a href="#create-new-page">Create New Page</a></li>
                    <li><a href="#Edit Code">Edit Code</a></li>
                    <li><a href="#Component Manager">Component Manager</a></li>
                    <li><a href="#page-manager">Page Manager</a></li>
                    <li><a href="#clear-canvas">Clear Canvas</a></li>
                    <li><a href="#save-component">Save Component</a></li>
                    <li><a href="#save-changes">Save Changes</a></li>
                </ul>
            </li>
            <li>
                <a href="#2-page-panel">Page Panel</a>
                <ul>
                    <li><a href="#select-page">Select Page</a></li>
                    <li><a href="#select-device">Select Device</a></li>
                </ul>
            </li>
            <li>
                <a href="#3-view-panel">View Panel</a>
                <ul>
                    <li><a href="#block-manager">Block Manager</a></li>
                    <li><a href="#layer-manager">Layer Manager</a></li>
                    <li><a href="#component-settings">Component Settings</a></li>
                    <li><a href="#style-manager">Style Manager</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li>
        <a href="#author">Author</a>
    </li>
    <li>
        <a href="#license">License</a>
    </li>
  </ol>
</details>

## About Laravel Grapes

Laravel Grapes is a library for laravel framework, that offer cms drag and drop page builder for frontend which support all Laravel functionality and help user to change all frontend and content just in simple clicks.

Laravel Grapes Comes With A Pro Version Available On [Code Canyon](https://codecanyon.net/)

<hr>

## Diffrence Between Regular Version And Pro Version

| Feature                    | Regular Version | Pro Version |
|----------------------------|-----------------|-------------|
| Laravel crf                | yes             | yes         |
| Laravel Auth user          | yes             | yes         |
| Laravel Auth Guard         | yes             | yes         |
| Multilingual               | No              | yes         |
| Dynamic Model widgets      | 2               | unlimted    |


<hr>

## Installation Steps

```jsx 
composer require msa/laravel-grapes
```
```jsx 
php artisan vendor:publish --provider="MSA\LaravelGrapes\LaravelGrapesServiceProvider" --tag="*"
```

```jsx 
php artisan migrate
```


#### Go to config/lg.php

```jsx
    <?php

    return [
        // routes configurations
        'builder_prefix' => 'hello', // prefix for builder

        'middleware' => null, // middleware for builder

        'frontend_prefix' => '', // prefix for frontend
    ];`
```

##### 1) builder_prefix
The builder by default come with route [your-domain.com/hello/front-end-builder](#1-builder_prefix).<br>
you can change the builder prefix to hi so now the builder load with route prefix hi instead of hello.

##### 2) middleware
Assign any middleware you want to the builder for example auth:admin.

##### 3) frontend_prefix
The frontend prefix by default it comes empty that mean that any generated front end page builder it load directly with your slug that created by you so if you need to set prefix for your generated frontend so change it to your prefix that you want. <br>

Now laravel grapes is working.

Navigate to builder route [your-domain.com/builder_prefix/front-end-builder](#1-builder_prefix).

<p align="left"><img src="./screenshots/screenshot_02.png"></p>

<hr>

### Customize Style

#### Go to public/css/laravel-grapes.css

Start Customizing Laravel Grapes Builder As You Wish.

<hr>

## Usage

The Controll Panel Consists Of 3 Panels :-

[1) Options Panel](#1-options-panel) <br>

[2) Page Panel](#2-page-panel) <br>

[3) View Panel](#3-view-panel) <br>

### 1. Options Panel
<p align="left"><img src="./screenshots/options_panel_screenshot.png" width="400"></p><br>

The options panel consists of 11 buttons :-

- [View Components](#view-components)
- [Preview](#preview)
- [Full Screen](#full-screen)
- [View Code](#view-code)
- [Create New Page](#create-new-page)
- [Edit Code](#edit-code)
- [Component Manager](#component-manager)
- [Page Manager](#page-manager)
- [Clear Canvas](#clear-canvas)
- [Save Component](#save-component)
- [Save Changes](#save-changes)

#### View Components
The view component button show grid lines for all components droped in the canvas, this help to to select each component individual for example take a look on the screenshot below.<br><br>

<p align="left"><img src="./screenshots/screenshot_04.png" width="790"></p><br>

#### Preview
The preview button help you to show page without pannels like screenshot below<br>
<p align="left"><img src="./screenshots/screenshot_preview.png" width="790"></p><br>

#### Full Screen
The full screen mode button hide all browser utils and show only the builder.<br><br>

#### View Code
The view code button show you the html and css code of the page like sceenshot below<br>
<p align="left"><img src="./screenshots/screenshot_05.png" width="790"></p><br>

#### Create New Page

The create new page button at topbar when you press on it, the popup modal open with new page form, so fill page name and slug and if you need the page become a home page type slug /  .<br>

<p align="left"><img src="./screenshots/screenshot_03.png" width="790"></p><br>
After submit the form will receive toast notification tha page creaded successfully, so select the new page throw select page input on the top bar to start modifying the page.<br><br>

#### Edit Code
The edit code button it will open a popup code editor modal that hold page code including html and css.<br>
<p align="left"><img src="./screenshots/edit_code_screenshot.png" width="790"></p><br>
So you can edit the html and css code from the code editor popup, for editing syles you will find page style inside tag <code><style></style></code>.<br>

###### Note: Html and css on the code editor merged in one page but after submit the code you can [View Code](#view-code), you will find styles and html each of them seperate and each generated page has it's own blade file and css file.<br><br>


#### Component Manager
The Component Manager button will open a popup hold all custome components that has been [saved](#save-component) to reused on another page to let you edit name of the component or delete it.<br>
<p align="left"><img src="./screenshots/component_manager_screenshot.png" width="790"></p><br>

#### Page Manager
The page manager button will open a popup hold all pages and let you to edit page name and slug.<br>
<p align="left"><img src="./screenshots/pages_manager_screenshot.png" width="790"></p><br>

#### Clear Canvas
The clear canvas button will remove all components from the canvas.<br><br>

#### Save Component
Laravel Grapes let you to save any custome component for reuse it on other pages all you need to select the component and click on [Save Component Button](#save-component).<br><br>

#### Save Changes
The save changes button update the page content and if you check the page slug you will find that page content has been changed.<br><br>

### 2. Page Panel

The options panel consists of 2 select input :-

- [Select Page](#select-page)
- [Select Device](#select-device)

#### Select Page
The select page input let you to select page that you need to modify it.<br><br>

#### Select Device
The select device input let you to modify page html and styles on different screens with the following sizes
- Desktop
- Extra Large
- Large
- Tablet
- Medium
- Mobile Landscape
- Small
- Extra Small
- Mobile Portrait

### 3. View Panel
The View Panel consists of 4 buttons :-
- [Block Manager](#block-manager)
- [Layer Manager](#layer-manager)
- [Components Settings](#components-settings)
- [Style Manager](#style-manager)


#### Block Manager
The Block Manager Comes with Bootstrap Components :-
- Layout which holds
  - [ ] Navbar
  - [ ] Section
  - [ ] Container
  - [ ] Row
  - [ ] Column
  - [ ] Column break
  - [ ] Media Object

- Components which holds
  - [ ] Dropdown Menu
  - [ ] Menu
  - [ ] Menu Link
  - [ ] Alert
  - [ ] Link
  - [ ] Tabs
  - [ ] Tab
  - [ ] Badge
  - [ ] Card
  - [ ] Card Container
  - [ ] Collapse
  - [ ] Dropdown Item
  - [ ] Dropdown Button

- Typography which holds
  - [ ] Header
  - [ ] Paragraph
  - [ ] Separator

- Templates which holds
  - [ ] 5 prebuilt templates

- Saved which holds
  - [ ] All your saved custom<br> 
  
#### Layer Manager
Another utility tool you might find useful when working with web elements is the layer manger. It's a tree overview of the structure nodes and enables you to manage it easier.<br>

<p align="left"><img src="./screenshots/layer_manager_screenshot.png" width="790"></p><br>

#### Components Settings
Each component come with it's own settings you can modify it for example, if you select from the canvas link element and got to component settings you will find the following:

* The attribute of href link
* The attribute of target
* The attribute of toggle
* Laravel Auth User option, for show element
* Laravel Auth Guard option, for show element. (default is web)
* The attribute of id
* The attribute of title<br>

<p align="left"><img src="./screenshots/component_settings_screenshot.png" width="790"></p><br>

#### Style Manager

The Style manager is composed by sectors, which group inside different types of CSS properties. So you can add, for instance, a Dimension sector for width and height, and another one as Typography for font-size and color and more. So it's up to you decide how organize sectors.<br>

<p align="left"><img src="./screenshots/style_manager_screenshot.png" width="790"></p><br>

- Classes
  - [ ] State (for styling the hover effect, and click, etc...)
  - [ ] Add class
  - [ ] remove class

- General
  - [ ] Float Options
  - [ ] Display Options
  - [ ] Position Options

- Flex Options

- Dimension Options

- Typography Options

- Decorations Options

- Extra
  - [ ] Tarnsitions 
  - [ ] Prespective 
  - [ ] Transform<br>

## Author

[![Mohamed Allam](https://github.com/allamo123.png?size=90)](https://github.com/allamo123) 

## [License](https://github.com/allamo123/laravel-grapes/blob/main/LICENSE.md)

MIT © [Mohamed Allam ](https://github.com/allamo123)
