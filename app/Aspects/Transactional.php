<?php

namespace App\Aspects;
use App\Http\Controllers\FileController;
use App\Models\MyFile;
use AhmadVoid\SimpleAOP\Aspect;
use Illuminate\Support\Facades\Cache;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class Transactional implements Aspect
{

    // The constructor can accept parameters for the attribute
    public function __construct(
        public $expiration = 30,
        public $maxAttemptingTime = 20,
        public $key = null 
    ){

    }
    

    public function executeBefore($request,$FileController,$reserveFiles)
    {
        //Get or generating a unique key
        $lockKey = $this->key ?? get_class($FileController) . '_' . $reserveFiles;
    
        //Cache::lock($resourceKey, $seconds)

        $lock = Cache::lock($lockKey,$this->expiration);

        $lock->block($this->maxAttemptingTime);
        $request->attributes->set('lock' , $lock);

    }

    public function executeAfter($request,$FileController,$reserveFiles,$response)
    {
       $lock = $request->attributes->get('lock');
       $lock->release();
       
        //     // إذا تم التنفيذ بنجاح، قم بتحديث حالة الملفات إلى "free" بعد انتهاء صلاحية القفل
        // $reservedFileIds = $response->getData()->ReservedFileIds ?? [];
        
        // // استخدم مدة القفل كفترة انتظار بدلاً من sleep
        // // $lockDuration = $this->expiration;
        // sleep(40);
        
        // $this->updateFileStatus($reservedFileIds);
    }

    public function executeException($request,$FileController,$reserveFiles,$exception)
    {
        $lock = $request->attributes->get('lock');
        $lock?->release();
    }

    private function updateFileStatus($fileIds)
{
    foreach ($fileIds as $fileId) {
        $fileModel = MyFile::find($fileId);

        // تحقق مرة أخرى من حالة الملف قبل التحديث
        if ($fileModel && $fileModel->status === 'reserved') {
            $fileModel->status = 'free';
            $result = $fileModel->save();
            // Log::channel('a')->info('تم تحديث حالة الملف لتكون "free": ' . $result);
        }
    }
}
}
