<?php
    function handle_file_uploads($upload_dir, $html_input_name, $maxsize=3145728, $allowed_types=array('jpg', 'png', 'jpeg', 'gif')) {
        $images = array();
        // $upload_dir = 'media' . '/' .($_SESSION['logged_username']). '/';
        // Checks if user sent an empty form
        if(!empty($_FILES[$html_input_name]['name'])) {
            // print_r($_FILES[$html_input_name]);
            // Loop through each file in files[] array
            foreach ($_FILES[$html_input_name]['tmp_name'] as $key => $file) {
                $file_tmpname = $_FILES[$html_input_name]['tmp_name'][$key];
                $file_name = $_FILES[$html_input_name]['name'][$key];
                $file_size = $_FILES[$html_input_name]['size'][$key];
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                // Set upload file path
                $filepath = $upload_dir.$file_name;

                // Check file type is allowed or not
                if(in_array(strtolower($file_ext), $allowed_types)) {
                    if ($file_size > $maxsize)
                        set_alert("Error: File size is larger than the allowed limit.", "danger");

                    // If file with name already exist then append time in
                    // front of name of the file to avoid overwriting of file
                    if(file_exists($filepath)) {
                        $filepath = $upload_dir.time().$file_name;
                    }
                    
                    if(move_uploaded_file($file_tmpname, $filepath)) {
                        set_alert("{$file_name} successfully uploaded", "success");
                        array_push($images, $filepath);
                    }
                    else {                    
                        set_alert("Error uploading {$file_name}", "danger");
                    }
                }
                else {
                    // If file extension not valid
                    set_alert("Error uploading {$file_name} ({$file_ext} file type is not allowed)", "danger");
                }
            }
        }
        else {
            // If no files selected
            set_alert("No files selected.", "danger");
        }
        $imagesStr = implode(',', $images);
        return $imagesStr;
    }
?>