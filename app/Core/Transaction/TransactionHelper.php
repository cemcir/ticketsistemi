<?php
    namespace App\Core\Transaction;

    use App\Exceptions\BusinessException;
    use App\Exceptions\ValidationException;
    use Illuminate\Support\Facades\DB;
    use Exception;

    class TransactionHelper { // otomatik transaction işlemi

        public static function Run(callable $callback)  {
            try {
                // Veritabanı işlemini başlat ve callback'i çalıştır
                return DB::transaction(function () use ($callback) {
                    return $callback();
                });
            }
            catch(BusinessException $e) {
                return response()->json(['status'=>400,'msg'=>$e->getMessage()],400);
            }
            catch(ValidationException $e) {
                return response()->json(['status'=>400,'msg'=>$e->getMessage()],400);
            }
            catch (Exception $e) {
                // Hata mesajını JSON olarak döndür
                //return response()->json(['status'=>400,'msg'=>'Bir Hata Meydana Geldi'],400); // ürün ortamı
                return response()->json(['status' => 500, 'msg' => $e->getMessage()], 400); // geliştirici ortamı
            }
        }

    }
