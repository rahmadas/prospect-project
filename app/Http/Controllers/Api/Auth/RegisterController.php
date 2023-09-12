<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Referral;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    function register(RegisterRequest $request) {

        // pecahkan 2 persoalan tersubut!!!
        // cari id user dari inviter referral code, ambil id usernya untuk di input ke tabel referral 
        // if iD USER INVETERREFERRALCODE not found keluarin return respone referralcode not found
        
        //     <<<<<<<<<<<            jawaban          >>>>>>>>>>>>

        // Data yang dikirimkan dalam permintaan di-validasi menggunakan-
        // aturan yang telah didefinisikan dalam RegisterRequest dan hasilnya disimpan dalam variabel $data.
        $data = $request->validated();

        // mencari pengguna (user) yang memiliki kode referral yang sesuai dengan kode referral- 
        // yang dikirimkan dalam permintaan. 
        // Jika kode referral tidak ditemukan, maka variabel $inviter akan menjadi null.
        $inviter= User::where('referral_code', $request['inviter_referral_code'])->first();
        
        // pengujian untuk memeriksa apakah pengguna yang merujuk ditemukan. 
        // Jika tidak ditemukan (nilai $inviter adalah null), 
        // maka Anda mengembalikan respons JSON yang berisi pesan kesalahan bahwa "respone referral code not found".
        if ($inviter == null) {
            return response()->json([
                'message' => 'respone referral code not found'
            ]); 
        }
        
        // Di sini, kata sandi (password) yang ada dalam data pendaftaran dienkripsi menggunakan bcrypt, 
        $data['password'] = bcrypt(($data['password']));
        // dan status pengguna diatur menjadi 1 (ini mungkin mengindikasikan status aktif). 
        $data['status'] = 1 ;
        // Selanjutnya, kode referral baru yang berisi 6 karakter acak (huruf dan angka) dibuat menggunakan Str::random(6).
        $data['referral_code'] = Str::random(6);
        
        // Pengguna baru kemudian dibuat di dalam basis data dengan menggunakan data yang telah disiapkan. 
        // Hasilnya disimpan dalam variabel $user.
        $user = User::create($data);

        // Jika pengguna yang merujuk ditemukan, maka ID pengguna yang merujuk ($inviterId) diambil.  
        if ($inviter) {
            
            // Kemudian, pencatatan di tabel referral dibuat dengan ID pengguna yang baru dibuat ($user->id), 
            $inviterId = $inviter->id; 
            
            // ID pengguna yang merujuk ($inviterId), dan tanggal saat ini.
            Referral::create([
                'user_id' => $user->id,
                'invited_id' => $inviterId,
                'date' => Carbon::now()
            ]);

            
        } 

        $token = $user->createToken('auth_token')->plainTextToken;
        
        // $token = $user->createToken($request->token_name)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Register Success',
            'data' => [
                'data' => $user,
                'token' => $token
            ]
            ]);
    } 
}
