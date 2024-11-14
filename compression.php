<?php
namespace staifa\php_bandwidth_hero_proxy\compression;

// Image compression with resizing
function process_image()
{
    return function ($ctx) {
        extract($ctx["config"], EXTR_REFS);
        extract($request_headers, EXTR_REFS);
        extract($response, EXTR_REFS);
        extract($ctx["http"], EXTR_REFS);
        extract($ctx["image"], EXTR_REFS);

        $format = $webp ? "webp" : "jpeg";
        $inst = $i_create($data);
        $ctx["instances"] += ["image" => $inst];

        // Resize the image if its height exceeds 12480 pixels
        list($original_width, $original_height) = $i_info($data);

        // Check if the image height exceeds the maximum allowed
        $max_height = 12480;
        if ($original_height > $max_height) {
            // Calculate the new dimensions while maintaining the aspect ratio
            $aspect_ratio = $original_width / $original_height;
            $new_height = $max_height;
            $new_width = intval($new_height * $aspect_ratio);

            // Create a new true color image
            $resized_image = imagecreatetruecolor($new_width, $new_height);

            // Resample the image to the new dimensions
            imagecopyresampled($resized_image, $inst, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

            // Destroy the original image and use the resized one
            $i_destroy($inst);
            $inst = $resized_image;
        }

        // Optionally, apply grayscale or palette reduction
        if ($origin_type == "image/png" || $origin_type == "image/gif") {
            $i_palette($inst);
        };
        if ($greyscale) {
            $i_filter($inst, IMG_FILTER_GRAYSCALE);
        };

        ob_start();

        // Compress and output the image
        ($format == "webp") ? $i_webp($inst, null, $quality) : $i_jpeg($inst, null, $quality);
        $converted_image = ob_get_contents();
        ob_end_clean();
        $i_destroy($inst);

        array_walk($headers, fn ($v, $k) => $set_header($k . ": " . $v));

        // Send the headers and the compressed image
        $size = strlen($converted_image);
        $set_header("content-length: " . $size);
        $set_header("content-type: image/" . $format);
        $set_header("x-original-size: " . $origin_size);
        $set_header("x-bytes-saved: " . $origin_size - $size);

        echo $converted_image;
        return $ctx;
    };
};

