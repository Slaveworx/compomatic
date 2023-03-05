<?php


function compile_sass()
{
    /*******************************************
     * CUSTOMIZE THESE VARIABLES TO YOUR LIKING *
     ********************************************/
    $output_file = './assets/css/components.css'; // Define output file
    $output_dir = dirname($output_file); // Get the directory of the output file
    $additional_includes = './src/scss/your_includes.scss'; //add any additional includes, fo example a set of mixins, variables or general styles...


    /**
     * Let the magic happen
     */
    if (!is_dir($output_dir)) {
        mkdir($output_dir, 0755, true); // Create output directory if it does not exist
    }

    require_once './vendor/autoload.php'; // Import ScssPhp compiler
    $scss = new \ScssPhp\ScssPhp\Compiler();
    $scss->setImportPaths('./src/scss/');
    $scss->setOutputStyle('compressed');

    // Compile the additional Sass file with general includes
    if (file_exists($additional_includes)) {
        $general_sass = file_get_contents($additional_includes);
        $css = $scss->compileString($general_sass);
        $handle = fopen($output_file, 'w');
        ftruncate($handle, 0); // Truncate the file to zero length
        fwrite($handle, str_replace('@charset "UTF-8";', '', $css->getCss())); // Write the output to the output file
        fclose($handle);
    }

    // Compile each PHP file in the ./components directory
    $compiled_css = '';

    foreach (glob('./components/*.php') as $file) {
        $content = file_get_contents($file);
        preg_match_all('/<style[^>]*>(.*?)<\/style>/is', $content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $match) {
                $compiled_css .= $scss->compileString($match)->getCss();
            }
        }
    }

    $handle = fopen($output_file, 'a');
    fwrite($handle, str_replace('@charset "UTF-8";', '', $compiled_css)); // Append the output to the output file
    fclose($handle);
}


/**
 * Helper Function that loads a component
 */
function load_component($slug)
{
    $template = locate_template(array("{$slug}.php", "components/{$slug}.php"));

    if (!$template) {
        return;
    }

    $content = file_get_contents($template);
    $content = preg_replace('/<style>(.*?)<\/style>/s', '', $content);

    echo $content;
}
