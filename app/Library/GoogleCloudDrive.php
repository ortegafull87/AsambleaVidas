<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 06/10/2016
 * Time: 09:50 PM
 */

namespace App\Library;

use Google\Cloud\Storage\StorageClient;
use League\Flysystem\Filesystem;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;


/**
 * The credentials will be auto-loaded by the Google Cloud Client.
 *
 * 1. The client will first look at the GOOGLE_APPLICATION_CREDENTIALS env var.
 *    You can use ```putenv('GOOGLE_APPLICATION_CREDENTIALS=/path/to/service-account.json');``` to set the location of your credentials file.
 *
 * 2. The client will look for the credentials file at the following paths:
 * - windows: %APPDATA%/gcloud/application_default_credentials.json
 * - others: $HOME/.config/gcloud/application_default_credentials.json
 *
 * If running in Google App Engine, the built-in service account associated with the application will be used.
 * If running in Google Compute Engine, the built-in service account associated with the virtual machine instance will be used.
 */
class GoogleCloudDrive
{
    /**
     *
     */
    public static function getFile()
    {

        putenv('GOOGLE_APPLICATION_CREDENTIALS=/public/google-cloud/Project-bdb7d21b37ca.json');
        $storageClient = new StorageClient([
            'projectId' => 'bdb7d21b37ca670514fce83d17840c167ea5ff07',
        ]);
        $bucket = $storageClient->bucket('your-bucket-name');

        $adapter = new GoogleStorageAdapter($storageClient, $bucket);

        $filesystem = new Filesystem($adapter);

        /**
         * The credentials are manually specified by passing in a keyFilePath.
         */

        $storageClient = new StorageClient([
            'projectId' => 'your-project-id',
            'keyFilePath' => '/path/to/service-account.json',
        ]);
        $bucket = $storageClient->bucket('your-bucket-name');

        $adapter = new GoogleStorageAdapter($storageClient, $bucket);

        $filesystem = new Filesystem($adapter);

// write a file
        $filesystem->write('path/to/file.txt', 'contents');

// update a file
        $filesystem->update('path/to/file.txt', 'new contents');

// read a file
        $contents = $filesystem->read('path/to/file.txt');

// check if a file exists
        $exists = $filesystem->has('path/to/file.txt');

// delete a file
        $filesystem->delete('path/to/file.txt');

// rename a file
        $filesystem->rename('filename.txt', 'newname.txt');

// copy a file
        $filesystem->copy('filename.txt', 'duplicate.txt');

// delete a directory
        $filesystem->deleteDir('path/to/directory');

// see http://flysystem.thephpleague.com/api/ for full list of available functionality

    }

}