<?php
if (!file_exists('/website/')) {

    mkdir('/website/', 0755, true);

}
if (isset($_FILES['file']) && !empty($_FILES['file'])) {
    $file = $_FILES['file'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    if ($file_error === UPLOAD_ERR_OK) {
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($file_ext === 'zip' || $file_ext === 'rar') {
            $folder_name = pathinfo($file_name, PATHINFO_FILENAME);
            $destination_folder = '/website/' . $folder_name;

            if (!file_exists($destination_folder)) {
                mkdir($destination_folder, 0755, true);
            }

            if (move_uploaded_file($file_tmp, $destination_folder . '/' . $file_name)) {
                $zip = new ZipArchive();

                if ($zip->open($destination_folder . '/' . $file_name) === true) {
                    $zip->extractTo($destination_folder);
                    $zip->close();

                    echo 'File uploaded, extracted, and folder created successfully.';

                    // Delete the ZIP/RAR file after extraction
                    unlink($destination_folder . '/' . $file_name);

                    // Generate a link to the newly uploaded folder
                    $folder_link = '/website/' . $folder_name;
                    echo '<br><br><a href="' . $folder_link . '">Open ' . $folder_name . '</a>';

                } else {
                    echo 'Error extracting the file.';
                }
            } else {
                echo 'Error moving the uploaded file.';
            }
        } else {
            echo 'Invalid file type. Please upload a ZIP or RAR file.';
        }
    } else {
        echo 'Error uploading the file.';
    }
} else {
    echo 'Please choose a file to upload.';
}

?>

</body>
</html>