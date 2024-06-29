![Rocket logo](https://i.imgur.com/51D1iLH.png)
Rocket is a static site generator written in PHP which uses Laravel's Blade template engine under the hood to generate build. Rocket automates the task of coding individual HTML pages and gets those pages ready to serve to users ahead of time. Because these HTML pages are pre-built, they can load very quickly in the browser.

### :zap: Get started
Rocket framework can be installed from the composer package manager. Make sure you can installed PHP and Composer from the requirments section before continuing with the steps given below.

* Create a project folder and open a command prompt inside that folder.
* Run the command `composer require niyko/rocket` to install the plugin.
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

### :rocket: Production build
Running next `composer rocket build` generates an optimized version of your application for production. HTML, CSS, and JavaScript files are created based on your pages. This build is stored in the `dist` folder and a zipped version of the same is saved in the `build` folder.

### :page_with_curl: License
Rocket is licensed under the [MIT License](https://github.com/Niyko/Rocket/blob/master/LICENSE).