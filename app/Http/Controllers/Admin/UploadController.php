<?php

namespace App\Http\Controllers\Admin;

use App\Services\UploadsManager;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    //
    protected $manager;

    public function __construct(UploadsManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @api {get} /admin/upload
     * @apiName index
     * @apiGroup UploadManager
     * @apiDescription 展示文件子目录上传页页
     */
    public function index(Request $request)
    {
        $folder = $request->get('folder');
        $data = $this->manager->folderInfo($folder);

        return view('admin.upload.index', $data);
    }

    /**
     * @api {post} /admin/upload/folder
     * @apiName createFolder
     * @apiGroup upload
     * @apiDescription 新建目录
     * @apiParam {String} new_folder 新目录名.
     * @apiParam {String} folder 所在目录名.
     * @apiSuccess {String} success "Folder '$new_folder' created."
     * @apiError {String} errors "An error occurred creating directory." and so on..
     */
    public function createFolder(Requests\Admin\Upload\UploadNewFolderRequest $request)
    {
        $new_folder = $request->get('new_folder');
        $folder = $request->get('folder').'/'.$new_folder;

        $result = $this->manager->createDirectory($folder);

        if ($result === true) {
            return redirect()->back()->withSuccess("Folder '$new_folder' created.");
        }

        $error = $result ? : "An error occurred creating directory.";
        return redirect()
                    ->back()
                    ->withErrors([$error]);
    }

    /**
     * @api {delete} /admin/upload/file
     * @apiName deleteFile
     * @apiGroup upload
     * @apiDescription 删除文件
     * @apiParam {String} del_file 删除的文件名.
     * @apiParam {String} folder 所在目录名.
     * @apiSuccess {String} success "File '$del_file' deleted."
     * @apiError {String} errors "An error occurred deleting file." and so on..
     */
    public function deleteFile(Request $request)
    {
        $del_file = $request->get('del_file');
        $path = $request->get('folder').'/'.$del_file;

        $result = $this->manager->deleteFile($path);

        if ($result === true) {
            return redirect()
                ->back()
                ->withSuccess("File '$del_file' deleted.");
        }

        $error = $result ? : "An error occurred deleting file.";
        return redirect()
                ->back()
                ->withErrors([$error]);
    }

    /**
     * @api {delete} /admin/upload/folder
     * @apiName deleteFolder
     * @apiGroup upload
     * @apiDescription 删除目录
     * @apiParam {String} del_folder 需要删除的目录名.
     * @apiParam {String} folder 所在目录名.
     * @apiSuccess {String} success "Folder '$del_folder' deleted."
     * @apiError {String} errors "An error occurred deleting directory." and so on..
     */
    public function deleteFolder(Request $request)
    {
        $del_folder = $request->get('del_folder');
        $folder = $request->get('folder').'/'.$del_folder;

        $result = $this->manager->deleteDirectory($folder);

        if ($result == true) {
            return redirect()
                    ->back()
                    ->withSuccess("Folder '$del_folder' deleted.");
        }

        $error = $result ? : "An error occurred deleting directory.";
        return redirect()
                ->back()
                ->withErrors([$error]);
    }

    /**
     * @api {post} /admin/upload/file
     * @apiName uploadFile
     * @apiGroup upload
     * @apiDescription 删除文件
     * @apiParam {String} file_name 上传的文件名.
     * @apiParam {String} folder 所在目录名.
     * @apiSuccess {String} success "File '$del_file' deleted."
     * @apiError {String} errors "An error occurred deleting file." and so on..
     */
    public function uploadFile(Requests\Admin\Upload\UploadFileRequest $request)
    {
        $file = $_FILES['file'];
        $fileName = $request->get('file_name');
        $fileName = $fileName ?: $file['name'];
        $path = str_finish($request->get('folder'),'/') . $fileName;
        $content = File::get($file['tmp_name']);

        $result = $this->manager->saveFile($path,$content);

        if ($result == true) {
            return redirect()
                    ->back()
                    ->withSuccess("File '$fileName' uploaded.");
        }

        $error = $result ?: "An error occurred uploading file.";
        return redirect()
                ->back()
                ->withErrors([$error]);
    }
}
