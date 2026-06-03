<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function saveFileToAdminAndFrontend($uploadedFile, string $adminDir, string $frontendDir, string $filename)
    {
        if (!file_exists($adminDir)) {
            mkdir($adminDir, 0777, true);
        }

        if (!file_exists($frontendDir)) {
            mkdir($frontendDir, 0777, true);
        }

        $uploadedFile->move($adminDir, $filename);

        $adminFilePath = rtrim($adminDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
        $frontendFilePath = rtrim($frontendDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;

        copy($adminFilePath, $frontendFilePath);
    }
}
