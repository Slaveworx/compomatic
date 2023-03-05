# Compomatic v. 0.0.1
![GitHub all releases](https://img.shields.io/github/downloads/slaveworx/compomatic/total) ![GitHub](https://img.shields.io/github/license/slaveworx/compomatic) ![GitHub commit activity](https://img.shields.io/github/commit-activity/y/slaveworx/compomatic?style=plastic) ![visitors](https://visitor-badge.glitch.me/badge?page_id=slaveworx.visitor-badge&left_color=green&right_color=red)

Tiago Galvão - Slaveworx - 2023
______________________

A simple sass compiler implementation that uses **Gulp** and **SCSSPHP** to compile sass used inside components that are defined inside PHP files and that follow something like the Vue.Js component definition style.

This will allow you to have something like this:

`my-component.php`
```php
<!-- ##### COMPONENT STYLES ##### -->
<style>
	//Here I will define all my sass for the component
	#my-component{
		h3{
			color:red;
		}

		p{
			font-size: 12px;
		}
	}
</style>

<!-- ##### COMPONENT BODY ##### -->
<div id="#my-component">
<h3>Hello!</h3>
<p><?php echo somefunction(foo);?></p>
</div>

<!-- ##### COMPONENT SCRIPTS ##### -->
<script>
//some component specific javascript will be here....
</script>
```
These files should be created inside a `./components` folder inside your wordpress theme. 

![file tree](https://i.ibb.co/xHR8F16/Captura-de-ecr-2023-03-05-210803.png)

# How to Use - Instructions
**1** - Make sure you have composer and npm installed in your system.

**2** - Go to the wordpress theme where you want to install the compiler and run:

`composer require scssphp/scssphp`

**3** - Copy the file `compomatic.php` and `gulpfile.js` to the theme root. Also, create a new folder called `components` where your components will live.

**4** - Include the following line to your theme’s `functions.php`:
```php
require_once(“compomatic.php”)
```

**5**- Run the following command:
`npm init`

**6** - Run the following command:
`npm install gulp gulp-phpunit gulp-shell gulp-watch --save-dev`

**7** - Then run `gulp watch`

From there onwards, all changes to the components directory will trigger the sass compiler during dev.
The folder for the outputed compiled css and also the folder for additional scss includes (for example your own mixin collection, variables, general styles, etc) shall be modified to your liking inside the file `compomatic.php`.

These are the variables you can modify:

```php
/*******************************************
* CUSTOMIZE THESE VARIABLES TO YOUR LIKING *
********************************************/

$output_file  =  './assets/css/test.css';  // Define output file
$output_dir  =  dirname($output_file);  // Get the directory of the output file
$additional_includes  =  './src/scss/test.scss';  //add any additional includes, fo example a set of mixins, variables or general styles...
```

# How To Load Components  ?

Compomatic has an helper function to load components.
What this helper function does is getting the components and trimming out everything that is inside the `<style>` tags. That way, the content of those tags does not pollute the DOM as those styles are already being served from the compiled css.

To use the helper function you just need to do it like this: 

```php
load_component("/components/my-component");
```

## Note:
Do not forget to enqueue the generated CSS file. The default location where Compomatic saves the output file is: `./assets/css/components.css`


```php
wp_register_style('components',get_template_directory_uri() .  '/assets/css/components.css',array(),'1.0');
// Enqueue components stylesheet.
wp_enqueue_style('components');
```

