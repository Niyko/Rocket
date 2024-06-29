![Rocket logo](https://i.imgur.com/51D1iLH.png)
Rocket is a static site generator written in PHP which uses Laravel's Blade template engine under the hood to generate build. Rocket automates the task of coding individual HTML pages and gets those pages ready to serve to users ahead of time. Because these HTML pages are pre-built, they can load very quickly in the browser.

### :tophat: Requirments
The Rocket framework has a few system requirements. You should ensure that your web server has the following minimum PHP version and extensions:

* PHP >= `8.0.0`
* Composer >= `1.0.0`

### :zap: Get started
Rocket framework can be installed from the composer package manager. Make sure you can installed PHP and Composer from the requirments section before continuing with the steps given below.

* Create a project folder and open a command prompt inside that folder.
* Run the command `composer require niyko/rocket:dev-main` to install the plugin.
* To setup the project, run the command `php vendor/niyko/rocket/src/Console/Console.php --ansi create`
* Explore the sample project that is copied to the project folder.
* Run the sample project with the command `composer rocket dev`.
* Open the URL shown on the command prompt in the browser.

> You can change the files in the project and reload the browser to view change. Restarting the development server is not required.

### :open_file_folder: Project structure
This project struture shows where is all the different files are located. An overview of the project structure of a Rocket application. It covers top-level files and folders, configuration files, and routing conventions.

* `/index.php` file contains routes for the pages.
* `/views` folder contains the blade files of the pages.
* `/assets` folder contains `images/css/js` assets for the pages.
* `/dist` folder contains generated static files when a build is created.
* `/build` folder contains a zip file of the build generated.

### :pushpin: Creating page routes
Pages to the website is added in the file called `index.php`, which are located in the root of the project directory. In this file we can add the page urls and the views that should be loaded for each page is defined. Here is any example of the `index.php`.

`````php
<?php

require __DIR__.'/vendor/autoload.php';

use Niyko\Rocket\Rocket;

Rocket::init();

// A sample page is added like this
Rocket::page('sample')->url('/')->view('sample')->add();

// Here is a page added with long url
Rocket::page('contact')->url('/about/contact')->view('contact-page')->add();

// Here is a sample page added with URL paramters
Rocket::page('blog.inner')
    ->url('/blog/{slug}', ['slug' => 'sample-blog-1'])
    ->view('blog-inner-page')
    ->add();

// Here is a sample page with view parameters
Rocket::page('blog.inner')
    ->url('/blog/{slug}', ['slug' => 'sample-blog-2'])
    ->view('blog-inner-page', ['title' => 'Sample blog two'])
    ->add();

Rocket::start();
`````

### :nazar_amulet: Creating page views
Laravel's Blade templating engine is used for creating views. View files are stored in the `views` folder of the project. You can learn more about how to create blade files and using them from this [article](https://laravel.com/docs/11.x/blade). Here is an example of how to use it.

**:page_facing_up: index.php**
`````php
<?php

require __DIR__.'/vendor/autoload.php';

use Niyko\Rocket\Rocket;

Rocket::init();

Rocket::page('blog.inner')
    ->url('/blog/{slug}', ['slug' => 'sample-blog-1'])
    ->view('blog-inner-page', ['title' => 'Sample blog one'])
    ->add();

Rocket::start();
`````

**:page_facing_up: views/blog-inner-page.blade.php**
`````html
<html>
    <body>
        <h1>{{ $title }}</h1>
    </body>
</html>
`````

### :card_file_box: Using assets
Assets like images, javascript, css etc are stored in the `assets` folder in the root of the project. You can use the `asset()` function in blade to link the assets. File cache parameters are managed automatically by the framework. Here is a example of the `asset()` function.

**:page_facing_up: views/sample.blade.php**
`````html
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    </head>
    <body>
        <h1>Hello world</h1>
        <img src="{{ asset('images/hello.png') }}">
    </body>
</html>
`````

### :link: Linking to other pages
In Rocket framework we can use the function `page()` to create a link of other pages. Which can be used into `<a>` links are other methods. Basically `page()` function create a links to the page using the route given in `index.php` file. Here is an example given using below.

**:page_facing_up: index.php**
`````php
<?php

require __DIR__.'/vendor/autoload.php';

use Niyko\Rocket\Rocket;

Rocket::init();

Rocket::page('about')->url('/about')->view('about-page')->add();

Rocket::page('contact')->url('/about/contact')->view('contact-page')->add();

Rocket::page('blog.inner')
    ->url('/blog/{slug}', ['slug' => 'sample-blog-1'])
    ->view('blog-inner-page', ['title' => 'Sample blog one'])
    ->add();

Rocket::start();
`````

**:page_facing_up: views/about-page.blade.php**
`````html
<html>
    <body>
        <h1>About</h1>
        <a href="{{ page('contact') }}">Go to contact us</a>
        <a href="{{ page('blog.inner', ['slug' => 'sample-blog-1']) }}">Go to sample blog page</a>
    </body>
</html>
`````

### :rocket: Production build
Running next `composer rocket build` generates an optimized version of your application for production. HTML, CSS, and JavaScript files are created based on your pages. This build is stored in the `dist` folder and a zipped version of the same is saved in the `build` folder.

### :open_file_folder: Deploying
As the final output of the build is a static HTML based websit, you can use them in anyway you want. To test the build, you can use the command `composer rocket run`. Which will create a server which runs the static files created in the build.

> `composer rocket run` should not be used to host the build in production. This command should only be used for testing purpose. It is recommended to use `Ngnix` or `Apache` as a server in production.

### :page_with_curl: License
Rocket is licensed under the [MIT License](https://github.com/Niyko/Rocket/blob/master/LICENSE).